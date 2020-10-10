<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Organizers extends Model
{
    use HasFactory;

    /**
     * Give specific table for this Model
     *
     * @var string
     */
    protected $table = 'organizers';

    /**
     * Table attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'event_id'
    ];

    /**
     * Get User for this Organizer
     *
     * @return HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get Event for this Organizer
     *
     * @return HasOne
     */
    public function event()
    {
        return $this->hasOne(Events::class, 'id', 'event_id');
    }
}
