<?php 

/**
 * 
 */
namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Verify extends Model
{
	
	protected $table = 'verify';

	protected $fillable = ['email', 'token', 'verified_at', 'expire_at', 'verified'];

	public function isExpired(){
		return Carbon::now() > $this->expire_at;
	}
}