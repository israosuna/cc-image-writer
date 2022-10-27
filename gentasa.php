<?php

// link to the font file no the server
$fontname = 'font/Roboto-Bold.ttf';
// controls the spacing between text
$i=30;
//JPG image quality 0-100
$quality = 90;

function create_image($user){

		global $fontname;	
		global $quality;
		$file = "tasas/".md5($user[0]['name'].$user[1]['name'].$user[2]['name']).".jpg";	
	
	// if the file already exists dont create it again just serve up the original	
	//if (!file_exists($file)) {	
			

			// define the base image that we lay our text on
			$im = imagecreatefromjpeg("tasa.jpg");
			
			// setup the text colours
			$color['grey'] = imagecolorallocate($im, 255, 255, 255);
			$color['green'] = imagecolorallocate($im, 55, 189, 102);
			
			// this defines the starting height for the text block
			$y = imagesy($im) - $height - 85;
			 
			imagettftext($im, 32, 0, 340, 260, $color[$user[0]['color']], $fontname,$user[0]['name']);
			imagettftext($im, 32, 0, 340, 500, $color[$user[0]['color']], $fontname,$user[1]['name']);
			imagettftext($im, 26, 0, 350, 650, $color[$user[0]['color']], $fontname,$user[2]['name']);
			imagejpeg($im, $file, $quality);
			
	//}
						
		return $file;	
}
	$user ="";	
		
	if(count($error)==0){
		
	$user = array(
	
		array(
			'name'=> $_GET['tasaventa'], 
			'font-size'=>'15',
			'color'=>'black'),
			
		array(
			'name'=> $_GET['tasacompra'],
			'font-size'=>'11',
			'color'=>'black'),

		array(
			'name'=> $_GET['tasagc'],
			'font-size'=>'11',
			'color'=>'black')
			
	);		
		
	}
		
	

// run the script to create the image
$filename = create_image($user);

echo "direccion de la imagen q acabo de crear es : https://www.appbb.co/template-sender/generarTDC/".$filename;
?>

