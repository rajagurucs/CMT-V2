<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_init_user_health_details extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'myhealth_curr_prog',
        'myhealth_curr_state',
        'mylifesatisfaction_curr_prog',
        'mylifesatisfaction_curr_state',
        'mysocialnetwork_curr_prog',
        'mysocialnetwork_curr_state',
        'mycommunitynetwork_curr_prog',
        'mycommunitynetwork_curr_state',
        'mystresslevel_curr_prog',
        'mystresslevel_curr_state',
        'myhealthissues_curr_prog',
        'myhealthissues_curr_state',
        'myfamilydoctor_curr_prog',
        'myfamilydoctor_curr_state',
        'myvisittofamilydoctor_curr_state',
        'myvisittoclinic_curr_state',
        'myvisittoemergency_curr_state',
        'myvisittohospital_curr_state',
        'mydiseaseawareness_curr_prog',
        'mydiseaseawareness_curr_state',
        'mycmtprogramawareness_curr_prog',
        'mycmtprogramawareness_curr_state',
        'myphysicalactiveness_curr_prog',
        'myphysicalactiveness_curr_state',
        'cmtagent_curr',
        'userId',
        
    ];
}
