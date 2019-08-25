<?php include("header.php"); ?>
<?php include("konekcija.php"); ?>
				<div id="main">
				<?php 
				if(isset($_POST["korisnickoime"])){
					
					
					$korime=$_POST["korisnickoime"];
					$lozinka=$_POST["lozinka"];

					SpojiNaBazu();
					
					$upit = "select * from korisnik where korisnicko_ime = '$korime' and lozinka = '$lozinka'";

					$obradi = ObradiUpit($upit);
					
					
					if(mysqli_num_rows($obradi)>0){
						
						list($id,$tip,$korisnik,$sifra,$ime,$prezime,$email,$slika)=mysqli_fetch_array($obradi);
						
						$_SESSION['aktivni_korisnik']=$korisnik;
						$_SESSION['aktivni_korisnik_ime']=$ime." ".$prezime;
						$_SESSION['aktivni_korisnik_tip']=$tip;
						$_SESSION["aktivni_korisnik_id"]=$id;
					}
					else
					{
						header("Location: prijava.php");
						return false;
					}
					
					header("Location: index.php");
					
				}
				
				?>
					<div id="content">
						<div id="box1">
							<h2>
								<strong>Prijava korisnika</strong>
							</h2>
							
							<form action="prijava.php" method="POST">
							<table id="tableform">
							<tr>
							<td>Korisničko ime:</td><td><input type="text" name="korisnickoime" id="korisnickoime"></td>
							</tr>
							<tr>
							<td>Lozinka:</td><td><input type="password" name="lozinka" id="lozinka"></td>
							</tr>
							<tr>
							<td colspan="2"><input type="submit" value="Prijavi se"></td>
							</tr>
							</table>
							</form>
							
						</div>
						<br class="clear" />
					</div>
					<br class="clear" />
				</div>
<?php include("footer.php"); ?>				