<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_community_programs extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table = 'tb_community_programs';

    protected $fillable = [
        'programName',
        'category',
                
    ];
}
