<?php

namespace App\Models\Notify;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = ['subject', 'body', 'status', 'published_at'];

    protected $table = 'public_mail';

    public function files()
    {
        return $this->hasMany(EmailFile::class, 'public_mail_id');
    }


}