<?php

namespace App\Http\Controllers;

use App\Models\tblsurveyforms;
use App\Models\tblsurveys;
use App\Models\tblsurveytypes;
use App\Models\tbluserrolepages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class surveyController extends Controller
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
         $page_id = tbluserrolepages::survey_page_id;
           if ($request->route()->getName()=='survey.destroy') {
                $access='deleteright';
           }
           elseif($request->route()->getName()=='survey.index' || $request->route()->getName()=='survey.show'){
                $access='readright';
           }elseif($request->route()->getName()=='survey.create'){
                $access='addright';
           }elseif($request->route()->getName()=='survey.edit' ){
                $access='editright';
           }else{
                $access="none";
           }
           if (HASACCESS($page_id,\Auth::user()->userroleid,$access)  || \Auth::user()->admin_right->adminrole==true) {
                return $next($request);
           }
           if ($request->route()->getName()=='survey.destroy') {
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
        $surveydata = DB::select('SELECT a.id, a.surveyname, a.description, b.surveytype FROM public.tblsurveys a, public.tblsurveytypes b WHERE a.surveytype_id=b.id');
        return view('survey.index', compact('surveydata'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $surveytype = tblsurveytypes::all();
        return view('survey.create', compact('surveytype'));
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
            'survey' => 'required|unique:tblsurveys,surveyname',
            'surveytype' => 'required'
        ]);

        $survey = new tblsurveys;
        $survey->surveyname = $request->survey;
        $survey->description = $request->description;
        $survey->surveytype_id = $request->surveytype;
        $survey->save();
        $surveyid = $survey->id;

        foreach ($request->multipleinput as $key => $value) {
            Log::debug($value);

            $checkbox = Arr::has($value, 'mandatory');

            if (is_null($value['question']) || is_null($value['questiontype'])) {
            } else {
                $surveyquestions = new tblsurveyforms;
                $surveyquestions->survey_id = $surveyid;
                $surveyquestions->question = $value['question'];
                $surveyquestions->question_type = $value['questiontype'];


                if (isset($value['mandatory'])) {
                    $surveyquestions->required = $value['mandatory'];
                }



                if ($value['questiontype'] == 'multichoiceoneans') {
                    $surveyquestions->option1 = $value['option0multichoiceoneans'];
                    $surveyquestions->option2 = $value['option1multichoiceoneans'];
                    $surveyquestions->option3 = $value['option2multichoiceoneans'];
                    $surveyquestions->option4 = $value['option3multichoiceoneans'];
                }
                if ($value['questiontype'] == 'multichoicemultians') {
                    $surveyquestions->option1 = $value['option0multichoicemultians'];
                    $surveyquestions->option2 = $value['option1multichoicemultians'];
                    $surveyquestions->option3 = $value['option2multichoicemultians'];
                    $surveyquestions->option4 = $value['option3multichoicemultians'];
                }

                 if ($value['questiontype'] == 'trueorfalse') {
                    $surveyquestions->true_false=$value['trueorfalse'];
                }
                if ($value['questiontype'] == 'number') {
                    $surveyquestions->size = $value['number'];
                }
                 if ($value['questiontype'] == 'text') {
                    $surveyquestions->text = $value['text'];
                }

                $column = Str::replace(' ', '_', $value['question']);
                $surveyquestions->column = $column;
                $surveyquestions->save();
            }
        }

        $tablename = $request->survey;

        $tablename = Str::replace(' ', '_', $tablename);

        if (!Schema::hasTable($tablename)) {
            Schema::create($tablename, function (Blueprint $table) use ($request) {
                $table->id();
                $table->integer('survey_id')->index();
                $table->foreign('survey_id')->references('id')->on('tblsurveys')->onDelete('cascade');
                // $table->geometry('baseline')->nullable();
                // $table->geometry('endline')->nullable();
                $table->string('type');
                $table->string('latlong');
                $table->integer('userid')->index();
                $table->foreign('userid')->references('id')->on('tblusers')->onDelete('cascade');
                foreach ($request->multipleinput as $tabkey => $tabvalue) {
                if(isset($tabvalue['question']) && $tabvalue['question'] != null){
                    $column = Str::replace(' ', '_', $tabvalue['question']);
                    $column = Str::lower($column);
                    if (isset($tabvalue['mandatory'])) {
                        $table->string($column);
                    } else {
                        $table->string($column)->nullable();
                    }
                }
                }
                $table->timestamps();
            });
        }

        $msg='Survey has been created successfully.';
        flashMessage('success',$msg);
        $url=route('survey.index');

        return response()->json(['msg'=>$msg,'status'=>true,'url'=>$url]);

        // return redirect()->route('survey.index')->with('success', 'Survey has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $survey = tblsurveys::find($id);
        $surveydata = tblsurveyforms::select('*')->where(["survey_id" => $id])->get();
        $surveytype = tblsurveytypes::all();
        return view('survey.view', compact('survey', 'surveydata', 'surveytype'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $survey = tblsurveys::find($id);
        $surveydata = tblsurveyforms::select('*')->where(["survey_id" => $id])->get();
        $surveytype = tblsurveytypes::all();
        return view('survey.edit', compact('survey', 'surveydata', 'surveytype'));
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
            'survey' => 'required',
            'surveytype' => 'required'
        ]);

        $oldsurvey = tblsurveys::find($id);
        $survey = tblsurveys::find($id);
        $survey->surveyname = $request->survey;
        $survey->description = $request->description;
        $survey->surveytype_id = $request->surveytype;
        $survey->save();
        $surveyid = $survey->id;

        tblsurveyforms::where('survey_id', $id)->delete();

        if(isset($request->multipleinput) && $request->multipleinput != null){
        foreach ($request->multipleinput as $key => $value) {
            if(isset($value['question']) && $value['question'] != null){
            Log::debug($value);

            $surveyquestions = new tblsurveyforms;
            $surveyquestions->survey_id = $surveyid;
            $surveyquestions->question = $value['question'];
            $surveyquestions->question_type = $value['questiontype'];
            if (Arr::exists($value, 'mandatory')) {
                $surveyquestions->required = $value['mandatory'];
            }

            if ($value['questiontype'] == 'multichoiceoneans') {
                $surveyquestions->option1 = $value['option0multichoiceoneans'];
                $surveyquestions->option2 = $value['option1multichoiceoneans'];
                $surveyquestions->option3 = $value['option2multichoiceoneans'];
                $surveyquestions->option4 = $value['option3multichoiceoneans'];
            }

            if ($value['questiontype'] == 'trueorfalse') {
                $surveyquestions->true_false=$value['trueorfalse'];
            }
            if ($value['questiontype'] == 'multichoicemultians') {
                $surveyquestions->option1 = $value['option0multichoicemultians'];
                $surveyquestions->option2 = $value['option1multichoicemultians'];
                $surveyquestions->option3 = $value['option2multichoicemultians'];
                $surveyquestions->option4 = $value['option3multichoicemultians'];
            }
            if ($value['questiontype'] == 'number') {
                $surveyquestions->size = $value['number'];
            }

            if ($value['questiontype'] == 'text') {
                    $surveyquestions->text = $value['text'];
                }
            // $column=Str::replace(' ','_',$value['question']);
            $surveyquestions->column = $value['dbcolumn'];

            $surveyquestions->save();
            }
        }
        }
        
        $tablename = $oldsurvey->surveyname;
        $newTableName = $request->survey;



        if (!Schema::hasTable($newTableName)) {
            if(Schema::hasTable($tablename)){
                Schema::table($tablename, function (Blueprint $table) {
                    $table->dropForeign(['survey_id']);
                });
             }

            if ($oldsurvey->surveyname == $request->survey) {
            } else {
                if(Schema::hasTable($tablename)){
                Schema::rename($tablename, $newTableName);
                }

                if(isset($request->multipleinput) && $request->multipleinput != null){
                        foreach ($request->multipleinput as $key => $value) {
                            if(isset($value['dbcolumn']) && $value['dbcolumn'] != null){
                            if (Schema::hasColumn($tablename, $value['dbcolumn'])) {
                            } else {
                                if (!Schema::hasColumn($newTableName,$value['dbcolumn'])) {
                                    Schema::table($newTableName, function (Blueprint $table) use ($value) {
                                        $table->string($value['dbcolumn']);
                                    });
                                }
                            }
                            }
                            
                        }
                        }
            }

            if(Schema::hasTable($newTableName)){

                Schema::table($newTableName, function (Blueprint $table) {
                    $table->foreign('survey_id')->references('id')->on('tblsurveys')->onDelete('cascade');
                });
            }
        }

         $msg='Survey has been updated successfully.';
        flashMessage('success',$msg);
        $url=route('survey.index');

        return response()->json(['msg'=>$msg,'status'=>true,'url'=>$url]);
       // return redirect()->route('survey.index')->with('success', 'Location has been created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $oldsurvey = tblsurveys::find($id);
        $tablename = $oldsurvey->surveyname;
        $y = date('Y');
        $m = date('m');
        $d = date('d');
        $newTableName = $tablename . $y . '_' . $m . '_'. $d;
         $newTableName=str_replace('"', "'", $newTableName);
         $tablename=str_replace('"', "'", $tablename);
        // dd($newTableName,$tablename);
        // dd('df');
        tblsurveys::where('id', $id)->delete();
        tblsurveyforms::where('survey_id', $id)->delete();

        if (!Schema::hasTable($tablename)) {
        } else {
            Schema::table($tablename, function (Blueprint $table) {
                $table->dropForeign(['survey_id']);
            });

            // $sql = 'ALTER TABLE :tablename RENAME TO :newtable';
            // $vals = [
            //     'tablename' => $tablename,
            //     'newtable' => $newTableName
            // ];
            // DB::select($sql, $vals);
            Schema::rename($tablename, $newTableName);

            Schema::table($newTableName, function (Blueprint $table) {
                $table->foreign('survey_id')->references('id')->on('tblsurveys')->onDelete('cascade');
            });

        }

      return response()->json(['success' => 1, 'msg' => 'Survey Deleted Successfully.']);

        // return redirect()->route('survey.index')
        //     ->with('success', 'Survey been deleted successfully');
    }

    
}
