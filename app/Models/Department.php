<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $primaryKey = 'department_id';
    protected $fillable = [
        'name',
        'staff_id',
        'category_type',
        'description',
    ];

    // For the manager (staff) of the department
    public function manager()
    {
        return $this->belongsTo(User::class, 'staff_id')->withDefault();
    }

    // For all users assigned to this department
    public function users()
    {
        return $this->hasMany(User::class, 'department_id', 'department_id');
    }

    // For fault reports assigned to this department
    public function reports()
    {
        return $this->hasMany(FaultReport::class, 'department_id', 'department_id');
    }

    // Add relationship to workers
    public function workers()
    {
        return $this->hasMany(Worker::class, 'department_id', 'department_id');
    }
}
