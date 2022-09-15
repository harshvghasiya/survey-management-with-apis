<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SurveyOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
     public function create()
    {

    	// $all_survey=\App\tblsurveys
       $title=trans('message.survey_order_title');
       return view('survey_order.addedit',compact('title'));
    }



    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $title=trans('message.survey_order_title');
        $all_survey=\App\Models\tblsurveys::with(['survey_type'])->orderBy('order','ASC')->get();
        return view('survey_order.index',compact('title','all_survey'));
    }

    /**
     * [store used for register admin ]
     * @return [type] [description]
     * @author Softtechover [Harsh V].

    */
    public function store(survey_orderRequest $request)
    {
       return $this->Model->store($request);    
    }

    /**
     * [survey_order_update used for register admin ]
     * @return [type] [description]
     * @author Softtechover [Harsh V].

    */
    public function surveyOrderUpdate(Request $request)
    {
       if ($request->survey_id != null) {
        	foreach ($request->survey_id as $key => $value) {
        		$res=\App\Models\tblsurveys::where('id',$value)->first();
        		$res->order=$key;
        		$res->save();
        	}
        }

          $msg='Survey order changed successfully.';
        flashMessage('success',$msg);
      	return response()->json(['status' => 1, 'msg' => $msg]);

    }

    /**
     * [anyData used for get admin list through yajra ]
     * @return [type] [description]
     * @author Softtechover [Harsh V].

    */
    public function anyData(Request $request)
    {
       return $this->Model->getListData($request);    
    }

     /**
     * [edit used for edit admin data ]
     * @return [type] [description]
     * @author Softtechover [Harsh V].

    */
    public function edit(Request $request,$id)
    {
       $title=trans('message.survey_order_edit');
       $survey_order=$this->Model->getSingleData($id);
       $encryptedId=$id;
       return view('survey_order.addedit',compact('title','survey_order','encryptedId'));  
    }

    /**
     * [update used for update admin data ]
     * @return [type] [description]
     * @author Softtechover [Harsh V].

    */
    public function update(survey_orderRequest $request,$id)
    {
       
       return $this->Model->store($request,$id);  
    }

    /**
     * [destroy used for destroy admin data ]
     * @return [type] [description]
     * @author Softtechover [Harsh V].

    */
    public function destroy(Request $request,$id)
    {
       $request['checkbox']=[$id];
        return $this->Model->deleteAll($request);
    }

    /**
     * [SingleStatusChange This function is active inactive single record .]
     * @param Request $request [description]
     * @author Softtechover [Harsh V] [Chirag G].
     */
    public function SingleStatusChange(Request $request){

        return $this->Model->SingleStatusChange($request);
    }


    /**
     * [deleteAll This function is used to delete specific seletec data]
     * @param  Request $request [description]
     * @return [type]           [description]
     * @author Softtechover [Harsh V] [Chirag G].
     */
    public function deleteAll(Request $request){
        
        return $this->Model->deleteAll($request);
    }

    /**
     * [statusAll This function is used to active or inactive specific selected banner record]
     * @param  Request $request [description]
     * @return [type]           [description]
     * @authorSofttechover [Harsh V]  [Chirag G].
     */
    public function statusAll(Request $request){
        
        return $this->Model->statusAll($request);
    }

}
