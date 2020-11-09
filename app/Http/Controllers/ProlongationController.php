<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Prolongation;

class ProlongationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function restGetByNumRes($numRes)
    {
        try{
            return  Prolongation::where('num_res', '=' ,$numRes)->get();
        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function validateData()
    {
        return request()->validate([
            'num_res' => 'required',
            'date_debut' => 'required',
            'date_fin' => 'required',
            'avance' => 'required',
            'mode_paiement' => 'required',
        ]);
    }

    public function restStore()
    {
       try{
           Prolongation::create($this->validateData());
           return true;
       }
       catch(\Exception $e)
       {
           return $e->getMessage();
       }
    }

    public function restDestroy(Prolongation $prolongation)
    {
       try{
           $prolongation->delete();
           return true;
       }
       catch(\Exception $e)
       {
           return $e->getMessage();
       }
    }
}
