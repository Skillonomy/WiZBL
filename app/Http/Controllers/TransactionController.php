<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\Wallet;
use App\Host;

class TransactionController extends Controller
{
    
    public function index()
    {
    	$transactions = Transaction::with(['hosts', 'wallets'])
    		->orderBy('id', 'desc')
    		->get();

		return view('index', compact('transactions'));
    }

}
