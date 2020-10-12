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
        'organizer_id',
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
        return $this->hasOne(Events::class, 'id', 'event_id');
    }

    /**
     * Get the Organizer for this OrganizersEvent
     *
     * @return HasOne
     */
    public function organizer()
    {
        return $this->hasOne(Organizers::class, 'id', 'organizer_id');
    }

    public static function storeOrganizers(array $organizers, $event_id)
    {
        $collection = collect($organizers);

        $collection->map(function ($organizer_id) use ($event_id) {
            return OrganizersEvent::firstOrCreate([
                'organizer_id' => $organizer_id,
                'event_id' => $event_id
            ], [
                'organizer_id' => $organizer_id,
                'event_id' => $event_id
            ]);
        });
    }
}
