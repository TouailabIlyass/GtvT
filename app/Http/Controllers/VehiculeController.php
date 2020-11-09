<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Vehicule;

class VehiculeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vehicules = Vehicule::all();

        return view('vehicules.index', compact('vehicules'));
    }

    public function create()
    {
        $vehicule = new Vehicule();
        return view('vehicules.create', compact('vehicule'));
    }

    public function store()
    {
        $vehicules = Vehicule::create($this->validateData());
        return redirect('/vehicules/'.$vehicules->id);
    }

    //Route Model Binding => \App\Customer $var
    public function show(Vehicule $vehicule)
    {
        return view('vehicules.show', compact('vehicule'));
    }

    public function edit(Vehicule $vehicule)
    {
        return view('vehicules.edit', compact('vehicule'));
    }

    public function update(Vehicule $vehicule)
    {
        $vehicule->update($this->validateData());    

        return redirect('/vehicules/'.$vehicules->id);
    }

    public function destroy(Vehicule $vehicule)
    {
        $vehicule->delete();

        return redirect('/vehicules');
    }


    public function validateData()
    {
        return request()->validate([
			'immatricule' => 'required|max:30|',

            'marque' => 'required|max:30',

            'modele' => 'required|max:30',

			'Nombre_Place' => 'required|max:30|',

			'Puissance' => 'required|max:30|',

			'Date_circulation' => 'required|max:30|',

			'Lieu_stationnement' => 'required|max:30|',

			'Num_chassis' => 'required|max:30|',

			'Code_radio' => 'required|max:30|',

			'Categorie' => 'required|max:30|',

			'Curburant' => 'required|max:30|',

			'Couleur' => 'required|max:30|',

			'Delai_debut' => 'required|max:30|',

            'Delai_fin' => 'required|max:30|',
            
            'disponible' => '',

		]);
 }


    //----------------------------------------Rest Controllers----------------------
    
    public function restIndex()
    {
        return Vehicule::orderBy('created_at', 'DESC')
        ->paginate(2);
    }

    public function restVehiculeActif()
    {
        return Vehicule::orderBy('created_at','DESC')
        ->where('disponible','=',0)
        ->paginate(2);
    }

    public function restStore()
    {
        try
        {
         Vehicule::create($this->validateData());
         return true;
        }catch(Exception $e){
        return $e->getMessage();
        } 
        return false;
    }

    //Route Model Binding => \App\Customer $var
    public function restShow(Vehicule $vehicule)
    {
        return $vehicule;
    }

    
    public function restUpdate(Vehicule $vehicule)
    {
        try{
            $vehicule->update($this->validateData());
            return true;
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
        return false;
    }

    public function restDestroy(Vehicule $vehicule)
    {
        try{
            $vehicule->delete();
            return true;
        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function restGetAllMarque()
    {
       return Vehicule::select('marque')
        ->groupBy('marque')
        ->get();
    }
    public function restGetModelesByMarque($marques)
    {   
        return Vehicule::select('modele','immatricule')
        ->where('marque',$marques)
        ->where('disponible',1)
        ->get();
    }

    public function restGetOne($keyword)
    {   
        if(strlen(trim($keyword)) == 0) return;
        $data = Vehicule::where('immatricule', 'LIKE', '%'.$keyword.'%')
        ->orWhere('marque','LIKE',"%{$keyword}%")
        ->orWhere('modele','LIKE',"%{$keyword}%")
        ->paginate(2);
        return $data;
    }
}
        