<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Ticket extends Model
{
    protected $guards = []; 
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;

    public function user() :BelongsTo 
    {
        return $this->belongsTo(User::class);
    }
}
