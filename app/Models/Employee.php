<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'company_id',
        'phone',
        'picture',
    ];

    public function worksAt(){
        return $this->belongsTo(Company::class,'company_id');
    }
}
