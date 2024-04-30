<?php

namespace App\Http\Controllers;

use App\Traits\Get;
use App\Traits\Store;
use Illuminate\Http\Client\Request;

class GeneralController extends Controller
{
    use Get,Store;
    public function __construct(){
        $this->middleware('role:admin')->only('setAppSettings');
    }
    public function index($data){
        return $this->GetAll($data);
    }
    public function show($data,$id){
        return $this->GetByDataId($data,$id);
    } 
    public function setAppSettings(Request $request){  
        return response()->json($this->storAppSettings($request));
    }
  
   
}
