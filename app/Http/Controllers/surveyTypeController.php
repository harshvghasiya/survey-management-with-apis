<?php

namespace App\Http\Controllers;

use App\Models\tblsurveytypes;
use App\Models\tbluserrolepages;
use Illuminate\Http\Request;

class surveyTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

          $this->middleware(function($request,$next)
       {
         $page_id = tbluserrolepages::surveyforms_page_id;
          if ($request->route()->getName()=='surveytypes.destroy') {
                $access='deleteright';
           }
           elseif($request->route()->getName()=='surveytypes.index' || $request->route()->getName()=='surveytypes.show'){
                $access='readright';
           }elseif($request->route()->getName()=='surveytypes.create'){
                $access='addright';
           }elseif($request->route()->getName()=='surveytypes.edit' ){
                $access='editright';
           }else{
                $access="none";
           }
           if (HASACCESS($page_id,\Auth::user()->userroleid,$access) || \Auth::user()->admin_right->adminrole==true) {
                return $next($request);
           }
           if ($request->route()->getName()=='surveytypes.destroy') {
                    $msg="Access Denied";
                    return response()->json(['success' => 2, 'msg' => $msg]);        
                }

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
        $survey = tblsurveytypes::all();
        return view('surveytypes.index',compact('survey'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('surveytypes.create');
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
            'surveytype' => 'required|unique:tblsurveytypes,surveytype'
        ]);

        $surveydata = new tblsurveytypes;
        $surveydata->surveytype = $request->surveytype;
        $surveydata->description = $request->description;
        $surveydata->save();

        return redirect()->route('surveytypes.index')
            ->with('success', 'Survey Type Has Been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $surveydata = tblsurveytypes::find($id);

        return view('surveytypes.edit',compact('surveydata'));
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
            'surveytype' => 'required'
        ]);

        $surveydata = tblsurveytypes::find($id);
        $surveydata->surveytype = $request->surveytype;
        $surveydata->description = $request->description;
        $surveydata->save();

        return redirect()->route('surveytypes.index')
            ->with('success', 'Survey Type Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author Method Edited  By Harsh Vaghasiya
     */
    public function destroy($id)
    {
        $exist=\App\Models\tblsurveys::where('surveytype_id',$id)->first();
        if ($exist != null) {
           $msg="Can't Delete Survey Type since it in use";
            $type='error';
            $status=2; 
        }else{
            tblsurveytypes::where('id', $id)->delete();
            $msg="Survey Type Deleted successfully";
            $type='success';
            $status=1;
        }
         return response()->json(['success' => $status, 'msg' => $msg]);  
    }
}
