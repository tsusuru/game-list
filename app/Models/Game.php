<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'title','synopsis','release_date','playtime_hours','is_active',
        'publisher_id','genre_id','developer_id','user_id'
    ];

    protected $casts = [
        'release_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function publisher(){
        return $this->belongsTo(Publisher::class);
    }
    public function genre() {
        return $this->belongsTo(Genre::class);
    }
    public function developer() {
        return $this->belongsTo(Developer::class);
    }

    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function favourites() {
        return $this->hasMany(Favourite::class);
    }
}
