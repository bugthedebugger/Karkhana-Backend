<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Language;
use Carbon\Carbon;

class PasswordResetToken extends Model
{
    protected $table = 'password_reset_token';
    
    protected $fillable = [
        'user_id',
        'token',
        'valid',
        'valid_till',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function scopeValidToken($query) {
        return $query->where([
            ['valid', '=', true],
            ['valid_till', '>=', Carbon::now()],
        ]);
    }
}