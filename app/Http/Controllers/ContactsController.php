<?php

namespace App\Http\Controllers;

use App\ContactPerson;
use App\Country;
use App\public_reg;
use App\Mail\ConfirmRegistration;
use Illuminate\Http\Request;
use App\Mail\adminEmail;
use App\Http\Requests;
use App\HRPerson;
use App\User;
use App\Province;
use App\Http\Controllers\AuditReportsController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ContactsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index() {
        $data['page_title'] = "Clients";
        $data['page_description'] = "Search Clients";
        $data['breadcrumb'] = [
            ['title' => 'Clients', 'path' => '/contacts', 'icon' => 'fa fa-users', 'active' => 0, 'is_module' => 1],
            ['title' => 'Search client', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Clients';
        $data['active_rib'] = 'search';
		AuditReportsController::store('Clients', 'Clients Search Page Accessed', "Actioned By User", 0);
        return view('contacts.search_contact')->with($data);
    }
    public function create() {
        $contactTypes = [1 => 'Company Rep', 2 => 'Student', 3 => 'Learner', 4 => 'Official', 5 => 'Educator', 6 => 'Osizweni Employee', 7 => 'Osizweni Board Member', 8 => 'Other'];
        $orgTypes = [1 => 'Private Company', 2 => 'Parastatal', 3 => 'School', 4 => 'Government', 5 => 'Other'];
        $data['page_title'] = "Contacts";
        $data['page_description'] = "Add a New Contact";
        $data['breadcrumb'] = [
            ['title' => 'Contacts', 'path' => '/contacts', 'icon' => 'fa fa-users', 'active' => 0, 'is_module' => 1],
            ['title' => 'Add contact', 'active' => 1, 'is_module' => 0]
        ];
        $data['contact_types'] = $contactTypes;
        $data['org_types'] = $orgTypes;
        $data['active_mod'] = 'partners';
        $data['active_rib'] = 'add contact';
		AuditReportsController::store('partners', 'partners Contact Page Accessed', "Actioned By User", 0);
        return view('contacts.add_contact')->with($data);
    }
	public function addContact() {

        $data['page_title'] = "Contact";
        $data['page_description'] = "Add a New Contact";
        $data['breadcrumb'] = [
            ['title' => 'Contacts', 'path' => '/contacts', 'icon' => 'fa fa-users', 'active' => 0, 'is_module' => 1],
            ['title' => 'Add Contact', 'active' => 1, 'is_module' => 0]
        ];
        $data['active_mod'] = 'Clients';
        $data['active_rib'] = 'Contact';
		$data['contact_type'] = 1; //Contacts
		AuditReportsController::store('partners', 'partners Contact Page Accessed', "Actioned By User", 0);
        return view('contacts.general_meeting')->with($data);
    }
	
	public function educatorRegistration() {
        $data['page_title'] = "Educator Registration";
        $data['page_description'] = "Add a New Educator Registration";
        $data['breadcrumb'] = [
            ['title' => 'Contacts', 'path' => '/contacts', 'icon' => 'fa fa-users', 'active' => 0, 'is_module' => 1],
            ['title' => 'Educator Registration', 'active' => 1, 'is_module' => 0]
        ];

		$ethnicities = DB::table('ethnicities')->where('status', 1)->orderBy('value', 'asc')->get();
		$data['ethnicities'] = $ethnicities;
        $data['active_mod'] = 'Clients';
        $data['active_rib'] = 'Educator Registration';
        return view('contacts.educator_registration')->with($data);
    }
	public function learnerRegistration() {
        $data['page_title'] = "Learner registration";
        $data['page_description'] = "Add a New Learner registration";
        $data['breadcrumb'] = [
            ['title' => 'Contacts', 'path' => '/contacts', 'icon' => 'fa fa-users', 'active' => 0, 'is_module' => 1],
            ['title' => 'Learner registration', 'active' => 1, 'is_module' => 0]
        ];

		$ethnicities = DB::table('ethnicities')->where('status', 1)->orderBy('value', 'asc')->get();
		$data['ethnicities'] = $ethnicities;
        $data['active_mod'] = 'Clients';
        $data['active_rib'] = 'Learner registration';
        return view('contacts.learner_registration')->with($data);
    }
    public function store(Request $request) {
        $this->validate($request, [
            'first_name' => 'bail|required',
            'surname' => 'bail|required',
            'contact_type' => 'bail|required',
            'organization_type' => 'bail|required',
            'office_number' => 'bail|required',
            'str_position' => 'bail|required',
            'org_name' => 'bail|required',
            
        ]);
        $contactData = $request->all();

        //Cell number formatting
        $contactData['cell_number'] = str_replace(' ', '', $contactData['cell_number']);
        $contactData['cell_number'] = str_replace('-', '', $contactData['cell_number']);
        $contactData['cell_number'] = str_replace('(', '', $contactData['cell_number']);
        $contactData['cell_number'] = str_replace(')', '', $contactData['cell_number']);

        //Office number formatting
        $contactData['office_number'] = str_replace(' ', '', $contactData['office_number']);
        $contactData['office_number'] = str_replace('-', '', $contactData['office_number']);
        $contactData['office_number'] = str_replace('(', '', $contactData['office_number']);
        $contactData['office_number'] = str_replace(')', '', $contactData['office_number']);

        //Exclude empty fields from query
        foreach ($contactData as $key => $value)
        {
            if (empty($contactData[$key])) {
                unset($contactData[$key]);
            }
        }

        //Save ContactPerson record
        $contact = new ContactPerson($contactData);
        $contact->status = 1;
        $contact->save();

        //Redirect to all usr view
		AuditReportsController::store('partners', 'New Contact Added', "Contact Successfully added", 0);
        return redirect("/contacts/$contact->id/edit")->with('success_add', "The contact has been added successfully.");
    }
	
    public function edit(ContactPerson $contact) {
        $contactTypes = [1 => 'Company Rep', 2 => 'Student', 3 => 'Learner', 4 => 'Official', 5 => 'Educator', 6 => 'Osizweni Employee', 7 => 'Osizweni Board Member', 8 => 'Other'];
        $orgTypes = [1 => 'Private Company', 2 => 'Parastatal', 3 => 'School', 4 => 'Government', 5 => 'Other'];
        $data['page_title'] = "Contacts";
        $data['page_description'] = "View/Update contact details";
        $data['back'] = "/contacts";
        $data['breadcrumb'] = [
            ['title' => 'Contacts', 'path' => '/contacts', 'icon' => 'fa fa-users', 'active' => 0, 'is_module' => 1],
            ['title' => 'Contact details', 'active' => 1, 'is_module' => 0]
        ];
        $data['contact'] = $contact;
        $data['contact_types'] = $contactTypes;
        $data['org_types'] = $orgTypes;
        $data['active_mod'] = 'partners';
        $data['active_rib'] = 'search';
		AuditReportsController::store('partners', 'Contact Edited', "Contact On Edit Mode", 0);
        return view('contacts.view_contact')->with($data);
    }
    
    public function profile() {
        $user = Auth::user()->load('person');
        $avatar = $user->person->profile_pic;
        $provinces = Province::where('country_id', 1)->orderBy('name', 'asc')->get();
        $ethnicities = DB::table('ethnicities')->where('status', 1)->orderBy('value', 'asc')->get();
        $marital_statuses = DB::table('marital_statuses')->where('status', 1)->orderBy('value', 'asc')->get();
        $data['page_title'] = "Clients";
        $data['page_description'] = "View/Update your details";
        $data['back'] = "/";
        $data['user_profile'] = 1;
        $data['user'] = $user;
        $data['avatar'] = (!empty($avatar)) ? Storage::disk('local')->url("avatars/$avatar") : '';
        $data['provinces'] = $provinces;
        $data['ethnicities'] = $ethnicities;
        $data['marital_statuses'] = $marital_statuses;
        $data['breadcrumb'] = [
            ['title' => 'Clients', 'path' => '/contacts', 'icon' => 'fa fa-users', 'active' => 0, 'is_module' => 1],
            ['title' => 'My profile', 'active' => 1, 'is_module' => 0]
        ];
		AuditReportsController::store('partners', 'Contact Profile Accessed', "Accessed By User", 0);
        return view('contacts.view_contact')->with($data);
    }
	public function emailAdmin(Request $request) {
		$emails = $request->all();
		$message  = $emails['message'];
        $user = Auth::user()->load('person');
		//return $user;
		$senderName = $user->person->first_name." ".$user->person->surname;
		$senderEmail = $user->person->email;
		$adminUser = DB::table('hr_people')->where('position', 2)->orderBy('id', 'asc')->get();
		foreach($adminUser as $admin)
		{
			Mail::to($admin->email)->send(new AdminEmail($admin->first_name, $senderName, $message, $senderEmail));
		}
		AuditReportsController::store('partners', 'New Email Sent', "Email Sent To Admin", 0);
        //return view('contacts.view_contact')->with($data);
		return redirect('/');
    }
    public function update(Request $request, ContactPerson $contact) {
        $this->validate($request, [
            'first_name' => 'required',
            'surname' => 'required',
        ]);

        //Cell number formatting
        $request['cell_number'] = str_replace(' ', '', $request['cell_number']);
        $request['cell_number'] = str_replace('-', '', $request['cell_number']);
        $request['cell_number'] = str_replace('(', '', $request['cell_number']);
        $request['cell_number'] = str_replace(')', '', $request['cell_number']);

        if ($request['email'] != $contact->email) {
            $this->validate($request, [
                'email' => 'unique:contacts_contacts,email',
            ]);
        }

        if ($request['cell_number'] != $contact->cell_number) {
            $this->validate($request, [
                'cell_number' => 'unique:contacts_contacts,cell_number',
            ]);
        }
        $contactData = $request->all();

        //Office number formatting
        $contactData['office_number'] = str_replace(' ', '', $contactData['office_number']);
        $contactData['office_number'] = str_replace('-', '', $contactData['office_number']);
        $contactData['office_number'] = str_replace('(', '', $contactData['office_number']);
        $contactData['office_number'] = str_replace(')', '', $contactData['office_number']);

        //Exclude empty fields from query
        foreach ($contactData as $key => $value)
        {
            if (empty($contactData[$key])) {
                unset($contactData[$key]);
            }
        }

        //Save ContactPerson record
        $contact->update($contactData);
		AuditReportsController::store('partners', 'Record Updated', "Updated By User", 0);
        //Redirect to all usr view
        return redirect("/contacts/$contact->id/edit")->with('success_edit', "The contact details have been updated successfully.");
    }

    public function getSearch(Request $request) {
        $personName = trim($request->person_name);
        $personIDNum = trim($request->id_number);

		$persons = DB::table('contacts_contacts')
		->where(function ($query) use ($personName) {
			if (!empty($personName)) {
				$query->where('first_name', 'ILIKE', "%$personName%");
			}
		})
		->where(function ($query) use ($personIDNum) {
			if (!empty($personIDNum)) {
				$query->where('id_number', 'ILIKE', "%$personIDNum%");
			}
		})
		->orderBy('first_name')
		->limit(100)
		->get();
			
        $data['page_title'] = "Clients";
        $data['page_description'] = "List of clients found";
        $data['persons'] = $persons;
        $data['m_silhouette'] = Storage::disk('local')->url('avatars/m-silhouette.jpg');
        $data['f_silhouette'] = Storage::disk('local')->url('avatars/f-silhouette.jpg');
        $data['status_values'] = [0 => 'Inactive', 1 => 'Active'];
        $data['breadcrumb'] = [
            ['title' => 'Clients', 'path' => '/contacts', 'icon' => 'fa fa-users', 'active' => 0, 'is_module' => 1],
            ['title' => 'Client search result', 'active' => 1, 'is_module' => 0]
        ];
		AuditReportsController::store('partners', 'Contact Search Results Accessed', "Search Results Accessed", 0);
        return view('contacts.contacts')->with($data);
    }

    public function updatePassword(Request $request, User $user) {
        //return response()->json(['message' => $request['current_password']]);

        $validator = Validator::make($request->all(),[
            'current_password' => 'required',
            'new_password' => 'bail|required|min:6',
            'confirm_password' => 'bail|required|same:new_password'
        ]);

        $validator->after(function($validator) use ($request, $user){
            $userPW = $user->password;

            if (!(Hash::check($request['current_password'], $userPW))) {
                $validator->errors()->add('current_password', 'The current password is incorrect, please enter the correct current password.');
            }
        });

        $validator->validate();

        //Update user password
        $newPassword = $request['new_password'];
        $user->password = Hash::make($newPassword);
        $user->update();
		AuditReportsController::store('partners', 'Contact Password Updated', "Password Updated", 0);
        return response()->json(['success' => 'Password updated successfully.'], 200);
    }
}
