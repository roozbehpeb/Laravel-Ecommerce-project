<?php

namespace App\Models\Content;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory,SoftDeletes;

   protected $fillable = ['body', 'author_id', 'parent_id', 'commentable_id', 'commentable_type', 'approved', 'status'];



   public function commentable()
   {
    return $this->morphTo();
   }


   public function user()
   {
    return $this->belongsTo(User::class, 'author_id');
   }


   public function parent()
   {
    return $this->belongsTo(Comment::class, 'parent_id');
   }

   public function answer()
   {
    return $this->hasMany(Comment::class, 'parent_id');

   }





}
