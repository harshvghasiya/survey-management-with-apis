<?php


// Show alert Messages
function flashMessage($type,$message)
{
    \Session::put($type,$message);

}

// Upload And Download Web Url
function UPLOAD_AND_DOWNLOAD_URL(){

    if (env('IS_LIVE_DEMO_LOCAL') == 'local') {

        return  asset('public');

    }
}
    function pageAccess($id = '') {
        
        $arr=[
            '1'=>'Edit',
            '3'=>'Create',
        ];

        if (array_key_exists($id, $arr)) {
            return $arr[$id];
        } else {
            return $arr;
        }
    }

function HASACCESS($page_id,$roleid,$access)
{
    $user=\App\Models\tbluserrolepages::where('page_id',$page_id)->where('userroleid',$roleid)->first();

    if ($user != null) {
        if ( isset($user->$access) && $user->$access==true) {
                // dd($access);
                return true;
           }   
           return false;
    }

    return false;
}

function state_dropdown()
{
    
}

// for Status Icon and Data in yajara box
function getStatusIcon($data){
    if ($data->status == 1) {
        return '<span title="'.trans('message.click_on_button_change_status_label').'" class="btn btn-sm btn-success" id="active_inactive"
        status="1" data-id="'.\Crypt::encrypt($data->id).'">'.trans('message.active').'</span>';
    }else{
        return '<span title="'.trans('message.click_on_button_change_status_label').'" class="btn btn-sm btn-danger" id="active_inactive"
        status="0" data-id="'.\Crypt::encrypt($data->id).'">'.trans('message.inactive').'</span>';
    }
}


// Web Url Prefix
function ADMIN_PREFIX_KEYWORD()
{
    return 'x11';
}

// Basic Setting prefix keyword
function BASIC_SETTING_PREFIX_KEYWORD()
{
    return 'basic-settings';
}

function SURVEY_ORDER_PREFIX_KEYWORD()
{
    return 'survey-order';
}

function SURVEY_ORDER_ROUTE_NAME()
{
    return 'survey_order.';
}

// Basic setting route prefix keyword
function BASIC_SETTING_ROUTE_NAME()
{
    return 'basic_setting.';
}

// Upload  Images
function UPLOAD_FILE($r,$name,$uploadPath){

    $image=$r->$name;
    $name = time().''.$image->getClientOriginalName();

    $image->move($uploadPath,time().''.$image->getClientOriginalName());

    return  $name;
}

// Favicon Upload path
function FAVICON_IMAGE_UPLOAD_PATH()
{
    return UPLOAD_AND_DOWNLOAD_PATH().'/upload/basic_setting/favicon/';
}

// Logo Upload path
function LOGO_IMAGE_UPLOAD_PATH()
{
    return UPLOAD_AND_DOWNLOAD_PATH().'/upload/basic_setting/logo/';
}

// Upload and download path
function UPLOAD_AND_DOWNLOAD_PATH()
{
    return public_path();
}

// Upload and download url
function FAVICON_IMAGE_UPLOAD_URL(){

    return UPLOAD_AND_DOWNLOAD_URL().'/upload/basic_setting/favicon/';
}

// Upload and download url
function LOGO_IMAGE_UPLOAD_URL(){

    return UPLOAD_AND_DOWNLOAD_URL().'/upload/basic_setting/logo/';
}

// If Image not avalaible this image will show
function NO_IMAGE_URL()
{
    return UPLOAD_AND_DOWNLOAD_URL().'/admin/no_image.png';
}

// Base Currency Symbol position Dropdown
function getBaseCurrencySymbolPositionDropDown()
{
    $arr=[
       'left'=>'Left',
       'right'=>'Right'
    ];

    return $arr;
}



// Admin user routes prefix
function ADMIN_USER_PREFIX_KEYWORD()
{
    return 'admin-user';
}

// Admin user route name
function ADMIN_USER_ROUTE_NAME()
{
    return 'admin_user.';
}

// Admin user image upload path
function ADMIN_USER_IMAGE_UPLOAD_PATH(){

    return UPLOAD_AND_DOWNLOAD_PATH().'/upload/admin_user/';
}

