<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'client_id',
        'health_program_id',
        'enrollment_date',
        'end_date',
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'enrollment_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the client associated with the enrollment.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the health program associated with the enrollment.
     */
    public function healthProgram()
    {
        return $this->belongsTo(HealthProgram::class);
    }
}
