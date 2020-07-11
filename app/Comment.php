<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [ 'user_id', 'respond_to_id', 'url', 'body' ];
    protected $appends = ['human_created_at'];
    protected $with = ['children', 'user'];

    public function getHumanCreatedAtAttribute() {
        return $this->created_at->diffForHumans();
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function children() {
        return $this->hasMany('App\Comment', 'respond_to_id');
    }


    public static function boot() {
        parent::boot();

        static::deleting(function($comment) {
            $comment->children->each(function($childComment) {
                $childComment->delete();
            });
            return true;
        });
    }
}
