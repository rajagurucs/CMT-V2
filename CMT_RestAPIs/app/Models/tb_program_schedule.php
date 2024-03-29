<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_program_schedule extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'tb_program_schedule';

    protected $fillable = [
        //Basic Details
        'Category',
        'ProgramName',
        'Description',
        'UserID',
        'FromDate',
        'ToDate',
        'Recurrence',
        'NoOfTimes',
        // 'EndDate',
        // 'EndTime',
        // 'Instructor',
        // 'Location'
        // 'notes_last_edited_byRole'
        ];
}
