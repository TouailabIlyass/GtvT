<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $primaryKey = 'numPiece';
    public $incrementing = false;
    protected $fillable = [
        'numPiece',
        'pieceIdentite',
        'dateDelivrPiece',
        'nom',
        'prenom',
        'telephone',
        'numPermis',
        'dateDelivrPermis',
        'dateLivrePermis',
        'dateLivrePiece',
        'lieuDelivrPiece',
        'lieuDelivrPermis',
        'dateNaissance',
        'lieuNaissance',
        'codePostale',
        'email',
        'pieceIdentiteScan',
        'permisScan',
        'addresse',
        'nationalite',
        'ville'
    ];
    protected $hidden = ['created_at', 'updated_at'];
}
