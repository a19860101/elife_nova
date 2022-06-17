<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class Post extends Model
{
    use HasFactory;
    use Actionable;
    protected $fillable = ['is_published'];
    protected $casts = [
        'publish_at' => 'datetime',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function tags(){
        return $this->belongsToMany(Tag::class);

    }
}
