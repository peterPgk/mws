<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Queue;

class Question extends Model
{
    protected $fillable = [];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function scopeByUser($query, User $user = null)
    {
        $user = $user ?? auth()->user();

//        \DB::enableQueryLog();
//
        $query->with(['answers' => function($q) use ($user) {
            $q->whereHas('users', function ($qr) use ($user) {
                $qr->where('user_id', $user->id);
            });
        }]);
//
//        dump(\DB::getQueryLog());

//        $query->with('answers.users');

//        $pivot = $this->answers()->getTable()

//        $query->whereHas('answers.users', function ($q) use ($user) {
////            $q->whereHas('users', function ($q) use ($user) {
//                $q->where('user_id', $user->id);
////            });
//        })->with('answers');
    }
}
