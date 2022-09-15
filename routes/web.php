<?php

use App\Http\Controllers\postalController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Route::group(['middleware'=>'web', 'as'=>'admin.'],function()
{
    Route::any('login', 'LoginController@login')->name('login');
    Route::any('postlogin', 'LoginController@postLogin')->name('postlogin');
    Route::any('forgot-password-post', 'LoginController@forgotPassword')->name('forgot_password');
    Route::any('forgot-password', 'LoginController@forgotPasswordForm')->name('forgot_password_form');
    Route::any('reset-password/{id}', 'LoginController@resetPassword')->name('reset_password');
    Route::any('update-password/{id}', 'LoginController@updatePassword')->name('update_password');
});

// Auth::routes();
    Route::any('logout', 'LoginController@logout')->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/getprojects/{user}', [App\Http\Controllers\HomeController::class, 'getprojects']);
Route::get('/getprojectsbyuser/{user}', [App\Http\Controllers\HomeController::class, 'getprojectsbyuser']);
Route::get('/getsurveysbyuser/{user}', [App\Http\Controllers\HomeController::class, 'getsurveycountbyuser']);
Route::get('/gettotalprojectsusers/{user}', [App\Http\Controllers\HomeController::class, 'gettotalprojectsusers']);
Route::get('/getprojectlocations/{user}', [App\Http\Controllers\HomeController::class, 'getprojectlocations']);
Route::get('/getprojectpoints/{user}', [App\Http\Controllers\HomeController::class, 'getprojectpoints']);
Route::get('/getprojectlines/{user}', [App\Http\Controllers\HomeController::class, 'getprojectlines']);
Route::get('/getprojectpolygon/{user}', [App\Http\Controllers\HomeController::class, 'getprojectpolygon']);

Route::get('/getprojectlocationsbyproject/{user}/{project}', [App\Http\Controllers\HomeController::class, 'getprojectlocationsbyproject']);
Route::get('/getprojectpointsbyproject/{user}/{project}', [App\Http\Controllers\HomeController::class, 'getprojectpointsbyproject']);
Route::get('/getprojectlinesbyproject/{user}/{project}', [App\Http\Controllers\HomeController::class, 'getprojectlinesbyproject']);
Route::get('/getprojectpolygonbyproject/{user}/{project}', [App\Http\Controllers\HomeController::class, 'getprojectpolygonbyproject']);

Route::get('/getprojectsbyuserbyproject/{user}/{project}', [App\Http\Controllers\HomeController::class, 'getprojectsbyuserbyproject']);
Route::get('/getsurveysbyuserbyproject/{user}/{project}', [App\Http\Controllers\HomeController::class, 'getsurveycountbyuserbyproject']);
Route::get('/gettotalprojectsusersbyproject/{user}/{project}', [App\Http\Controllers\HomeController::class, 'gettotalprojectsusersbyproject']);



Route::resource('usermanagement', userManagementController::class);

Route::get('/project/{id}/surveymodal', [App\Http\Controllers\projectController::class, 'survey'])->name('project.survey');
Route::put('/surveymodal/{survey}', [App\Http\Controllers\projectController::class, 'updatesurvey'])->name('project.updatesurvey');
Route::get('/project/{id}/locationmodal', [App\Http\Controllers\projectController::class, 'location'])->name('project.location');
Route::put('/locationmodal/{location}', [App\Http\Controllers\projectController::class, 'updatelocation'])->name('project.updatelocation');
Route::get('/project/{id}/usersmodal', [App\Http\Controllers\projectController::class, 'getusers'])->name('project.users');
Route::put('/usersmodal/{user}', [App\Http\Controllers\projectController::class, 'updateusers'])->name('project.updateusers');

Route::resource('project', projectController::class);

Route::any('get_survey_data', 'projectController@getSurveyData')->name('project.get_survey_data');
Route::any('project/survey-dependency-order/{id}', 'projectController@projectSurveyOrder')->name('project.survey_order');
Route::any('project/destroy-survey/{project_id}/{survey_id}', 'projectController@projectSurveyDestroy')->name('project.survey_destory');
Route::any('project-survey-order-update', 'projectController@projectSurveyOrderUpdate')->name('project.survey_order_update');

