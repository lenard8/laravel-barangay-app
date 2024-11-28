<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Residence extends Model
{
    /** @use HasFactory<\Database\Factories\ResidenceFactory> */
    use HasFactory;

    protected $fillable = [
        'ID',
        'firstname',
        'lastname',
        'middlename',
        'gender',
        'date_of_birth',
        'civil_status',
        'occupation',
        'home_address',
        'email_address',
        'mobile_number',
        'is_senior_citizen_or_pwd',
        'relationship_to_head_of_household',
        'number_of_household_members',
    ];
    
}
