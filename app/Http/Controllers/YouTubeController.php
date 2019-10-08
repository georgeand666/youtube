<?php

namespace App\Http\Controllers;

use App\YouTubeClass;

class YouTubeController 
{
	protected $youtube;
	
    public function index($idVideo=''){
    	
    	return view('youtube');
    	
    }
    
    
    public function search(){
    	
    	$youtube = new YouTubeClass();
    	
    	return $youtube->Teste();
    	
    }
}
