<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    use HasFactory;

    // Nếu bảng của bạn không theo quy tắc tên bảng số nhiều tự động
    // protected $table = 'registers'; 

    // Đảm bảo chỉ các trường sau được phép gán
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Nếu bạn có cột created_at và updated_at
    // public $timestamps = true;

    // Để bảo mật các trường như password
    protected $hidden = [
        'password',
    ];

    // Để tự động băm password khi lưu
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->password) {
                $model->password = bcrypt($model->password);
            }
        });
    }
}
