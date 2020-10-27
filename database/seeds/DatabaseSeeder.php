<?php

use Illuminate\Database\Seeder;
use App\User;
use App\HRPerson;
use App\Country;
use App\Province;
use App\modules;
use App\module_ribbons;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //insert default user
        $user = new User;
        $user->email = 'smalto@afrixcel.co.za';
        $user->password = Hash::make('sptusr1');
        $user->type = 3;
        $user->status = 1;
        $user->save();

        //insert default user's hr record
        $person = new HRPerson();
        $person->first_name = 'Smalto';
        $person->surname = 'Tsham';
        $person->email = 'smalto@afrixcel.co.za';
        $person->status = 1;
        $user->addPerson($person);

        //insert default user
        $user = new User;
        $user->email = 'francois@afrixcel.co.za';
        $user->password = Hash::make('sptusr@!');
        $user->type = 3;
        $user->status = 1;
        $user->save();
		
		//insert default user's hr record
        $person = new HRPerson();
        $person->first_name = 'Francois';
        $person->surname = 'keou';
        $person->email = 'francois@afrixcel.co.za';
        $person->status = 1;
        $user->addPerson($person);

        //insert default country
        $country = new Country;
        $country->name = 'South Africa';
        $country->a2_code = 'ZA';
        $country->a3_code = 'ZAF';
        $country->numeric_code = 710;
        $country->dialing_code = '27';
        $country->abbreviation = 'RSA';
        $country->save();
        
        //insert default country's provinces
        $province = new Province();
        $province->name = 'Eastern Cape';
        $country->addProvince($province);

        $province = new Province();
        $province->name = 'Free State';
        $country->addProvince($province);

        $province = new Province();
        $province->name = 'Gauteng';
        $province->abbreviation = 'GP';
        $country->addProvince($province);

        $province = new Province();
        $province->name = 'KwaZulu-Natal';
        $province->abbreviation = 'KZN';
        $country->addProvince($province);

        $province = new Province();
        $province->name = 'Limpopo';
        $country->addProvince($province);

        $province = new Province();
        $province->name = 'Mpumalanga';
        $country->addProvince($province);

        $province = new Province();
        $province->name = 'North West';
        $country->addProvince($province);

        $province = new Province();
        $province->name = 'Northern Cape';
        $country->addProvince($province);

        $province = new Province();
        $province->name = 'Western Cape';
        $country->addProvince($province);
        
        //insert marital statuses
        DB::table('marital_statuses')->insert([
            'value' => 'Single',
            'status' => 1,
        ]);
        DB::table('marital_statuses')->insert([
            'value' => 'Married',
            'status' => 1,
        ]);
        DB::table('marital_statuses')->insert([
            'value' => 'Divorced',
            'status' => 1,
        ]);
        DB::table('marital_statuses')->insert([
            'value' => 'Widower',
            'status' => 1,
        ]);

        //insert ethnicity
        DB::table('ethnicities')->insert([
            'value' => 'Black',
            'status' => 1,
        ]);
        DB::table('ethnicities')->insert([
            'value' => 'Asian',
            'status' => 1,
        ]);
        DB::table('ethnicities')->insert([
            'value' => 'White',
            'status' => 1,
        ]);
        DB::table('ethnicities')->insert([
            'value' => 'Coloured',
            'status' => 1,
        ]);
        DB::table('ethnicities')->insert([
            'value' => 'Indian',
            'status' => 1,
        ]);

        //insert some positions
        DB::table('hr_positions')->insert([
            'name' => 'General Manager',
            'status' => 1,
        ]);
        DB::table('hr_positions')->insert([
            'name' => 'Administrator',
            'status' => 1,
        ]);
        DB::table('hr_positions')->insert([
            'name' => 'Programme Manager',
            'status' => 1,
        ]);
        DB::table('hr_positions')->insert([
            'name' => 'Education and Learning Manager',
            'status' => 1,
        ]);
        DB::table('hr_positions')->insert([
            'name' => 'Project Manager',
            'status' => 1,
        ]);
        DB::table('hr_positions')->insert([
            'name' => 'Facilitator',
            'status' => 1,
        ]);

        //Insert navigation menus
        $module = new modules(); //Contacts
        $module->active = 1;
        $module->name = 'Clients';
        $module->path = 'contacts';
        $module->font_awesome = 'fa-users';
        $module->save();

        $ribbon = new module_ribbons();
        $ribbon->active = 0;
        $ribbon->sort_order = 1;
        $ribbon->ribbon_name = 'AGM';
        $ribbon->description = 'AGM';
        $ribbon->ribbon_path = 'contacts/agm';
        $ribbon->access_level = 3;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 2;
        $ribbon->ribbon_name = 'Educator Registration';
        $ribbon->description = 'Add Educator';
        $ribbon->ribbon_path = 'contacts/educator';
        $ribbon->access_level = 3;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 3;
        $ribbon->ribbon_name = 'Public Registration';
        $ribbon->description = 'Add Public';
        $ribbon->ribbon_path = 'contacts/public';
        $ribbon->access_level = 3;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 4;
        $ribbon->ribbon_name = 'Learner Registration';
        $ribbon->description = 'Add Learner';
        $ribbon->ribbon_path = 'contacts/learner';
        $ribbon->access_level = 3;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 0;
        $ribbon->sort_order = 5;
        $ribbon->ribbon_name = 'Add New NSW & STX';
        $ribbon->description = 'Add School';
        $ribbon->ribbon_path = 'contacts/school/create';
        $ribbon->access_level = 3;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 0;
        $ribbon->sort_order = 6;
        $ribbon->ribbon_name = 'Add New Provider';
        $ribbon->description = 'Add Service Provider';
        $ribbon->ribbon_path = 'contacts/provider/create';
        $ribbon->access_level = 3;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 7;
        $ribbon->ribbon_name = 'Group Learner Registration';
        $ribbon->description = 'Group Learner Registration';
        $ribbon->ribbon_path = 'education/nsw';
        $ribbon->access_level = 3;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 8;
        $ribbon->ribbon_name = 'Search';
        $ribbon->description = 'Search';
        $ribbon->ribbon_path = 'contacts/general_search';
        $ribbon->access_level = 3;
        $module->addRibbon($ribbon);

        $module = new modules();
        $module->active = 1;
        $module->name = 'Programmes';
        $module->path = 'education';
        $module->font_awesome = 'fa-graduation-cap';
        $module->save();

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 1;
        $ribbon->ribbon_name = 'Add New Programme';
        $ribbon->description = 'Add Programme';
        $ribbon->ribbon_path = 'education/programme/create';
        $ribbon->access_level = 3;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 2;
        $ribbon->ribbon_name = 'Add New Project';
        $ribbon->description = 'Add Project';
        $ribbon->ribbon_path = 'education/project/create';
        $ribbon->access_level = 3;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 3;
        $ribbon->ribbon_name = 'Add New Activity';
        $ribbon->description = 'Add Activity';
        $ribbon->ribbon_path = 'education/activity/create';
        $ribbon->access_level = 3;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 4;
        $ribbon->ribbon_name = 'Search';
        $ribbon->description = 'Search';
        $ribbon->ribbon_path = 'education/search';
        $ribbon->access_level = 3;
        $module->addRibbon($ribbon);

        $module = new modules();
        $module->active = 1;
        $module->name = 'Security';
        $module->path = 'users';
        $module->font_awesome = 'fa-lock';
        $module->save();

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 1;
        $ribbon->ribbon_name = 'Create User';
        $ribbon->description = 'Add User';
        $ribbon->ribbon_path = 'users/create';
        $ribbon->access_level = 3;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 2;
        $ribbon->ribbon_name = 'Search Users';
        $ribbon->description = 'Search Users';
        $ribbon->ribbon_path = 'users';
        $ribbon->access_level = 4;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 3;
        $ribbon->ribbon_name = 'Setup';
        $ribbon->description = 'Setup';
        $ribbon->ribbon_path = 'users/setup';
        $ribbon->access_level = 5;
        $module->addRibbon($ribbon);

        $module = new modules();
        $module->active = 1;
        $module->name = 'Partners';
        $module->path = 'contacts';
        $module->font_awesome = 'fa-group';
        $module->save();

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 1;
        $ribbon->ribbon_name = 'Add New School';
        $ribbon->description = 'Add School';
        $ribbon->ribbon_path = 'contacts/school/create';
        $ribbon->access_level = 1;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 2;
        $ribbon->ribbon_name = 'Add New Service Provider';
        $ribbon->description = 'Add Service Provider';
        $ribbon->ribbon_path = 'contacts/provider/create';
        $ribbon->access_level = 1;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 3;
        $ribbon->ribbon_name = 'Add New Sponsor';
        $ribbon->description = 'Add Sponsor';
        $ribbon->ribbon_path = 'contacts/sponsor/create';
        $ribbon->access_level = 1;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 4;
        $ribbon->ribbon_name = 'Add Facilitator';
        $ribbon->description = 'Add Facilitator';
        $ribbon->ribbon_path = 'users/create';
        $ribbon->access_level = 0;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 5;
        $ribbon->ribbon_name = 'Add Contact';
        $ribbon->description = 'Add Contact';
        $ribbon->ribbon_path = 'contacts/create';
        $ribbon->access_level = 3;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 6;
        $ribbon->ribbon_name = 'Search';
        $ribbon->description = 'Search';
        $ribbon->ribbon_path = 'partners/search';
        $ribbon->access_level = 4;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 7;
        $ribbon->ribbon_name = 'Search Contact';
        $ribbon->description = 'Search Contact';
        $ribbon->ribbon_path = 'contacts';
        $ribbon->access_level = 4;
        $module->addRibbon($ribbon);

        $module = new modules();
        $module->active = 1;
        $module->name = 'Attendance Register';
        $module->path = 'education/attendance';
        $module->font_awesome = 'fa-adn';
        $module->save();

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 1;
        $ribbon->ribbon_name = 'Mark Attendance';
        $ribbon->description = 'Mark Attendance';
        $ribbon->ribbon_path = 'education/attendance';
        $ribbon->access_level = 3;
        $module->addRibbon($ribbon);

        $module = new modules();
        $module->active = 1;
        $module->name = 'Subject Registration';
        $module->path = 'registration';
        $module->font_awesome = 'fa-list-alt';
        $module->save();

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 1;
        $ribbon->ribbon_name = 'Register';
        $ribbon->description = 'Enroll learner, educators and general public to their respective subjects, modules and areas';
        $ribbon->ribbon_path = 'education/registration';
        $ribbon->access_level = 3;
        $module->addRibbon($ribbon);

        $module = new modules();
        $module->active = 1;
        $module->name = 'Reports';
        $module->path = 'reports';
        $module->font_awesome = 'fa-bug';
        $module->save();

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 1;
        $ribbon->ribbon_name = 'Programmes';
        $ribbon->description = 'Search Programmes';
        $ribbon->ribbon_path = 'reports/programme';
        $ribbon->access_level = 4;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 2;
        $ribbon->ribbon_name = 'Learners';
        $ribbon->description = 'Learners Reports';
        $ribbon->ribbon_path = 'reports/learner';
        $ribbon->access_level = 4;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 3;
        $ribbon->ribbon_name = 'Educators';
        $ribbon->description = 'Educator Report';
        $ribbon->ribbon_path = 'reports/educator';
        $ribbon->access_level = 4;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 4;
        $ribbon->ribbon_name = 'Finance';
        $ribbon->description = 'Finance Report';
        $ribbon->ribbon_path = 'reports/finance';
        $ribbon->access_level = 4;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 5;
        $ribbon->ribbon_name = 'Attendance Register';
        $ribbon->description = 'Attendance Register';
        $ribbon->ribbon_path = 'reports/attendance';
        $ribbon->access_level = 4;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 6;
        $ribbon->ribbon_name = 'Statistics';
        $ribbon->description = 'Programmes, Projects, Activities statistics';
        $ribbon->ribbon_path = 'reports/stats';
        $ribbon->access_level = 5;
        $module->addRibbon($ribbon);

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 7;
        $ribbon->ribbon_name = 'Audit';
        $ribbon->description = 'Audit Report';
        $ribbon->ribbon_path = 'reports/audit';
        $ribbon->access_level = 5;
        $module->addRibbon($ribbon);

        $module = new modules();
        $module->active = 1;
        $module->name = 'Results';
        $module->path = 'results';
        $module->font_awesome = 'fa-percent';
        $module->save();

        $ribbon = new module_ribbons();
        $ribbon->active = 1;
        $ribbon->sort_order = 1;
        $ribbon->ribbon_name = 'Capture Results';
        $ribbon->description = "Capture a learner, educator or member of the general public's results at the end of a semester/year for a project/programme";
        $ribbon->ribbon_path = 'education/loadclients';
        $ribbon->access_level = 3;
        $module->addRibbon($ribbon);
    }
}
