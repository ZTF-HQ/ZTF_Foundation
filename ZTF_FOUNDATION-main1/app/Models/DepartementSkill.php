<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartementSkill extends Model
{
    protected $table = 'department_skills';
    
    protected $fillable = [
        'name',
        'description',
        'department_id'
    ];

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }


}
