<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = 
    ['title',
    'slug',
    'category_id',
    'ingridients',
    'method',
    'tips',
    'energy',
    'carbohydrate',
    'protein',
    'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    
}
