<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\dynamic;
use App\Models\tblsurveyforms;
use App\Models\tblsurveys;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SurveyController extends BaseController
{
    public function getsurvey($id)
    {
        $surveyform = DB::select('SELECT * FROM public.tblsurveyforms WHERE survey_id=' . $id . '');

        if (is_null($surveyform)) {
            return $this->sendError('No survey form mapped to this project.');
        }
        $form = "";
        $regular = "";
        $collection = collect();
        foreach ($surveyform as $surveyformdata) {
            if ($surveyformdata->question_type == 'text') {
                $type = 'Text';
                $fieldtype = 'Text';
                $regular = '^[a-zA-Z \\s]+';
                $options = [];
                $getout = ['Size' => '255', 'Mandatory' => $surveyformdata->required];
            }
            if ($surveyformdata->question_type == 'number') {
                $type = 'Number';
                $fieldtype = 'Number';
                $regular = '\d{10}';
                $options = [];
                $getout = ['Size' => $surveyformdata->size, 'Mandatory' => $surveyformdata->required];
            }
            if ($surveyformdata->question_type == 'trueorfalse') {
                $type = 'TrueOrFalse';
                $fieldtype = 'Radio';
                $options = ['Yes', 'No'];
                $getout = ['Size' => NULL, 'Mandatory' => $surveyformdata->required];
            }
            if ($surveyformdata->question_type == 'multichoiceoneans') {
                $type = 'SingleSelect';
                $fieldtype = 'Single Select Dropdown';
                $options = ['SELECT Options', $surveyformdata->option1, $surveyformdata->option2, $surveyformdata->option3, $surveyformdata->option4];
                $getout = ['Size' => NULL, 'Mandatory' => $surveyformdata->required];
            }
            if ($surveyformdata->question_type == 'multichoicemultians') {
                $type = 'MultiSelect';
                $fieldtype = 'Multi Select Dropdown';
                $options = ['SELECT Options', $surveyformdata->option1, $surveyformdata->option2, $surveyformdata->option3, $surveyformdata->option4];
                $getout = ['Size' => NULL, 'Mandatory' => $surveyformdata->required];
            }

            $form = ['Question' => $surveyformdata->question, 'Question Type' => $type, 'Field Type' => $fieldtype, 'DBColumn' => Str::lower($surveyformdata->column), 'Regexp' => $regular, 'Options' => $options, 'Properties' => $getout];
            $collection->push($form);
        }

        return $this->sendResponse($collection, 'Posts fetched.');
    }

    public function getsurvey2($id)
    {
        $collection = collect();
        if ($id == 1) {
            $options = [];
            $conditions = [];
            $getout = ['Size' => '255', 'Mandatory' => true];
            $form = ['Question' => 'Name', 'Question Type' => 'Text', 'Field Type' => 'Text', 'DBColumn' => 'name', 'Regexp' => '^[a-zA-Z \\s]+', 'Options' => $options, 'Properties' => $getout, 'Condition' => $conditions];
            $collection->push($form);

            $options1 = [];
            $getout1 = ['Size' => '10', 'Mandatory' => true];
            $conditions1 = [];
            $form1 = ['Question' => 'Phone Number', 'Question Type' => 'Number', 'Field Type' => 'Number', 'DBColumn' => 'phone_number', 'Regexp' => '\\d{10}', 'Options' => $options1, 'Properties' => $getout1, 'Condition' => $conditions1];
            $collection->push($form1);

            $options2 = ['Yes', 'No'];
            $options41 = ['Select Options', 'Hyderabad', 'Bengaluru', 'Mumbai', 'Delhi'];
            $getout2 = ['Size' => null, 'Mandatory' => true];
            $conditionsnextnew=[];
            $next = collect();
            $conditionsextraa = collect();
            $arr=['Question' => 'Places wanted to visit yes', 'Question Type' => 'MultiSelect', 'Field Type' => 'Multi Select Dropdown', 'DBColumn' => 'places_wanted_to_visit', 'Regexp' => '^[a-zA-Z \\s]+', 'Options' => $options41, 'Properties' => $getout2, 'Condition' => $conditionsnextnew];
            $next->push($arr);

            $arr=['Question' => 'Places wanted to visit yes', 'Question Type' => 'MultiSelect', 'Field Type' => 'Multi Select Dropdown', 'DBColumn' => 'places_wanted_to_visit', 'Regexp' => '^[a-zA-Z \\s]+', 'Options' => $options41, 'Properties' => $getout2, 'Condition' => $conditionsnextnew];
            $next->push($arr);

            $game=['case'=>'Yes', 'Conquestion'=>$next];

            $conditionsextraa->push($game);

            $next = collect();
            $arr=['Question' => 'Places wanted to visit no', 'Question Type' => 'MultiSelect', 'Field Type' => 'Multi Select Dropdown', 'DBColumn' => 'places_wanted_to_visit', 'Regexp' => '^[a-zA-Z \\s]+', 'Options' => $options41, 'Properties' => $getout2, 'Condition' => $conditionsnextnew];
            $next->push($arr);

            $arr=['Question' => 'Places wanted to visit no', 'Question Type' => 'MultiSelect', 'Field Type' => 'Multi Select Dropdown', 'DBColumn' => 'places_wanted_to_visit', 'Regexp' => '^[a-zA-Z \\s]+', 'Options' => $options41, 'Properties' => $getout2, 'Condition' => $conditionsnextnew];
            $next->push($arr);

            $gameno=['case'=>'No', 'Conquestion'=>$next];

            $conditionsextraa->push($gameno);

            $form2 = ['Question' => 'Graduated', 'Question Type' => 'TrueOrFalse', 'Field Type' => 'Radio', 'DBColumn' => 'graduated', 'Regexp' => '^[a-zA-Z \\s]+', 'Options' => $options2, 'Properties' => $getout2, 'Condition' => $conditionsextraa];
            $collection->push($form2);

            $options3 = ['Select Options', 'Hyderabad', 'Bengaluru', 'Mumbai', 'Delhi'];
            $getout3 = ['Size' => null, 'Mandatory' => true];
            $conditions3 = [];
            $form3 = ['Question' => 'Preferred Place of residence', 'Question Type' => 'SingleSelect', 'Field Type' => 'Single Select Dropdown', 'DBColumn' => 'preferred_place_of_residence', 'Regexp' => '^[a-zA-Z \\s]+', 'Options' => $options3, 'Properties' => $getout3, 'Condition' => $conditions3];
            $collection->push($form3);

            $options4 = ['Select Options', 'Hyderabad', 'Bengaluru', 'Mumbai', 'Delhi'];
            $getout4 = ['Size' => null, 'Mandatory' => true];
            $conditions4 = [];
            $form4 = ['Question' => 'Places wanted to visit', 'Question Type' => 'MultiSelect', 'Field Type' => 'Multi Select Dropdown', 'DBColumn' => 'places_wanted_to_visit', 'Regexp' => '^[a-zA-Z \\s]+', 'Options' => $options4, 'Properties' => $getout4, 'Condition' => $conditions4];
            $collection->push($form4);

            return $this->sendResponse($collection, 'Posts fetched.');
        } else {
            return $this->sendResponse($collection, 'Posts fetched.');
        }
    }


    /**
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author Method Edited by Harsh Vaghasiya
     */

    public function show()
    {
        $data=[];
         $survey=tblsurveys::select('id','surveyname','description','surveytype_id')->with(['survey_type'=>function($qu)
        {
            $qu->select('id','surveytype','description');
        },'survey_form'])->get();

         if ($survey == null) {
            $data['message']="No Survey Found";
            return response()->json($data,404);
         }

           $survey= $survey->makeHidden(['survey_form']);

            foreach ($survey as $single_suvey_key => $single_survey_value) {
                $new_arr=[];
                    $new_arr['survey_data']=$single_survey_value;

                           if (isset($single_survey_value->survey_form) && $single_survey_value->survey_form != null) {
                            $arr=[];
                            foreach ($single_survey_value->survey_form as $key => $value) {
                                $sec=[];
                                if ($value->question_type=='text') {
                                    $sec['question_type']=$value->question_type;
                                    $sec['question']=$value->question;
                                    $sec['column']=$value->column;
                                    $sec['required']=$value->required;
                                    $sec['answer']=$value->text;
                                    $arr[]=$sec;
                                }
                                if ($value->question_type=='trueorfalse') {
                                    $sec['question_type']=$value->question_type;
                                    $sec['question']=$value->question;
                                    $sec['column']=$value->column;
                                    $sec['required']=$value->required;
                                    $sec['answer']=$value->true_false;
                                    $arr[]=$sec;
                                }
                                if ($value->question_type=='number') {
                                    $sec['question_type']=$value->question_type;
                                    $sec['question']=$value->question;
                                    $sec['column']=$value->column;
                                    $sec['required']=$value->required;
                                    $sec['answer']=$value->size;
                                    $arr[]=$sec;
                                }
                                if ($value->question_type=='multichoiceoneans') {
                                    $sec['question_type']=$value->question_type;
                                    $sec['question']=$value->question;
                                    $sec['column']=$value->column;
                                    $sec['required']=$value->required;
                                    $sec['answer']['option1']=$value->option1;
                                    $sec['answer']['option2']=$value->option2;
                                    $sec['answer']['option3']=$value->option3;
                                    $sec['answer']['option4']=$value->option4;
                                    $arr[]=$sec;
                                }
                                if ($value->question_type=='multichoicemultians') {
                                    $sec['question_type']=$value->question_type;
                                    $sec['question']=$value->question;
                                    $sec['column']=$value->column;
                                    $sec['required']=$value->required;
                                    $sec['answer']['option1']=$value->option1;
                                    $sec['answer']['option2']=$value->option2;
                                    $sec['answer']['option3']=$value->option3;
                                    $sec['answer']['option4']=$value->option4;
                                    $arr[]=$sec;
                                }
                            }

                            $new_arr['survey_form_data']=$arr;

                        }
                $data[]=$new_arr;
            }

        return response()->json($data,200);

    }

  

     /**
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @author Method Edited by Harsh Vaghasiya

     */

    public function getSurveyData($id)
    {
        $data=[];

        $survey=tblsurveys::select('id','surveyname','description','surveytype_id')->with(['survey_type'=>function($qu)
        {
            $qu->select('id','surveytype','description');
        },'survey_form'])->where('id',$id)->first();
        if ($survey == null) {
            $data['message']="No Survey Found";
            return response()->json($data,404);
        }else{
           $survey= $survey->makeHidden(['survey_form']);
        }


        $data['survey_data']=$survey;
        if (isset($survey->survey_form) && $survey->survey_form != null) {
            $arr=[];
            foreach ($survey->survey_form as $key => $value) {
                $sec=[];
                if ($value->question_type=='text') {
                    $sec['question_type']=$value->question_type;
                    $sec['question']=$value->question;
                    $sec['column']=$value->column;
                    $sec['required']=$value->required;
                    $sec['answer']=$value->text;
                    $arr[]=$sec;
                }
                if ($value->question_type=='trueorfalse') {
                    $sec['question_type']=$value->question_type;
                    $sec['question']=$value->question;
                    $sec['column']=$value->column;
                    $sec['required']=$value->required;
                    $sec['answer']=$value->true_false;
                    $arr[]=$sec;
                }
                if ($value->question_type=='number') {
                    $sec['question_type']=$value->question_type;
                    $sec['question']=$value->question;
                    $sec['column']=$value->column;
                    $sec['required']=$value->required;
                    $sec['answer']=$value->size;
                    $arr[]=$sec;
                }
                if ($value->question_type=='multichoiceoneans') {
                    $sec['question_type']=$value->question_type;
                    $sec['question']=$value->question;
                    $sec['column']=$value->column;
                    $sec['required']=$value->required;
                    $sec['answer']['option1']=$value->option1;
                    $sec['answer']['option2']=$value->option2;
                    $sec['answer']['option3']=$value->option3;
                    $sec['answer']['option4']=$value->option4;
                    $arr[]=$sec;
                }
                if ($value->question_type=='multichoicemultians') {
                    $sec['question_type']=$value->question_type;
                    $sec['question']=$value->question;
                    $sec['column']=$value->column;
                    $sec['required']=$value->required;
                    $sec['answer']['option1']=$value->option1;
                    $sec['answer']['option2']=$value->option2;
                    $sec['answer']['option3']=$value->option3;
                    $sec['answer']['option4']=$value->option4;
                    $arr[]=$sec;
                }
            }

            $data['survey_form_data']=$arr;

        }

        return response()->json($data,200);
    }
}
