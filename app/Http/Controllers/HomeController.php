<?php

namespace App\Http\Controllers;

use App\Models\tblprojects;
use App\Models\tblprojectusers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getprojects($userid)
    {
        $projects['data'] = DB::select('SELECT a.id, a.projectname FROM public.tblprojects a, public.tblprojectusers b WHERE a.id=b.project_id and b.user_id=:id', ['id' => $userid]);

        return response()->json($projects);
    }

    public function getprojectsbyuser($userid)
    {
        $projectuserdata['data'] = DB::select('SELECT a.projectname,count(a.id) FROM public.tblprojects a, public.tblprojectusers b WHERE a.id=b.project_id and b.user_id=:id GROUP BY a.projectname', ['id' => $userid]);

        $output['data'] = collect();
        $sum = 0;
        $output['data']->push(['Project', 'Count']);
        if (is_null($projectuserdata['data'])) {
            $output['data']->push(['No Projects', 0]);
        } else {
            foreach ($projectuserdata['data'] as $project) {
                $output['data']->push([$project->projectname, $project->count]);

                $sum = $sum + $project->count;
            }

            $output['count'] = $sum;
        }

        return response()->json($output);
    }

    public function getprojectsbyuserbyproject($userid, $userpid)
    {
        $data = explode(',', $userpid);
        $i = 0;
        $conditionproject = "";
        foreach ($data as $id) {
            if ($i == 0) {
                $conditionproject = "a.id = $id";
                $i++;
            } else {
                $conditionproject = $conditionproject . " OR a.id = $id";
            }
        }

        if (count($data) > 0) {
            $projectuserdata['data'] = DB::select('SELECT a.projectname,count(a.id) FROM public.tblprojects a, public.tblprojectusers b WHERE a.id=b.project_id and b.user_id=:id and (' . $conditionproject . ') GROUP BY a.projectname', ['id' => $userid]);
        } else {
            $projectuserdata['data'] = DB::select('SELECT a.projectname,count(a.id) FROM public.tblprojects a, public.tblprojectusers b WHERE a.id=b.project_id and b.user_id=:id GROUP BY a.projectname', ['id' => $userid]);
        }


        $output['data'] = collect();
        $sum = 0;
        $output['data']->push(['Project', 'Count']);
        if (is_null($projectuserdata['data'])) {
            $output['data']->push(['No Projects', 0]);
        } else {
            foreach ($projectuserdata['data'] as $project) {
                $output['data']->push([$project->projectname, $project->count]);

                $sum = $sum + $project->count;
            }

            $output['count'] = $sum;
        }

        return response()->json($output);
    }

    public function getsurveycountbyuser($userid)
    {

        $surveyname = DB::select('SELECT a.surveyname FROM public.tblsurveys a, public.tblprojects b, public.tblprojectusers c WHERE a.id=b.survey_id and b.id=c.project_id and c.user_id=:id', ['id' => $userid]);

        $table = $surveyname[0]->surveyname;

        $table = Str::replace(' ', '_', $table);

        $projectuserdata['data'] = DB::select('SELECT a.projectname, count(c.id) FROM public.tblprojects a, public.tblprojectusers b, public."' . $table . '" c WHERE a.id=b.project_id and a.survey_id=c.survey_id and b.user_id=:id GROUP BY a.projectname', ['id' => $userid]);

        // return response()->json($projectuserdata);

        $output['data'] = collect();
        $sum = 0;
        $output['data']->push(['Project', 'Count']);
        if (is_null($projectuserdata['data'])) {
            $output['data']->push(['No Projects', 0]);
        } else {
            foreach ($projectuserdata['data'] as $project) {
                $output['data']->push([$project->projectname, $project->count]);

                $sum = $sum + $project->count;
            }

            $output['count'] = $sum;
        }

        return response()->json($output);
    }

    public function getsurveycountbyuserbyproject($userid, $userpid)
    {

        $data = explode(',', $userpid);
        $i = 0;
        $j = 0;
        $conditionproject = "";
        $conditionprojectnew = "";
        foreach ($data as $id) {
            if ($i == 0) {
                $conditionproject = "b.id = $id";
                $i++;
            } else {
                $conditionproject = $conditionproject . " OR b.id = $id";
            }
        }

        foreach ($data as $id) {
            if ($j == 0) {
                $conditionprojectnew = "a.id = $id";
                $j++;
            } else {
                $conditionprojectnew = $conditionprojectnew . " OR a.id = $id";
            }
        }

        if (count($data) > 0) {
            $surveyname = DB::select('SELECT a.surveyname FROM public.tblsurveys a, public.tblprojects b, public.tblprojectusers c WHERE a.id=b.survey_id and b.id=c.project_id and c.user_id=:id and (' . $conditionproject . ')', ['id' => $userid]);

            $table = $surveyname[0]->surveyname;

            $table = Str::replace(' ', '_', $table);

            $projectuserdata['data'] = DB::select('SELECT a.projectname, count(c.id) FROM public.tblprojects a, public.tblprojectusers b, public."' . $table . '" c WHERE a.id=b.project_id and a.survey_id=c.survey_id and b.user_id=:id and (' . $conditionprojectnew . ') GROUP BY a.projectname', ['id' => $userid]);

        } else {
            $surveyname = DB::select('SELECT a.surveyname FROM public.tblsurveys a, public.tblprojects b, public.tblprojectusers c WHERE a.id=b.survey_id and b.id=c.project_id and c.user_id=:id', ['id' => $userid]);
            $table = $surveyname[0]->surveyname;

            $table = Str::replace(' ', '_', $table);

            $projectuserdata['data'] = DB::select('SELECT a.projectname, count(c.id) FROM public.tblprojects a, public.tblprojectusers b, public."' . $table . '" c WHERE a.id=b.project_id and a.survey_id=c.survey_id and b.user_id=:id GROUP BY a.projectname', ['id' => $userid]);
        }



        // return response()->json($projectuserdata);

        $output['data'] = collect();
        $sum = 0;
        $output['data']->push(['Project', 'Count']);
        if (is_null($projectuserdata['data'])) {
            $output['data']->push(['No Projects', 0]);
        } else {
            foreach ($projectuserdata['data'] as $project) {
                $output['data']->push([$project->projectname, $project->count]);

                $sum = $sum + $project->count;
            }

            $output['count'] = $sum;
        }

        return response()->json($output);
    }

    public function gettotalprojectsusers($userid)
    {

        $projectid = tblprojectusers::select('project_id')->where('user_id', $userid)->get();

        $output['data'] = collect();
        $sum = 0;
        $output['data']->push(['Project', 'Count']);

        foreach ($projectid as $projects) {
            $pid = $projects->project_id;

            $projectuserdata['data'] = DB::select('SELECT a.projectname,count(b.id) FROM public.tblprojects a, public.tblprojectusers b WHERE a.id=b.project_id and a.id=:id GROUP BY a.projectname', ['id' => $pid]);

            if (is_null($projectuserdata['data'])) {
                // $output['data']->push(['No Projects',0]);
            } else {
                foreach ($projectuserdata['data'] as $project) {
                    $output['data']->push([$project->projectname, $project->count]);

                    $sum = $sum + $project->count;
                }

                $output['count'] = $sum;
            }
        }
        return response()->json($output);
    }

    public function gettotalprojectsusersbyproject($userid, $userpid)
    {
        $data = explode(',', $userpid);
        $i = 0;
        $conditionproject = "";
        $conditionprojectnew = "";
        foreach ($data as $id) {
            if ($i == 0) {
                $conditionproject = "a.id = $id";
                $i++;
            } else {
                $conditionproject = $conditionproject . " OR a.id = $id";
            }
        }

        if (count($data) == 0) {
            $projectid = tblprojectusers::select('project_id')->where('user_id', $userid)->get();

            $output['data'] = collect();
            $sum = 0;
            $output['data']->push(['Project', 'Count']);

            foreach ($projectid as $projects) {
                $pid = $projects->project_id;

                $projectuserdata['data'] = DB::select('SELECT a.projectname,count(b.id) FROM public.tblprojects a, public.tblprojectusers b WHERE a.id=b.project_id and a.id=:id GROUP BY a.projectname', ['id' => $pid]);

                if (is_null($projectuserdata['data'])) {
                    // $output['data']->push(['No Projects',0]);
                } else {
                    foreach ($projectuserdata['data'] as $project) {
                        $output['data']->push([$project->projectname, $project->count]);

                        $sum = $sum + $project->count;
                    }

                    $output['count'] = $sum;
                }
            }
            return response()->json($output);
        } else if (count($data) > 0) {

            $output['data'] = collect();
            $sum = 0;
            $output['data']->push(['Project', 'Count']);

            $projectuserdata['data'] = DB::select('SELECT a.projectname,count(b.id) FROM public.tblprojects a, public.tblprojectusers b WHERE a.id=b.project_id and (' . $conditionproject . ') GROUP BY a.projectname');

            if (is_null($projectuserdata['data'])) {
                // $output['data']->push(['No Projects',0]);
            } else {
                foreach ($projectuserdata['data'] as $project) {
                    $output['data']->push([$project->projectname, $project->count]);

                    $sum = $sum + $project->count;
                }

                $output['count'] = $sum;
            }
            return response()->json($output);
        }
    }

    public function getprojectlocations($userid)
    {
        $projectid = tblprojectusers::select('project_id')->where('user_id', $userid)->get();

        $output['data'] = collect();

        foreach ($projectid as $projects) {
            $pid = $projects->project_id;

            $projectuserdata['data'] = DB::select('SELECT a.lat, a.long, b.locationname, d.projectname FROM public.tblmultilocations a, public.tbllocations b, public.tblprojectlocations c, public.tblprojects d WHERE a.locationid=b.id and c.location_id=b.id and c.project_id=d.id and d.id=:id', ['id' => $pid]);

            if (is_null($projectuserdata['data'])) {
                // $output['data']->push(['No Projects',0]);
            } else {
                foreach ($projectuserdata['data'] as $project) {
                    $output['data']->push(['lat' => $project->lat, 'long' => $project->long, 'location' => $project->locationname, 'project' => $project->projectname]);
                }
            }
        }
        return response()->json($output);
    }

    public function getprojectlocationsbyproject($userid, $userpid)
    {
        $data = explode(',', $userpid);
        if (count($data) == 0) {
            $projectid = tblprojectusers::select('project_id')->where('user_id', $userid)->get();

            $output['data'] = collect();

            foreach ($projectid as $projects) {
                $pid = $projects->project_id;

                $projectuserdata['data'] = DB::select('SELECT a.lat, a.long, b.locationname, d.projectname FROM public.tblmultilocations a, public.tbllocations b, public.tblprojectlocations c, public.tblprojects d WHERE a.locationid=b.id and c.location_id=b.id and c.project_id=d.id and d.id=:id', ['id' => $pid]);

                if (is_null($projectuserdata['data'])) {
                    // $output['data']->push(['No Projects',0]);
                } else {
                    foreach ($projectuserdata['data'] as $project) {
                        $output['data']->push(['lat' => $project->lat, 'long' => $project->long, 'location' => $project->locationname, 'project' => $project->projectname]);
                    }
                }
            }
            return response()->json($output);
        } else if (count($data) > 0) {

            // Log::debug($data);
            $i = 0;
            $conditionlocation = "";
            foreach ($data as $id) {
                if ($i == 0) {
                    $conditionlocation = "d.id = $id";
                    $i++;
                } else {
                    $conditionlocation = $conditionlocation . " OR d.id = $id";
                }
            }

            $output['data'] = collect();

            $projectuserdata['data'] = DB::select('SELECT a.lat, a.long, b.locationname, d.projectname FROM public.tblmultilocations a, public.tbllocations b, public.tblprojectlocations c, public.tblprojects d WHERE a.locationid=b.id and c.location_id=b.id and c.project_id=d.id and (' . $conditionlocation . ')');

            if (is_null($projectuserdata['data'])) {
                // $output['data']->push(['No Projects',0]);
            } else {
                foreach ($projectuserdata['data'] as $project) {
                    $output['data']->push(['lat' => $project->lat, 'long' => $project->long, 'location' => $project->locationname, 'project' => $project->projectname]);
                }
            }
            return response()->json($output);
        }
    }

    public function getprojectpoints($userid)
    {
        $surveyname = DB::select('SELECT a.surveyname FROM public.tblsurveys a, public.tblprojects b, public.tblprojectusers c WHERE a.id=b.survey_id and b.id=c.project_id and c.user_id=:id', ['id' => $userid]);

        $table = $surveyname[0]->surveyname;

        $table = Str::replace(' ', '_', $table);

        $pointdata['data'] = DB::select('SELECT latlong FROM public."' . $table . '" WHERE type=:type and latlong is not NULL', ['type' => 'point']);

        return response()->json($pointdata);
    }

    public function getprojectpointsbyproject($userid, $userpid)
    {
        $data = explode(',', $userpid);
        $i = 0;
        $conditionproject = "";
        foreach ($data as $id) {
            if ($i == 0) {
                $conditionproject = "b.id = $id";
                $i++;
            } else {
                $conditionproject = $conditionproject . " OR b.id = $id";
            }
        }

        if (count($data) > 0) {
            $surveyname = DB::select('SELECT a.surveyname FROM public.tblsurveys a, public.tblprojects b, public.tblprojectusers c WHERE a.id=b.survey_id and b.id=c.project_id and c.user_id=:id and (' . $conditionproject . ')', ['id' => $userid]);
        } else {
            $surveyname = DB::select('SELECT a.surveyname FROM public.tblsurveys a, public.tblprojects b, public.tblprojectusers c WHERE a.id=b.survey_id and b.id=c.project_id and c.user_id=:id', ['id' => $userid]);
        }

        $table = $surveyname[0]->surveyname;

        $table = Str::replace(' ', '_', $table);

        $pointdata['data'] = DB::select('SELECT latlong FROM public."' . $table . '" WHERE type=:type and latlong is not NULL', ['type' => 'point']);

        return response()->json($pointdata);
    }

    public function getprojectlines($userid)
    {
        $surveyname = DB::select('SELECT a.surveyname FROM public.tblsurveys a, public.tblprojects b, public.tblprojectusers c WHERE a.id=b.survey_id and b.id=c.project_id and c.user_id=:id', ['id' => $userid]);

        $table = $surveyname[0]->surveyname;

        $table = Str::replace(' ', '_', $table);

        $pointdata['data'] = DB::select('SELECT latlong FROM public."' . $table . '" WHERE type=:type and latlong is not NULL', ['type' => 'line']);

        return response()->json($pointdata);
    }

    public function getprojectlinesbyproject($userid, $userpid)
    {
        $data = explode(',', $userpid);
        $i = 0;
        $conditionproject = "";
        foreach ($data as $id) {
            if ($i == 0) {
                $conditionproject = "b.id = $id";
                $i++;
            } else {
                $conditionproject = $conditionproject . " OR b.id = $id";
            }
        }

        if (count($data) > 0) {
            $surveyname = DB::select('SELECT a.surveyname FROM public.tblsurveys a, public.tblprojects b, public.tblprojectusers c WHERE a.id=b.survey_id and b.id=c.project_id and c.user_id=:id and (' . $conditionproject . ')', ['id' => $userid]);
        } else {
            $surveyname = DB::select('SELECT a.surveyname FROM public.tblsurveys a, public.tblprojects b, public.tblprojectusers c WHERE a.id=b.survey_id and b.id=c.project_id and c.user_id=:id', ['id' => $userid]);
        }


        $table = $surveyname[0]->surveyname;

        $table = Str::replace(' ', '_', $table);

        $pointdata['data'] = DB::select('SELECT latlong FROM public."' . $table . '" WHERE type=:type and latlong is not NULL', ['type' => 'line']);

        return response()->json($pointdata);
    }

    public function getprojectpolygon($userid)
    {
        $surveyname = DB::select('SELECT a.surveyname FROM public.tblsurveys a, public.tblprojects b, public.tblprojectusers c WHERE a.id=b.survey_id and b.id=c.project_id and c.user_id=:id', ['id' => $userid]);

        $table = $surveyname[0]->surveyname;

        $table = Str::replace(' ', '_', $table);

        $pointdata['data'] = DB::select('SELECT latlong FROM public."' . $table . '" WHERE type=:type and latlong is not NULL', ['type' => 'polygon']);

        return response()->json($pointdata);
    }

    public function getprojectpolygonbyproject($userid, $userpid)
    {
        $data = explode(',', $userpid);
        $i = 0;
        $conditionproject = "";
        foreach ($data as $id) {
            if ($i == 0) {
                $conditionproject = "b.id = $id";
                $i++;
            } else {
                $conditionproject = $conditionproject . " OR b.id = $id";
            }
        }

        if (count($data) > 0) {
            $surveyname = DB::select('SELECT a.surveyname FROM public.tblsurveys a, public.tblprojects b, public.tblprojectusers c WHERE a.id=b.survey_id and b.id=c.project_id and c.user_id=:id and (' . $conditionproject . ')', ['id' => $userid]);
        } else {
            $surveyname = DB::select('SELECT a.surveyname FROM public.tblsurveys a, public.tblprojects b, public.tblprojectusers c WHERE a.id=b.survey_id and b.id=c.project_id and c.user_id=:id', ['id' => $userid]);
        }

        $table = $surveyname[0]->surveyname;

        $table = Str::replace(' ', '_', $table);

        $pointdata['data'] = DB::select('SELECT latlong FROM public."' . $table . '" WHERE type=:type and latlong is not NULL', ['type' => 'polygon']);

        return response()->json($pointdata);
    }
}
