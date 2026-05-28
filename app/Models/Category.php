<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'category_user');
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'category_user')
            ->where('role', 'teacher');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'category_user')
            ->where('role', 'student');
    }
}

