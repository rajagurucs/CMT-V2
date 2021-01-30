<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_init_user_extra_details extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'tb_init_user_extra_details';

    protected $fillable = [
        'myHealth',
        'myLifeSatisfaction',
        'mySocialNetwork',
        'myCommunityNetwork',
        'myStressLevel',
        'myHealthIssues',
        'myFamilyDoctor',
        'myVisitToFamilyDoctor',
        'myVisitToClinic',
        'myVisitToEmergency',
        'myVisitToHospital',
        'myDiseaseAwareness',
        'myCmtProgramAwareness',
        'myPhysicalActiveness',
        'cmtAgent',
        'userId',
        
    ];
}
