<?php

if( ! function_exists('idClean')){
	
	function idClean($id,$size=11){
		return intval(substr($id,0,$size));
	}

}

if( ! function_exists('dbClean')){
	
	function dbClean($string,$size=1000000){
		return xss_clean(substr($string,0,$size));
	}
	
}