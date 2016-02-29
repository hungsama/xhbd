<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testmd extends Model
{
  protected $table = 'categories';
  protected $fillable = ['name', 'content'];
}
