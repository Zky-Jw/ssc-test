<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TicketDueDateSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $this->command->info("🚀 Menambahkan field dueDate dan isLate (melewati weekend, tanpa hari libur nasional)...");

            $servicesRaw = DB::table('services as s')
                ->join('service_mappings as sm', 's.id', '=', 'sm.service_id')
                ->join('service_additionals as sa', 'sm.service_additional_id', '=', 'sa.id')
                ->select('s.service as service_name', 'sa.duration', 's.id as service_id')
                ->get();

            $mappings = collect();
            foreach ($servicesRaw as $service) {
                $originalName = $service->service_name;
                $normalizedName = $this->normalizeServiceName($originalName);

                $mappings->put($originalName, $service);
                $mappings->put($normalizedName, $service);
                $mappings->put(strtolower($originalName), $service);
                $mappings->put(strtoupper($originalName), $service);
            }

            $this->command->info("✅ Total mappings (with variations): " . $mappings->count());
            $this->command->info("✅ Unique services: " . $servicesRaw->count());
            $this->command->info("📋 Sample mappings:");
            $servicesRaw->take(3)->each(function ($service) {
                $this->command->info("   '{$service->service_name}' → Duration: {$service->duration} hari");
            });

            // Query untuk tickets yang belum punya dueDate ATAU belum punya isLate
            $tickets = DB::connection('mongodb')->collection('ticket')
                ->where('active', 'Y')
                ->where(function ($query) {
                    $query->whereNull('dueDate')
                          ->orWhereNull('isLate');
                })
                ->get();

            $this->command->info("✅ Total tickets yang perlu diproses: " . $tickets->count());

            $processed = 0;
            $skipped = 0;
            $timestampErrors = 0;
            $mappingErrors = 0;
            $foundMappings = collect();
            $lateTickets = 0;
            $isLateOnlyUpdates = 0; // Counter untuk tickets yang hanya perlu update isLate

            foreach ($tickets as $ticket) {
                $createdAtRaw = $ticket['created_at'] ?? null;
                $updatedAtRaw = $ticket['updated_at'] ?? null;
                $serviceNameRaw = $ticket['purpose']['service']['name'] ?? null;
                $ticketNumber = $ticket['ticketNumber'] ?? 'N/A';
                $existingDueDate = $ticket['dueDate'] ?? null;
                $existingIsLate = $ticket['isLate'] ?? null;

                // Jika hanya field isLate yang belum ada, tapi dueDate sudah ada
                if ($existingDueDate && is_null($existingIsLate)) {
                    try {
                        $updatedAtTimestamp = $updatedAtRaw ? $this->parseMongoDate($updatedAtRaw) : time();
                        $dueDateTimestamp = strtotime($existingDueDate);

                        $isLate = $dueDateTimestamp < $updatedAtTimestamp;
                        if ($isLate) {
                            $lateTickets++;
                        }

                        $updateResult = DB::connection('mongodb')->collection('ticket')
                            ->where('_id', $ticket['_id'])
                            ->update([
                                'isLate' => $isLate,
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);

                        if ($updateResult) {
                            $isLateOnlyUpdates++;
                            if ($isLateOnlyUpdates <= 5) {
                                $lateStatus = $isLate ? " (TERLAMBAT)" : " (TEPAT WAKTU)";
                                $this->command->info("🔧 #{$ticketNumber}: Menambahkan isLate saja{$lateStatus}");
                            }
                        }
                        continue;
                    } catch (\Exception $e) {
                        $this->command->error("   Error update isLate #{$ticketNumber}: " . $e->getMessage());
                        $skipped++;
                        continue;
                    }
                }

                // Proses normal untuk tickets yang belum punya dueDate
                if (!$createdAtRaw || !$serviceNameRaw) {
                    // Jika data tidak lengkap tapi belum ada isLate, set default false
                    if (is_null($existingIsLate)) {
                        try {
                            DB::connection('mongodb')->collection('ticket')
                                ->where('_id', $ticket['_id'])
                                ->update([
                                    'isLate' => false,
                                    'updated_at' => date('Y-m-d H:i:s')
                                ]);
                            $isLateOnlyUpdates++;
                        } catch (\Exception $e) {
                            // Silent fail untuk update default isLate
                        }
                    }
                    $skipped++;
                    continue;
                }

                $mapping = $this->findServiceMapping($mappings, $serviceNameRaw);
                if (!$mapping || !$mapping->duration) {
                    // Jika mapping tidak ditemukan tapi belum ada isLate, set default false
                    if (is_null($existingIsLate)) {
                        try {
                            DB::connection('mongodb')->collection('ticket')
                                ->where('_id', $ticket['_id'])
                                ->update([
                                    'isLate' => false,
                                    'updated_at' => date('Y-m-d H:i:s')
                                ]);
                            $isLateOnlyUpdates++;
                        } catch (\Exception $e) {
                            // Silent fail untuk update default isLate
                        }
                    }
                    $mappingErrors++;
                    if ($mappingErrors <= 5) {
                        $this->command->error("   Mapping tidak ditemukan untuk: '{$serviceNameRaw}'");
                    }
                    continue;
                }

                $foundMappings->put($serviceNameRaw, $mapping->service_name);

                try {
                    $timestampSeconds = $this->parseMongoDate($createdAtRaw);
                } catch (\Exception $e) {
                    // Jika error parsing timestamp tapi belum ada isLate, set default false
                    if (is_null($existingIsLate)) {
                        try {
                            DB::connection('mongodb')->collection('ticket')
                                ->where('_id', $ticket['_id'])
                                ->update([
                                    'isLate' => false,
                                    'updated_at' => date('Y-m-d H:i:s')
                                ]);
                            $isLateOnlyUpdates++;
                        } catch (\Exception $e2) {
                            // Silent fail untuk update default isLate
                        }
                    }
                    if ($timestampErrors < 3) {
                        $this->command->error("   Timestamp error #{$ticketNumber}: " . $e->getMessage());
                    }
                    $timestampErrors++;
                    continue;
                }

                try {
                    $updatedAtTimestamp = $updatedAtRaw ? $this->parseMongoDate($updatedAtRaw) : $timestampSeconds;
                } catch (\Exception $e) {
                    $updatedAtTimestamp = $timestampSeconds;
                }

                $durationDays = intval($mapping->duration);
                $dueDateTimestamp = $this->addWorkingDays($timestampSeconds, $durationDays);

                $isLate = $dueDateTimestamp < $updatedAtTimestamp;
                if ($isLate) {
                    $lateTickets++;
                }

                $createdAtFormatted = date('Y-m-d H:i:s', $timestampSeconds);
                $dueDateFormatted = date('Y-m-d H:i:s', $dueDateTimestamp);
                $updatedAtFormatted = date('Y-m-d H:i:s', $updatedAtTimestamp);

                try {
                    $updateData = [
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    // Hanya update dueDate jika belum ada
                    if (!$existingDueDate) {
                        $updateData['dueDate'] = $dueDateFormatted;
                    }

                    // Selalu update isLate (baik yang belum ada atau yang sudah ada)
                    $updateData['isLate'] = $isLate;

                    $updateResult = DB::connection('mongodb')->collection('ticket')
                        ->where('_id', $ticket['_id'])
                        ->update($updateData);

                    if ($updateResult) {
                        $processed++;
                        if ($processed <= 10) {
                            $lateStatus = $isLate ? " (TERLAMBAT)" : "";
                            $dueDateInfo = !$existingDueDate ? "Due: {$dueDateFormatted} | " : "";
                            $this->command->info("✅ #{$ticketNumber}: '{$serviceNameRaw}' → {$dueDateInfo}Updated: {$updatedAtFormatted} (+{$durationDays} hari kerja){$lateStatus}");
                        }
                    }
                } catch (\Exception $e) {
                    $this->command->error("   Update error #{$ticketNumber}: " . $e->getMessage());
                    $skipped++;
                }

                if (($processed + $skipped + $timestampErrors + $mappingErrors + $isLateOnlyUpdates) % 100 === 0) {
                    $total = $processed + $skipped + $timestampErrors + $mappingErrors + $isLateOnlyUpdates;
                    $this->command->info("   Progress: {$total} tickets processed...");
                }
            }

            $this->command->info("");
            $this->command->info("🎉 Seeder selesai!");
            $this->command->info("📊 Statistik Detail:");
            $this->command->info("   - ✅ Berhasil diproses (dueDate + isLate): {$processed} tickets");
            $this->command->info("   - 🔧 Update isLate saja: {$isLateOnlyUpdates} tickets");
            $this->command->info("   - ⚠️  Data tidak lengkap: {$skipped} tickets");
            $this->command->info("   - 🕐 Error parsing timestamp: {$timestampErrors} tickets");
            $this->command->info("   - 🔗 Mapping tidak ditemukan: {$mappingErrors} tickets");
            $this->command->info("   - ⏰ Tickets yang terlambat: {$lateTickets} tickets");

            if ($foundMappings->count() > 0) {
                $this->command->info("");
                $this->command->info("✅ Service mappings yang berhasil ditemukan:");
                $foundMappings->unique()->each(function ($dbName, $mongoName) {
                    $this->command->info("   '{$mongoName}' → '{$dbName}'");
                });
            }

        } catch (\Throwable $e) {
            Log::error("❌ Error: " . $e->getMessage());
            $this->command->error("Error: " . $e->getMessage());
        }
    }

    private function parseMongoDate($dateRaw)
    {
        if (is_object($dateRaw) || is_array($dateRaw)) {
            $dateArray = json_decode(json_encode($dateRaw), true);
            if (isset($dateArray['$date']['$numberLong'])) {
                $timestamp = $dateArray['$date']['$numberLong'];
                $timestampSeconds = intval($timestamp / 1000);
            } elseif (isset($dateArray['$date'])) {
                $timestampSeconds = strtotime($dateArray['$date']);
            } else {
                throw new \Exception("Unknown MongoDB date format");
            }
        } elseif (is_numeric($dateRaw)) {
            $timestampSeconds = intval($dateRaw / 1000);
        } elseif (is_string($dateRaw)) {
            $timestampSeconds = strtotime($dateRaw);
        } else {
            throw new \Exception("Unsupported date format");
        }

        if ($timestampSeconds === false || $timestampSeconds < 1577836800 || $timestampSeconds > 1893456000) {
            throw new \Exception("Invalid timestamp: {$timestampSeconds}");
        }

        return $timestampSeconds;
    }

    private function normalizeServiceName($name)
    {
        return trim(preg_replace('/\s+/', ' ', $name));
    }

    private function findServiceMapping($mappings, $serviceName)
    {
        $normalized = $this->normalizeServiceName($serviceName);

        foreach ([
            $serviceName,
            trim($serviceName),
            $normalized,
            strtolower($serviceName),
            strtoupper($serviceName),
            strtolower($normalized),
        ] as $variant) {
            if ($mappings->has($variant)) {
                return $mappings->get($variant);
            }
        }

        return null;
    }

    /**
     * Tambahkan sejumlah hari kerja ke dalam timestamp.
     * Weekend (Sabtu/Minggu) dilewati, tanpa cek hari libur nasional.
     */
    private function addWorkingDays($startTimestamp, $daysToAdd)
    {
        $current = $startTimestamp;
        $added = 0;

        while ($added < $daysToAdd) {
            $current += 86400; // Tambah 1 hari
            $dayOfWeek = date('w', $current);

            if ($dayOfWeek != 0 && $dayOfWeek != 6) {
                $added++;
            }
        }

        return $current;
    }
}
