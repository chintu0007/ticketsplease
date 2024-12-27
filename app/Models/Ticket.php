<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guards = []; 
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;
}
