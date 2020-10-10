<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Events extends Model
{
    use HasFactory;

    /**
     * Give specific table for this Model
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * Table attributes that are mass assignable
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date'
    ];

    /**
     * Indicates if the model should be timestamped
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get Organizer for this Event
     *
     * @return HasMany
     */
    public function organizers()
    {
        return $this->hasMany(Organizers::class, 'event_id', 'id');
    }
}
