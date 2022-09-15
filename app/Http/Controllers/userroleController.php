<?php

namespace App\Http\Controllers;

use App\Models\tblpages;
use App\Models\tbluserrolepages;
use App\Models\tbluserroles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class userroleController extends Controller
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
         $page_id = tbluserrolepages::userrole_page_id;
           if ($request->route()->getName()=='userrole.destroy') {
                $access='deleteright';
           }
           elseif($request->route()->getName()=='userrole.index' || $request->route()->getName()=='userrole.show'){
                $access='readright';
           }elseif($request->route()->getName()=='userrole.create'){
                $access='addright';
           }elseif($request->route()->getName()=='userrole.edit' ){
                $access='editright';
           }else{
                $access="none";
           }
           if (HASACCESS($page_id,\Auth::user()->userroleid,$access) || \Auth::user()->admin_right->adminrole==true) {
                return $next($request);
           }
           if ($request->route()->getName()=='userrole.destroy') {
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
        $userrole=tbluserroles::all();
        return view('userrole.index', compact('userrole'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $old=" ";
        $new="_";
        $pages=DB::select('SELECT pagename,REPLACE(pagename, ?, ?) AS new FROM public.tblpages',[$old, $new]);
        return view('userrole.create',compact('pages'));
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
            'userrole'=>'required|unique:tbluserroles,userrole'
        ]);

        $userrole=new tbluserroles;
        $userrole->userrole=$request->userrole;
        $userrole->adminrole=$request->adminrights;
        $userrole->description=$request->description;
        $userrole->save();
        $userroleid=$userrole->id;


        $pages=tblpages::all();
        foreach($pages as $pages){
            $page=$pages->pagename;
            $new='_';
            $old=' ';
            $page=Str::replaceFirst($old, $new, $page);
            $pagenamedata=$request->input('pagename');
            for($i=0;$i<count($pagenamedata);$i++){
                if($page==$pagenamedata[$i]){
                    $userrolepage=new tbluserrolepages;
                    $userrolepage->userroleid=$userroleid;
                    $userrolepage->page_id=$pages->id;

                    $userreadright="read".$page;
                    $userwriteright="write".$page;
                    $usereditright="edit".$page;
                    $userdeleteright="delete".$page;

                    
                    if($request->$userreadright==null){
                        $request->$userreadright='off';
                    }
                    if($request->$userwriteright==null){
                        $request->$userwriteright='off';
                    }
                    if($request->$usereditright==null){
                        $request->$usereditright='off';
                    }
                    if($request->$userdeleteright==null){
                        $request->$userdeleteright='off';
                    }

                    $userrolepage->readright=$request->$userreadright;
                    $userrolepage->addright=$request->$userwriteright;
                    $userrolepage->editright=$request->$usereditright;
                    $userrolepage->deleteright=$request->$userdeleteright;

                    $userrolepage->save();
                    // }
                }
            }
        }
        return redirect()->route('userrole.index')
            ->with('success', 'User Role Has Been inserted successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userroledata=DB::select('SELECT b.pagename, c.readright, c.addright, c.editright, c.deleteright FROM public.tblpages b, public.tbluserrolepages c WHERE c.page_id=b.id and c.userroleid=?',[$id]);
        return view('userrole.view', compact('userroledata'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userrole=tbluserroles::find($id);
        $userroledata=DB::select('SELECT b.pagename, c.readright, c.addright, c.editright, c.deleteright FROM public.tblpages b, public.tbluserrolepages c WHERE c.page_id=b.id and c.userroleid=?',[$id]);
        $old=" ";
        $new="_";
        $pages=DB::select('SELECT pagename,REPLACE(pagename, ?, ?) AS new FROM public.tblpages',[$old, $new]);
        return view('userrole.edit',compact('userroledata', 'userrole', 'pages'));
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
            'userrole'=>'required'
        ]);

        $userrole=tbluserroles::find($id);
        $userrole->userrole=$request->userrole;
        $userrole->adminrole=$request->adminrights;
        $userrole->description=$request->description;
        $userrole->save();
        $userroleid=$userrole->id;

        tbluserrolepages::where('userroleid', $id)->delete();
        $pages=tblpages::all();
        foreach($pages as $pages){
            $page=$pages->pagename;
            $new='_';
            $old=' ';
            $page=Str::replaceFirst($old, $new, $page);
            $pagenamedata=$request->input('pagename');
            for($i=0;$i<count($pagenamedata);$i++){
                if($page==$pagenamedata[$i]){
                    $userrolepage=new tbluserrolepages;
                    $userrolepage->userroleid=$userroleid;
                    $userrolepage->page_id=$pages->id;

                    $userreadright="read".$page;
                    $userwriteright="write".$page;
                    $usereditright="edit".$page;
                    $userdeleteright="delete".$page;

                    if($request->$userreadright==null){
                        $request->$userreadright='off';
                    }
                    if($request->$userwriteright==null){
                        $request->$userwriteright='off';
                    }
                    if($request->$usereditright==null){
                        $request->$usereditright='off';
                    }
                    if($request->$userdeleteright==null){
                        $request->$userdeleteright='off';
                    }

                    $userrolepage->readright=$request->$userreadright;
                    $userrolepage->addright=$request->$userwriteright;
                    $userrolepage->editright=$request->$usereditright;
                    $userrolepage->deleteright=$request->$userdeleteright;

                    $userrolepage->save();
                }
            }
        }
        return redirect()->route('userrole.index')
            ->with('success', 'User Role Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author Edited by Harsh
     */
    public function destroy($id)
    {
        $exist=\App\Models\tblusers::where('userroleid',$id)->first();
        if ($exist != null) {
            $msg = 'You Cant delete this resource since in use';
            $status = 2;
        }else{
        tbluserroles::where('id', $id)->delete();
        tbluserrolepages::where('userroleid', $id)->delete();
        $msg="Resource Deleted successfully.";
        $status=1;
        }
      return response()->json(['success' => $status, 'msg' =>$msg]);
        
    }
}
