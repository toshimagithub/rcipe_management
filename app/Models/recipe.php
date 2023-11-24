<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $table = 'recipes';

    protected $fillable = [
        'user_id',
        'name',
        'comment',
        'image',
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

        public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

        public function steps()
    {
        return $this->hasMany(Step::class);
    }

    public function recipesreview()
{
    return $this->hasMany(RecipesReview::class, 'recipe_id', 'id');
}


}
