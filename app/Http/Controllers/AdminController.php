<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RightModule;
use App\Models\tblusers;
use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\PasswordupdateRequest;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->Model=new tblusers;
        
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $title=trans('message.admin_user_title');
        return view('admin_user.index',compact('title'));
    }


    /**
     * [store used for register admin ]
     * @return [type] [description]
     * @author  [Harsh V].

    */
    public function store(AdminRegisterRequest $request)
    {
       return $this->Model->store($request);    
    }

    /**
     * [profile used for view profile of admin ]
     * @return [type] [description]
     * @author  [Harsh V].

    */
    public function profile(Request $request,$id)
    {
        $title="Profile";
       return view('admin_user.profile',compact('title'));    
    }

    /**
     * [profileEdit used for view profileEdit of admin ]
     * @return [type] [description]
     * @author  [Harsh V].

    */
    public function profileEdit(Request $request)
    {
        $title="Edit Profile";
       return view('admin_user.profile_edit',compact('title'));    
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
       $title=trans('message.admin_user_edit');
       $admin_user=$this->Model->getSingleData($id);
       $encryptedId=$id;
       return view('admin_user.register',compact('title','admin_user','encryptedId'));  
    }

    /**
     * [update used for update admin data ]
     * @return [type] [description]
     * @author  [Harsh V].

    */
    public function update(AdminRegisterRequest $request,$id)
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
     * @author [Harsh V].
     */
    public function statusAll(Request $request){
        
        return $this->Model->statusAll($request);
    }

   
  



}
