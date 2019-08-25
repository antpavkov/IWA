<?php include("header.php"); ?>
<?php include("konekcija.php"); ?>
				<div id="main">
					<div id="content">
						<div id="box1">
							<h2>
								<strong>Kategorije</strong>
							</h2>
							
            
					<?php
					$spoj = SpojiNaBazu();
					$upit = "select
						kat.kategorija_id,
						kat.moderator_id,
						kat.naziv,
						kat.opis,
						concat(kor.ime,' ',kor.prezime)
						from kategorija kat
						inner join korisnik kor
						on kat.moderator_id = kor.korisnik_id";
					
					echo "<h2>Popis ";
					if(isset($_GET["mod"])){
						$_SESSION["url"]=$_SERVER["QUERY_STRING"];
						$upit.=" where moderator_id=".$aktivni_korisnik_id;
						echo "mojih";
					}
					echo " kategorija</h2>";
					
					
					$obradi = ObradiUpit($upit);
					
					echo "<ul>";
					while(list($idkat,$moderator,$naziv,$opis,$moderatorime)=mysqli_fetch_array($obradi)){
						$detalji="<a name='$idkat' href='kategorije.php?pogodini=$idkat'>$naziv</a>";
						if($aktivni_korisnik_tip==0){
						$detalji.=" => $opis => <strong><strong>Moderator:</strong></strong> $moderatorime";	
						}
						$azurkat="<a href='kategorija.php?azuriraj=$idkat'>Ažuriraj</a>";
						//$detalji="<a name='$idkat' href='#' onclick=\"IspisKategorija('$idkat')\">$naziv</a>";
						
						if(isset($_GET["pogodini"])){
							
							if($_GET["pogodini"]==$idkat){
								$detalji="<strong>$naziv</strong>";
								if($aktivni_korisnik_tip==0){
								$detalji.=" => $opis => <strong>Moderator:</strong> $moderatorime";	
								}
							}
						}
						
							if(isset($_GET["mod"])){
								$detalji="<strong>$naziv</strong>";
								echo "<li>$detalji => <a href='prekrsaji.php?kategorijamod=$idkat'>Pogledaj prekršaje</a></li>";
							}
							else
							{
								echo "<li>$detalji";
								if($aktivni_korisnik_tip==0){
								echo " => $azurkat";	
								}
								echo "</li>";
							}
						
							if(isset($_GET["pogodini"])){
								if($_GET["pogodini"]==$idkat){
									
									$prekgodine = "select
									year(prek.datum_prekrsaja) as 'godina',
									count(year(prek.datum_prekrsaja)) as 'brojprekrsaja'
									from prekrsaj prek
									where prek.kategorija_id=".$idkat."
									 group by year(prek.datum_prekrsaja)";
									 $obradi2=ObradiUpit($prekgodine);
									 echo "<ul>";
									 while(list($godina,$brprek)=mysqli_fetch_array($obradi2)){
										 echo "<li>Godina: $godina - Broj prekršaja: $brprek</li>";
									 }
									
									
									
									
									echo "</ul>";								
								}
							
							}
						
					}
					echo "</ul>";
					
								if($aktivni_korisnik_tip==0){
								echo "<p><a href='kategorija.php?nova=1'>Dodaj novu kategoriju</a></p>";	
								}
					$zatvori = ZatvoriKonekciju();
					?>
  
  
						</div>
						<br class="clear" />
					</div>
					<br class="clear" />
				</div>
<?php include("footer.php"); ?>				