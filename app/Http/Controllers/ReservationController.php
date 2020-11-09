<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Reservation;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $reservations = Reservation::all();

        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $reservation = new Reservation();
        return view('reservations.create', compact('reservation'));
    }

    public function store()
    {
        $reservations = Reservation::create($this->validateData());
        return redirect('/reservations/'.$reservations->id);
    }

    //Route Model Binding => \App\Customer $var
    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        return view('reservations.edit', compact('reservation'));
    }

    public function update(Reservation $reservation)
    {
        $reservation->update($this->validateData());    

        return redirect('/reservations/'.$reservations->id);
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect('/reservations');
    }


    public function validateData()
    {
        return request()->validate([

			'numRes' => 'required|max:30|',

			'numPiece' => 'required|max:30|',

			'immatricule' => 'required|max:30|',

			'Date_depart' => 'required|max:50|',

			'Lieu_depart' => 'required|max:30|',

            'Date_retour' => 'required|max:50|',
            
            'Date_retour_reelle' => '',

			'Lieu_retour' => 'required|max:30|',

            'Montant' => 'required|max:30|',
            
            'pu' => 'required',

            'Mode_paiement' => 'required|max:30|',

            'carburant_depart' => 'required',

            'carburant_retour' => 'required',

            'km_depart' => 'required',

            'km_retour' => 'required',

            'numPieceConducteur' => 'max:30|',

            'depot' => 'required|max:30|',

			'solde' => 'max:30|',

        ]);
        
 }

    public function validateApp()
    {
        $mac='00-27-10-ED-FF-E0';
        $newmac='';
        foreach(explode("\n",str_replace(' ','',trim(`getmac`,"\n"))) as $i){
           // if(strpos($i,'Tcpip')>-1){$newmac.=substr($i,0,17).";";}
            //else if(strpos($i,'N/A')>-1){$newmac.=substr($i,0,17).";";}
            $newmac.=substr($i,0,17).";";
        }
        if($newmac != '')
        {
            foreach(explode(';',$newmac) as $i)
            {
                if($i === $mac)
                {
                    return true;
                }
            }
        }
        return true;
    }

    //----------------------------------------Rest Controllers----------------------
    
    public function restIndex()
    {
        if(!$this->validateApp())
        {
            return '-166';
        }

        try{
            $data = Reservation::orderBy('reservations.created_at','DESC')
            ->paginate(2);
            $len = count($data->items());
            for($i = 0 ; $i < $len ; $i++)
            {
                $client =  DB::table('clients')->where('clients.numPiece','=', $data->items()[$i]->numPiece)->first();
                $conducteur =  DB::table('clients')->where('clients.numPiece','=', $data->items()[$i]->numPieceConducteur)->first();
                $vehicule = DB::table('vehicules')->where('vehicules.immatricule', '=', $data->items()[$i]->immatricule)->select('marque')->addSelect('modele')->first();
                $prolongation = DB::table('prolongations')->where('prolongations.num_res', '=', $data->items()[$i]->numRes)->get();
                $data->items()[$i]['client'] = $client;
                $data->items()[$i]['conducteur'] = $conducteur;
                $data->items()[$i]['marque'] = $vehicule->marque;
                $data->items()[$i]['modele'] = $vehicule->modele;
                $data->items()[$i]['prolongation'] = $prolongation;
            }
            return $data;
        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
        
    }

    public function restReservationActif()
    {    
        if(!$this->validateApp())
        {
            return '-166';
        }
        
        try{
            $data = Reservation::orderBy('reservations.created_at','DESC')
            ->whereNull('Date_retour_reelle')
            ->paginate(2);
            $len = count($data->items());
            for($i = 0 ; $i < $len ; $i++)
            {
                $client =  DB::table('clients')->where('clients.numPiece','=', $data->items()[$i]->numPiece)->first();
                $conducteur =  DB::table('clients')->where('clients.numPiece','=', $data->items()[$i]->numPieceConducteur)->first();
                $vehicule = DB::table('vehicules')->where('vehicules.immatricule', '=', $data->items()[$i]->immatricule)->select('marque')->addSelect('modele')->first();
                $prolongation = DB::table('prolongations')->where('prolongations.num_res', '=', $data->items()[$i]->numRes)->get();
                $data->items()[$i]['client'] = $client;
                $data->items()[$i]['conducteur'] = $conducteur;
                $data->items()[$i]['marque'] = $vehicule->marque;
                $data->items()[$i]['modele'] = $vehicule->modele;
                $data->items()[$i]['prolongation'] = $prolongation;
            }
            return $data;
        }catch(\Exception $e)
        {
            return $e->getMessage();
        }
        
    }

    public function restStore()
    {
        DB::beginTransaction();
        try
        {        
            if(Request()->input('Mode_paiement') != 'espece')
            {    $validateCarte = request()->validate([
                'nom_banq' => 'required|max:30|',
                'num_cart' => 'required|max:30|',
                ]);
                if($validateCarte)
                {
                    Reservation::create($this->validateData());
                    DB::update('update vehicules  set disponible = 0 where immatricule = ?', [request()->input('immatricule')]);
                    DB::commit();
                    return true;
                }
            }
            Reservation::create($this->validateData());
            DB::update('update vehicules  set disponible = 0 where immatricule = ?', [request()->input('immatricule')]);
            DB::commit();
            return true;
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return $e->getMessage();
        }
    }

    //Route Model Binding => \App\Customer $var
    public function restShow(Reservation $reservation)
    {
        return $reservation;
    }

    
    public function restUpdate(Reservation $reservation)
    {   
        DB::beginTransaction();
        try{
            if($reservation == null) return false;
            if (Request()->filled('Date_retour_reelle')){
                if ($reservation->Date_retour_reelle != request()->input('Date_retour_reelle'))
                {
                    DB::update('update vehicules  set disponible = 1 where immatricule = ?', [$reservation->immatricule]);
                }
            }    
            $reservation->update($this->validateData());
            DB::commit();
            return true;
        }catch(\Exception $e)
        {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function RestDestroy(Reservation $reservation)
    {   
        DB::beginTransaction();
        try{
            $prolongation = new \App\Prolongation();
            $prolongation->where('num_res', '=', $reservation->numRes)->delete();
            DB::update('update vehicules  set disponible = 1 where immatricule = ?', [$reservation->immatricule]);
            $reservation->delete();
            DB::commit();
            return true;
        }catch(\Exception $e)
        {   
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function restGetOne($keyword)
    {   
        if(strlen(trim($keyword)) == 0) return;
        $data = Reservation::where('numRes', 'LIKE', '%'.$keyword.'%')
        ->orWhere('numPiece','LIKE',"%{$keyword}%")
        ->orWhere('immatricule','LIKE',"%{$keyword}%")
        ->paginate(2);
        return $data;
    }
}
        