<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipesReview extends Model
{
    use HasFactory;

    protected $table = 'recipes_reviews';

    protected $fillable = [
        'recipe_id',
        'user_id',
        'star',
    ];

        public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}

