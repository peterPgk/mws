<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Answer extends Model
{
    protected $fillable = ['text'];

    /**
     * @return BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_answer');
    }

    /**
     * This will filter answers that are already chosen by user
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAnswered(Builder $query)
    {
        return $query->whereHas('users');
    }
}
