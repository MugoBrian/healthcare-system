<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the clients enrolled in this health program.
     */
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'enrollments')
            ->withPivot('enrollment_date', 'end_date', 'status', 'notes')
            ->withTimestamps();
    }

    /**
     * Get the enrollments for this health program.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
