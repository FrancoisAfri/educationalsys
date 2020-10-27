<?php

namespace App\Http\Controllers;

use App\activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\contacts_company;
use App\HRPerson;
use App\projects;
use App\programme;
use App\Http\Controllers\AuditReportsController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class FinanceReportsController extends Controller
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
        $data['page_title'] = "Finance Report";
        $data['page_description'] = "Generate a report for project, programme or activity finance";
        $data['breadcrumb'] = [
            ['title' => 'Reports', 'path' => '/reports', 'icon' => 'fa fa-graduation-cap', 'active' => 0, 'is_module' => 1],
            ['title' => 'Finance', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Reports';
        $data['active_rib'] = 'Finance';
		$programmes = programme::whereIn('status', [2, 3])->orderBy('name', 'asc')->get();
		$data['programmes'] = $programmes;
		AuditReportsController::store('Reports', 'Finance Report Viewed ', "Actioned By User", 0);
        return view('reports.finance_search')->with($data);
    }
	public function programmesReport(Request $request, $print = -1) {
		$user = Auth::user()->load('person');
		$startFrom = $startTo = 0;
		$progID = $request->input('programme_id');
		$dateRage = $request->input('start_date_range');
		$reportType = $request->input('search_type');
		if (!empty($dateRage)) {
			$startExplode = explode('-', $dateRage);
			$startFrom = strtotime(trim($startExplode[0]));
			$startTo = strtotime(trim($startExplode[1]));
		}
		$programmes = programme::whereIn('status', [2, 3])
			->where(function ($query) use ($progID) {
				if (!empty($progID) && $progID > 0) {
					$query->where('id', (int) $progID);
				}
			})
			->where(function ($query) use ($startFrom, $startTo) {
				if ($startFrom > 0 && $startTo > 0) {
					$query->whereBetween('start_date', [$startFrom, $startFrom]);
				}
			})
			->get()
			->load('income', 'expenditure');

		//resubmitted fields
		$data['programme_id'] = $progID;
		$data['start_from'] = $startFrom;
		$data['start_to'] = $startTo;
		$data['search_type'] = $reportType;

		$data['user'] = $user;
		$data['company_name'] = 'OSIZWENI EDUCATIONAL AND DEVELOPMENT \TRUST';
		$data['company_logo'] = url('/') . Storage::disk('local')->url('logos/logo.png');
		$data['date'] = date("d/m/Y");

		$data['programme'] = !empty($progID) ? programme::find($progID)->name : '[all]';
		$data['start_date_range'] = ($startFrom > 0 && $startTo > 0) ? date('d/m/Y', $startFrom) . ' - ' . date('d/m/Y', $startTo) : '[all]';

		$data['programmes'] = $programmes;
		$data['str_report_type'] = 'Programme Finance';
		$data['page_title'] = "Programme Finance Report";
		$data['page_description'] = "View Programmes Finance Report";
		$data['breadcrumb'] = [
			['title' => 'Reports', 'path' => '/reports', 'icon' => 'fa fa-bug', 'active' => 0, 'is_module' => 1],
			['title' => 'Finance', 'path' => '/reports/finance', 'active' => 0, 'is_module' => 0],
			['title' => 'Programmes finance', 'active' => 1, 'is_module' => 0]
		];
		$data['active_mod'] = 'Reports';
		$data['active_rib'] = 'finance';
		if ($print == 1) return view('reports.finance_print')->with($data);
		else return view('reports.finance_result')->with($data);
	}
	public function projectsReport(Request $request, $print = -1) {
		$user = Auth::user()->load('person');
		$startFrom = $startTo = 0;
		$progID = $request->input('programme_id');
		$projID = $request->input('project_id');
		$dateRage = $request->input('start_date_range');
		$reportType = $request->input('search_type');
		if (!empty($dateRage)) {
			$startExplode = explode('-', $dateRage);
			$startFrom = strtotime(trim($startExplode[0]));
			$startTo = strtotime(trim($startExplode[1]));
		}
		$projects = projects::whereIn('status', [2, 3])
			->where(function ($query) use ($progID) {
				if (!empty($progID) && $progID > 0) {
					$query->where('programme_id', (int) $progID);
				}
			})
			->where(function ($query) use ($projID) {
				if (!empty($projID) && $projID > 0) {
					$query->where('id', (int) $projID);
				}
			})
			->where(function ($query) use ($startFrom, $startTo) {
				if ($startFrom > 0 && $startTo > 0) {
					$query->whereBetween('start_date', [$startFrom, $startFrom]);
				}
			})
			->get()
			->load('programme', 'income', 'expenditure');

		//resubmitted fields
		$data['programme_id'] = $progID;
		$data['project_id'] = $projID;
		$data['start_from'] = $startFrom;
		$data['start_to'] = $startTo;
		$data['search_type'] = $reportType;

		$data['user'] = $user;
		$data['company_name'] = 'OSIZWENI EDUCATIONAL AND DEVELOPMENT \TRUST';
		$data['company_logo'] = url('/') . Storage::disk('local')->url('logos/logo.png');
		$data['date'] = date("d/m/Y");

		$data['programme'] = !empty($progID) ? programme::find($progID)->name : '[all]';
		$data['project'] = !empty($projID) ? projects::find($projID)->name : '[all]';
		$data['start_date_range'] = ($startFrom > 0 && $startTo > 0) ? date('d/m/Y', $startFrom) . ' - ' . date('d/m/Y', $startTo) : '[all]';

		$data['projects'] = $projects;
		$data['str_report_type'] = 'Project Finance';
		$data['page_title'] = "Project Finance Report";
		$data['page_description'] = "View Projects Finance Report";
		$data['breadcrumb'] = [
			['title' => 'Reports', 'path' => '/reports', 'icon' => 'fa fa-bug', 'active' => 0, 'is_module' => 1],
			['title' => 'Finance', 'path' => '/reports/finance', 'active' => 0, 'is_module' => 0],
			['title' => 'Projects finance', 'active' => 1, 'is_module' => 0]
		];
		$data['active_mod'] = 'Reports';
		$data['active_rib'] = 'finance';
		if ($print == 1) return view('reports.finance_print')->with($data);
		else return view('reports.finance_result')->with($data);
	}
	public function activitiesReport(Request $request, $print = -1) {
		$user = Auth::user()->load('person');
		$startFrom = $startTo = 0;
		$progID = $request->input('programme_id');
		$projID = $request->input('project_id');
		$activityID = $request->input('activity_id');
		$dateRage = $request->input('start_date_range');
		$reportType = $request->input('search_type');
		if (!empty($dateRage)) {
			$startExplode = explode('-', $dateRage);
			$startFrom = strtotime(trim($startExplode[0]));
			$startTo = strtotime(trim($startExplode[1]));
		}
		$activities = activity::whereIn('status', [2, 3])
			->where(function ($query) use ($progID) {
				if (!empty($progID) && $progID > 0) {
					$query->where('programme_id', (int) $progID);
				}
			})
			->where(function ($query) use ($projID) {
				if (!empty($projID) && $projID > 0) {
					$query->where('project_id', (int) $projID);
				}
			})
			->where(function ($query) use ($activityID) {
				if (!empty($activityID) && $activityID > 0) {
					$query->where('id', (int) $activityID);
				}
			})
			->where(function ($query) use ($startFrom, $startTo) {
				if ($startFrom > 0 && $startTo > 0) {
					$query->whereBetween('start_date', [$startFrom, $startFrom]);
				}
			})
			->get()
			->load('project.programme', 'income', 'expenditure');

		//resubmitted fields
		$data['programme_id'] = $progID;
		$data['project_id'] = $projID;
		$data['activity_id'] = $activityID;
		$data['start_from'] = $startFrom;
		$data['start_to'] = $startTo;
		$data['search_type'] = $reportType;

		$data['user'] = $user;
		$data['company_name'] = 'OSIZWENI EDUCATIONAL AND DEVELOPMENT \TRUST';
		$data['company_logo'] = url('/') . Storage::disk('local')->url('logos/logo.png');
		$data['date'] = date("d/m/Y");

		$data['programme'] = !empty($progID) ? programme::find($progID)->name : '[all]';
		$data['project'] = !empty($projID) ? projects::find($projID)->name : '[all]';
		$data['activity'] = !empty($activityID) ? activity::find($activityID)->name : '[all]';
		$data['start_date_range'] = ($startFrom > 0 && $startTo > 0) ? date('d/m/Y', $startFrom) . ' - ' . date('d/m/Y', $startTo) : '[all]';

		$data['activities'] = $activities;
		$data['str_report_type'] = 'Activity Finance';
		$data['page_title'] = "Activity Finance Report";
		$data['page_description'] = "View Activities Finance Report";
		$data['breadcrumb'] = [
			['title' => 'Reports', 'path' => '/reports', 'icon' => 'fa fa-bug', 'active' => 0, 'is_module' => 1],
			['title' => 'Finance', 'path' => '/reports/finance', 'active' => 0, 'is_module' => 0],
			['title' => 'Activities finance', 'active' => 1, 'is_module' => 0]
		];
		$data['active_mod'] = 'Reports';
		$data['active_rib'] = 'finance';
		if ($print == 1) return view('reports.finance_print')->with($data);
		else return view('reports.finance_result')->with($data);
	}
}
