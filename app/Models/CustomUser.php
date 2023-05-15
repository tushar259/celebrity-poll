<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Laravel\Passport\HasApiTokens;

class CustomUser extends Model
{
    // use HasFactory;
    // use HasApiTokens;
    protected $table = "custom_users";
    protected $primaryKey ="id";
	public $timestamps = false;
}
