<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prolongation extends Model
{
    //protected $primaryKey = ['num_res', 'date_debut', 'date_fin'];
    //public $incrementing = false;
    protected $fillable = [
    'num_res',
    'date_debut',
    'date_fin',
    'avance',
    'mode_paiement'
    ];
}
