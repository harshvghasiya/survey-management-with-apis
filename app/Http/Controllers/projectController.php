<?php

namespace App\Http\Controllers;

use App\Models\tbllocations;
use App\Models\tbluserrolepages;
use App\Models\tblprojectcateogries;
use App\Models\tblprojectlocations;
use App\Models\ProjectSurvey;
use App\Models\ProjectSurveyOrder;
use App\Models\tblprojects;
use App\Models\tblprojectusers;
use App\Models\tblsurveyforms;
use App\Models\tblsurveys;
use App\Models\tblusers;
use App\Http\Requests\ProjectRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class projectController extends Controller
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
           $page_id = tbluserrolepages::project_page_id;
          if ($request->route()->getName()=='project.destroy') {
                $access='deleteright';
           }
           elseif($request->route()->getName()=='project.index' || $request->route()->getName()=='project.show'){
                $access='readright';
           }elseif($request->route()->getName()=='project.create'){
                $access='addright';
           }elseif($request->route()->getName()=='project.edit' ){
                $access='editright';
           }else{
                $access="none";
           }
           if (HASACCESS($page_id,\Auth::user()->userroleid,$access) || \Auth::user()->admin_right->adminrole==true) {
                return $next($request);
           }
           if ($request->route()->getName()=='project.destroy') {
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
        $projects = tblprojects::all();

        return view('project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = tblprojectcateogries::all();
        return view('project.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author Method Edited by Harsh Vaghasiya

     */
    public function store(ProjectRequest $request)
    {
        
        $projectdata = new tblprojects;
        $projectdata->projectname = $request->projectname;
        $projectdata->startdate = $request->startdate;
        $projectdata->enddate = $request->enddate;
        $projectdata->category_id = $request->category;
        $projectdata->targetbeneficiaries = $request->target;
        $projectdata->projectestimation = $request->estimation;
        $projectdata->description = $request->description;
        $projectdata->save();
        
        $msg="Project Updated successfully";
        $url=route('project.index');
        flashMessage('success',$msg);
        
        return response()->json(['msg'=>$msg,'status'=>true,'url'=>$url]);
   
    }


     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author  Harsh Vaghasiya
     */

     public function projectSurveyOrderUpdate(Request $request)
     {
        if ($request->survey_id != null) {
            ProjectSurvey::where('project_id',$request->project_id)->delete();
            foreach ($request->survey_id as $key => $value) {
                $res=new ProjectSurvey;
                $res->survey_id=$value;
                $res->project_id=$request->project_id;
                $res->order=$key;
                $res->save();
            }
        }
          $msg='Survey order changed successfully.';
        flashMessage('success',$msg);
        return response()->json(['status' => 1, 'msg' => $msg]);
     }


      /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author  Harsh Vaghasiya
     */
     public function projectSurveyDestroy(Request $request,$project_id,$survey_id)
     {
         ProjectSurvey::where('project_id',$project_id)->where('survey_id',$survey_id)->delete();
         $msg="Survey Deleted SuccessFully";
         return response()->json(['success' => 1,'type'=>'survey_order', 'msg' => $msg]);        

     }


      /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author  Harsh Vaghasiya
     */
    public function projectSurveyOrder(Request $request,$id)
    {
        $project=tblprojects::with(['project_surveys'])
                            ->whereHas('project_surveys',function($query) use($id)
                            {
                                $query->orderBy('order','ASC');
                            })
                            ->where('id',$id)->first();
        if ($project == null) {
             $project=tblprojects::with(['project_surveys'])->where('id',$id)->first();
        }
        $survey = tblsurveys::with(['survey_project'])->get();
        $survey_selected=tblsurveys::whereHas('survey_project',function($query) use($id)
        {
            $query->where('project_id',$id);
        })->pluck('id')->toArray();

        return view('project.partial.survey_order',compact('project','survey','survey_selected'));
    }


     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author  Harsh Vaghasiya
     */
    public function getSurveyData(Request $request)
    {
        $survey_forms=tblsurveyforms::whereIn('survey_id',$request->survey_id)->get();
        return view('project.partial.survey_modal',compact('survey_forms'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author Method Edited by Harsh Vaghasiya
     */
    public function show($id)
    {
        $project=tblprojects::with(['project_categories','project_locations','project_users','project_survey'])
         ->where('id',$id)->first();
        return view('project.show', compact('project'));
    }

    public function survey($id)
    {
        $survey = tblsurveys::with(['survey_project'])->get();
        $survey_selected=tblsurveys::whereHas('survey_project',function($query) use($id)
        {
            $query->where('project_id',$id);
        })->pluck('id')->toArray();

        return view('project.survey', compact('survey','id','survey_selected'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author Method Edited by Harsh Vaghasiya
     */
    public function updatesurvey(Request $request, $id)
    {
       $exist=ProjectSurvey::where('project_id',$id)->delete();
       if ($request->surveyform != null) {
           foreach ($request->surveyform as $key => $value) {
               $res=new ProjectSurvey;
               $res->project_id=$id;
               $res->survey_id=$value;
               $res->save();
           }
       }
        
        if (isset($request->is_order) && $request->is_order==2) {
            $route="project.survey_order";
        }else{
            $route="project.index";
        }
        return redirect()->back()
            ->with('success', 'Survey has been updated successfully');
    }

    public function location($id)
    {
        $locations = tbllocations::all();
        $projects = tblprojects::find($id);
        $projectlocations = tblprojectlocations::where('project_id', $id)->get();
        return view('project.location', compact('projects', 'projectlocations', 'locations'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author Method Edited by Harsh Vaghasiya

     */

    public function updatelocation(Request $request, $id)
    {
        tblprojectlocations::where('project_id', $id)->delete();

        if(isset($request->locationform) && $request->locationform != null){
        foreach ($request->locationform as $locationid) {
            $projectlocation = new tblprojectlocations;
            $projectlocation->project_id = $id;
            $projectlocation->location_id = $locationid;
            $projectlocation->save();
        }
        }

        $msg="Locations has been updated successfully.";
        flashMessage('success',$msg);
        return redirect()->route('project.index');
    }

    public function getusers($id)
    {
        $userdata = DB::select('SELECT * FROM public.tblusers');
        $projects = tblprojects::find($id);
        $projectusers = tblprojectusers::where('project_id', $id)->get();
        return view('project.users', compact('projects', 'projectusers', 'userdata'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author Method Edited by Harsh Vaghasiya

     */
    public function updateusers(Request $request, $id)
    {
        tblprojectusers::where('project_id', $id)->delete();
        if (isset($request->userform) && $request->userform != null) {
            foreach ($request->userform as $userid) {
                $projectlocation = new tblprojectusers;
                $projectlocation->project_id = $id;
                $projectlocation->user_id = $userid;
                $projectlocation->save();
            }
        }

        $msg="Users has been updated successfully.";
        flashMessage('success',$msg);
        return redirect()->route('project.index');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $projects = tblprojects::find($id);

        $categories = tblprojectcateogries::all();
        // $survey=tblsurveys::all();
        // $locations=tbllocations::all();

        return view('project.edit', compact('projects', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author Method Edited by Harsh Vaghasiya

     */
    public function update(ProjectRequest $request, $id)
    {
        

        $projectdata = tblprojects::find($id);
        $projectdata->projectname = $request->projectname;
        $projectdata->startdate = $request->startdate;
        $projectdata->enddate = $request->enddate;
        $projectdata->category_id = $request->category;
        $projectdata->targetbeneficiaries = $request->target;
        $projectdata->projectestimation = $request->estimation;
        $projectdata->description = $request->description;
        $projectdata->save();
        
        $msg="Project Updated successfully";
        $url=route('project.index');
        flashMessage('success',$msg);
        
        return response()->json(['msg'=>$msg,'status'=>true,'url'=>$url]);
   
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @author Edited By Harsh Vaghasiya
     */
    public function destroy($id)
    {
        tblprojects::where('id', $id)->delete();
        tblprojectlocations::where('project_id', $id)->delete();
        tblprojectusers::where('project_id', $id)->delete();

        $msg="Project Deleted successfully";
        $url=route('project.index');
        flashMessage('success',$msg);
         return response()->json(['success' => 1, 'msg' => $msg]);        
        
    }
}
