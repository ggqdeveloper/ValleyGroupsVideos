<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Video extends Model
    {
        protected $table = 'videos';

        public function comments()
        {
            return $this->hasMany('App\Comment');
        }

        public function user()
        {
            return $this->belongsTo('App\User', 'user_id');
        }
    }
