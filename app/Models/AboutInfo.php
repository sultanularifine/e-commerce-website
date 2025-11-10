<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutInfo extends Model
{
    use HasFactory;
     protected $fillable = [
        'title',
        'subtitle',
        'who_we_are',
        'our_story',
        'image',
    ];
}