// Admin user image upload url
function ADMIN_USER_IMAGE_UPLOAD_URL(){

    return UPLOAD_AND_DOWNLOAD_URL().'/upload/admin_user/';
}


// admin module route prefix
function MODULE_PREFIX_KEYWORD()
{
    return 'module';
}

// admin module route name
function MODULE_ROUTE_NAME()
 {
     return 'module.';
 }

//  Admin right route prefix
function RIGHT_PREFIX_KEYWORD()
{
    return 'right';
}
// Admin Right route name
function RIGHT_ROUTE_NAME()
{
    return 'right.';
}


// Genrate Token
function GENERATE_TOKEN()
{
    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
     $token = '';
    for ($i = 0; $i < 6; $i++)
    {
        $token .= $characters[rand(0, strlen($characters) - 1)];
    }
    $token = time().$token.time();
    return $token;
}

// GET Basic setting data
function GET_BASIC_SETTING()
{
    $data=\App\Models\BasicSetting::select('id','logo','favicon','is_recaptcha','website_title')->first();
    return $data;
}

// country prefix keyword
function COUNTRY_PREFIX_KEYWORD()
{
    return 'country';
}

// country route name
function COUNTRY_ROUTE_NAME()
{
    return 'country.';
}

// state route prefix
function STATE_PREFIX_KEYWORD()
{
    return 'state';
}

// state route name
function STATE_ROUTE_NAME()
{
    return 'state.';
}

// City route prefix
function CITY_PREFIX_KEYWORD()
{
    return 'city';
}

// city route name
function CITY_ROUTE_NAME()
{
    return 'city.';
}

// panel activity
function PanelActivtyStore($u_id,$name,$description,$slug)
{
    $res= new \App\Models\PanelActivity;
    $res->u_id=$u_id;
    $res->name=$name;
    $res->description=$description;
    $res->status=1;
    $res->slug=$slug;

    if (\Auth::user() != null) {
        $res->created_by=\Auth::user()->id;
    }
    $res->save();
    return true;
}

// PanelActivty get Data
function PanelActivtyData()
{
    $res=\App\Models\PanelActivity::with(['user_data'])->where('status',1)->orderBy('created_at','DESC')->take(9)->get();
    return $res;
}

// panel activity route prefix
function PANEL_ACTIVTY_PREFIX_KEYWORD()
{
    return 'panel-activty';
}

// Panel Activity route name
function PANEL_ACTIVTY_ROUTE_NAME()
{
    return 'panel_activity.';
}

// Support route prefix
function SUPPORT_PREFIX_KEYWORD()
{
    return 'support';
}

// Support route name
function SUPPORT_ROUTE_NAME()
{
    return 'support.';
}

// support data
 function GetSupportData()
{
    $data=\App\Models\Support::with(['user_data'])->where('status',1)->where('mark_as_read','!=',1)->orderBy('created_at','DESC')->take(9)->get();
    return $data;
}

// Validate User
 function CHECK_RIGHTS_TO_ACCESS_DENIED($module_id,$authuserId)
    {
        $authId=$authuserId;
        if ($authId->is_admin==1) {
            return true;
        }
        $right=\App\Models\Right::find($authId->right_id);
        $module_data=\App\Models\RightModule::where('status',\App\Models\RightModule::STATUS_ACTIVE)->where('right_id',$right->id)->pluck('module_id')->toArray();
        if (!empty($module_data)){
            if (in_array($module_id,$module_data)){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

// Contact Route prefix
function CONTACT_PREFIX_KEYWORD()
{
    return 'contact';
}

// Contact route name
function CONTACT_ROUTE_NAME()
{
    return 'contact.';
}

// Location route prefix
function LOCATION_PREFIX_KEYWORD()
{
    return 'location';
}

// Location route name
function LOCATION_ROUTE_NAME()
{
    return 'location.';
}

// Search Route
function SEARCH_PREFIX_KEYWORD()
{
    return 'search';
}

// Search Name
function SEARCH_ROUTE_NAME()
{
    return 'search.';
}

?>
