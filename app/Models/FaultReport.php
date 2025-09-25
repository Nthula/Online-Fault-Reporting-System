<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaultReport extends Model
{
    //
    use HasFactory;

    protected $primaryKey = 'report_id';
    protected $fillable = [
        'user_id',
        'description',
        'category',
        'room_number',
        'image',
        'status',
        'validated',
        'validated_at',
        'validated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'report_id');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    /**
     * Get the department this fault report is assigned to
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }
}
