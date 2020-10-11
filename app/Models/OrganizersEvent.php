<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrganizersEvent extends Model
{
    use HasFactory;

    /**
     * Give specific table for this Model
     *
     * @var string
     */
    protected $table = 'organizers_events';

    /**
     * Table attributes that are mass assignable
     *
     * @var string[]
     */
    protected $fillable = [
        'event_id',
        'organizer',
    ];

    /**
     * Indicates if the model should be timestamped
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the Event for this OrganizersEvents
     *
     * @return HasOne
     */
    public function event()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
