<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_feeds extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'tb_feeds';

    protected $fillable = [
        //Basic Details
        'Title',
        'PostContent',
        'File_Loc',
        'LikeCount',
        'DislikeCount',
        'UserID'
        // 'notes_last_edited_byRole'
        ];
}
