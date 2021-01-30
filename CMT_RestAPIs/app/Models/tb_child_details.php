<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_child_details extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table = 'tb_child_details';

    protected $fillable = [
        'childFirstname',
        'childLastname',
        'childDob',
    ];
}