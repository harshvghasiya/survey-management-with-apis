<?php

namespace App\Http\Controllers;

use App\Models\tblprojectcateogries;
use App\Models\tbluserrolepages;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class categoryController extends Controller
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
         $page_id = tbluserrolepages::projectcategory_page_id;
           if ($request->route()->getName()=='projectcategory.destroy') {
                $access='deleteright';
           }
           elseif($request->route()->getName()=='projectcategory.index' || $request->route()->getName()=='projectcategory.show'){
                $access='readright';
           }elseif($request->route()->getName()=='projectcategory.create'){
                $access='addright';
           }elseif($request->route()->getName()=='projectcategory.edit' ){
                $access='editright';
           }else{
                $access="none";
           }
           if (HASACCESS($page_id,\Auth::user()->userroleid,$access) || \Auth::user()->admin_right->adminrole==true) {
                return $next($request);
           }
           if ($request->route()->getName()=='projectcategory.destroy') {
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
        $category = tblprojectcateogries::all();
        return view('projectcategory.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projectcategory.create');
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
            'category' => 'required|unique:tblprojectcateogries,category'
        ]);

        $sql='INSERT INTO public.tblprojectcateogries (category, description) VALUES (:category, :description)';

        $vals=[
            'category' => $request->category,
            'description' => $request->description
        ];
        if(DB::insert($sql, $vals)){
            return redirect()->route('projectcategory.index')
            ->with('success', 'Project Category has been created successfully');
        }
        else{
            return redirect()->route('projectcategory.index')
            ->with('danger', 'error in Category creation');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $catdata = tblprojectcateogries::find($id);

        return view('projectcategory.edit',compact('catdata'));
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
            'category' => 'required'
        ]);

        $catedata = tblprojectcateogries::find($id);
        $catedata->category = $request->category;
        $catedata->description = $request->description;
        $catedata->save();
        return redirect()->route('projectcategory.index')
            ->with('success', 'Category Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author Method Edited By Harsh Vaghasiya
     */
    public function destroy($id)
    {
        $exist=\App\Models\tblprojects::where('category_id',$id)->first();
        if ($exist != null) {
           $msg="Can't Delete Category since it in use";
            $url=route('projectcategory.index');
            $type='error';
            $status=2; 
        }else{
            tblprojectcateogries::where('id', $id)->delete();
            $msg="Category Deleted successfully";
            $url=route('projectcategory.index');
            $type='success';
            $status=1;
        }

         return response()->json(['success' => $status, 'msg' => $msg]);        
        
    }
}
