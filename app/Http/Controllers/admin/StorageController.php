<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StorageController extends Controller
{
    public function index(){
    	return view('storage.father.father');
    }
    public function homepage(){
    	return view('storage.index.index');
    }
    public function notallow(){
    	return view('storage.notallow');
    }
    public function blade(Request $request){
    	$type=$request->has('type')?$request->input('type'):'index.balde.php';
    	\View::addExtension('html','php');
		return  view()->file(public_path().'/admin/layuiadmin/html/'.$type);
    }
}
