<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class activity extends Model
{
    //Specify the table name
    public $table = 'activities';

    // Mass assignable fields
    protected $fillable = [
        'project_id', 'name', 'sponsor_id', 'code', 'start_date', 'end_date', 'topic', 'budget', 'description', 'actual_cost', 'sponsor', 'sponsorship_amount', 'contract_amount', 'contract_doc', 'supporting_doc', 'comment'
    ];

    //Relationship activity and programme
    public function programme() {
        return $this->belongsTo(programme::class, 'programme_id');
    }
    //Relationship activity and project
    public function project() {
        return $this->belongsTo(projects::class, 'project_id');
    }
    //Relationship activity and registration
    public function registration() {
        return $this->hasMany(Registration::class, 'activity_id');
    }
    //Registered people count
    public function regPeople() {
        return $this->hasOne(Registration::class, 'activity_id')
            ->selectRaw('activity_id, count(*) as count')
            ->groupBy('activity_id');
    }
    //Registered male public count
    public function regMalePublic() {
        return $this->hasOne(Registration::class, 'activity_id')
            ->selectRaw('activity_id, count(*) as count')
            ->whereIn('gen_public_id', function ($query) {
                $query->select('id')->from('public_regs')->where('gender', 1);
            })
            ->groupBy('activity_id');
    }
    //Registered female public count
    public function regFemalePublic() {
        return $this->hasOne(Registration::class, 'activity_id')
            ->selectRaw('activity_id, count(*) as count')
            ->whereIn('gen_public_id', function ($query) {
                $query->select('id')->from('public_regs')->where('gender', 2);
            })
            ->groupBy('activity_id');
    }
    //Registered black public count
    public function regBlackPublic() {
        return $this->hasOne(Registration::class, 'activity_id')
            ->selectRaw('activity_id, count(*) as count')
            ->whereIn('gen_public_id', function ($query) {
                $query->select('id')->from('public_regs')->whereIn('ethnicity', [1, 2, 5]);
            })
            ->groupBy('activity_id');
    }
    //Registered white public count
    public function regWhitePublic() {
        return $this->hasOne(Registration::class, 'activity_id')
            ->selectRaw('activity_id, count(*) as count')
            ->whereIn('gen_public_id', function ($query) {
                $query->select('id')->from('public_regs')->where('ethnicity', 3);
            })
            ->groupBy('activity_id');
    }
    //Registered coloured public count
    public function regColouredPublic() {
        return $this->hasOne(Registration::class, 'activity_id')
            ->selectRaw('activity_id, count(*) as count')
            ->whereIn('gen_public_id', function ($query) {
                $query->select('id')->from('public_regs')->where('ethnicity', 4);
            })
            ->groupBy('activity_id');
    }
    //Registered male educator count
    public function regMaleEducators() {
        return $this->hasOne(Registration::class, 'activity_id')
            ->selectRaw('activity_id, count(*) as count')
            ->whereIn('educator_id', function ($query) {
                $query->select('id')->from('educators')->where('gender', 1);
            })
            ->groupBy('activity_id');
    }
    //Registered female educator count
    public function regFemaleEducators() {
        return $this->hasOne(Registration::class, 'activity_id')
            ->selectRaw('activity_id, count(*) as count')
            ->whereIn('educator_id', function ($query) {
                $query->select('id')->from('educators')->where('gender', 2);
            })
            ->groupBy('activity_id');
    }
    //Registered black educators count
    public function regBlackEducators() {
        return $this->hasOne(Registration::class, 'activity_id')
            ->selectRaw('activity_id, count(*) as count')
            ->whereIn('educator_id', function ($query) {
                $query->select('id')->from('educators')->whereIn('ethnicity', [1, 2, 5]);
            })
            ->groupBy('activity_id');
    }
    //Registered white educators count
    public function regWhiteEducators() {
        return $this->hasOne(Registration::class, 'activity_id')
            ->selectRaw('activity_id, count(*) as count')
            ->whereIn('educator_id', function ($query) {
                $query->select('id')->from('educators')->where('ethnicity', 3);
            })
            ->groupBy('activity_id');
    }
    //Registered coloured educators count
    public function regColouredEducators() {
        return $this->hasOne(Registration::class, 'activity_id')
            ->selectRaw('activity_id, count(*) as count')
            ->whereIn('educator_id', function ($query) {
                $query->select('id')->from('educators')->where('ethnicity', 4);
            })
            ->groupBy('activity_id');
    }
    //Registered male learner count
    public function regMaleLearners() {
        return $this->hasOne(Registration::class, 'activity_id')
            ->selectRaw('activity_id, count(*) as count')
            ->whereIn('learner_id', function ($query) {
                $query->select('id')->from('learners')->where('gender', 1);
            })
            ->groupBy('activity_id');
    }
    //Registered female learner count
    public function regFemaleLearners() {
        return $this->hasOne(Registration::class, 'activity_id')
            ->selectRaw('activity_id, count(*) as count')
            ->whereIn('learner_id', function ($query) {
                $query->select('id')->from('learners')->where('gender', 1);
            })
            ->groupBy('activity_id');
    }
    //Registered black learners count
    public function regBlackLearners() {
        return $this->hasOne(Registration::class, 'activity_id')
            ->selectRaw('activity_id, count(*) as count')
            ->whereIn('learner_id', function ($query) {
                $query->select('id')->from('learners')->whereIn('ethnicity', [1, 2, 5]);
            })
            ->groupBy('activity_id');
    }
    //Registered white learners count
    public function regWhiteLearners() {
        return $this->hasOne(Registration::class, 'activity_id')
            ->selectRaw('activity_id, count(*) as count')
            ->whereIn('learner_id', function ($query) {
                $query->select('id')->from('learners')->where('ethnicity', 3);
            })
            ->groupBy('activity_id');
    }
    //Registered coloured learners count
    public function regColouredLearners() {
        return $this->hasOne(Registration::class, 'activity_id')
            ->selectRaw('activity_id, count(*) as count')
            ->whereIn('learner_id', function ($query) {
                $query->select('id')->from('learners')->where('ethnicity', 4);
            })
            ->groupBy('activity_id');
    }
    //Relationship activity and hr person
    public function facilitator() {
        return $this->belongsTo(HRPerson::class, 'facilitator_id');
    }
    //Relationship activity and service provider
    public function serviceProvider() {
        return $this->belongsTo(contacts_company::class, 'service_provider_id');
    }
    //Relationship expenditure and activity
    public function expenditure() {
        return $this->hasMany(activity_expenditures::class, 'activity_id');
    }
     //Relationship income and activity
    public function income() {
        return $this->hasMany(activity_incomes::class, 'activity_id');
    }

    //function to add Expenditures
    public function addExpenditure(activity_expenditures $expenditure) {
        return $this->expenditure()->save($expenditure);
    }
    //function to add Expenditures
    public function addIncome(activity_incomes $income) {
        return $this->income()->save($income);
    }
    //function to return an array of activities from a specifi project
    public static function activitiesFromProject($projectID, $incComplete = -1) {
        return activity::where('project_id', $projectID)
            ->where(function($query) use($incComplete) {
                if ($incComplete == 1) $query->whereIn('status', [2, 3]);
                else $query->whereIn('status', [2]);
            })
            ->orderBy('name')
            ->pluck('id', 'name');
    }
}
