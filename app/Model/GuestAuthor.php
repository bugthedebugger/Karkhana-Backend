<?php

/**
 * 
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Language;
use Storage;

class GuestAuthor extends Model
{
	protected $table = 'guest_author';
    protected $fillable = [
        'name',
        'email',
        'bio', 
        'avatar',
        'linkedin',
        'facebook',
        'twitter',
        'youtube',
        'instagram',
    ];

    public function blogs() {
        return $this->hasMany('App\Model\Blog');
    }
    
    public function info() { 
        $avatar = null;

        if (Storage::disk('s3')->exists($this->avatar))
            $avatar = Storage::disk('s3')->url($this->avatar);

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'bio' => $this->bio, 
            'avatar' => $avatar,
            'linkedin' => $this->linkedin,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'youtube' => $this->youtube,
            'instagram' => $this->instagram,
        ];

        return $data;
    }
}