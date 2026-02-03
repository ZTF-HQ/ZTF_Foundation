<?php

namespace App\Models;

use App\Models\User;
use App\Models\Service;
use App\Models\DepartementSkill;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'head_id',
        'head_assigned_at',
        'email_notifications',
        'report_frequency',
        'two_factor_enabled',
        'session_timeout',
        'theme',
        'language'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'head_assigned_at' => 'datetime'
    ];


    protected static function booted (){
        static::deleting(function ($department){
            $department->users()->delete();
        });
    }

    public function users(){
        return $this->belongsToMany(User::class, 'department_user')->withTimestamps();
    }

    public function departmentUsers(){
        return $this->hasMany(User::class,'department_id');
    }

    public function headDepartment(){
        return $this->belongsTo(User::class, 'user_id');
    }


    public function head(){
        return $this->belongsTo(User::class, 'head_id', 'id');
    }

    public function skills(){
        return $this->hasMany(DepartementSkill::class, 'department_id');
    }

    public function services(){
        return $this->hasMany(Service::class, 'department_id');
    }

    public function activeServices()
    {
        return $this->services()->where('is_active', true);
    }

    public function servicesCount()
    {
        return $this->services()->count();
    }

    public function activeServicesCount()
    {
        return $this->activeServices()->count();
    }
}
