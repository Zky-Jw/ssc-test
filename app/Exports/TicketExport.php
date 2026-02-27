<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth;

class TicketExport implements FromCollection, WithHeadings
{
    protected $status;
    protected $unit;
    protected $petugas;
    protected $sortType;
    protected $sortBy;

    public function __construct($status, $unit, $petugas, $sortBy, $sortType)
    {
        $this->status = $status;
        $this->unit = $unit;
        $this->petugas = $petugas;
        $this->sortBy = $sortBy;
        $this->sortType = $sortType;
    }

    public function collection()
    {
        $query = Ticket::when($this->status, function ($query) {
                return $query->where('status', $this->status);
            })
            ->when($this->unit, function ($query) {
                return $query->where('purpose.unit.name', $this->unit);
            })
            ->when($this->petugas, function ($query) {
                return $query->where('person.recipient.name', $this->petugas);
            });

        $query = $query->orderBy($this->sortBy, $this->sortType);

        return $query->get()->map(function ($ticket) {
            return [
                'ticketNumber' => $ticket->ticketNumber ?? '',
                'creatorName'  => $ticket->person['creator']['name'] ?? '',
                'creatorMajor'  => $ticket->person['creator']['major'] ?? '',
                'creatorYear'  => $ticket->person['creator']['years'] ?? '',
                'status'       => $ticket->status ?? 'on progress',
                'created_at'   => $ticket->created_at ? $ticket->created_at->format('Y-m-d H:i:s') : '',
                'unitName'     => $ticket->purpose['unit']['name'] ?? '',
                'serviceName'  => $ticket->purpose['service']['name'] ?? '',
                'dueDate'      => $ticket->dueDate ?? '',
                'updatedAt'      => $ticket->updated_at ?? '',
            ];
        });
    }


    public function headings(): array
    {
        if($this->status === 'closed'){
            return ['Nomor Tiket', 'Pemilik', 'Prodi', 'Angkatan',  'Status', 'Tanggal Pengajuan', 'Unit', 'Layanan', 'Tenggat Waktu', 'Closed Date'];
        }else{
            return ['Nomor Tiket', 'Pemilik', 'Prodi', 'Angkatan',  'Status', 'Tanggal Pengajuan', 'Unit', 'Layanan', 'Tenggat Waktu'];
        }
    }
}
