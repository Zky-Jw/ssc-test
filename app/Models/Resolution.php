<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Jenssegers\Mongodb\Eloquent\Model;

use MongoDB\Laravel\Eloquent\Model;

class Resolution extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'resolution';

    // ticketId head content attachment by timestamp
    protected $fillable = [
        'ticketId',
        'resolution',
        'response',
        'attachment',
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
