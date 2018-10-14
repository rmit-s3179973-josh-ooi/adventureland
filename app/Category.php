<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ['name'];
	protected $appends = ['type'];

    public function events()
    {
    	return $this->hasMany(Event::class);
    }

    public function getTypeAttribute()
    {
        return $this->attributes['type'] = 'category';
    }
}
