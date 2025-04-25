<?php

namespace App\Models\Content;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Faq extends Model
{
    use HasFactory,Sluggable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */



    public function sluggable(): array
    {
        return [
            'slug' => [
            'source' => 'question'
        ]
    ];
}



    protected $fillable = [
        'question',
        'answer',
        'status',
        'tags',
        'slug',
        'user_id',
        'published_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */

}
