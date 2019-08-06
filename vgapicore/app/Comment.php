<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Comment extends Model
    {
        protected $table = 'comments';

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function video()
        {
            return $this->belongsTo(Video::class);
        }
    }
