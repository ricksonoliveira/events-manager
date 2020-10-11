<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use phpDocumentor\Reflection\Types\Integer;

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
    ];

    /**
     * Indicates if the model should be timestamped
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get Organizers for this Organizers
     *
     * @return HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Scope of all organizers which has a valid user
     *
     * @param Builder $query
     */
    public function scopeOrganizers(Builder $query)
    {
        $query->whereHas('user');
    }

    /**
     * Create User as an Organizer
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @return Model
     * @throws \Exception
     */
    public function createOrganizerUser(string $name, string $email, string $password): Model
    {
        $existsEmail = User::where('email', $email)->first();
        if($existsEmail) {
            throw new \Exception(__('common.email_unique'));
        }

        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);
    }

    /**
     * Update User as an Organizer
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @return Model
     * @throws \Exception
     */
    public function updateOrganizerUser(string $name, string $email, string $password): Model
    {
        $existsEmail = User::where('email', $email)->whereNotIn('id', [$this->user->id])->first();
        if($existsEmail) {
            throw new \Exception(__('common.email_unique'));
        } else  {

            $this->user()->update([
                'name' => $name,
                'email' => $email,
                'password' => $password
            ]);
        }

        return $this->user;
    }

    /**
     * Create Organizer
     *
     * @param int $user_id
     * @return Model
     */
    public function createOrganizer(int $user_id): Model
    {
        $this->fill([
            'user_id' => $user_id,
        ]);
        $this->save();
        return $this;
    }
}
