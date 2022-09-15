<?php

namespace App\Http\Controllers;

use App\Models\tblusers;
use App\Models\tbluserrolepages;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class userManagementController extends Controller
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

         $page_id = tbluserrolepages::user_page_id;
           if ($request->route()->getName()=='usermanagement.destroy') {
                $access='deleteright';
           }
           elseif($request->route()->getName()=='usermanagement.index' || $request->route()->getName()=='usermanagement.show'){
                $access='readright';
           }elseif($request->route()->getName()=='usermanagement.create'){
                $access='addright';
           }elseif($request->route()->getName()=='usermanagement.edit' ){
                $access='editright';
           }else{
                $access="none";
           }
           if (HASACCESS($page_id,\Auth::user()->userroleid,$access) || \Auth::user()->admin_right->adminrole==true) {
                return $next($request);
           }
           // if ($request->route()->getName()=='usermanagement.destroy') {
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
        $admin = "admin";
        $users = DB::select('SELECT a.id, a.first_name, a.last_name, a.phone_number, a.email, a.state, a.district, a.taluk, b.userrole, a.username FROM public.tblusers a LEFT JOIN public.tbluserroles b ON a.userroleid=b.id WHERE a.username!=:username', ['username' => $admin]);
        return view('userManagement.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $project=Projects::all()->select('id','projectname');
        $userrole = DB::select('SELECT id, userrole FROM public.tbluserroles');
        $state = DB::select('SELECT DISTINCT state FROM public.tblpostaldatas ORDER BY state');

        return view('usermanagement.create', compact('userrole', 'state'));
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
            'role' => 'required',
            'username' => 'required|unique:tblusers,username',
            'password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'phonenumber' => 'required',
            'email' => 'required|unique:tblusers,email',
            'state' => 'required',
            'district' => 'required',
            'taluk' => 'required'
        ]);

        $sql = 'INSERT INTO public.tblusers(
            first_name, last_name, phone_number, email, state, district, taluk, address, userroleid, username, password, created_at, updated_at) VALUES (:first_name, :last_name, :phone_number, :email, :state, :district, :taluk, :address, :userroleid, :username, :password, NOW(), NOW())';
        $vals = [
            'userroleid' => $request->role,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'first_name' => $request->firstname,
            'last_name' => $request->lastname,
            'phone_number' => $request->phonenumber,
            'email' => $request->email,
            'state' => $request->state,
            'district' => $request->district,
            'taluk' => $request->taluk,
            'address' => $request->address
        ];

        if (DB::insert($sql, $vals)) {
            return redirect()->route('usermanagement.index')
                ->with('success', 'Users has been created successfully.');
        } else {
            return redirect()->route('usermanagement.index')
                ->with('danger', 'error in user creation');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(tblusers $userdata)
    {
        $userrole = DB::select('SELECT id, userrole FROM public.tbluserroles');
        $state = DB::select('SELECT DISTINCT state FROM public.tblpostaldatas ORDER BY state');

        return view('usermanagement.edit', compact('userdata', 'userrole', 'state'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userdata = tblusers::find($id);

        $userrole = DB::select('SELECT id, userrole FROM public.tbluserroles');

        $state = DB::select('SELECT DISTINCT state FROM public.tblpostaldatas ORDER BY state');

        $district = DB::select('SELECT DISTINCT district FROM public.tblpostaldatas ORDER BY district');

        $block = DB::select('SELECT DISTINCT block FROM public.tblpostaldatas ORDER BY block');

        return view('usermanagement.edit', compact('userdata', 'userrole', 'state', 'district', 'block'));
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
            'role' => 'required',
            'username' => 'required|unique:tblusers,username,' . $id,
            'firstname' => 'required',
            'lastname' => 'required',
            'phonenumber' => 'required',
            'email' => 'required',
            'state' => 'required',
            'district' => 'required',
            'taluk' => 'required'
        ]);

        $userdata = tblusers::find($id);
        $userdata->userroleid = $request->role;
        $userdata->username = $request->username;
        $pwd = $request->password;
        if ($pwd == null || $pwd == '') {
        } else {
            $userdata->password = Hash::make($request->password);
        }
        $userdata->first_name = $request->firstname;
        $userdata->last_name = $request->lastname;
        $userdata->phone_number = $request->phonenumber;
        $userdata->email = $request->email;
        $userdata->state = $request->state;
        $userdata->district = $request->district;
        $userdata->taluk = $request->taluk;
        $userdata->address = $request->address;
        $userdata->save();
        return redirect()->route('usermanagement.index')
            ->with('success', 'User Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        tblusers::where('id', $id)->delete();
        return redirect()->route('usermanagement.index')
            ->with('success', 'User has been deleted successfully');
    }

    public function loginCheck(Request $request)
    {

        $credentials = array([
            'username' => $request->email,
            'password' => $request->password
        ]);
        if (Auth::attempt($credentials)) {
            echo "1";
        } else {
            echo "0";
        }
    }
}
