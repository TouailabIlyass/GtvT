<?php

 namespace App;

use Illuminate\Database\Eloquent\Model;


class Reservation extends Model {
	
    protected $primaryKey = 'numRes';
	public $incrementing = false;
    protected $fillable = [
	'numRes',
	'numPiece',
	'immatricule',
	'Date_depart',
	'Lieu_depart',
	'Date_retour',
	'Date_retour_reelle',
	'Lieu_retour',
	'Montant',
	'pu',
	'Mode_paiement',
	'numPieceConducteur',
	'carburant_depart',
	'carburant_retour',
	'km_depart',
	'km_retour',
	'nom_banq',
	'num_cart',
	'depot',
	'solde',
	];
}