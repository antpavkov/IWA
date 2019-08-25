<?php include("header.php"); ?>
<?php include("konekcija.php"); ?>
				<div id="main">
					<div id="content">
						<div id="box1">
							<h2>
								<strong>Korisnici</strong>
							</h2>
							<h2>Administracija korisnika</h2>
		  
		  <?php
	  $spoj = SpojiNaBazu();	
	
	if(isset($_POST['KorisnikPost'])) {
		if (isset($_POST['tip'])) {
			$tip = $_POST['tip'];
		} else  {
			$tip = 2;
		}	
		
		$kor_ime = $_POST['kor_ime'];
				
		$ime = $_POST['ime'];
		$prezime = $_POST['prezime'];
		$lozinka = $_POST['lozinka'];

		$email = $_POST['email'];
		
		
		$postojeca = $_POST['slikahidden'];
		
		$mjesto = "korisnici/";	

		
		
		if(isset($_POST["slika"])){
		
			$ime_dat = basename($_FILES['slika']['name']);
			if($ime_dat != ""){
			$slika = $mjesto.$ime_dat;	
			$stavi = move_uploaded_file($_FILES['slika']['tmp_name'],$slika);
			}
			
		}
		else
		{

				if($postojeca != ""){
					$slika = $postojeca;
				}
				else
				{
					$slika = "korisnici/nophoto.jpg";
				}
				
		}
		
		
		$id = $_POST['novi'];
		
		if ($id == 0) {
		
			$upit = "INSERT INTO korisnik 
			(tip_id, korisnicko_ime, lozinka, ime, prezime, email, slika)
			VALUES
			($tip, '$kor_ime', '$lozinka', '$ime', '$prezime', '$email', '$slika');
			";
		} else {
			$upit = "UPDATE korisnik SET 				 
				ime='$ime',
				prezime='$prezime',
				lozinka='$lozinka',
				email = '$email',
				tip_id = '$tip',
				slika = '$slika'
				WHERE korisnik_id = ".$id;
		}		
		
		$obradi=ObradiUpit($upit);
		header("Location: korisnici.php");
	
	}
	
	if(isset($_GET['korisnik'])) {
		$id = $_GET['korisnik'];
		if ($aktivni_korisnik_tip==2) {
			$id = $_SESSION["aktivni_korisnik_id"]; 
		}
		$upit = "SELECT * FROM korisnik WHERE korisnik_id='$id'";
		
		
		$obradi=ObradiUpit($upit);
		list($id, $tip, $kor_ime,$lozinka,$ime,$prezime,$email, $slika) = 
		mysqli_fetch_row($obradi);
		
		
	} else {
		$kor_ime = "";
		$ime = "";
		$tip = 2;
		$prezime = "";
		$lozinka = "";
		$email = "";
		$slika = "";
	}
	?>
	
	<div id="glavniprikaz">
	<div id="lijevi">
		<form method="post" action="korisnik.php" id="korisnik" enctype="multipart/form-data" onsubmit="return ProvjeriKorisnika(this)">
			<input type="hidden" name="novi" id="novi" value="<?php echo $id?>"/>
			<input type="hidden" name="slikahidden" id="slikahidden" value="<?php echo $slika?>"/>
			
			<table id="tableform">
				<tr>
					 <td><label id="lblkor_ime" for="kor_ime">Korisničko ime:</label></td>
					 <td><input type="text" name="kor_ime" id="kor_ime"
						<?php 
							if (isset($id)) {
								echo "readonly='readonly'";
							}	?>
						
						value="<?php echo $kor_ime; ?>"/></td>
				</tr>
				
				<tr>
					 <td><label id="lblime" for="ime">Ime:</label></td>
					 <td><input type="text" name="ime" id="ime" value="<?php echo $ime?>"/></td>
				</tr>
				
				<tr>
					 <td><label id="lblprezime" for="prezime">Prezime:</label></td>
					 <td><input type="text" name="prezime" id="prezime" value="<?php echo $prezime?>"/></td>
				</tr>
				
				<tr>
					 <td><label id="lbllozinka" for="lozinka" >Lozinka:</label></td>
					 <td><input type="text" name="lozinka" id="lozinka" value="<?php echo $lozinka?>"/></td>
				</tr>
				<tr>
					 <td>
					<label for="tipkorisnik">Tip korisnika:</label>
					</td>
					 <td>
					<select name="tip" id="tip">
					<option value="odb">Odaberi:</option>
					<?php
					$upit = "SELECT tip_id, naziv FROM tip_korisnika";
					$obradi=ObradiUpit($upit);
					while(list($idtip,$nazivtip)=mysqli_fetch_row($obradi)){
						echo "<option value='$idtip'";
						if($idtip==$tip){
							echo " selected";
						}
						echo ">$nazivtip</option>";
					}
					?>
					
					</select>
					</td>
				</tr>	
				<tr>
					 <td><label id="lblemail" for="email">email:</label></td>
					 <td><input type="text" name="email" id="email" value="<?php echo $email?>"/></td>
				</tr>
				
				<tr>
					 <td><label for="slika">Slika:</label></td>
					 <td><input type="file" name="slika" id="slika" /></td>
				</tr>
				<tr>
					 <td colspan="2"><input class="submit" type="submit" name="KorisnikPost" value="Pošalji"/></td>
				</tr>		
			</table>
		</form>	
			</div>
			<div id="desni">
			
			</div>
			</div>
<?php
$zatvori = ZatvoriKonekciju();
?>
						</div>
						<br class="clear" />
					</div>
					<br class="clear" />
				</div>
<?php include("footer.php"); ?>		