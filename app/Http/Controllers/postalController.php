<?php

namespace App\Http\Controllers;

use App\Models\tblmultilocations;
use App\Models\tblpostaldata;
use App\Models\tblsurveyforms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class postalController extends Controller
{
    public function getsurveydata($surveyid){
        $surveydata=tblsurveyforms::where('survey_id', $surveyid)->get();

        return response()->json($surveydata);
    }

    public function getlocationdata($locationid){
        // Log::debug($locationid);
        $data=explode(',', $locationid);
        // Log::debug($data);
        $i=0;
        $conditionlocation="";
        foreach($data as $id){
            if($i==0){
                $conditionlocation="a.locationid = $id";
                $i++;
            }
            else{
                $conditionlocation=$conditionlocation." OR a.locationid = $id";
            }
        }
        // Log::debug($conditionlocation);
        $location=DB::select('SELECT a.*,b.locationname FROM public.tblmultilocations a, public.tbllocations b WHERE a.locationid=b.id AND ('.$conditionlocation.')');
        // Log::debug($location);
        return response()->json($location);
    }

    public function getuserdata($userid){
        // Log::debug($locationid);
        $data=explode(',', $userid);
        // Log::debug($data);
        $i=0;
        $conditionuser="";
        foreach($data as $id){
            if($i==0){
                $conditionuser="a.id = $id";
                $i++;
            }
            else{
                $conditionuser=$conditionuser." OR a.id = $id";
            }
        }
        // Log::debug($conditionuser);
        $user=DB::select('SELECT a.*, b.userrole FROM public.tblusers a, public.tbluserroles b WHERE b.id=a.userroleid ('.$conditionuser.')');
        // Log::debug($location);
        return response()->json($user);
    }

    public function getdistrict($state)
    {

        // Fetch Employees by Departmentid
        $statedata['data'] = tblpostaldata::orderby("district", "asc")
            ->select('district')
            ->distinct()
            ->where('state', $state)
            ->get();

        return response()->json($statedata);
    }

    public function gettaluk($state)
    {

        // Fetch Employees by Departmentid
        $statedata['data'] = tblpostaldata::orderby("block", "asc")
            ->select('block')
            ->distinct()
            ->where('state', $state)
            ->get();

        return response()->json($statedata);
    }

    public function gettalukbydist($district,$state)
    {

        // Fetch Employees by Departmentid
        $statedata['data'] = tblpostaldata::orderby("block", "asc")
            ->select('block')
            ->distinct()
            ->where(["state"=> $state, "district" => $district])
            ->get();

        return response()->json($statedata);
    }

    public function getvillagebytaluk($taluk,$district,$state)
    {

        // Fetch Employees by Departmentid
        $statedata['data'] = tblpostaldata::orderby("village", "asc")
            ->select('village')
            ->distinct()
            ->where(["state"=> $state, "district" => $district, "block"=>$taluk])
            ->get();

        return response()->json($statedata);
    }
}
