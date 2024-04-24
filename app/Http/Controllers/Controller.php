<?php

namespace App\Http\Controllers;

use App\Traits\Get;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller 
{
    use Get;
    public function index($data){
        return $this->GetAll($data);
    }
    public function show($data,$id){
        return $this->GetByDataId($data,$id);
    }
    
}
