<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\EssentialMedicine;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cities = Cache::get('cities');
        if (!$cities) {
            logger('caching');
            $temp = $this->getCities();
            $caching =   Cache::put('cities', $temp, 120);

            $cities = Cache::get('cities');
        }
        // else {
        //     logger('cache exist');

        //     // return $c->count();
        // }
        $meds = [];
        return view('shop', compact('cities',));

        // $cities = City::all();

        // $meds = EssentialMedicine::with('medicine')->get(10);

    }



    public function show(Medicine $med)
    {
        $cities = Cache::get('cities');
        if (!$cities) {
            logger('caching');
            $temp = $this->getCities();
            $caching =   Cache::put('cities', $temp, 120);

            $cities = Cache::get('cities');
        }
        return view('med_show',compact('med','cities'));
    }
    public function getCities()
    {
        $cities = City::all();
        return $cities;
    }




    public function searchByCity(Request $request)
    {

        // return Medicine::all();
        //    return $request;
        // return Medicine::where(['city_id' => $request->city_id])->get();
           $cities = Cache::get('cities');
           if (!$cities) {
               logger('caching');
               $temp = $this->getCities();
               $caching =   Cache::put('cities', $temp, 120);

               $cities = Cache::get('cities');
           }

        $medicines = Medicine::where(['city_id' => $request->city_id, 'available' => true,])->where(function($query ) use ($request){

            $query->where('name', 'like', '%' . $request->search . '%');
            $query->orWhere('name_en', 'like', '%' . $request->search . '%');
            $query->orWhere('tags', 'like', '%' . $request->search . '%');
            // ->with('user')
        })
            ->paginate(25);

            $pharms = Pharmacy::where('active',true)->whereHas('user' ,function($query) use ($request){
                $query->where('city_id',$request->city_id);
            })

            ->paginate(25);
            // return $pharm;
            // $pharms = User::where(['type'=> 'pharmacy'])->paginate(25);

        return view('search', compact('medicines','cities','pharms'));
    }
    public function searchByLocation(Request $request)
    {
        // return $request;
        $cities = Cache::get('cities');
        if (!$cities) {
            logger('caching');
            $temp = $this->getCities();
            $caching =   Cache::put('cities', $temp, 120);

            $cities = Cache::get('cities');
        }




        // return $request;
        // $request->la


        $medicines = Medicine::where(['city_id' => $request->city_id, 'available' => true,])
            ->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('name_en', 'like', '%' . $request->search . '%')
            ->orWhere('tags', 'like', '%' . $request->search . '%')
            ->with('user')
            ->select(
                "medicines.id",
                "medicines.user_id",
                "medicines.name",
                "medicines.price",
                "medicines.dose",

                "medicines.lat",
                "medicines.lng",
                "medicines.img_url",
                /**
                 *  to use miles instead change @var[6371]
                 * to @var
                 */
                //
                DB::raw("6371 * acos(cos(radians(" . $request->lat . "))
            * cos(radians(medicines.lat))
            * cos(radians(medicines.lng) - radians(" . $request->lng . "))
            + sin(radians(" . $request->lat . "))
            * sin(radians(medicines.lat))) AS distance ")

            )
            // will search in provided radius
            // or use default as told to customers [default : 5 km]
            ->having('distance', '<', 25)
            ->groupBy("medicines.id")
            ->get();

        // return $showResult;
        // $type = $request->city_id;
        // $medicines = Medicine::where('city_id', $request->city_id)
        //     ->where('name', 'like', '%' . $request->search . '%')
        //     ->orWhere('name_en', 'like', '%' . $request->search . '%')
        //     ->orWhere('tags', 'like', '%' . $request->search . '%')
        //     ->paginate(25);

        // return $medicines;
        return view('search', compact('medicines','cities'));
    }
}
