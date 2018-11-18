<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{

	public function transactions()
	{

		return $this->hasMany(Transaction::class, 'wallet_id');

	}

}
