<?php

$kon=null;
$velstr=5;
$server="localhost";
$korisnik="iwa_2016";
$lozinka="foi2016";
$baza="iwa_2016_zb_projekt";

function SpojiNaBazu(){
	
	global $kon;
	
	$BP_server = 'localhost';
	$BP_bazaPodataka = 'iwa_2016_zb_projekt';
	$BP_korisnik = 'iwa_2016';
	$BP_lozinka = 'foi2016';
	
	$kon = mysqli_connect($BP_server, $BP_korisnik, $BP_lozinka,$BP_bazaPodataka);
	
	if(mysqli_connect_errno()){
		die("Greška pri spajanju: ".mysqli_connect_error());
	}
	
	mysqli_set_charset($kon,"utf8");
}

function ObradiUpit($sql){
	
	global $kon;
	
	$ex = mysqli_query($kon,$sql);
	
	if(!$ex){
		die("Greška u prijavi: ".mysqli_error($kon));
	}
	
	return $ex;
	
}

function ZatvoriKonekciju(){
	
	global $kon;
	if(is_resource($kon)){
		
		mysqli_close($kon);
	}
}

?>