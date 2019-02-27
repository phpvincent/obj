<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StorageController extends Controller
{
    public function index(){
    	return view('storage.father.father');
    }
    public function notallow(){
    	return view('storage.notallow');
    }
}
