<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'employee';
    protected $primarykey = 'id';
    protected $fillable = [
        'id',
       'user_type',
       'first_name',
       'middle_name',
       'last_name',
       'gender',
       'date_of_birth',
       'age',
       'martial_status',
       'current_address',
       'permanent_address',
       'number',
       'emergency_number',
       'blood_group',
       'Bank',
       'Account_number',
        'IFSC',
        'Branch_name',
        'Branch_city',
        'emp_type',
        'employee_id',
        'location',
        'official_email_id',
        'email_id',
        'password',
        'Source_of_hire',
        'experience',
        'start_date',
        'end_date',
        'skillset',
        'Reporting_manager',
        'profile_photo',
        'practice',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    
}
