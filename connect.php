<?php
$connection = mysqli_connect('localhost', 'appbb156_loginad', '!$r@el123');
if(!$connection){
	die("Database Connection Failed" . mysqli_error($connection));
}
$select_db = mysqli_select_db($connection, 'appbb156_loginadmints');
if(!$select_db){
	die("Database Selection Failed" . mysqli_error($connection));
}
?>