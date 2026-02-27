<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Jenssegers\Mongodb\Eloquent\Model;

use MongoDB\Laravel\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $table = 'ticket';

    protected $fillable = [
        'feedback',
        'attachment',
        'created',
        'person',
        'purpose',
        'category',
        'updated',
        'rating',
        'status',
        'active',
        'ticketNumber',
        'ticketNumberStr',
        'content',
        'id',
        'dueDate',
        'isLate'
    ];

    protected $casts = [
        'id' => 'string',
        'ticketNumber' => 'string',
    ];

    public function progress()
    {
        return $this->hasMany('App\Models\TicketProgress', 'ticketId', 'id');
    }

    public function logs()
    {
        return $this->hasMany('App\Models\TicketLog', 'ticketId', 'id');
    }

    public function resolution()
    {
        return $this->hasMany('App\Models\Resolution', 'ticketId', 'id');
    }

    public function document()
    {
        return $this->hasOne('App\Models\Document', 'ticketNumber', 'ticketNumber');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function scopeOnProgress($query)
    {
        return $query->where('status', 'on progress');
    }

    public function scopeCreatedToday($query)
    {
        return $query->whereBetween('created_at', [Carbon::today(), Carbon::tomorrow()]);
    }

    public function scopeUpdatedToday($query)
    {
        return $query->whereBetween('updated_at', [Carbon::today(), Carbon::tomorrow()]);
    }
}
