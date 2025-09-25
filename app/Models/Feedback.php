<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    protected $fillable = [
        'feedback_id', 
        'report_id', 
        'student_validation', 
        'comments', 
        'date_created_at',
    ];

    // Define relationships
    public function report()
    {
        return $this->belongsTo(FaultReport::class, 'report_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
