<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StorageController extends Controller
{
    public function index(){
    	return 'Fuck U Up,asshole!';
    }
    public function notallow(){
    	return view('storage.notallow');
    }
}
