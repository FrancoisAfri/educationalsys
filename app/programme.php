<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class programme extends Model
{
    //Specify the table name
    public $table = 'programmes';

    // Mass assignable fields
    protected $fillable = [
        'name', 'code', 'sponsor_id', 'start_date', 'end_date', 'budget_expenditure', 'budget_income', 'description', 'sponsor', 'sponsorship_amount', 'contract_amount', 'contract_doc', 'supporting_doc', 'comment'
    ];

    //Relationship programme and service provider
    public function serviceProvider() {
        return $this->belongsTo(contacts_company::class, 'service_provider_id');
    }
    //Relationship programme and manager (HR Person)
    public function manager() {
        return $this->belongsTo(HRPerson::class, 'manager_id');
    }
    //Relationship programme and project
    public function project() {
        return $this->hasMany(projects::class, 'programme_id');
    }
    //Relationship programme and registration
    public function registration() {
        return $this->hasMany(Registration::class, 'programme_id');
    }
    //Registered people count
    public function regPeople() {
        return $this->hasOne(Registration::class)
            ->selectRaw('programme_id, count(*) as count')
            ->groupBy('programme_id');
    }
    //Registered male public count
    public function regMalePublic() {
        return $this->hasOne(Registration::class)
            ->selectRaw('programme_id, count(*) as count')
            ->whereIn('gen_public_id', function ($query) {
                $query->select('id')->from('public_regs')->where('gender', 1);
            })
            ->groupBy('programme_id');
    }
    //Registered female public count
    public function regFemalePublic() {
        return $this->hasOne(Registration::class)
            ->selectRaw('programme_id, count(*) as count')
            ->whereIn('gen_public_id', function ($query) {
                $query->select('id')->from('public_regs')->where('gender', 2);
            })
            ->groupBy('programme_id');
    }
    //Registered black public count
    public function regBlackPublic() {
        return $this->hasOne(Registration::class)
            ->selectRaw('programme_id, count(*) as count')
            ->whereIn('gen_public_id', function ($query) {
                $query->select('id')->from('public_regs')->whereIn('ethnicity', [1, 2, 5]);
            })
            ->groupBy('programme_id');
    }
    //Registered white public count
    public function regWhitePublic() {
        return $this->hasOne(Registration::class)
            ->selectRaw('programme_id, count(*) as count')
            ->whereIn('gen_public_id', function ($query) {
                $query->select('id')->from('public_regs')->where('ethnicity', 3);
            })
            ->groupBy('programme_id');
    }
    //Registered coloured public count
    public function regColouredPublic() {
        return $this->hasOne(Registration::class)
            ->selectRaw('programme_id, count(*) as count')
            ->whereIn('gen_public_id', function ($query) {
                $query->select('id')->from('public_regs')->where('ethnicity', 4);
            })
            ->groupBy('programme_id');
    }
    //Registered male educator count
    public function regMaleEducators() {
        return $this->hasOne(Registration::class)
            ->selectRaw('programme_id, count(*) as count')
            ->whereIn('educator_id', function ($query) {
                $query->select('id')->from('educators')->where('gender', 1);
            })
            ->groupBy('programme_id');
    }
    //Registered female educator count
    public function regFemaleEducators() {
        return $this->hasOne(Registration::class)
            ->selectRaw('programme_id, count(*) as count')
            ->whereIn('educator_id', function ($query) {
                $query->select('id')->from('educators')->where('gender', 2);
            })
            ->groupBy('programme_id');
    }
    //Registered black educators count
    public function regBlackEducators() {
        return $this->hasOne(Registration::class)
            ->selectRaw('programme_id, count(*) as count')
            ->whereIn('educator_id', function ($query) {
                $query->select('id')->from('educators')->whereIn('ethnicity', [1, 2, 5]);
            })
            ->groupBy('programme_id');
    }
    //Registered white educators count
    public function regWhiteEducators() {
        return $this->hasOne(Registration::class)
            ->selectRaw('programme_id, count(*) as count')
            ->whereIn('educator_id', function ($query) {
                $query->select('id')->from('educators')->where('ethnicity', 3);
            })
            ->groupBy('programme_id');
    }
    //Registered coloured educators count
    public function regColouredEducators() {
        return $this->hasOne(Registration::class)
            ->selectRaw('programme_id, count(*) as count')
            ->whereIn('educator_id', function ($query) {
                $query->select('id')->from('educators')->where('ethnicity', 4);
            })
            ->groupBy('programme_id');
    }
    //Registered male learner count
    public function regMaleLearners() {
        return $this->hasOne(Registration::class)
            ->selectRaw('programme_id, count(*) as count')
            ->whereIn('learner_id', function ($query) {
                $query->select('id')->from('learners')->where('gender', 1);
            })
            ->groupBy('programme_id');
    }
    //Registered female learner count
    public function regFemaleLearners() {
        return $this->hasOne(Registration::class)
            ->selectRaw('programme_id, count(*) as count')
            ->whereIn('learner_id', function ($query) {
                $query->select('id')->from('learners')->where('gender', 1);
            })
            ->groupBy('programme_id');
    }
    //Registered black learners count
    public function regBlackLearners() {
        return $this->hasOne(Registration::class)
            ->selectRaw('programme_id, count(*) as count')
            ->whereIn('learner_id', function ($query) {
                $query->select('id')->from('learners')->whereIn('ethnicity', [1, 2, 5]);
            })
            ->groupBy('programme_id');
    }
    //Registered white learners count
    public function regWhiteLearners() {
        return $this->hasOne(Registration::class)
            ->selectRaw('programme_id, count(*) as count')
            ->whereIn('learner_id', function ($query) {
                $query->select('id')->from('learners')->where('ethnicity', 3);
            })
            ->groupBy('programme_id');
    }
    //Registered coloured learners count
    public function regColouredLearners() {
        return $this->hasOne(Registration::class)
            ->selectRaw('programme_id, count(*) as count')
            ->whereIn('learner_id', function ($query) {
                $query->select('id')->from('learners')->where('ethnicity', 4);
            })
            ->groupBy('programme_id');
    }
	//Relationship expenditure and programme
    public function expenditure() {
        return $this->hasMany(programme_expenditures::class, 'programme_id');
    }
    //..

    //Relationship income and programme
    public function income() {
        return $this->hasMany(programme_incomes::class, 'programme_id');
    }
	
	//function to add Expenditures
	public function addExpenditure(programme_expenditures $expenditure) {
		return $this->expenditure()->save($expenditure);
	}

    // function to add income
    public function addIncome(programme_incomes $income){
        return $this->income()->save($income);
    }
}
