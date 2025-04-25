<?php

namespace App\Models\Notify;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailFile extends Model
{
    use HasFactory,SoftDeletes;

protected $fillable = ['public_mail_id', 'file_path', 'file_size', 'file_type', 'status','access', 'original_name'];

    protected $table = 'public_mail_files';


    public function email()
    {
        return $this->belongsTo(Email::class, 'public_mail_id');
    }
}
