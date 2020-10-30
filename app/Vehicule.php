<?php

 namespace App;

use Illuminate\Database\Eloquent\Model;


class Vehicule extends Model {
	
	protected $primaryKey = 'immatricule';
	public $incrementing = false;
    protected $fillable = [
	'immatricule',
	'marque',
	'modele',
	'Nombre_Place',
	'Puissance',
	'Date_circulation',
	'Lieu_stationnement',
	'Num_chassis',
	'Code_radio',
	'Categorie',
	'Curburant',
	'Couleur',
	'Delai_debut',
	'Delai_fin',
	'disponible',
	];
}