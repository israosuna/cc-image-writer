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
			 
		// loop through the array and write the text	
		

//			imagettftext($im, tamano  fuente, 0, 59, coordenada y, color fuente, nombre d ela cuensta $fontname,texto);
			$x1=center_text($user[0]['name'], 32);
			$x2=center_text($user[1]['name'], 32);
			$x3=center_text($user[2]['name'], 32);
			imagettftext($im, 32, 0, 340, 260, $color[$user[0]['color']], $fontname,$user[0]['name']);
			imagettftext($im, 32, 0, 340, 500, $color[$user[0]['color']], $fontname,$user[1]['name']);
			imagettftext($im, 26, 0, 350, 650, $color[$user[0]['color']], $fontname,$user[2]['name']);
			// imagettftext($im, 14, 0, 59, 400, 'black', $fontname,$user[1]['name']);
			// imagettftext($im, 14, 0, 59, 600, 'black', $fontname,$user[2]['name']);
			// imagettftext($im, 14, 0, 59, 700, 'black', $fontname,$user[3]['name']);


		// foreach ($user as $value){
		// 	// center the text in our image - returns the x value
		// 	$x = center_text($value['name'], $value['font-size']);
		// 	imagettftext($im, $value['font-size'], 0, 59, $y+$i, $color[$value['color']], $fontname,$value['name']);
		// 	// add 32px to the line height for the next text block
		// 	$i = $i+25;	
			
		// }

			// create the image
			imagejpeg($im, $file, $quality);
			
	//}
						
		return $file;	
}

function center_text($string, $font_size){

			global $fontname;

			$image_width = 800;
			$dimensions = imagettfbbox($font_size, 0, $fontname, $string);
			
			return ceil(($image_width - $dimensions[4]) / 2);				
}



	$user ="";	
		
	if(count($error)==0){
		
	$user = array(
	
		array(
			'name'=> $_POST['tasaventa'], 
			'font-size'=>'15',
			'color'=>'black'),
			
		array(
			'name'=> $_POST['tasacompra'],
			'font-size'=>'11',
			'color'=>'black'),

		array(
			'name'=> $_POST['tasagc'],
			'font-size'=>'11',
			'color'=>'black')
			
	);		
		
	}
		
	

// run the script to create the image
$filename = create_image($user);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Generador de TDC para verificaicon y otros. APPBB.co</title>
<link href="../style.css" rel="stylesheet" type="text/css" />

<style>
input{
	border:1px solid #ccc;
	padding:8px;
	font-size:14px;
	width:300px;
	}
	
.submit{
	width:110px;
	background-color:#FF6;
	padding:3px;
	border:1px solid #FC0;
	margin-top:20px;}	

</style>

</head>

<body>



<img src="<?=$filename;?>?id=<?=rand(0,1292938);?>" width="500" height="500"/><br/><br/>

<ul>
<?php if(isset($error)){
	
	foreach($error as $errors){
		
		echo '<li>'.$errors.'</li>';
			
	}
	
	
}?>
</ul>

<div class="dynamic-form">
<form action="https://www.appbb.co/template-sender/generarTDC/tasa.php" method="post">

<table>
	<tr>
		<td><label>Tasa Venta</label></td>
		<td><input type="text" value="<?php if(isset($_POST['tasaventa'])){echo $_POST['number'];}?>" name="tasaventa" maxlength="25" placeholder="number"><br/></td>
	</tr>

	<tr>
		<td><label>Tasa Compra</label></td>
		<td><input type="text" value="<?php if(isset($_POST['tasacompra'])){echo $_POST['valid'];}?>" name="tasacompra" placeholder="valid until"><br/></td>
	</tr>

	<tr>
		<td><label>Tasa compra GC</label></td>
		<td><input type="text" value="<?php if(isset($_POST['tasagc'])){echo $_POST['ccv2'];}?>" name="tasagc" placeholder="ccv2"><br/></td>
	</tr>	
	<tr><td><input name="submit" type="submit" class="btn btn-primary" value="Generar TDC" /></td></tr>
	<tr><td><a href="https://www.appbb.co/template-sender/">Volver al Template Sender</a></td></tr>

</form>

</table>
</div>



<?php include '../includes/footer.php';?>

</body>
</html>
