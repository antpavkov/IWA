<?php include("header.php"); ?>
<?php include("konekcija.php"); ?>
				<div id="main">
					<div id="content">
						<div id="box1">
							<h2>
								<strong>Kategorija</strong>
							</h2>
							<h2>Administracija kategorije</h2>
            
					<?php
					$spoj = SpojiNaBazu();
					
					
					if(isset($_POST["KategorijaForma"])){
						
						$idkat=$_POST["kategorijaid"];
						$moderator=$_POST["moderator"];
						$naziv=$_POST["naziv"];
						$opis=$_POST["opis"];
						
						if($idkat==0){
							$upit = "insert into kategorija values ('','$moderator','$naziv','$opis')";
						}
						else
						{
							$upit = "update kategorija set moderator_id='$moderator',naziv='$naziv',opis='$opis' where kategorija_id=".$idkat;
						}
						
						$obradi = ObradiUpit($upit);
						
						header("Location: kategorije.php");
						
					}
					
					if(isset($_GET["nova"]) || isset($_GET["azuriraj"])){
						
						if(isset($_GET["azuriraj"])){
							
							$upit = "select * from kategorija where kategorija_id = ".$_GET["azuriraj"];
							$obradi = ObradiUpit($upit);
							
							list($idkat,$moderator,$naziv,$opis)=mysqli_fetch_array($obradi);
							
						}
						else
						{
							$idkat=0;
							$moderator=0;
							$naziv="";
							$opis="";
						}
					
					?>
					
					
					<div id="glavniprikaz">
					<div id="lijevi">
					<form name="kategorija" id="kategorija" method="POST" action="kategorija.php" onsubmit="return ProvjeriKategoriju(this)">
					<input type="hidden" name="kategorijaid" id="kategorijaid" value="<?php echo $idkat; ?>">
					<table id="tableform">
					<tr>
							<td>Moderator:</td>
							<td>
							<select name="moderator" id="moderator">
							<?php
							$upit="select korisnik_id, ime, prezime from korisnik where tip_id = 1";
							$obradi=ObradiUpit($upit);
							while(list($idkor,$ime,$prezime)=mysqli_fetch_array($obradi)){
								echo "<option value='$idkor'";
								if($moderator==$idkor){
									echo " selected";
								}
								echo ">$ime $prezime</option>";
							}
							?>
							</select>
							</td>
							</tr>
							<tr>
							<td>Naziv:</td><td><input type="text" name="naziv" id="naziv" value="<?php echo $naziv; ?>"></td>
							</tr>
							<tr>
							<td>Opis:</td><td><textarea name="opis" id="opis" rows="4" cols="25"><?php echo $opis; ?></textarea></td>
							</tr>
							<td colspan="2"><input type="submit" name="KategorijaForma" id="KategorijaForma" value="Spremi"></td>
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