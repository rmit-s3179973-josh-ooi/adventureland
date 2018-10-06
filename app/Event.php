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

    public function users()
    {
    	return $this->belongsToMany(User::class);
    }

    public function setEventCreator(User $user)
    {
    	$this->users()->attach($user,['is_creator'=>true]);
    }

    public function addUser(User $user)
    {
    	
		$this->users()->attach($user,['is_creator'=>false]);		
    }

    public function hasUser(User $user)
    {
    	return $this->users->contains($user);
    }

    public function removeUser(User $user)
    {
    	return $this->users()->detach($user);
    }
}
