<?php include("header.php"); ?>
<?php include("konekcija.php"); ?>
				<div id="main">
					<div id="content">
						<div id="box1">
							<h2>
								<strong>Prekršaji</strong>
							</h2>
							<h2>Administracija prekršaja</h2>
            
					<?php
					$spoj = SpojiNaBazu();
					
					if(isset($_POST["PlatiForma"])){
						
						$prekid= $_POST["prekrsajid"];
						$datumpl= $_POST["datum"];
						$datumpl=date("Y-m-d",strtotime($datumpl));
						$vrijemepl= $_POST["vrijeme"];
						
						$upit = "update prekrsaj set status = 'P',datum_placanja='$datumpl',vrijeme_placanja='$vrijemepl' where prekrsaj_id = ".$prekid;
						$obradi=ObradiUpit($upit);
						
						header("Location: prekrsaji.php?vozilo_id=".$_SESSION["voziloid"]);
						
						
					}
					
					if(isset($_GET["platiprekrsaj"])){
							$idprek=$_GET["platiprekrsaj"];
							$iznos=$_GET["iznos"];
							$preknaziv=$_GET["naziv"];
					
					?>
					<div id="glavniprikaz">
					<div id="lijevi">
					<form name="prekrsajplati" id="prekrsajplati" method="POST" action="prekrsaj.php" onsubmit="return ProvjeriPlacanje(this)">
					<input type="hidden" name="prekrsajid" id="prekrsajid" value="<?php echo $idprek; ?>">
					<table id="tableform">
					<tr>
					<td>Prekršaj:</td><td><strong><?php echo $preknaziv; ?></strong></td>
					</tr>
					<tr>
					<td>Datum:</td><td><input type="text" name="datum" id="datum" value="<?php echo date("d.m.Y"); ?>"></td>
					</tr>
					<tr>
					<td>Vrijeme:</td><td><input type="text" name="vrijeme" id="vrijeme" value="<?php echo date("H:i:s"); ?>"></td>
					</tr>
					<tr>
					<td>Iznos:</td><td><input type="text" name="iznos" id="iznos" value="<?php echo $iznos." kn"; ?>" disabled="disabled"></td>
					</tr>					
					<tr>
					<td colspan="2"><input type="submit" name="PlatiForma" id="PlatiForma" value="Plati"></td>
					</tr>					
					</table>					
					</form>
					</div>
					<div id="desni">
					
					</div>
					</div>
					<?php

					}
					
					
					if(isset($_POST["PrekrsajForma"])){
						
						$idprek=$_POST["prekrsajid"];
						$idvoz=$_POST["vozilo"];
						$idkat=$_POST["kategorija"];
						$naziv=$_POST["naziv"];
						$opis=$_POST["opis"];
						$iznos=$_POST["iznos"];
						$datum=$_POST["datum"];
						$datum=date("Y-m-d",strtotime($datum));
						$vrijeme=$_POST["vrijeme"];
						$url=$_POST["url"];
						$video=$_POST["video"];
						
						if($idprek==0){
							$unos="insert into prekrsaj values ('','$idkat','$idvoz','$naziv','$opis','N','$iznos','$datum','$vrijeme','0000-00-00','00:00:00','$url','$video')";
						}
						else
						{
							$unos="update prekrsaj set kategorija_id='$idkat',vozilo_id='$idvoz',naziv='$naziv',opis='$opis',novcana_kazna='$iznos',datum_prekrsaja='$datum',vrijeme_prekrsaja='$vrijeme',slika='$url',video='$video' where prekrsaj_id=".$idprek;
						}
						
						$obradi=ObradiUpit($unos);
						header("Location: prekrsaji.php");
						
					}
					
					if(isset($_GET["novi"]) || isset($_GET["azurirajprekrsaj"])){
						
						if(isset($_GET["azurirajprekrsaj"])){
							
							$upit="select * from prekrsaj where prekrsaj_id=".$_GET["azurirajprekrsaj"];
							$obradi=ObradiUpit($upit);
							
							list($idprek,$kat,$voz,$naz,$op,$stat,$kazna,$datpr,$vrijemepr,$datpl,$vrijemepl,$url,$video)=mysqli_fetch_array($obradi);
							$datpr=date("d.m.Y",strtotime($datpr));
						}
						else
						{
							$idprek=0;
							$kat=0;
							$voz=0;
							$naz="";
							$op="";
							$kazna="";
							$datpr="";
							$vrijemepr="";
							$url="";
							$video="";
						}
						
						?>
						<div id="glavniprikaz">
							<div id="lijevi">
							<form name="prekrsaj" id="prekrsaj" method="POST" action="prekrsaj.php" onsubmit="return ProvjeriPrekrsaj(this)">
							<input type="hidden" name="prekrsajid" id="prekrsajid" value="<?php echo $idprek; ?>">
							<table id="tableform">
							<tr>
							<td>Kategorija:</td>
							<td>
							<select name="kategorija" id="kategorija">
							<?php
							$upit="select kategorija_id, naziv from kategorija";
							if($aktivni_korisnik_tip==1){
								$upit.=" where moderator_id=".$aktivni_korisnik_id;
							}
							$obradi=ObradiUpit($upit);
							while(list($idkat,$nazivkat)=mysqli_fetch_array($obradi)){
								echo "<option value='$idkat'";
								if($kat==$idkat){
									echo " selected";
								}
								echo ">$nazivkat</option>";
							}
							?>
							</select>
							</td>
							</tr>
							<tr>
							<td>Vozilo:</td>
							<td>
							<select name="vozilo" id="vozilo">
							<?php
							$upit="select vozilo_id, registracija from vozilo order by registracija asc";

							$obradi=ObradiUpit($upit);
							while(list($idvoz,$reg)=mysqli_fetch_array($obradi)){
								echo "<option value='$idvoz'";
								if($voz==$idvoz){
									echo " selected";
								}
								echo ">$reg</option>";
							}
							?>
							</select>
							</td>
							</tr>
							<tr>
							<td>Naziv:</td><td><input type="text" name="naziv" id="naziv" value="<?php echo $naz; ?>"></td>
							</tr>
							<tr>
							<td>Opis:</td><td><textarea name="opis" id="opis"><?php echo $op; ?></textarea></td>
							</tr>
							<tr>
							<td>Iznos:</td><td><input type="text" name="iznos" id="iznos" value="<?php echo $kazna; ?>"></td>
							</tr>
							<tr>
							<td>Datum:</td><td><input type="text" name="datum" id="datum" value="<?php echo $datpr; ?>"></td>
							</tr>
							<tr>
							<td>Vrijeme:</td><td><input type="text" name="vrijeme" id="vrijeme" value="<?php echo $vrijemepr; ?>"></td>
							</tr>
							<tr>
							<td>URL:</td><td><input type="text" name="url" id="url" value="<?php echo $url; ?>"></td>
							</tr>
							<tr>
							<td>Video:</td><td><input type="text" name="video" id="video" value="<?php echo $video; ?>"></td>
							</tr>							
							<tr>
							<td colspan="2"><input type="submit" name="PrekrsajForma" id="PrekrsajPlatiForma" value="Evidentiraj"></td>
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