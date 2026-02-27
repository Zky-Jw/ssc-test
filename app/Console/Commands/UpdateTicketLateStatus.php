<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateTicketLateStatus extends Command
{
    protected $signature = 'tickets:update-late-status {--dry-run : Show what would be updated without making changes}';
    protected $description = 'Update isLate field based on updated_at, dueDate, and current time comparison';

    public function handle()
    {
        $this->info('🚀 Starting ticket late status update based on updated_at vs dueDate...');

        $now = Carbon::now();
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->warn('🔍 DRY RUN MODE - No changes will be made');
        }

        try {
            // Ambil hanya tickets yang masih on progress dan memiliki dueDate
            $tickets = Ticket::where('active', 'Y')
                ->whereNotNull('dueDate')
                ->where(function($query) {
                    $openStatuses = ['on progress'];
                    $query->whereIn('status', $openStatuses)
                          ->orWhereNull('status');
                })
                ->get();

            $this->info("📊 Processing {$tickets->count()} open tickets with dueDate");

            $lateCount = 0;
            $notLateCount = 0;
            $totalUpdated = 0;

            foreach ($tickets as $ticket) {
                $dueDate = Carbon::parse($ticket->dueDate);
                $updatedAt = Carbon::parse($ticket->updated_at);
                $currentIsLate = $ticket->isLate ?? false;

                // Tentukan status late berdasarkan logika untuk open tickets
                $shouldBeLate = $this->determineIsLateForOpenTicket($dueDate, $updatedAt, $now);

                // Track statistik
                if ($shouldBeLate) {
                    $lateCount++;
                } else {
                    $notLateCount++;
                }

                if ($currentIsLate !== $shouldBeLate) {
                    if ($isDryRun) {
                        $status = $shouldBeLate ? 'LATE' : 'ON TIME';
                        $reason = $this->getReasonTextForOpenTicket($dueDate, $updatedAt, $now);
                        $this->line("   #{$ticket->ticketNumber} → {$status} ({$reason})");
                    } else {
                        $ticket->update([
                            'isLate' => $shouldBeLate,
                            'updated_at' => $now
                        ]);
                        $totalUpdated++;
                    }
                }
            }

            if ($isDryRun) {
                $this->info("\n📊 Summary (DRY RUN) - Open Tickets Only:");
                $this->info("   🔴 Would be marked as LATE: {$lateCount}");
                $this->info("   🟢 Would be marked as ON TIME: {$notLateCount}");
                $this->warn("\n⚠️  Use without --dry-run to apply changes");
                return Command::SUCCESS;
            }

            // Log untuk monitoring
            Log::info('Open ticket late status updated', [
                'total_processed' => $tickets->count(),
                'total_updated' => $totalUpdated,
                'late_count' => $lateCount,
                'on_time_count' => $notLateCount,
                'timestamp' => $now->toDateTimeString()
            ]);

            $this->info("\n📊 Final Statistics (Open Tickets Only):");
            $this->info("   📋 Total processed: {$tickets->count()} open tickets");
            $this->info("   🔄 Updated: {$totalUpdated} tickets");
            $this->info("   🔴 Currently late: {$lateCount} tickets");
            $this->info("   🟢 Currently on time: {$notLateCount} tickets");
            $this->info("\n✅ Successfully completed at: {$now->toDateTimeString()}");

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Error updating ticket status: " . $e->getMessage());

            Log::error('Failed to update ticket late status', [
                'error' => $e->getMessage(),
                'timestamp' => $now->toDateTimeString()
            ]);

            return Command::FAILURE;
        }
    }

    /**
     * Tentukan apakah open ticket terlambat berdasarkan updated_at, dueDate, dan waktu sekarang
     */
    private function determineIsLateForOpenTicket($dueDate, $updatedAt, $now)
    {
        // Untuk ticket yang masih open, ada 2 kondisi late:
        // 1. Jika sudah di-update setelah deadline
        if ($updatedAt->gt($dueDate)) {
            return true;
        }

        // 2. Jika belum di-update tapi deadline sudah lewat
        if ($now->gt($dueDate)) {
            return true;
        }

        // Tidak late jika masih dalam deadline
        return false;
    }

    /**
     * Get reason text for open tickets dry run output
     */
    private function getReasonTextForOpenTicket($dueDate, $updatedAt, $now)
    {
        if ($updatedAt->gt($dueDate)) {
            $diffDays = $updatedAt->diffInDays($dueDate);
            return "Updated {$diffDays} days after deadline";
        } elseif ($now->gt($dueDate)) {
            $diffDays = $now->diffInDays($dueDate);
            return "Deadline passed {$diffDays} days ago";
        } else {
            $diffDays = $dueDate->diffInDays($now);
            return "{$diffDays} days until deadline";
        }
    }
}
