<?php include("header.php"); ?>
<?php include("konekcija.php"); ?>
				<div id="main">
					<div id="content">
						<div id="box1">
							<h2>
								<strong>Vozilo</strong>
							</h2>
							<h2>Administracija vozila</h2>
            
					<?php
					$spoj = SpojiNaBazu();
					
					
					if(isset($_POST["VoziloForma"])){
						
						$idvoz=$_POST["voziloid"];
						$registracija=$_POST["registracija"];
						$marka=$_POST["marka"];
						$tip=$_POST["tip"];
						
						if($idvoz==0){
							$upit = "insert into vozilo values ('','$aktivni_korisnik_id','$registracija','$marka','$tip')";
						}
						else
						{
							$upit = "update vozilo set registracija='$registracija', marka_vozila='$marka',tip_vozila='$tip' where vozilo_id=".$idvoz;
						}
						
						$obradi = ObradiUpit($upit);
						
						header("Location: vozila.php");
						
					}
					
					if(isset($_GET["novo"]) || isset($_GET["azurvozilo"])){
						
						if(isset($_GET["azurvozilo"])){
							
							$upit = "select * from vozilo where vozilo_id = ".$_GET["azurvozilo"];
							$obradi = ObradiUpit($upit);
							
							list($idvoz,$idvlasnik,$registracija,$marka,$tip)=mysqli_fetch_array($obradi);
							
						}
						else
						{
							$idvoz=0;
							$idvlasnik=0;
							$registracija="";
							$marka="";
							$tip="";
						}
					
					?>
					<div id="glavniprikaz">
					<div id="lijevi">
					<form name="vozilo" id="vozilo" method="POST" action="vozilo.php" onsubmit="return ProvjeriVozilo(this)">
					<input type="hidden" name="voziloid" id="voziloid" value="<?php echo $idvoz; ?>">
					<table id="tableform">
					<tr>
					<td>Registracija:</td><td><input type="text" name="registracija" id="registracija" value="<?php echo $registracija; ?>"></td>
					</tr>
					<tr>
					<td>Marka:</td><td><input type="text" name="marka" id="marka" value="<?php echo $marka; ?>"></td>
					</tr>
					<tr>
					<td>Tip:</td><td><input type="text" name="tip" id="tip" value="<?php echo $tip; ?>"></td>
					</tr>					
					<tr>
					<td colspan="2"><input type="submit" name="VoziloForma" id="VoziloForma" value="Spremi"></td>
					</tr>					
					</table>					
					</form>
					</div>
					<div id="desni">
					
					</div>
					
					</div>
					<?php

					}
					
					echo "<p><a href=\"javascript:window.history.back()\">Natrag</a></p>";
					$zatvori = ZatvoriKonekciju();
					?>
  
  
						</div>
						<br class="clear" />
					</div>
					<br class="clear" />
				</div>
<?php include("footer.php"); ?>				