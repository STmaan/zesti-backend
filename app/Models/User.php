<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_num',
        'country',
        'picture_id',
        'name',
        'home_town',
        'gender',
        'dob',
        'language',
    ];
}
