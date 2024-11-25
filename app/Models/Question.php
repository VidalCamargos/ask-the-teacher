<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $fillable = [
        'question',
        'created_by_id',
        'created_at',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function likesCount(): Attribute
    {
        return Attribute::get(fn () => $this->votes->sum('like'));
    }

    public function unlikesCount(): Attribute
    {
        return Attribute::get(fn () => $this->votes->sum('unlike'));
    }
}
