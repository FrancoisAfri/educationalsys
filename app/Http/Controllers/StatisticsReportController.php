<?php

namespace App\Http\Controllers;

use App\activity;
use App\contacts_company;
use App\HRPerson;
use App\programme;
use App\projects;
use Illuminate\Http\Request;

//use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class StatisticsReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['page_title'] = "Statistics Report";
        $data['page_description'] = "Programmes, Projects, Activities stats";
        $data['breadcrumb'] = [
            ['title' => 'Reports', 'path' => '/reports/stats', 'icon' => 'fa fa-graduation-cap', 'active' => 0, 'is_module' => 1],
            ['title' => 'Statistics', 'path' => '/reports/stats', 'icon' => 'fa fa-tasks', 'active' => 0, 'is_module' => 0],
            ['title' => 'Programmes stats', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Reports';
        $data['active_rib'] = 'Statistics';
        $programmeManagers = HRPerson::where('status', 1)->where('position', 3)->get();
        $activityFacilitators = HRPerson::where('status', 1)->where('position', 6)->get();
        $serviceProviders = contacts_company::where('status', 1)->where('company_type', 1)->orderBy('name')->get();
        $programmes = DB::table('programmes')->where('status', 2)->orderBy('name', 'asc')->get();
        $projects = DB::table('projects')/*->where('status', 1)*/->orderBy('name', 'asc')->get();
        $facilitators = DB::table('hr_people')->where('position', 6)->orderBy('first_name', 'asc')->get();
        $managers = DB::table('hr_people')->where('position', 5)->orderBy('first_name', 'asc')->get();
        $ethnicities = DB::table('ethnicities')->where('status', 1)->orderBy('value', 'asc')->get();
        $data['ethnicities'] = $ethnicities;
        $data['programmes'] = $programmes;
        $data['projects'] = $projects;
        $data['facilitators'] = $facilitators;
        $data['managers'] = $managers;
        $data['programme_managers'] = $programmeManagers;
        $data['activityFacilitators'] = $activityFacilitators;
        $data['service_providers'] = $serviceProviders;
        AuditReportsController::store('Reports', 'Statistics Search Form Viewed ', "Actioned By User", 0);
        return view('reports.statistics_index')->with($data);
    }

    public function programmeStats(Request $request)
    {
        $startDate = trim($request->start_date);
        $endDate = trim($request->end_date);

        if (!empty($startDate))
        {
            $startDate = str_replace('/', '-', $startDate);
            $startDate = strtotime($startDate);
        }
        if (!empty($endDate))
        {
            $endDate = str_replace('/', '-', $endDate);
            $endDate = strtotime($endDate);
        }
        $programmes = programme::where('status', 2)
            ->where(function ($query) use($startDate) {
                if (!empty($startDate)) $query->whereRaw('start_date >=' . $startDate);
            })
            ->where(function ($query) use($endDate) {
                if (!empty($endDate)) $query->whereRaw('end_date <=' . $endDate);
            })
            ->with('regPeople', 'regMalePublic', 'regMaleEducators', 'regMaleLearners', 'regFemalePublic', 'regFemaleEducators',
                'regFemaleLearners', 'regBlackPublic', 'regWhitePublic', 'regColouredPublic', 'regBlackEducators',
                'regWhiteEducators', 'regColouredEducators', 'regBlackLearners', 'regWhiteLearners', 'regColouredLearners')
            ->orderBy('name')
            ->limit(250)
            ->get();
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;
        $data['programmes'] = $programmes;
        $data['page_title'] = "Statistics Report";
        $data['page_description'] = "Programmes / Projects / Activities stats";
        $data['breadcrumb'] = [
            ['title' => 'Reports', 'path' => '/reports/programme', 'icon' => 'fa fa-graduation-cap', 'active' => 0, 'is_module' => 1],
            ['title' => 'Statistics', 'path' => '/reports/programme', 'icon' => 'fa fa-tasks', 'active' => 0, 'is_module' => 0],
            ['title' => 'Programmes stats', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Reports';
        $data['active_rib'] = 'Statistics';
        AuditReportsController::store('Reports', 'Statistics Search Results Viewed ', "Actioned By User", 0);
        return view('reports.statistics_programme_result')->with($data);
    }

    public function projectStatsPost(Request $request)
    {
        $startDate = trim($request->start_date);
        $endDate = trim($request->end_date);
        return $this->projectStats($startDate, $endDate);
    }

    public function projectStatsGet($programmeID)
    {
        return $this->projectStats('', '', $programmeID);
    }

    public function projectStats($startDateInput = '', $endDateInput = '', $programmeID = null)
    {
        $startDate = trim($startDateInput);
        $endDate = trim($endDateInput);

        if (!empty($startDate))
        {
            $startDate = str_replace('/', '-', $startDate);
            $startDate = strtotime($startDate);
        }
        if (!empty($endDate))
        {
            $endDate = str_replace('/', '-', $endDate);
            $endDate = strtotime($endDate);
        }
        $projects = projects::where('status', 2)
            ->where(function ($query) use($programmeID) {
                if ($programmeID) $query->where('programme_id', $programmeID);
            })
            ->where(function ($query) use($startDate) {
                if (!empty($startDate)) $query->whereRaw('start_date >=' . $startDate);
            })
            ->where(function ($query) use($endDate) {
                if (!empty($endDate)) $query->whereRaw('end_date <=' . $endDate);
            })
            ->with('regPeople', 'regMalePublic', 'regMaleEducators', 'regMaleLearners', 'regFemalePublic', 'regFemaleEducators',
                'regFemaleLearners', 'regBlackPublic', 'regWhitePublic', 'regColouredPublic', 'regBlackEducators',
                'regWhiteEducators', 'regColouredEducators', 'regBlackLearners', 'regWhiteLearners', 'regColouredLearners')
            ->orderBy('name')
            ->limit(250)
            ->get();
            //return $projects;
        $data['start_date'] = $startDateInput;
        $data['end_date'] = $endDateInput;
        $data['programme_id'] = $programmeID;
        $data['projects'] = $projects;
        $data['page_title'] = "Statistics Report";
        $data['page_description'] = "Programmes / Projects / Activities stats";
        $data['breadcrumb'] = [
            ['title' => 'Reports', 'path' => '/reports/programme', 'icon' => 'fa fa-graduation-cap', 'active' => 0, 'is_module' => 1],
            ['title' => 'Statistics', 'path' => '/reports/programme', 'icon' => 'fa fa-tasks', 'active' => 0, 'is_module' => 0],
            ['title' => 'Projects stats', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Reports';
        $data['active_rib'] = 'Statistics';
        AuditReportsController::store('Reports', 'Statistics Search Results Viewed ', "Actioned By User", 0);
        return view('reports.statistics_project_result')->with($data);
    }

    public function activityStatsPost(Request $request)
    {
        $startDate = trim($request->start_date);
        $endDate = trim($request->end_date);
        return $this->activityStats($startDate, $endDate);
    }

    public function activityStatsGet($programmeID)
    {
        return $this->activityStats('', '', $programmeID);
    }

    public function activityStats($startDateInput = '', $endDateInput = '', $projectID = null)
    {
        $startDate = trim($startDateInput);
        $endDate = trim($endDateInput);

        if (!empty($startDate))
        {
            $startDate = str_replace('/', '-', $startDate);
            $startDate = strtotime($startDate);
        }
        if (!empty($endDate))
        {
            $endDate = str_replace('/', '-', $endDate);
            $endDate = strtotime($endDate);
        }
        $activities = activity::where('status', 2)
            ->where(function ($query) use($projectID) {
                if ($projectID) $query->where('project_id', $projectID);
            })
            ->where(function ($query) use($startDate) {
                if (!empty($startDate)) $query->whereRaw('start_date >=', $startDate);
            })
            ->where(function ($query) use($endDate) {
                if (!empty($endDate)) $query->whereRaw('end_date <=', $endDate);
            })
            ->with('regPeople', 'regMalePublic', 'regMaleEducators', 'regMaleLearners', 'regFemalePublic', 'regFemaleEducators',
                'regFemaleLearners', 'regBlackPublic', 'regWhitePublic', 'regColouredPublic', 'regBlackEducators',
                'regWhiteEducators', 'regColouredEducators', 'regBlackLearners', 'regWhiteLearners', 'regColouredLearners')
            ->orderBy('name')
            ->limit(250)
            ->get();
        $data['start_date'] = $startDateInput;
        $data['end_date'] = $endDateInput;
        $data['project_id'] = $projectID;
        $data['activities'] = $activities;
        $data['page_title'] = "Statistics Report";
        $data['page_description'] = "Programmes / Projects / Activities stats";
        $data['breadcrumb'] = [
            ['title' => 'Reports', 'path' => '/reports/programme', 'icon' => 'fa fa-graduation-cap', 'active' => 0, 'is_module' => 1],
            ['title' => 'Statistics', 'path' => '/reports/programme', 'icon' => 'fa fa-tasks', 'active' => 0, 'is_module' => 0],
            ['title' => 'Activities stats', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Reports';
        $data['active_rib'] = 'Statistics';
        AuditReportsController::store('Reports', 'Statistics Search Results Viewed ', "Actioned By User", 0);
        return view('reports.statistics_activity_result')->with($data);
    }
}
