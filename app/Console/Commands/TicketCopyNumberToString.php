<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket;

class TicketCopyNumberToString extends Command
{
    protected $signature = 'ticket:copy-number-to-string';
    protected $description = 'Menyalin nilai ticketNumber (int) ke ticketNumberStr (string)';

    public function handle()
    {
        $this->info('Memulai menyalin ticketNumber ke ticketNumberStr...');

        $tickets = Ticket::whereNull('ticketNumberStr')->get();
        $total = $tickets->count();

        foreach ($tickets as $ticket) {
            $ticket->ticketNumberStr = (string) $ticket->ticketNumber;
            $ticket->save();
        }

        $this->info("Selesai menyalin $total tiket.");
    }
}
