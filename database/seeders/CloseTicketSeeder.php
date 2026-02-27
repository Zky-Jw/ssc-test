<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Person;
use App\Models\Service;
use App\Models\ServiceMapping;
use App\Models\ServiceCategory;
use App\Models\ServiceAdditional;
use App\Models\Unit;
use App\Models\Ticket;
use App\Models\TicketProgress;
use App\Models\TicketLog;
use App\Models\Resolution;

class CloseTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $arr = [
            ['ticket_id'=>13000789,'closed_date'=>'04/10/2025','resolution'=>'Reset 2FA SSO','response'=>'Silahkan melakukan reaktivasi authenticator','email'=>'salmans@telkomuniversity.ac.id'],
            ['ticket_id'=>13000780,'closed_date'=>'03/10/2025','resolution'=>'Reset 2FA SSO','response'=>'Silahkan melakukan reaktivasi authenticator','email'=>'salmans@telkomuniversity.ac.id'],
            ['ticket_id'=>13000770,'closed_date'=>'03/10/2025','resolution'=>'Reset 2FA SSO','response'=>'Silahkan melakukan reaktivasi authenticator','email'=>'salmans@telkomuniversity.ac.id'],
            ['ticket_id'=>13000767,'closed_date'=>'02/10/2025','resolution'=>'Reset 2FA SSO','response'=>'Silahkan melakukan reaktivasi authenticator','email'=>'salmans@telkomuniversity.ac.id'],
            ['ticket_id'=>13000766,'closed_date'=>'02/10/2025','resolution'=>'Reset 2FA SSO','response'=>'Silahkan melakukan reaktivasi authenticator','email'=>'salmans@telkomuniversity.ac.id'],
            ['ticket_id'=>13000762,'closed_date'=>'02/10/2025','resolution'=>'Reset 2FA SSO','response'=>'Silahkan melakukan reaktivasi authenticator','email'=>'salmans@telkomuniversity.ac.id'],
            ['ticket_id'=>13000481,'closed_date'=>'14/08/2025','resolution'=>'Reset 2FA SSO','response'=>'Silahkan melakukan reaktivasi authenticator','email'=>'salmans@telkomuniversity.ac.id'],
        ];

        foreach ($arr as $a) {

            $closedDate = \DateTime::createFromFormat('d/m/Y', $a['closed_date']);

            // Generate waktu acak antara 09:00:00 dan 15:00:00
            $startTimestamp = strtotime('09:00:00');
            $endTimestamp   = strtotime('15:00:00');
            $randomTime     = rand($startTimestamp, $endTimestamp);
            $randomTimeFormatted = date('H:i:s', $randomTime);

            // Gabungkan
            $closedDateTime = $closedDate->format('Y-m-d') . ' ' . $randomTimeFormatted;

            $ticket = Ticket::where('ticketNumber', $a['ticket_id'])->first();
            $p = Person::where('per_email', $a['email'])->first();

            $by = [
                'name' => $p->person,
                'id' => $p->id,
            ];

            $ticket->update([
                'status' => 'closed',
            ]);

            // input resolution
            $resolution = Resolution::create([
                'ticketId' => $ticket->id,
                'resolution' => $a['resolution'],
                'response' => $a['response'],
                'attachment' => '',
                'by' => $by,
                'timestamp' => $closedDateTime,
            ]);

            if (!$resolution) {
                throw new \Exception('Resolution failed to create.');
            }

            // input progress
            $ticketProgress = TicketProgress::create([
                'ticketId' => $ticket->id,
                'head' => 'closed',
                'content' => 'Ticket ' . $ticket->ticketNumber . ' ditutup oleh ' . $p->person . ', Tiket ditutup dengan keterangan ' . $a['response'],
                'attachment' => '',
                'by' => $by,
                'timestamp' => $closedDateTime,
            ]);

            if (!$ticketProgress) {
                throw new \Exception('Progress failed to create.');
            }

            $ticketLog = TicketLog::create([
                'ticketId' => $ticket->id,
                'action' => 'Ticket Closed',
                'content' => "Ticket closed by " . $p->person . " on " . $closedDateTime,
                'ticketdata' => $ticket->toArray(),
                'by' => $by,
                'timestamp' => $closedDateTime,
            ]);

            if (!$ticketLog) {
                throw new \Exception('Log failed to create.');
            }
            
        }

    }
}