Route::resource('survey', surveyController::class);
Route::resource('location', locationController::class);
Route::resource('userrole', userroleController::class);
Route::resource('projectcategory', categoryController::class);
Route::resource('surveytypes', surveyTypeController::class);
Route::get('/getdistrict/{state}', [postalController::class, 'getdistrict']);
Route::get('/gettaluk/{state}', [postalController::class, 'gettaluk']);
Route::get('/gettalukbydist/{district}/{state}', [postalController::class, 'gettalukbydist']);
Route::get('/getvillagebytaluk/{taluk}/{district}/{state}', [postalController::class, 'getvillagebytaluk']);
Route::get('/getsurveydata/{surveyid}', [postalController::class, 'getsurveydata']);
Route::get('/getlocationdata/{surveyid}', [postalController::class, 'getlocationdata']);
Route::get('/getuserdata/{surveyid}', [postalController::class, 'getuserdata']);



// Survey order  Routes [@author Harsh Vaghasiya]

    Route::group(['prefix'=>SURVEY_ORDER_PREFIX_KEYWORD(),'as'=>SURVEY_ORDER_ROUTE_NAME()],function()
    {
       Route::any('/', 'SurveyOrderController@index')->name('index');
       Route::any('/survey_order_update', 'SurveyOrderController@surveyOrderUpdate')->name('survey_order_update');
       
    });


// Admin User Routes [@author Harsh Vaghasiya]
    Route::group(['prefix'=>ADMIN_USER_PREFIX_KEYWORD(),'as'=>ADMIN_USER_ROUTE_NAME()],function()
    {
        Route::any('create', 'LoginController@create')->name('create');
       Route::any('store', 'AdminController@store')->name('store');
       Route::any('edit/{id}', 'AdminController@edit')->name('edit');
       Route::any('update/{id}', 'AdminController@update')->name('update');
       Route::any('destroy/{id}', 'AdminController@destroy')->name('destroy');
       Route::any('/', 'AdminController@index')->name('index');
       Route::any('profile/{id}', 'AdminController@profile')->name('profile');
       Route::any('edit-profile', 'AdminController@profileEdit')->name('profile_edit');
       Route::any('any_data', 'AdminController@anyData')->name('any_data');
       Route::any('delete-all','AdminController@deleteAll')->name('delete_all');
       Route::any('status-all','AdminController@statusAll')->name('status_all');
       Route::any('single_status_change', 'AdminController@singleStatusChange')->name('single_status_change');
       
    });

// Admin Modules Routes [@author Harsh Vaghasiya]
    Route::group(['prefix'=>MODULE_PREFIX_KEYWORD(),'as'=>MODULE_ROUTE_NAME()],function()
    {
       Route::any('create', 'ModuleController@create')->name('create');
       Route::any('store', 'ModuleController@store')->name('store');
       Route::any('edit/{id}', 'ModuleController@edit')->name('edit');
       Route::any('update/{id}', 'ModuleController@update')->name('update');
       Route::any('destroy/{id}', 'ModuleController@destroy')->name('destroy');
       Route::any('/', 'ModuleController@index')->name('index');
       Route::any('any_data', 'ModuleController@anyData')->name('any_data');
       Route::any('delete-all','ModuleController@deleteAll')->name('delete_all');
       Route::any('status-all','ModuleController@statusAll')->name('status_all');
       Route::any('single_status_change', 'ModuleController@singleStatusChange')->name('single_status_change');
       
    });

// Admin Right Routes [@author Harsh Vaghasiya]
Route::group(['prefix'=>RIGHT_PREFIX_KEYWORD(),'as'=>RIGHT_ROUTE_NAME()],function()
{
       Route::any('create', 'RightController@create')->name('create');
       Route::any('store', 'RightController@store')->name('store');
       Route::any('edit/{id}', 'RightController@edit')->name('edit');
       Route::any('update/{id}', 'RightController@update')->name('update');
       Route::any('destroy/{id}', 'RightController@destroy')->name('destroy');
       Route::any('/', 'RightController@index')->name('index');
       Route::any('any_data', 'RightController@anyData')->name('any_data');
       Route::any('delete-all','RightController@deleteAll')->name('delete_all');
       Route::any('status-all','RightController@statusAll')->name('status_all');
       Route::any('single_status_change', 'RightController@singleStatusChange')->name('single_status_change');
       
});

