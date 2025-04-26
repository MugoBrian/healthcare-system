<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'contact_number',
        'email',
        'address',
        'national_id',
    ];

    /**
     * Get the full name of the client.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the health programs the client is enrolled in.
     */
    public function healthPrograms()
    {
        return $this->belongsToMany(HealthProgram::class, 'enrollments')
            ->withPivot('enrollment_date', 'end_date', 'status', 'notes')
            ->withTimestamps();
    }

    /**
     * Get the enrollments for this client.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
