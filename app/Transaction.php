<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

	public function hosts()
	{

		return $this->belongsTo(Host::class, 'host_id');

	}

	public function wallets()
	{

		return $this->belongsTo(Wallet::class, 'wallet_id');

	}

}
