<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;


/**
 * Class Question
 * @package App
 *
 * @property Collection|Relation $answers
 * @property int|string $id
 * @property int|string $text
 */
class Question extends Model
{
    protected $fillable = ['text'];

    /**
     * @return Relation
     */
    public function answers(): Relation
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * @param Builder $query
     * @param User|null $user
     */
    public function scopeByUser(Builder $query, User $user = null)
    {
        $user = $user ?? auth()->user();

        $query->with(['answers' => function(Relation $q) use ($user) {
            $q->whereHas('users', function (Builder $qr) use ($user) {
                $qr->where('user_id', $user->id);
            });
        }]);
    }

    /**
     * Check if this question already has selected answers
     *
     * @return bool
     */
    public function hasAnswered()
    {
        return $this->load(['answers' => function (Relation $q) {
            $q->answered('users');
        }])->answers->isNotEmpty();
    }
}
