<?php

if(session_id()=="")
	session_start();


if(isset($_SESSION["aktivni_korisnik"])){
	session_destroy();
	
	header("Location: index.php");
}

?>