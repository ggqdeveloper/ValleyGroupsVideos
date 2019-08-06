<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Video extends Model
    {
        protected $table = 'videos';

        public function comments()
        {
            return $this->hasMany(Comment::class);
        }

        public function user()
        {
            return $this->belongsTo(User::class);
        }
    }
