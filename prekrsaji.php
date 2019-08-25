<?php include("header.php"); ?>
<?php include("konekcija.php"); ?>
				<div id="main">
					<div id="content">
						<div id="box1">
							<h2>
								<strong>Prekršaji</strong>
							</h2>
							<h2>Popis prekršaja</h2>
            
					<?php
					

					
					$spoj = SpojiNaBazu();
					$upit = "select
						k.kategorija_id,
						k.naziv,
						v.vozilo_id,
						v.korisnik_id,
						v.registracija,
						p.prekrsaj_id,
						p.naziv,
						p.opis,
						p.`status`,
						p.novcana_kazna,
						p.datum_prekrsaja,
						p.vrijeme_prekrsaja,
						p.datum_placanja,
						p.vrijeme_placanja,
						p.slika,
						p.video
						from prekrsaj p
						inner join kategorija k
						on p.kategorija_id = k.kategorija_id
						inner join vozilo v
						on p.vozilo_id = v.vozilo_id";
						
						if($_SERVER["QUERY_STRING"]==""){
						
							if(isset($_SESSION["kategorijamod"])){
								unset($_SESSION["kategorijamod"]);
							}
						}
						
						if(($aktivni_korisnik_tip==1 && !isset($_GET["vozilo_id"]) && $_SERVER["QUERY_STRING"]=="") || ($aktivni_korisnik_tip==1 && isset($_GET['str'])) && !isset($_GET["kategorijamod"])){
							
							$upit.=" where k.kategorija_id in (select kategorija_id from kategorija where moderator_id=".$aktivni_korisnik_id.")";
						}
						
						
						
						
						if(isset($_GET["vozilo_id"]) && ($aktivni_korisnik_tip==2 || $aktivni_korisnik_tip==1)){
							
							$upit.=" where p.vozilo_id = ".$_GET["vozilo_id"];
						}
						
						if(isset($_GET["kategorijamod"]) && isset($_SESSION["url"])){
							$_SESSION["kategorijamod"]=$_GET["kategorijamod"];
							
							$upit.=" where k.kategorija_id = ".$_GET["kategorijamod"];
						}
					
					$obradi = ObradiUpit($upit);
					
					$podaci = mysqli_num_rows($obradi);					
					$brojstrana = ceil($podaci/$velstr);
					
					$upit.=" limit ".$velstr;
					if(isset($_GET['str'])){		
						$upit.=" offset ".(($_GET['str']-1)*$velstr);
					}
					$obradi = ObradiUpit($upit);
					echo "<table id=\"tablica\">";
					echo "<tr>";
					echo "<th>Kategorija</th><th>Vozilo</th><th>Prekršaj</th><th>Kazna</th><th>Status</th>";
					echo "<th>Datum i vrijeme prekršaja</th><th>Datum i vrijeme plaćanja</th><th>Slika</th><th>Video</th><th>Mogućnosti</th>";
					echo "</tr>";
					while(list($katid,$katnaziv,$vozid,$vlasnik,$vozreg,$prekid,$preknaziv,$prekopis,$prekstatus,$prekkazna,$prekdp,$prekvp,$prekdpl,$prekvpl,$prekslika,$prekvideo)=mysqli_fetch_array($obradi)){
					$prekdp=date("d.m.Y",strtotime($prekdp));
					$prekdpl=date("d.m.Y",strtotime($prekdpl));
					//$prekpovozilu="<a title='Klikni da pogledaš prekršaje' href='prekrsaji.php?vozilo_id=$idvoz'>Prekršaji</a>";
					//$azurvozilo="<a title='' href='vozilo.php?vozilo_id=$idvoz'>Ažuriraj vozilo</a>";

					echo "<tr>";
					echo "<td>$katnaziv</td><td>$vozreg</td><td>$preknaziv</td><td>$prekkazna</td>";
					echo "<td>$prekstatus</td><td>$prekdp $prekvp</td><td>$prekdpl $prekvpl</td><td><img src='$prekslika' width='100px' height='94px'></td>";
					echo "<td>";
					if($prekvideo != "" && $prekvideo != null){
					echo "<video width='160' height='120' controls>";
					echo "<source src='$prekvideo' type='video/mp4'>";
					echo "<source src='$prekvideo' type='video/webm'>";
					echo "</video>";
					}
					echo "</td>";
					echo "<td>";
					$link = "";
					if($aktivni_korisnik_tip == 2 || $aktivni_korisnik_tip==1){
						
						if($aktivni_korisnik_tip==1){
							$link = "<a href='prekrsaj.php?azurirajprekrsaj=$prekid'>Ažuriraj</a>";
						}
						
						if($prekstatus=="N"){
							if($vlasnik==$aktivni_korisnik_id){
						$link .= "=> <a href='prekrsaj.php?platiprekrsaj=$prekid&iznos=$prekkazna&naziv=$preknaziv'>Plati</a>";
					    $_SESSION["voziloid"]=$vozid;
							}
						}
						
					}
					else
					{
						$link = "<a href='prekrsaj.php?azurirajprekrsaj=$prekid'>Ažuriraj</a>";
					}
					echo $link;
					echo "</td>";
					echo "</tr>";							
					}
					echo "<tr>";
					echo "<td colspan='10' class='last'>Stranice:";
					for($str=1;$str<=$brojstrana;$str++){
						$strlink="<a href='prekrsaji.php?str=$str";
						if(isset($_SESSION["kategorijamod"])){
							$strlink.="&kategorijamod=".$_SESSION["kategorijamod"];
						}
						if(isset($_GET["vozilo_id"]) && ($aktivni_korisnik_tip==2 || $aktivni_korisnik_tip==1)){
							$strlink.="&vozilo_id=".$_GET["vozilo_id"];
						}
						
						$strlink.="'>$str</a>";	
						if(isset($_GET['str'])){
							if($_GET['str'] == $str){
							$strlink="<strong><mark><a href='prekrsaji.php?str=$str";
								if(isset($_SESSION["kategorijamod"])){
									$strlink.="&kategorijamod=".$_SESSION["kategorijamod"];
									
								}
						if(isset($_GET["vozilo_id"]) && ($aktivni_korisnik_tip==2 || $aktivni_korisnik_tip==1)){
							$strlink.="&vozilo_id=".$_GET["vozilo_id"];
						}
								
							$strlink.="'>$str</a></mark></strong>";	
							}
						}
						
						echo $strlink." ";
					}
					echo "</td>";
					echo "</tr>";
					echo "</table>";
					if($aktivni_korisnik_tip == 0 || $aktivni_korisnik_tip==1){
					echo "<p><a href=\"prekrsaj.php?novi=1\">Evidentiraj novi prekršaj</a></p>";
					echo "<p><a href=\"placenineplaceni.php\">Plaćeni i neplaćeni prekršaji po korisniku</a></p>";
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