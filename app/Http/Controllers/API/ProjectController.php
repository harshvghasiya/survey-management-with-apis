<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Blog;
use App\Http\Resources\Blog as BlogResource;
use App\Models\tblprojects;
use App\Models\tblprojectusers;
use Illuminate\Support\Facades\DB;

class ProjectController extends BaseController
{
    
    public function index()
    {
        // $blogs = Blog::all();
        // return $this->sendResponse(BlogResource::collection($blogs), 'Posts fetched.');
    }   

     /**
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author Method Edited by Harsh Vaghasiya

     */

    public function getprojects($id){
        $data=array();
        if(is_null($id)){
            $data['message']="No Project Id Found";
            return response()->json($data,404);
        }

        $projectid=tblprojectusers::where('user_id',$id)->first();
        if (is_null($projectid)) {

            $data['message']="No Project Found";
            return response()->json($data,404);
        }

        // $sql='SELECT a.id,a.projectname, a.startdate, a.enddate, b.category, a.survey_id, c.surveyname, a.description FROM public.tblprojects a, public.tblprojectcateogries b, public.tblsurveys c, public.tblprojectusers d WHERE a.category_id=b.id and c.id=a.survey_id and d.project_id=a.id and d.user_id='.$id.'';

        // $project=DB::select($sql);


        $project=\App\Models\tblprojects::with(['project_categories'])
                                            ->select('id','projectname','startdate','enddate','category_id','description')
                                            ->whereHas('project_users',function($query) use($id)
                                            {
                                                $query->where('user_id',$id);
                                            })
                                            ->get();
            if ($project != null ) {
                    $project=$project->makeHidden(['project_surveys','project_users']);
                
                foreach ($project as $pro => $proj) {
                    $arr=[];
                    // $tempArray = json_decode($proj);
                    $arr['project_data']=$proj;

                    if (isset($proj->project_surveys) && $proj->project_surveys != null) {
                    $sec=[];
                                foreach ($proj->project_surveys as $sur => $survey_data) {

                                    if(isset($survey_data->survey) && $survey_data->survey != null){
                                            $sec[]=$survey_data->survey;
                                            // $proj->project_surveys=$survey_data->survey;
                                    }else{
                                        $sec[]=null;
                                    }
                                    $arr['project_data']['project_survey']=$sec;
                                }
                            
                    }

                    if (isset($proj->project_users) && $proj->project_users != null) {
                        $sec2=[];
                                foreach ($proj->project_users as $user => $user_data) {
                                    if(isset($user_data->users) && $user_data->users != null){
                        
                                        $sec2[]=$user_data->users;   
                                    }else{
                                        $sec2[]=null;
                                    }
                                    $arr['project_data']['project_user']=$sec2;

                        }
                    }


                    $data[]=$arr;
                }
            }

        if (is_null($project)) {
            $data['message']="Project Not Found.";
            return response()->json($data,404);
        }

        
        return response()->json($data,200);
    }

    public function getUserData()
    {
        $user=\App\Models\tblusers::where('id',auth()->user()->id)->first();
        return response()->json([$user],200);
    }

    public function store(Request $request)
    {
        // $input = $request->all();
        // $validator = Validator::make($input, [
        //     'title' => 'required',
        //     'description' => 'required'
        // ]);
        // if($validator->fails()){
        //     return $this->sendError($validator->errors());       
        // }
        // $blog = Blog::create($input);
        // return $this->sendResponse(new BlogResource($blog), 'Post created.');
    }
   
    public function show($id)
    {
        // $blog = Blog::find($id);
        // if (is_null($blog)) {
        //     return $this->sendError('Post does not exist.');
        // }
        // return $this->sendResponse(new BlogResource($blog), 'Post fetched.');
    }
    
    public function update(Request $request, tblprojects $project)
    {
        // $input = $request->all();
        // $validator = Validator::make($input, [
        //     'title' => 'required',
        //     'description' => 'required'
        // ]);
        // if($validator->fails()){
        //     return $this->sendError($validator->errors());       
        // }
        // $blog->title = $input['title'];
        // $blog->description = $input['description'];
        // $blog->save();
        
        // return $this->sendResponse(new BlogResource($blog), 'Post updated.');
    }
    
    public function destroy(tblprojects $project)
    {
        // $blog->delete();
        // return $this->sendResponse([], 'Post deleted.');
    }
}