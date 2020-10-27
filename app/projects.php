<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class projects extends Model
{
    //Specify the table name
    public $table = 'projects';

    // Mass assignable fields
    protected $fillable = [
        'name', 'code', 'sponsor_id', 'start_date', 'end_date', 'description', 'programme_id', 'facilitator_id'
        , 'sponsor', 'manager_id', 'service_provider_id', 'budget', 'sponsorship_amount'
        , 'contract_amount', 'supporting_doc', 'contract_doc', 'user_id', 'approver_id', 'rejection_reason', 'status'
    ];

    //Relationship project and service provider
    public function serviceProvider()
    {
        return $this->belongsTo(contacts_company::class, 'service_provider_id');
    }

    //Relationship project and manager (HR Person)
    public function manager()
    {
        return $this->belongsTo(HRPerson::class, 'manager_id');
    }

    //Relationship project and facilitator (HR Person)
    public function facilitator()
    {
        return $this->belongsTo(HRPerson::class, 'facilitator_id');
    }

    //Relationship project and programme
    public function programme()
    {
        return $this->belongsTo(programme::class, 'programme_id');
    }

    //Relationship project and activity
    public function activity()
    {
        return $this->hasMany(activity::class, 'project_id');
    }

    //Relationship project and registration
    public function registration()
    {
        return $this->hasMany(Registration::class, 'project_id');
    }

    //Registered people count
    public function regPeople() {
        return $this->hasOne(Registration::class, 'project_id')
            ->selectRaw('project_id, count(*) as count')
            ->groupBy('project_id');
    }
    //Registered male public count
    public function regMalePublic() {
        return $this->hasOne(Registration::class, 'project_id')
            ->selectRaw('project_id, count(*) as count')
            ->whereIn('gen_public_id', function ($query) {
                $query->select('id')->from('public_regs')->where('gender', 1);
            })
            ->groupBy('project_id');
    }
    //Registered female public count
    public function regFemalePublic() {
        return $this->hasOne(Registration::class, 'project_id')
            ->selectRaw('project_id, count(*) as count')
            ->whereIn('gen_public_id', function ($query) {
                $query->select('id')->from('public_regs')->where('gender', 2);
            })
            ->groupBy('project_id');
    }
    //Registered black public count
    public function regBlackPublic() {
        return $this->hasOne(Registration::class, 'project_id')
            ->selectRaw('project_id, count(*) as count')
            ->whereIn('gen_public_id', function ($query) {
                $query->select('id')->from('public_regs')->whereIn('ethnicity', [1, 2, 5]);
            })
            ->groupBy('project_id');
    }
    //Registered white public count
    public function regWhitePublic() {
        return $this->hasOne(Registration::class, 'project_id')
            ->selectRaw('project_id, count(*) as count')
            ->whereIn('gen_public_id', function ($query) {
                $query->select('id')->from('public_regs')->where('ethnicity', 3);
            })
            ->groupBy('project_id');
    }
    //Registered coloured public count
    public function regColouredPublic() {
        return $this->hasOne(Registration::class, 'project_id')
            ->selectRaw('project_id, count(*) as count')
            ->whereIn('gen_public_id', function ($query) {
                $query->select('id')->from('public_regs')->where('ethnicity', 4);
            })
            ->groupBy('project_id');
    }
    //Registered male educator count
    public function regMaleEducators() {
        return $this->hasOne(Registration::class, 'project_id')
            ->selectRaw('project_id, count(*) as count')
            ->whereIn('educator_id', function ($query) {
                $query->select('id')->from('educators')->where('gender', 1);
            })
            ->groupBy('project_id');
    }
    //Registered female educator count
    public function regFemaleEducators() {
        return $this->hasOne(Registration::class, 'project_id')
            ->selectRaw('project_id, count(*) as count')
            ->whereIn('educator_id', function ($query) {
                $query->select('id')->from('educators')->where('gender', 2);
            })
            ->groupBy('project_id');
    }
    //Registered black educators count
    public function regBlackEducators() {
        return $this->hasOne(Registration::class, 'project_id')
            ->selectRaw('project_id, count(*) as count')
            ->whereIn('educator_id', function ($query) {
                $query->select('id')->from('educators')->whereIn('ethnicity', [1, 2, 5]);
            })
            ->groupBy('project_id');
    }
    //Registered white educators count
    public function regWhiteEducators() {
        return $this->hasOne(Registration::class, 'project_id')
            ->selectRaw('project_id, count(*) as count')
            ->whereIn('educator_id', function ($query) {
                $query->select('id')->from('educators')->where('ethnicity', 3);
            })
            ->groupBy('project_id');
    }
    //Registered coloured educators count
    public function regColouredEducators() {
        return $this->hasOne(Registration::class, 'project_id')
            ->selectRaw('project_id, count(*) as count')
            ->whereIn('educator_id', function ($query) {
                $query->select('id')->from('educators')->where('ethnicity', 4);
            })
            ->groupBy('project_id');
    }
    //Registered male learner count
    public function regMaleLearners() {
        return $this->hasOne(Registration::class, 'project_id')
            ->selectRaw('project_id, count(*) as count')
            ->whereIn('learner_id', function ($query) {
                $query->select('id')->from('learners')->where('gender', 1);
            })
            ->groupBy('project_id');
    }
    //Registered female learner count
    public function regFemaleLearners() {
        return $this->hasOne(Registration::class, 'project_id')
            ->selectRaw('project_id, count(*) as count')
            ->whereIn('learner_id', function ($query) {
                $query->select('id')->from('learners')->where('gender', 1);
            })
            ->groupBy('project_id');
    }
    //Registered black learners count
    public function regBlackLearners() {
        return $this->hasOne(Registration::class, 'project_id')
            ->selectRaw('project_id, count(*) as count')
            ->whereIn('learner_id', function ($query) {
                $query->select('id')->from('learners')->whereIn('ethnicity', [1, 2, 5]);
            })
            ->groupBy('project_id');
    }
    //Registered white learners count
    public function regWhiteLearners() {
        return $this->hasOne(Registration::class, 'project_id')
            ->selectRaw('project_id, count(*) as count')
            ->whereIn('learner_id', function ($query) {
                $query->select('id')->from('learners')->where('ethnicity', 3);
            })
            ->groupBy('project_id');
    }
    //Registered coloured learners count
    public function regColouredLearners() {
        return $this->hasOne(Registration::class, 'project_id')
            ->selectRaw('project_id, count(*) as count')
            ->whereIn('learner_id', function ($query) {
                $query->select('id')->from('learners')->where('ethnicity', 4);
            })
            ->groupBy('project_id');
    }

    //Relationship between projects and expenditure
    public function expenditure()
    {
        return $this->hasMany(projects_expenditures::class, 'project_id');
    }

    //Relationship between project and income
    public function income()
    {
        return $this->hasMany(projects_incomes::class, 'project_id');
    }

    //Function to return projects from a certain programme
    public static function projectsFromProgramme($programmeID, $incComplete = -1 )
    {
        return projects::where('programme_id', $programmeID)
            ->where(function($query) use($incComplete) {
                if ($incComplete == 1) $query->whereIn('status', [2, 3]);
                else $query->whereIn('status', [2]);
            })
            ->orderBy('name')
            ->pluck('id', 'name');
    }

    //function to add Expenditures
    public function addExpenditure(projects_expenditures $expenditure) {
        return $this->expenditure()->save($expenditure);
    }

    //function to add Expenditures
    public function addIncome(projects_incomes $income) {
        return $this->income()->save($income);
    }
}
