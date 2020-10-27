<?php

namespace App\Http\Controllers;

use App\projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\contacts_company;
use App\HRPerson;
use App\Http\Controllers\AuditReportsController;
use Illuminate\Support\Facades\Storage;

class ClientSearchController extends Controller
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
        $data['page_title'] = "Client Search";
        $data['page_description'] = "Client Search";
        $data['breadcrumb'] = [
            ['title' => 'Client', 'path' => '/contacts', 'icon' => 'fa fa-graduation-cap', 'active' => 0, 'is_module' => 1],
            ['title' => 'Search', 'path' => '/contacts/general_search', 'icon' => 'fa fa-tasks', 'active' => 0, 'is_module' => 0],
            ['title' => 'Client Search', 'active' => 1, 'is_module' => 0]
        ];
		
		$schools = contacts_company::where('company_type', 2)->where('status', 1)->orderBy('name')->get();
		$projects = projects::where('status', 2)->orderBy('name', 'asc')->get();
		
        $data['schools'] = $schools;
		$data['projects'] = $projects;
        $data['active_mod'] = 'clients';
        $data['active_rib'] = 'Search';
		AuditReportsController::store('Clients', 'Search for a client', "view infos", 0);
        return view('contacts.client_search')->with($data);
    }

    public function educatorSearchPrint(Request $request) {
        return $this->educatorSearch($request, true);
    }
	public function educatorSearch(Request $request, $print = false)
    {
		$name = $request->educator_name;
		$educatorID = $request->educator_ID;
		$cellPhone = $request->educator_number;
		$projectID = $request->project_id;
		$activityID = $request->activity_id;

		$educators = DB::table('educators')
		->where(function ($query) use ($educatorID) {
			if (!empty($educatorID)) {
				$query->where('id_number', 'ILIKE', "%$educatorID%");
			}
		})
		->where(function ($query) use ($name) {
			if (!empty($name)) {
				$query->where('first_name', 'ILIKE', "%$name%");
				$query->orWhere('surname', 'ILIKE', "%$name%");
			}
		})
		->where(function ($query) use ($cellPhone) {
			if (!empty($cellPhone)) {
				$query->where('cell_number', 'ILIKE', "%$cellPhone%");
			}
		})
		->where(function ($query) use ($projectID) {
			if (!empty($projectID)) {
				$query->where('project_id', $projectID);
			}
		})
		->where(function ($query) use ($activityID) {
			if (!empty($activityID)) {
				$query->where('activity_id', $activityID);
			}
		})
		->orderBy('educators.first_name')
		->get();
        $user = Auth::user()->load('person');
		$data['page_title'] = "Educators Search Results";
        $data['page_description'] = "Educators Search Results";
        $data['breadcrumb'] = [
            ['title' => 'Clients', 'path' => '/contacts/general_search', 'icon' => 'fa fa-graduation-cap', 'active' => 0, 'is_module' => 1],
            ['title' => 'Search', 'path' => '/contacts/general_search', 'icon' => 'fa fa-tasks', 'active' => 0, 'is_module' => 0],
            ['title' => 'Search', 'active' => 1, 'is_module' => 0]
        ];
        $data['educators'] = $educators;
		//return $data;
        $data['active_mod'] = 'Clients';
        $data['active_rib'] = 'Search';

        $data['educator_name'] = $request->educator_name;
        $data['educator_ID'] = $request->educator_ID;
        $data['educator_number'] = $request->educator_number;
        $data['project_id'] = $request->project_id;
        $data['activity_id'] = $request->activity_id;
        $data['company_logo'] = url('/') . Storage::disk('local')->url('logos/logo.png');
        $data['date'] = date("d-m-Y");
        $data['user'] = $user;

		AuditReportsController::store('Clients', 'View Educator Search Results', "view Search results", 0);
        if ($print) return view('contacts.educator_search_print')->with($data);
        else return view('contacts.educator_search')->with($data);
    }
    public function publicSearchPrint(Request $request) {
        return $this->publicSearch($request, true);
    }
	public function publicSearch(Request $request, $print = false)
    {
		$name = $request->public_name;
		$publicNumber = $request->public_number;
		$publicCellNumber = $request->public_cell_number;
		$projectID = $request->project_id;
		$activityID = $request->activity_id;
		
		$publicReg = DB::table('public_regs')
		->where(function ($query) use ($publicNumber) {
			if (!empty($publicNumber)) {
				$query->where('id_number', 'ILIKE', "%$publicNumber%");
			}
		})
		->where(function ($query) use ($name) {
			if (!empty($name)) {
				$query->where('names', 'ILIKE', "%$name%");
			}
		})
		->where(function ($query) use ($publicCellNumber) {
			if (!empty($publicCellNumber)) {
				$query->where('cell_number', 'ILIKE', "%$publicCellNumber%");
			}
		})
		->where(function ($query) use ($projectID) {
			if (!empty($projectID)) {
				$query->where('project_id', $projectID);
			}
		})
		->where(function ($query) use ($activityID) {
			if (!empty($activityID)) {
				$query->where('activity_id', $activityID);
			}
		})
		->orderBy('public_regs.names')
		->get();
        $user = Auth::user()->load('person');
		$data['publicsRegs'] = $publicReg;
        $data['page_title'] = "Public Registration Search Results";
        $data['page_description'] = "Public Registration Search Results";
        $data['breadcrumb'] = [
            ['title' => 'Clients', 'path' => '/contacts/general_search', 'icon' => 'fa fa-graduation-cap', 'active' => 0, 'is_module' => 1],
            ['title' => 'Search', 'path' => '/contacts/general_search', 'icon' => 'fa fa-tasks', 'active' => 0, 'is_module' => 0],
            ['title' => 'Search', 'active' => 1, 'is_module' => 0]
        ];
		$data['active_mod'] = 'Clients';
        $data['active_rib'] = 'Search';

        $data['educator_name'] = $request->educator_name;
        $data['educator_ID'] = $request->educator_ID;
        $data['educator_number'] = $request->educator_number;
        $data['project_id'] = $request->project_id;
        $data['activity_id'] = $request->activity_id;
        $data['company_logo'] = url('/') . Storage::disk('local')->url('logos/logo.png');
        $data['date'] = date("d-m-Y");
        $data['user'] = $user;

		AuditReportsController::store('Clients', 'View Public Search Results', "view Search results", 0);
        if ($print) return view('contacts.public_search_print')->with($data);
        else return view('contacts.public_search')->with($data);
    }

    public function groupSearchPrint(Request $request) {
        return $this->groupSearch($request, true);
    }
	public function groupSearch(Request $request, $print = false)
    {
		$startFrom = $startTo = 0;
		$schoolID = $request->school_id;
		$dateAttended = $request->date_attended;
		if (!empty($dateAttended))
		{
			$startExplode = explode('-', $dateAttended);
			$startFrom = strtotime($startExplode[0]);
			$startTo = strtotime($startExplode[1]);
		}
		if (!empty($endDate))
		{
			$endExplode = explode('-', $endDate);
			$endFrom = strtotime($endExplode[0]);
			$endTo = strtotime($endExplode[1]);
		}
		$groups = DB::table('nsw_stxes')
		->leftJoin('contacts_companies', 'nsw_stxes.school_id', '=', 'contacts_companies.id')
		->where(function ($query) use ($startFrom, $startTo) {
		if ($startFrom > 0 && $startTo  > 0) {
			$query->whereBetween('nsw_stxes.date_attended', [$startFrom, $startTo]);
		}
		})
		->where(function ($query) use ($schoolID) {
		if (!empty($schoolID)) {
			$query->where('nsw_stxes.school_id', $schoolID);
		}
		})
		->orderBy('nsw_stxes.id')
		->get();
        $user = Auth::user()->load('person');
		$data['groups'] = $groups;
        $data['page_title'] = "Group Learner Search Results";
        $data['page_description'] = "Group Learner Search";
        $data['breadcrumb'] = [
            ['title' => 'Clients', 'path' => '/contacts/general_search', 'icon' => 'fa fa-graduation-cap', 'active' => 0, 'is_module' => 1],
            ['title' => 'Search', 'path' => '/contacts/general_search', 'icon' => 'fa fa-tasks', 'active' => 0, 'is_module' => 0],
            ['title' => 'Search', 'active' => 1, 'is_module' => 0]
        ];
		$data['active_mod'] = 'Clients';
        $data['active_rib'] = 'Search';

        $data['school_id'] = $request->school_id;
        $data['date_attended'] = $request->date_attended;
        $data['company_logo'] = url('/') . Storage::disk('local')->url('logos/logo.png');
        $data['date'] = date("d-m-Y");
        $data['user'] = $user;

		AuditReportsController::store('Clients', 'View Group Search Results', "view Search results", 0);
        if ($print) return view('contacts.group_search_print')->with($data);
        else return view('contacts.group_search')->with($data);
    }

    public function learnerSearchPrint(Request $request) {
        return $this->LearnerSearch($request, true);
    }
	public function LearnerSearch(Request $request, $print = false)
    {
		$name = $request->learner_name;
		$learnerID = $request->learner_id;
		$learnerCellNumber = $request->learner_number;
		$projectID = $request->project_id;
		$activityID = $request->activity_id;
		
		$learners = DB::table('learners')
		->where(function ($query) use ($learnerID) {
			if (!empty($learnerID)) {
				$query->where('id_number', 'ILIKE', "%$learnerID%");
			}
		})
		->where(function ($query) use ($name) {
			if (!empty($name)) {
				$query->where('first_name', 'ILIKE', "%$name%");
				$query->orWhere('surname', 'ILIKE', "%$name%");
			}
		})
		->where(function ($query) use ($learnerCellNumber) {
			if (!empty($learnerCellNumber)) {
				$query->where('cell_number', 'ILIKE', "%$learnerCellNumber%");
			}
		})
		->where(function ($query) use ($projectID) {
			if (!empty($projectID)) {
				$query->where('project_id', $projectID);
			}
		})
		->where(function ($query) use ($activityID) {
			if (!empty($activityID)) {
				$query->where('activity_id', $activityID);
			}
		})
		->orderBy('learners.first_name')
		->get();
        $user = Auth::user()->load('person');
		$data['learners'] = $learners;
		$data['page_title'] = "Learner Search Results";
        $data['page_description'] = "Learner Search";
        $data['breadcrumb'] = [
            ['title' => 'Clients', 'path' => '/contacts/general_search', 'icon' => 'fa fa-graduation-cap', 'active' => 0, 'is_module' => 1],
            ['title' => 'Search', 'path' => '/contacts/general_search', 'icon' => 'fa fa-tasks', 'active' => 0, 'is_module' => 0],
            ['title' => 'Search', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Clients';
        $data['active_rib'] = 'Search';

        $data['learner_name'] = $request->learner_name;
        $data['learner_id'] = $request->learner_id;
        $data['learner_number'] = $request->learner_number;
        $data['project_id'] = $request->project_id;
        $data['activity_id'] = $request->activity_id;
        $data['company_logo'] = url('/') . Storage::disk('local')->url('logos/logo.png');
        $data['date'] = date("d-m-Y");
        $data['user'] = $user;

		AuditReportsController::store('Clients', 'View Learner Search Results', "view Search results", 0);
        if ($print) return view('contacts.learner_search_print')->with($data);
        else return view('contacts.learner_search')->with($data);
    }
}
