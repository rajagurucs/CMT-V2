<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_program_files extends Model
{
    use HasFactory;
    
    protected $table = 'tb_program_files';
   

    protected $fillable = [
        //Basic Details
        'file_id',
        'Program_Name',
        'Sentfrom',
        'FileName',
        'File_Loc',
        'UserType',
        'usergrade',
        'agentcomments',
        // 'notes_last_edited_byRole'
        ];
}
