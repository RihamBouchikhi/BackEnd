<?php

namespace App\Http\Controllers;

use App\Traits\Get;
use App\Traits\Store;
use Illuminate\Http\Client\Request;

class Controller 
{
    use Get,Store;
    public function index($data){
        return $this->GetAll($data);
    }
    public function show($data,$id){
        return $this->GetByDataId($data,$id);
    }
    
   
}
