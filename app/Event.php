<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Event extends Model
{
    protected $fillable = [
    	'event_title',
    	'event_description',
    	'location',
    	'start_datetime',
    	'end_datetime',
    	'is_active'
    ];

    private function users()
    {
    	return $this->belongsToMany(User::class);
    }

    public function setEventCreator(User $user)
    {
    	$this->users()->attach($user,['is_admin'=>true]);
    }

    public function addUser($user)
    {
    	$this->users()->attach($user);
    }
}
