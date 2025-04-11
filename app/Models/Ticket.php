<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'titolo',
        'descrizione',
        'requester_id',
        'stato'
    ];

    /**
     * Ottieni l'utente che ha richiesto questo ticket.
     */
    public function richiedente()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }
}