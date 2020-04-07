<?php

/**
 * Base Model
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {
    public function translate(Language $language) {
        return $this->translations()->where('language_id', $language->id);
    }
}