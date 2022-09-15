<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Right;
use App\Models\RightModule;
use App\Http\Requests\RightRequest;

class RightController extends Controller
{

      function __construct()
    {
        $this->middleware('auth');
        $this->Model=new Right;
        
    }

    /**
     * [creare This function is used to show company category form]
     * @return [type] [description]
     * @author  [Harsh V].
    */

    public function create()
    {
       $title=trans('message.add_right_title');
       return view('right.addedit',compact('title'));
    }



    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $title=trans('message.right_title');
        return view('right.index',compact('title'));
    }

    /**
     * [store used for register admin ]
     * @return [type] [description]
     * @author  [Harsh V].

    */
    public function store(RightRequest $request)
    {
       return $this->Model->store($request);    
    }

    /**
     * [anyData used for get admin list through yajra ]
     * @return [type] [description]
     * @author  [Harsh V].

    */
    public function anyData(Request $request)
    {
       return $this->Model->getListData($request);    
    }

     /**
     * [edit used for edit admin data ]
     * @return [type] [description]
     * @author  [Harsh V].

    */
    public function edit(Request $request,$id)
    {
       $title=trans('message.right_edit');
       $right=$this->Model->getSingleData($id);
       $encryptedId=$id;
       return view('right.addedit',compact('title','right','encryptedId'));  
    }

    /**
     * [update used for update admin data ]
     * @return [type] [description]
     * @author  [Harsh V].

    */
    public function update(RightRequest $request,$id)
    {
       
       return $this->Model->store($request,$id);  
    }

    /**
     * [destroy used for destroy admin data ]
     * @return [type] [description]
     * @author  [Harsh V].

    */
    public function destroy(Request $request,$id)
    {
       $request['checkbox']=[$id];
        return $this->Model->deleteAll($request);
    }

    /**
     * [SingleStatusChange This function is active inactive single record .]
     * @param Request $request [description]
     * @author  [Harsh V].
     */
    public function SingleStatusChange(Request $request){

        return $this->Model->SingleStatusChange($request);
    }


    /**
     * [deleteAll This function is used to delete specific seletec data]
     * @param  Request $request [description]
     * @return [type]           [description]
     * @author  [Harsh V].
     */
    public function deleteAll(Request $request){
        
        return $this->Model->deleteAll($request);
    }

    /**
     * [statusAll This function is used to active or inactive specific selected banner record]
     * @param  Request $request [description]
     * @return [type]           [description]
     * @author [Harsh V] .
     */
    public function statusAll(Request $request){
        
        return $this->Model->statusAll($request);
    }

}
