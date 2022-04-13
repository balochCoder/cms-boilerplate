<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $guarded= [];

    const HOME = 'home';
    const ABOUT_US = 'about-us';
    const CONATACT_US = 'contact-us';
}
