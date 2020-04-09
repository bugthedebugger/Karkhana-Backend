<?php

/**
 * 
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTranslation extends Model
{
    use SoftDeletes;

    protected $table = 'products_translation';
    
    protected $fillable = [
        'product_id',
        'language_id',
        'name',
        'tag',
        'grade',
        'type',
        'school_services',
        'student_services',
        'description',
        'facts',
        'features',
        'brochure',
    ];

    protected $casts = [
        'facts' => 'array',
        'features' => 'array',
	];

    public function language() {
        return $this->belongsTo('App\Model\Language', 'language_id', 'id');
    }

    public function product() {
        return $this->belongsTo('App\Model\Product', 'product_id', 'id');
    }

}