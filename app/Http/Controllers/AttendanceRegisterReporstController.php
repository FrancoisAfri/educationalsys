<?php

namespace App\Http\Controllers;

use App\educator;
use App\Learner;
use App\public_reg;
use App\Registration;
use App\programme;
use App\projects;
use App\AttendanceRegister;
use Illuminate\Http\Request;
use App\Http\Controllers\AuditReportsController;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttendanceRegisterReporstController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $programmes = DB::table('programmes')->where('status', 2)->orderBy('name', 'asc')->get();

        $data['page_title'] = "Attendance Register";
        $data['page_description'] = "Attendance Register Report";
        $data['breadcrumb'] = [
            ['title' => 'Attendance Register', 'path' => '/reports/attendance', 'icon' => 'fa fa-adn', 'active' => 0, 'is_module' => 1],
            ['title' => 'Attendance Register', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Reports';
        $data['active_rib'] = 'Attendance Register';
        $data['programmes'] = $programmes;
        AuditReportsController::store('Attendance Register', 'Search Clients', "Actioned By User", 0);
        return view('reports.attendance')->with($data);
    }

   // draw audit report acccording to search criteria
	public function getReport(Request $request)
    {
		//Validation
        $validator = Validator::make($request->all(), [
            'registration_type' => 'required',
            'programme_id' => 'required',
            'project_id' => 'required',
            'registration_year' => 'required',
            'attendance_date' => 'required',
            'course_type' => 'required',
            'registration_semester' => 'required_if:course_type,2',
        ]);
        if ($validator->fails()) {
            return redirect('/reports/attendance')
                ->withErrors($validator)
                ->withInput();
        }
		$strReportTypes = ['' => '', 1 => 'Learners', 2 => 'Educators', 3 => 'Members of the General Public'];
		$courseTypes = [1 => 'Year Course', 2 => 'Semester Course'];
		$dateFrom = $dateTo = 0;
		$sSelectFirstname = $sSelectsurname = '';
		$regType = $request->registration_type;
		$attendanceDate = $request->attendance_date;
		$programmeID = $request->programme_id;
		$projectID = $request->project_id;
		$regYear = $request->registration_year;
		$courseType = $request->course_type;
		$regSemester = $request->registration_semester;
		if (!empty($attendanceDate))
		{
			$startExplode = explode('-', $attendanceDate);
			$dateFrom = strtotime($startExplode[0]);
			$dateTo = strtotime($startExplode[1]);
		}
		
		if ($regType == 1) 
		{
			$learnerID = 'learner_id';
			$Table = 'learners';
			$sSelectFirstname = $Table.'.first_name';
			$sSelectsurname = $Table.'.surname';
		}
		elseif ($regType == 2) 
		{
			$learnerID = 'educator_id';
			$Table = 'educators';
			$sSelectFirstname = $Table.'.first_name';
			$sSelectsurname = $Table.'.surname';
		}		
		elseif ($regType == 3) 
		{
			$learnerID = 'gen_public_id'; 
			$Table = 'public_regs';
			$sSelectFirstname = $Table.'.names';
			$sSelectsurname = '';
		}
		$attendances = DB::table('attendance_register')
		->select('attendance_register.*',''.$sSelectFirstname.'', ''.$sSelectsurname.'', 'programmes.name as prog_name', 'projects.name as proj_name')
		->leftJoin(''.$Table.'', 'attendance_register.'.$learnerID.'', '=',''.$Table.''.'.id')
		->leftJoin('programmes', 'attendance_register.programme_id', '=','programmes.id' )
		->leftJoin('projects', 'attendance_register.project_id', '=', 'projects.id')
		->where('attendance_register.programme_id', $programmeID)
		->where('attendance_register.project_id', $projectID)
		->where('attendance_register.registration_year', $regYear)
		->where('attendance_register.course_type', $courseType)
		->where('attendance_register.registration_type', $regType)
		->whereNotNull('registration_id')
		->where(function ($query) use ($courseType, $regSemester) {
			if ($courseType == 2 && $regSemester > 0) {
				$query->where('attendance_register.registration_semester', $regSemester);
			}
		})
		->where(function ($query) use ($dateFrom, $dateTo) {
		if ($dateFrom > 0 && $dateTo  > 0) {
			$query->whereBetween('attendance_register.date_attended', [$dateFrom, $dateTo]);
		}
		})
		->orderBy('attendance_register.'.$learnerID.'')
		->orderBy('attendance_register.date_attended')
		->get();
		
        $data['registration_type'] = $request->registration_type;
        $data['programme_id'] = $request->programme_id;
        $data['attendance_date'] = $request->attendance_date;
        $data['project_id'] = $request->project_id;
        $data['registration_year'] = $request->registration_year;
        $data['course_type'] = $request->course_type;
        $data['registration_semester'] = $request->registration_semester;
        $data['attendances'] = $attendances;

        $data['str_report_type'] = $strReportTypes[$regType];
        $data['programme'] = !empty($request->programme_id) ? programme::find($request->programme_id)->name : '[all]';
        $data['project'] = !empty($request->project_id) ? projects::find($request->project_id)->name : '[all]';
        $data['str_registration_year'] = !empty($regYear) ? $regYear : '[all]';
        $data['str_course_type'] = !empty($courseType) ? $courseTypes[$courseType] : '[all]';
        $data['str_registration_semester'] = !empty($regSemester) ? $regSemester : '[all]';
		$data['page_title'] = "Attendance Register";
        $data['page_description'] = "Attendance Register Report";
        $data['breadcrumb'] = [
            ['title' => 'Attendance Register', 'path' => '/reports/attendance', 'icon' => 'fa fa-adn', 'active' => 0, 'is_module' => 1],
            ['title' => 'Attendance Register', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Reports';
        $data['active_rib'] = 'Attendance Register';
		
		AuditReportsController::store('Reports', 'View Attendance Register Results', "view Reports Results", 0);
        return view('reports.attendance_result')->with($data);
    }
	// Print audit report acccording to sent criteria
	public function printreport(Request $request)
    {
		//Validation
        $validator = Validator::make($request->all(), [
            'registration_type' => 'required',
            'programme_id' => 'required',
            'project_id' => 'required',
            'registration_year' => 'required',
            'attendance_date' => 'required',
            'course_type' => 'required',
            'registration_semester' => 'required_if:course_type,2',
        ]);
        if ($validator->fails()) {
            return redirect('/reports/attendance')
                ->withErrors($validator)
                ->withInput();
        }
		$strReportTypes = ['' => '', 1 => 'Learners', 2 => 'Educators', 3 => 'Members of the General Public'];
		$courseTypes = [1 => 'Year Course', 2 => 'Semester Course'];
		$dateFrom = $dateTo = 0;
		$sSelectFirstname = $sSelectsurname = '';
		$regType = $request->registration_type;
		$attendanceDate = $request->attendance_date;
		$programmeID = $request->programme_id;
		$projectID = $request->project_id;
		$regYear = $request->registration_year;
		$courseType = $request->course_type;
		$regSemester = $request->registration_semester;
		if (!empty($attendanceDate))
		{
			$startExplode = explode('-', $attendanceDate);
			$dateFrom = strtotime($startExplode[0]);
			$dateTo = strtotime($startExplode[1]);
		}
		
		if ($regType == 1) 
		{
			$learnerID = 'learner_id';
			$Table = 'learners';
			$sSelectFirstname = $Table.'.first_name';
			$sSelectsurname = $Table.'.surname';
		}
		elseif ($regType == 2) 
		{
			$learnerID = 'educator_id';
			$Table = 'educators';
			$sSelectFirstname = $Table.'.first_name';
			$sSelectsurname = $Table.'.surname';
		}		
		elseif ($regType == 3) 
		{
			$learnerID = 'gen_public_id'; 
			$Table = 'public_regs';
			$sSelectFirstname = $Table.'.names';
			$sSelectsurname = '';
		}
		$attendances = DB::table('attendance_register')
		->select('attendance_register.*',''.$sSelectFirstname.'', ''.$sSelectsurname.'', 'programmes.name as prog_name', 'projects.name as proj_name')
		->leftJoin(''.$Table.'', 'attendance_register.'.$learnerID.'', '=',''.$Table.''.'.id')
		->leftJoin('programmes', 'attendance_register.programme_id', '=','programmes.id' )
		->leftJoin('projects', 'attendance_register.project_id', '=', 'projects.id')
		->where('attendance_register.programme_id', $programmeID)
		->where('attendance_register.project_id', $projectID)
		->where('attendance_register.registration_year', $regYear)
		->where('attendance_register.course_type', $courseType)
		->where('attendance_register.registration_type', $regType)
		->whereNotNull('registration_id')
		->where(function ($query) use ($courseType, $regSemester) {
			if ($courseType == 2 && $regSemester > 0) {
				$query->where('attendance_register.registration_semester', $regSemester);
			}
		})
		->where(function ($query) use ($dateFrom, $dateTo) {
		if ($dateFrom > 0 && $dateTo  > 0) {
			$query->whereBetween('attendance_register.date_attended', [$dateFrom, $dateTo]);
		}
		})
		->orderBy('attendance_register.'.$learnerID.'')
		->orderBy('attendance_register.date_attended')
		->get();
		
        $data['registration_type'] = $request->registration_type;
        $data['programme_id'] = $request->programme_id;
        $data['attendance_date'] = $request->attendance_date;
        $data['project_id'] = $request->project_id;
        $data['registration_year'] = $request->registration_year;
        $data['course_type'] = $request->course_type;
        $data['registration_semester'] = $request->registration_semester;
        $data['attendances'] = $attendances;

        $data['str_report_type'] = $strReportTypes[$regType];
        $data['programme'] = !empty($request->programme_id) ? programme::find($request->programme_id)->name : '[all]';
        $data['project'] = !empty($request->project_id) ? projects::find($request->project_id)->name : '[all]';
        $data['str_registration_year'] = !empty($regYear) ? $regYear : '[all]';
        $data['str_course_type'] = !empty($courseType) ? $courseTypes[$courseType] : '[all]';
        $data['str_registration_semester'] = !empty($regSemester) ? $regSemester : '[all]';
		$data['page_title'] = "Attendance Register";
        $data['page_description'] = "Attendance Register Report";
        $data['breadcrumb'] = [
            ['title' => 'Attendance Register', 'path' => '/reports/attendance', 'icon' => 'fa fa-adn', 'active' => 0, 'is_module' => 1],
            ['title' => 'Attendance Register', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Reports';
        $data['active_rib'] = 'Attendance Register';
		
		$user = Auth::user()->load('person');
		$data['company_name'] = 'OSIZWENI EDUCATIONAL AND DEVELOPMENT \TRUST';
        $data['company_logo'] = url('/') . Storage::disk('local')->url('logos/logo.png');
		$data['support_email'] = 'support@afrixcel.co.za';
		$data['date'] = date("d/m/Y");
		$data['user'] = $user;
		//return $data;
		AuditReportsController::store('Reports', 'Print Attendance Register Search Results', "Print Reports Results", 0);
        return view('reports.attendance_print')->with($data);
    }
}
