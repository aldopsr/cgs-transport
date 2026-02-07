<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ritase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'queue_id',
        'tujuan',
        'keterangan',
        'waktu_berangkat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }
}