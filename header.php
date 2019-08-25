<?php
ob_start();
	if(session_id()==""){
		session_start();
	}

	$aktivni_korisnik=0;
	$aktivni_korisnik_tip=-1;
	$aktivni_korisnik_id=0;		

	if(isset($_SESSION['aktivni_korisnik'])){
		$aktivni_korisnik=$_SESSION['aktivni_korisnik'];
		$aktivni_korisnik_ime=$_SESSION['aktivni_korisnik_ime'];
		$aktivni_korisnik_tip=$_SESSION['aktivni_korisnik_tip'];
		$aktivni_korisnik_id=$_SESSION["aktivni_korisnik_id"];
	}	
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>ePrekršaji</title>
        <link href="http://fonts.googleapis.com/css?family=PT+Sans+Narrow" rel="stylesheet" type="text/css" />
        <link href="http://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script type="text/javascript">
		
		function ProvjeriVozilo(forma){
			
			
			var greske="";
			var kolikogresaka=0;
			var naslov = "<h1>Popis svih grešaka</h1>";
			greske+=naslov;
			
			var reg = document.getElementById("registracija");
			if(reg.value==""){
				greske+="<br>Registracija je prazna!";
				kolikogresaka++;
			}
			
			var marka = document.getElementById("marka");
			if(marka.value==""){
				greske+="<br>Marka vozila je prazna!";
				kolikogresaka++;
			}
			
			var tip = document.getElementById("tip");
			if(tip.value==""){
				greske+="<br>Tip vozila je prazan!";
				kolikogresaka++;
			}
			
			
			if(kolikogresaka!=0){
				
				document.getElementById("desni").innerHTML=greske;
				return false;
			}
			
			return true;
		}
		
		function ProvjeriPrekrsaj(forma){
			
			
			var greske="";
			var kolikogresaka=0;
			var naslov = "<h1>Popis svih grešaka</h1>";
			greske+=naslov;
			
			var naziv = document.getElementById("naziv");
			if(naziv.value==""){
				greske+="<br>Naziv je prazan!";
				kolikogresaka++;
			}
			
			var opis = document.getElementById("opis");
			if(opis.value==""){
				greske+="<br>Opis je prazan!";
				kolikogresaka++;
			}
			
			var iznos = document.getElementById("iznos");
			if(iznos.value==""){
				greske+="<br>Iznos je prazan!";
				kolikogresaka++;
			}
			
			var datum = document.getElementById("datum");
			if(datum.value==""){
				greske+="<br>Datum je prazan!";
				kolikogresaka++;
			}
			
			var datval = /(0[1-9]|[1-2][0-9]|3[0-1])+\.(0[1-9]|1[0-2])+\.[0-9]{4}/;
			if(datval.test(datum.value) == false) {
			greske+="<br>Datum mora biti dd.mm.gggg";
			kolikogresaka++;
			}

			var vrijeme = document.getElementById("vrijeme");
			if(vrijeme.value==""){
				greske+="<br>Vrijeme je prazno!";
				kolikogresaka++;
			}
		
			var vrval = /^([01][1-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/;
			
			if(vrval.test(vrijeme.value) == false) {
			greske+="<br>Vrijeme mora biti HH:mm:ss";
			kolikogresaka++;
			}
			
			var url = document.getElementById("url");
			if(url.value==""){
				greske+="<br>Url je prazan!";
				kolikogresaka++;
			}
			
			
			if(kolikogresaka!=0){
				
				document.getElementById("desni").innerHTML=greske;
				return false;
			}
			
			return true;
		}
		
		function ProvjeriPlacanje(forma){
			
			
			var greske="";
			var kolikogresaka=0;
			var naslov = "<h1>Popis svih grešaka</h1>";
			greske+=naslov;
						
			var datum = document.getElementById("datum");
			if(datum.value==""){
				greske+="<br>Datum je prazan!";
				kolikogresaka++;
			}
			
			var datval = /(0[1-9]|[1-2][0-9]|3[0-1])+\.(0[1-9]|1[0-2])+\.[0-9]{4}/;
			if(datval.test(datum.value) == false) {
			greske+="<br>Datum mora biti dd.mm.gggg";
			kolikogresaka++;
			}

			var vrijeme = document.getElementById("vrijeme");
			if(vrijeme.value==""){
				greske+="<br>Vrijeme je prazno!";
				kolikogresaka++;
			}
		
			var vrval = /^([01][1-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/;
			
			if(vrval.test(vrijeme.value) == false) {
			greske+="<br>Vrijeme mora biti HH:mm:ss";
			kolikogresaka++;
			}
						
			
			if(kolikogresaka!=0){
				
				document.getElementById("desni").innerHTML=greske;
				return false;
			}
			
			return true;
		}
		
		
		function ProvjeriKategoriju(forma){
			
			
			var greske="";
			var kolikogresaka=0;
			var naslov = "<h1>Popis svih grešaka</h1>";
			greske+=naslov;
			
			var naziv = document.getElementById("naziv");
			if(naziv.value==""){
				greske+="<br>Naziv je prazan!";
				kolikogresaka++;
			}
			
			var opis = document.getElementById("opis");
			if(opis.value==""){
				greske+="<br>Opis je prazan!";
				kolikogresaka++;
			}
			
			
			if(kolikogresaka!=0){
				
				document.getElementById("desni").innerHTML=greske;
				return false;
			}
			
			return true;
		}
		
		function ProvjeriKorisnika(forma){
			
			
			var greske="";
			var kolikogresaka=0;
			var naslov = "<h1>Popis svih grešaka</h1>";
			greske+=naslov;
			
			var korime = document.getElementById("kor_ime");
			if(korime.value==""){
				greske+="<br>Korisničko ime je prazno!";
				kolikogresaka++;
				korime.style.backgroundColor="#FA5858";
			}
			
			var ime = document.getElementById("ime");
			if(ime.value==""){
				greske+="<br>Ime je prazno!";
				kolikogresaka++;
				ime.style.backgroundColor="#FA5858";
			}
			
			
			var prezime = document.getElementById("prezime");
			if(prezime.value==""){
				greske+="<br>Prezime je prazno!";
				kolikogresaka++;
				prezime.style.backgroundColor="#FA5858";
			}
			
			var lozinka = document.getElementById("lozinka");
			if(lozinka.value==""){
				greske+="<br>Lozinka je prazna!";
				kolikogresaka++;
				lozinka.style.backgroundColor="#FA5858";
			}
			
			var email = document.getElementById("email");
			if(email.value==""){
				greske+="<br>Email polje je prazno!";
				kolikogresaka++;
				email.style.backgroundColor="#FA5858";
			}
			
			if(kolikogresaka!=0){
				
				document.getElementById("desni").innerHTML=greske;
				return false;
			}
			
			return true;
		}
		
		</script>
    </head>
    <body>
		<div id="bg">
			<div id="outer">
				<div id="header">
					<div id="logo">
						<h1>
							<a href="#">e - Prekršaji</a>
						</h1>
					</div>
					<div id="nav">
						<ul>
							<li class="first active">
								<a href="index.php">Home</a>
							</li>
							<li>
								<a href="kategorije.php">Kategorije</a>
							</li>
							<?php
							switch($aktivni_korisnik_tip){
								
								case 0:
								?>
								<li><a href="korisnici.php">Korisnici</a></li>
								<li><a href="adminstatistika.php">Statistika prekršaja</a></li>
								<li><a href="prekrsaji.php">Prekršaji</a></li>
								<li><a href="vozila.php">Vozila</a></li>
								<?php
								break;
								
								case 1:
								?>
								<li><a href="prekrsaji.php">Prekršaji</a></li>
								<li><a href="vozila.php">Vozila</a></li>
								<?php
								break;
								
								case 2:
								?>
								<li><a href="vozila.php">Vozila</a></li>
								<?php
								break;
								
							}
							?>						
							<li class="last">
							<?php
							if(isset($_SESSION['aktivni_korisnik'])){
							?>
								<a href="odjava.php">Odjava</a>
							<?php
							}
							?>
							</li>
						</ul>
						<br class="clear" />
					</div>
				</div>
				<div id="banner">
					<img src="images/mainlogo.png" width="1124" height="212" alt="" />
				</div>
				<div id="login">
				<?php
				if(isset($_SESSION['aktivni_korisnik'])){
				?>
				<p>Vi ste: <?php echo $_SESSION['aktivni_korisnik']; ?></p>
				<?php
				}
				else
				{
					echo "<p>Niste prijavljeni!<br><a href=\"prijava.php\">Prijava</a></p>";
				}
				?>
				</div>