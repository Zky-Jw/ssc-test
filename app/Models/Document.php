<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Jenssegers\Mongodb\Eloquent\Model;

use MongoDB\Laravel\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $table = 'document';

    protected $fillable = [
        'id',
        'ticketNumber',
        'template',
        'approval',
        'content',
        'enclosure',
        'created',
    ];
    protected $casts = [
        'id' => 'string',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
