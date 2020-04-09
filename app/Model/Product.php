<?php

/**
 * 
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends BaseModel
{
    use SoftDeletes;

    protected $table = 'products';
    protected $fillable = [
        'logo',
        'color',
        'secondary_color',
        'code',
    ];

    public function translations() {
        return $this->hasMany('App\Model\ProductTranslation');
    }

}