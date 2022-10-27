<?php
session_start();

include_once 'connect.php';
if(!isset($_SESSION['username']))
{
    header("Location: login.php");
}

$username = $_SESSION['username'];
// link to the font file no the server
$fontname = 'font/CREDC___.ttf';
// controls the spacing between text
$i=30;
//JPG image quality 0-100
$quality = 90;

function create_image($user){

		global $fontname;	
		global $quality;
		$file = "covers/".md5($user[0]['name'].$user[1]['name'].$user[2]['name']).".jpg";	
		$pedido = $user[4]['name'];
	// if the file already exists dont create it again just serve up the original	
	//if (!file_exists($file)) {	
			if ($_POST['number'][0]==5){
							// define the base image that we lay our text on
			$im = imagecreatefrompng("source_2.png");
				
			}else{
							$im = imagecreatefrompng("visa_base.png");

			}

			
			// setup the text colours
			$color['grey'] = imagecolorallocate($im, 255, 255, 255);
			$color['green'] = imagecolorallocate($im, 55, 189, 102);
			
			// this defines the starting height for the text block
			$y = imagesy($im) - $height - 120;
			 
		// loop through the array and write the text	
		foreach ($user as $value){
			// center the text in our image - returns the x value
			$x = center_text($value['name'], $value['font-size']);
			imagettftext($im, $value['font-size'], 0, 59, $y+$i, $color[$value['color']], $fontname,$value['name']);
			// add 32px to the line height for the next text block
			$i = $i+25;	
			
		}

			// create the image
			imagejpeg($im, $file, $quality);
			
	//}		
						
		return $file;	
}

function center_text($string, $font_size){

			global $fontname;

			$image_width = 400;
			$dimensions = imagettfbbox($font_size, 0, $fontname, $string);
			
			return ceil(($image_width - $dimensions[4]) / 2);				
}



	$user ="";
	
	
	if(isset($_POST['submit'])){
	
	$error = array();
	
		if(strlen($_POST['number'])==0){
			$error[] = 'Please enter a number';
		}
		
		if(strlen($_POST['valid'])==0){
			$error[] = 'Please enter a job title';
		}		

		if(strlen($_POST['ccv2'])==0){
			$error[] = 'Please enter an email address';
		}
		if(strlen($_POST['name'])==0){
			$error[] = 'Please enter an email address';
		}	
		if(strlen($_POST['pedido'])==0){
			$error[] = 'Obligado el pedido';
		}				
		
	if(count($error)==0){
		
	$user = array(
	
		array(
			'name'=> $_POST['number'], 
			'font-size'=>'15',
			'color'=>'grey'),
			
		array(
			'name'=> $_POST['valid'],
			'font-size'=>'11',
			'color'=>'grey'),

		array(
			'name'=> $_POST['ccv2'],
			'font-size'=>'11',
			'color'=>'grey'),
			
		array(
			'name'=> strtoupper($_POST['name']),
			'font-size'=>'14',
			'color'=>'grey'
			),
			
		array(
			'name'=> $_POST['pedido'],
			'font-size'=>'12',
			'color'=>'grey'
			)			
	);		
		
	}
		
	}
	$pedido2=$user[4]['name'];
	
if ($pedido2 != ""){

	$sql2 = "INSERT INTO `logs` (usuario,accion,pedido) VALUES ('$username', 'Creacion de tarjeta de verificacion', '$pedido2')";
	$result = mysqli_query($connection, $sql2);
	
}	
						
// run the script to create the image
$filename = create_image($user);

?>

<?php include "../header.php";?>


<img src="<?=$filename;?>?id=<?=rand(0,1292938);?>" width="500" height="300"/><br/><br/>

<ul>
<?php if(isset($error)){
	
	foreach($error as $errors){
		
		echo '<li>'.$errors.'</li>';
			
	}
	
	
}?>
</ul>

<div class="dynamic-form">
<form action="https://www.appbb.co/template-sender2/generarTDC/" method="post">

<table>
	<tr>
		<td><label>Numero Tarjeta</label></td>
		<td><input type="text" value="<?php if(isset($_POST['number'])){echo $_POST['number'];}?>" name="number" maxlength="25" placeholder="number"><br/></td>
	</tr>

	<tr>
		<td><label>Fecha Vencimeinto (MM/YY)</label></td>
		<td><input type="text" value="<?php if(isset($_POST['valid'])){echo $_POST['valid'];}?>" name="valid" placeholder="valid until"><br/></td>
	</tr>

	<tr>
		<td><label>CVC2/CVC</label></td>
		<td><input type="text" value="<?php if(isset($_POST['ccv2'])){echo $_POST['ccv2'];}?>" name="ccv2" placeholder="ccv2"><br/></td>
	</tr>

	<tr>
		<td><label>Nombre</label></td>
		<td><input type="text" value="<?php if(isset($_POST['name'])){echo $_POST['name'];}?>" name="name" placeholder="Name"><br/></td>
	</tr>	

	<tr>
		<td><label>PEDIDO</label></td>
		<td><input required type="text" value="<?php if(isset($_POST['pedido'])){echo $_POST['pedido'];}?>" name="pedido" placeholder="Pedido"><br/></td>
	</tr>			
	<tr><td><input name="submit" type="submit" class="btn btn-primary" value="Generar TDC" /></td></tr>
	
</form>

</table>
</div>
<?php include "../footer.php"; ?>
