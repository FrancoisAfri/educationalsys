<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactPerson extends Model
{
    //Specify the table
    public $table = 'contacts_contacts';

    // Mass assignable fields
    protected $fillable = [
        'first_name', 'surname', 'middle_name', 'maiden_name', 'aka', 'initial', 'email', 'cell_number', 'phone_number', 'id_number', 'date_of_birth', 'passport_number', 'drivers_licence_number', 'drivers_licence_code', 'proof_drive_permit', 'proof_drive_permit_exp_date', 'drivers_licence_exp_date', 'gender', 'own_transport', 'marital_status', 'ethnicity', 'profile_pic', 'status', 'contact_type', 'organization_type', 'office_number', 'str_position'
    ];

    //Relationship contacts_contacts and user
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
