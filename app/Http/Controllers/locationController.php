<?php

namespace App\Http\Controllers;

use App\Models\tbllocations;
use App\Models\tbluserrolepages;
use App\Models\tblmultilocations;
use App\Http\Controllers\Debugbar;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class locationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
         $this->middleware(function($request,$next)
       {
         $page_id = tbluserrolepages::location_page_id;
           if ($request->route()->getName()=='location.destroy') {
                $access='deleteright';
           }
           elseif($request->route()->getName()=='location.index' || $request->route()->getName()=='location.show'){
                $access='readright';
           }elseif($request->route()->getName()=='location.create'){
                $access='addright';
           }elseif($request->route()->getName()=='location.edit' ){
                $access='editright';
           }else{
                $access="none";
           }
           if (HASACCESS($page_id,\Auth::user()->userroleid,$access) || \Auth::user()->admin_right->adminrole==true) {
                return $next($request);
           }
           // if ($request->route()->getName()=='location.destroy') {
           //          $msg="Access Denied";
           //          return response()->json(['success' => 2, 'msg' => $msg]);        
           //      }
        flashMessage('error','Access Denied');
                
               return redirect('home');
           
       })->only(['create','edit','destroy','index']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $location=tbllocations::all();
        return view('location.index',compact('location'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $state=DB::select('SELECT DISTINCT state FROM public.tblpostaldatas ORDER BY state');
        return view('location.create',compact('state'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'location'=>'required|unique:tbllocations,locationname',
            'zone'=>'required',
            'multipleinput.*.state'=>'required'
        ]);

        $tbllocation=new tbllocations;
        $tbllocation->locationname=$request->location;
        $tbllocation->zone=$request->zone;
        $tbllocation->save();
        $locationid=$tbllocation->id;

        foreach ($request->multipleinput as $key => $value) {
            
            // Log::debug($value);
            // Log::debug($value['long']);
            
            // Debugbar::debug($value);
            $sql2='INSERT INTO public.tblmultilocations(
                locationid, taluk, village, district, state, address, lat, long, geom, created_at, updated_at, city, ward)
                VALUES (:locationid, :taluk, :village, :district, :state, :address, :lat, :long, :geom, NOW(), NOW(), :city, :ward)';
            
            $long=$value['long'];
            $lat=$value['lat'];

            $vals2=[
                'locationid' => $locationid,
                'taluk' => $value['taluk'],
                'village' => $value['village'],
                'district' => $value['district'],
                'state' => $value['state'],
                'address' => $value['address'],
                'lat' => $lat,
                'long' => $long,
                'city' => $value['city'],
                'ward' => $value['ward'],
                'geom' => 'POINT('."$long $lat".')'
            ];

            DB::insert($sql2,$vals2);
        }
        
        return redirect()->route('location.index')
            ->with('success', 'Location has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $locationdata=DB::select('SELECT a.locationname, b.taluk,b.village,b.district, b.state, b.address FROM public.tbllocations a, public.tblmultilocations b where a.id=b.locationid and a.id=?',[$id]);
        return view('location.show', compact('locationdata'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $location=tbllocations::find($id);
        $locationdata=DB::select('SELECT id, taluk, village, district, state, address, lat, long, city, ward FROM public.tblmultilocations WHERE locationid=?',[$id]);
        $state=DB::select('SELECT DISTINCT state FROM public.tblpostaldatas ORDER BY state');
        $district=DB::select('SELECT DISTINCT district FROM public.tblpostaldatas ORDER BY district');
        $taluk=DB::select('SELECT DISTINCT block as taluk FROM public.tblpostaldatas ORDER BY taluk');
        return view('location.edit',compact('location', 'locationdata', 'state', 'district', 'taluk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'location'=>'required',
            'zone'=>'required',
            'multipleinput.*.state'=>'required'
        ]);

        $tbllocation=tbllocations::find($id);
        $tbllocation->locationname=$request->location;
        $tbllocation->zone=$request->zone;
        $tbllocation->save();

        tblmultilocations::where('locationid', $id)->delete();

        foreach ($request->multipleinput as $key => $value) {
            
            // Log::debug($value);
            // Log::debug($value['long']);
            
            // Debugbar::debug($value);
            $sql2='INSERT INTO public.tblmultilocations(
                locationid, taluk, village, district, state, address, lat, long, geom, created_at, updated_at, city, ward)
                VALUES (:locationid, :taluk, :village, :district, :state, :address, :lat, :long, :geom, NOW(), NOW(), :city, :ward)';
            
            $long=$value['long'];
            $lat=$value['lat'];

            $vals2=[
                'locationid' => $id,
                'taluk' => $value['taluk'],
                'village' => $value['village'],
                'district' => $value['district'],
                'state' => $value['state'],
                'address' => $value['address'],
                'lat' => $value['lat'],
                'long' => $value['long'],
                'city' => $value['city'],
                'ward' => $value['ward'],
                'geom' => 'POINT('."$long $lat".')'
            ];

            DB::insert($sql2,$vals2);
        }
        
        return redirect()->route('location.index')
            ->with('success', 'Location has been updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        tbllocations::where('id', $id)->delete();
        tblmultilocations::where('locationid', $id)->delete();
        return redirect()->route('location.index')
            ->with('success', 'User Role has been deleted successfully');
    }
}
