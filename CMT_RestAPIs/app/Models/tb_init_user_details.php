<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tb_init_user_details extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'tb_init_user_details';

    protected $fillable = [
                            //Basic Details
                            'firstName',
                            'middleName',
                            'lastName',
                            'gender',
                            'age',
                            'streetAddress',
                            'city',
                            'province',
                            'country',
                            'zipCode',
                            'phoneHome',
                            'phoneCell',
                            'phoneWork',
                            'email',
                            'firstLang',
                            'EmerContactName',
                            'EmerContactNo',
                            'aboutUs',
                            'ChildValue',
                            'notes',
                            'notes_last_edited_byName',
                            'notes_last_edited_byRole'
                            ];
    
}
