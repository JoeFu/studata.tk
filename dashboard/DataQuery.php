<?php

class DataQuery
{
	// Call the restful api	
	public function callAPI($service_url, $curl_post_data)
    {
    	$curl = curl_init($service_url);
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    	if ($curl_post_data != null){
    		curl_setopt($curl, CURLOPT_POST, true);
    		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);    		
    	}
    	$curl_response = curl_exec($curl);    	
    	curl_close($curl);
    	return $curl_response;
    } 
}