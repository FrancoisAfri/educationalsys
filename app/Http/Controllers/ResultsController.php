<?php

namespace App\Http\Controllers;

use App\activity;
use App\educator;
use App\Learner;
use App\programme;
use App\projects;
use App\public_reg;
use App\Registration;
use App\RegistrationArea;
use App\RegistrationModule;
use App\RegistrationSubject;
use Illuminate\Http\Request;
use App\Http\Controllers\AuditReportsController;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ResultsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //show registration search form
    public function searchRegistrations(){
        $programmes = DB::table('programmes')->where('status', 2)->orderBy('name', 'asc')->get();

        $data['page_title'] = "Results";
        $data['page_description'] = "Capture a Learner, Educator or Member of the General Public's Results";
        $data['breadcrumb'] = [
            ['title' => 'Results', 'path' => '/education/results/search', 'icon' => 'fa fa-percent', 'active' => 0, 'is_module' => 1],
            ['title' => 'Load Clients', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'results';
        $data['active_rib'] = 'capture results';
        $data['programmes'] = $programmes;
		AuditReportsController::store('Registration Search', 'Search Details', "Actioned By User", 0);
        return view('results.load_clients')->with($data);
    }

    //get registration search result
    public function getRegistrations(Request $request){
        //Validation
        $validator = Validator::make($request->all(), [
            'registration_type' => 'required',
            'programme_id' => 'required',
            'registration_year' => 'required',
            'course_type' => 'required',
            'registration_semester' => 'required_if:course_type,2',
        ]);
        if ($validator->fails()) {
            return redirect('/education/loadclients')
                ->withErrors($validator)
                ->withInput();
        }
        $regData = $request->all();
        $regType = (int) $regData['registration_type'];
        $programmeID = (int) $regData['programme_id'];
        $regYear = (int) $regData['registration_year'];
        $courseType = (int) $regData['course_type'];
        $regSemester = ($regData['registration_semester'] != '') ? (int) $regData['registration_semester'] : 0;
        $projectID = ($regData['project_id'] != '') ? (int) $regData['project_id'] : 0;
        $activityID = ($regData['activity_id'] != '') ? (int) $regData['activity_id'] : 0;
        $registrations = Registration::where('registration_type', $regType)
            ->where('programme_id', $programmeID)
            ->where('registration_year', $regYear)
            ->where('course_type', $courseType)
            ->where(function ($query) use ($courseType, $regSemester, $projectID, $activityID) {
                if ($projectID > 0) $query->where('project_id', $projectID);
                if ($activityID > 0) $query->where('activity_id', $activityID);
                if ($courseType == 2 && $regSemester > 0) $query->where('registration_semester', $regSemester);
            })
            ->get();

        $subjectNames = [];
        if ($regType == 1) {$subjectNames = RegistrationSubject::$subjects;} //Subjects (learner)
        //elseif ($regType == 2) {} //Modules (educator)
        elseif ($regType == 3) {$subjectNames = RegistrationArea::$areas;} //area (general public)

        $studentClass = (object) [];
        if ($registrations) $registrations->load('client', 'programme', 'project', 'subjects');
        //return $registrations;
        if ($activityID > 0) {
            $studentClass->label = 'Activity';
            $studentClass->name = activity::find($activityID)->name;
        }
        elseif ($projectID > 0) {
            $studentClass->label = 'Project';
            $studentClass->name = projects::find($projectID)->name;
        }
        else {
            $studentClass->label = 'Programme';
            $studentClass->name = programme::find($programmeID)->name;
        }

        $data['page_title'] = "Results";
        $data['page_description'] = "Capture a Learner, Educator or Member of the General Public's Results";
        $data['breadcrumb'] = [
            ['title' => 'Programmes', 'path' => '/education/results/search', 'icon' => 'fa fa-percent', 'active' => 0, 'is_module' => 1],
            ['title' => 'Load Clients', 'path' => '/education/loadclients', 'icon' => 'fa fa-tasks', 'active' => 0, 'is_module' => 0],
            ['title' => 'Capture Results', 'active' => 1, 'is_module' => 0]
        ];
        $data['regType'] = $regType;
        $data['registrations'] = $registrations;
        $data['subjectNames'] = json_encode($subjectNames);
        $data['className'] = $studentClass;
        $data['active_mod'] = 'results';
        $data['active_rib'] = 'capture results';
		AuditReportsController::store('Registration Performed', 'Student Registered', "Actioned By User", 0);
        return view('results.show_clients')->with($data);
    }

    //update registration results
    public function updateResults(Request $request, Registration $registration) {
        $regType = (int) $request->input('reg_type');
        $regSubjectIDs = $request->input('reg_subject_ids');
        $regSubjectResults = $request->input('results');
        $allResultsCaptured = true;
        $count = count($regSubjectIDs);
        if ($regType == 1) { //Subjects (learner)
            for ($i = 0; $i < $count; $i++) {
                $regSubject = RegistrationSubject::find($regSubjectIDs[$i]);
                $result = trim($regSubjectResults[$i]) != '' ? trim($regSubjectResults[$i]) : null;
                $regSubject->result = $result;
                $regSubject->update();
                if ($allResultsCaptured == true && $result == null) $allResultsCaptured = false;
            }
            if ($allResultsCaptured) {
                $learner = Learner::find($registration->learner_id);
                $learner->is_registered = 0;
                $learner->update();
            }
        }
        elseif ($regType == 2) { //Modules (educator)
            for ($i = 0; $i < $count; $i++) {
                $regModule = RegistrationModule::find($regSubjectIDs[$i]);
                $result = trim($regSubjectResults[$i]) != '' ? trim($regSubjectResults[$i]) : null;
                $regModule->result = $result;
                $regModule->update();
                if ($allResultsCaptured == true && $result == null) $allResultsCaptured = false;
            }
            if ($allResultsCaptured) {
                $educator = educator::find($registration->educator_id);
                $educator->is_registered = 0;
                $educator->update();
            }
        }
        elseif ($regType == 3) { //area (general public)
            for ($i = 0; $i < $count; $i++) {
                $regArea = RegistrationArea::find($regSubjectIDs[$i]);
                $result = trim($regSubjectResults[$i]) != '' ? trim($regSubjectResults[$i]) : null;
                $regArea->result = $result;
                $regArea->update();
                if ($allResultsCaptured == true && $result == null) $allResultsCaptured = false;
            }
            if ($allResultsCaptured) {
                $genPub = public_reg::find($registration->gen_public_id);
                $genPub->is_registered = 0;
                $genPub->update();
            }
        }
        return response()->json(['success' => 'Results saved'], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
