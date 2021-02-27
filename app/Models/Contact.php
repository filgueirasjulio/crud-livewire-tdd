<?php

namespace App\Models;

use App\Models\Traits\TeamTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;
    use TeamTenant;
    
    /**
     * guard
     *
     * @var array
     */
    protected $guard = ['id'];
}
