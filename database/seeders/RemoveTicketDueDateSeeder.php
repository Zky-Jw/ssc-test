<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;

class RemoveTicketDueDateSeeder extends Seeder
{
    public function run(): void
    {
        $result = Ticket::raw(function ($collection) {
            return $collection->updateMany(
                [
                    '$or' => [
                        ['dueDate' => ['$exists' => true]],
                        ['isLate' => ['$exists' => true]]
                    ]
                ],
                [
                    '$unset' => [
                        'dueDate' => "",
                        'isLate' => ""
                    ]
                ]
            );
        });

        $count = $result->getModifiedCount();

        $this->command->info("🗑️ Field dueDate dan isLate berhasil dihapus dari $count tiket.");
    }
}
