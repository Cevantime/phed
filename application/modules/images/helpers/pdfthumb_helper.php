<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

if (!function_exists('pdfthumb')) {

	function pdfthumb($src) {
		if(!$src || !file_exists(realpath($src))) 
			return '';
		
		$infos = pathinfo(realpath($src));
		$cachedFile = 'application/cache/pdfsthumbs/'. str_replace('/','-',str_replace(realpath(BASEPATH.'/../').'/','',$infos['dirname'].'/'.$infos['filename'])).'.png';

		if(file_exists($cachedFile))  
			return $cachedFile;
		
		$source = realpath($src);
		
		$im = new Imagick($source);
		$im->setiteratorindex(0);
		$im->setcompressionquality(90);
		$im->writeimage($cachedFile);
		
		return $cachedFile;
	}
}
	
