<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Crypt;
use Auth;
use Yajra\Datatables\Datatables;


class tblusers extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    const STATUS_INACTIVE=0;
   const STATUS_ACTIVE=1;
   const page_id=2;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


     public function admin_right()
   {
      return $this->belongsTo('\App\Models\tbluserroles','userroleid','id');
   }

   

     public function user_projects()
   {
      return $this->hasMany('\App\Models\tblprojectusers','user_id','id');
   }

    /**
     * [store used for register data of admin ]
     * @return [type] [description]
     * @author  [Harsh V].

    */
    public function store($request,$id=null)
    { 
        if ($id ==null) {   
           $res=new self;
           $res->password=\Hash::make($request->password);
            $msg=trans('message.admin_added_successfully');
          $description=trans('message.new_user_added_msg');


        }else{
            $id=Crypt::decrypt($id);
            $res=self::find($id);
            if ($request->change_password !=null && $request->change_password==1   ) {
              $request->password=\Hash::make($request->password);
            }
            $msg=trans('message.admin_updated_successfully');
        }

        $res->username=$request->username;
        $res->first_name=$request->first_name;
        $res->last_name=$request->last_name;
        $res->phone_number=$request->phone_number;
        $res->email=$request->email;
        $res->right_id=$request->right_id;
        $res->userroleid=$request->userroleid;
        $res->state=$request->state;
        $res->district=$request->district;
        $res->taluk=$request->taluk;
        $res->address=$request->address;
      

        $res->save();
        
        $url=route('admin_user.index');
          flashMessage('success',$msg);
        
        return response()->json(['msg'=>$msg,'status'=>true,'url'=>$url]);
    }
     
    
    /**
     * [getListData used for get admin list through yajra ]
     * @return [type] [description]
     * @author  [Harsh V].

    */
    public function getListData($request)
    {
         $sql=self::select("*");
        return Datatables::of($sql)
              ->addColumn('action',function($data){

                  $string ='<a title="'.trans('message.edit_admin_user').'" href="'.route('admin_user.edit',Crypt::encrypt($data->id)).'" class="btn btn-xs btn-primary">Edit</a>';

                    if (env('IS_MASTER_ADMIN') == true) {
                      
                    $string .=' <a href="javascript:void(0)" title="'.trans('message.delete_admin_user_label').'" data-route="'.route('admin_user.destroy',Crypt::encrypt($data->id)).'" class="btn btn-xs btn-danger delete_record">Delete</a>';
                    }
                  
                  
                  return $string;
              })

              ->editColumn('id',function($data){
                  return '<input type="checkbox" name="checkbox[]" class="select_checkbox_value" value="'.Crypt::encrypt($data->id).'" />';
              })
              ->editColumn('right_id',function($data){
                  if (isset($data->admin_right) && $data->admin_right != null) {
                    $name=$data->admin_right->name;
                  }else{
                    $name="";
                  }
                  return $name;
              })
              ->editColumn('status',function($data){
                  return getStatusIcon($data);
              })
              ->filter(function ($query) use ($request) {
                
                  if (isset($request['status']) && $request['status'] != "") {
                      $query->where('status', $request['status']);
                  }
                  if (isset($request['name']) && $request['name'] != "") {
                      $query->where('name', 'like', '%' . $request->name . '%')
                           ->orwhere('email', 'like', '%' . $request->name . '%');
                  }
              })
              ->rawColumns(['id','action','status','image'])
              ->make(true);
    }


    

    /**
     * [getSingleData This function will return sinlge data of admin]
     * @return [type] [description]
     * @author  [Harsh V].
     */
    public function getSingleData($id){
        $id=Crypt::decrypt($id);
        $data=self::find($id);
        return $data;
    } 


     /**
     * [deleteAll This funtion is used to delete specific resources]
     * @param  [type] $r [description]
     * @return [type]    [description]
     * @author  [Harsh V].

     */
    public function deleteAll($r)
    {

     $input=$r->all();
      foreach ($input['checkbox'] as $key => $c) {

          $obj = $this->findOrFail(Crypt::decrypt($c));
          $obj->delete();
      }

      return response()->json(['success' => 1, 'msg' => trans('message.admin_user_delete_message_label')]);
    }


    /**
     * [SingleStatusChange This function is used to active in active single status]
     * @param [type] $r [description]
     * @author [Harsh V].
     */
    public function SingleStatusChange($r){

      $l = self::where('id',\Crypt::decrypt($r->id))->first();
      if ($l !=NULL) {
          
          if ($l->status == 1) {
            $l->status = self::STATUS_INACTIVE;
          }else{
            $l->status = self::STATUS_ACTIVE;
          }
          $l->save();
          return response()->json(['status' => $l->status]);
      }
    } 

    /**
     * [statusAll This function is used to active or inactive sepcifuc resources]
     * @param  [type] $r [description]
     * @return [type]    [description]
     * @author softtechover [Chirag G][Harsh V].
     */
    public function statusAll($r){

      $input=$r->all();
      foreach ($input['checkbox'] as $key => $c) {
            $l = self::where('id',\Crypt::decrypt($c))->first();
            if ($l !=NULL) {
                
                if ($l->status == 1) {
                  $l->status = self::STATUS_INACTIVE;
                }else{
                  $l->status = self::STATUS_ACTIVE;
                }
                $l->save();
            }
      }
      return response()->json(['success' => 1, 'msg' => trans('message.admin_user_delete_message_label')]);
    } 

    
    
}
