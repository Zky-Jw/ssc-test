<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;

class TicketLog extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'ticketlog';

    // ticketId head content attachment by timestamp
    protected $fillable = [
        'ticketId',
        'action',
        'content',
        'ticketdata',
        'by',
        'timestamp',
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
