<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_init_user_goals extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_goal_category_name',
        'user_goal_program_name',
        'user_goal_program_location',
        'user_goal_program_instructor',
        'user_goal_program_startdate',
        'user_goal_program_enddate',
        'user_goal_program_participantcomments',
        'user_goal_program_additionalcomments',
        'user_goal_program_status',
        'user_goal_program_RatingBefore',
        'user_goal_program_RatingAfter',
        'userId',
    ];
}
