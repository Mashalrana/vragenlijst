<?php

namespace App\Models;

use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class History extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'subscriber_id',
        'message_id',
    ];

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
