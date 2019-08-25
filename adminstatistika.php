<?php include("header.php"); ?>
<?php include("konekcija.php"); ?>
				<div id="main">
					<div id="content">
						<div id="box1">
							<h2>
								<strong>Pretraga prekršaja</strong>
							</h2>
						
					<form name="pretragaadmin" id="pretragaadmin" method="GET" action="adminstatistika.php">
					<table id="tableform">
					<tr>
					<td>Datum od:</td><td><input type="text" name="datum_od" id="datum_od" value=""></td>
					</tr>
					<tr>
					<td>Datum do:</td><td><input type="text" name="datum_do" id="datum_do" value=""></td>
					</tr>
					<tr>
					<td>Tip pretrage:</td>
					<td>
					<br><input type="radio" name="tippretrage" id="tippretrage" value="ukupno" checked> Ukupno
					<br><input type="radio" name="tippretrage" id="tippretrage" value="top20"> Top 20
					</td>
					</tr>
					<tr>
					<td colspan="2"><input type="submit" name="pretragaForma" id="pretragaForma" value="Pretraži"></td>
					</tr>					
					</table>					
					</form>
					<p>&nbsp;</p>
            
					<?php
					$spoj = SpojiNaBazu();
					
					if(isset($_GET["tippretrage"])){
						
						if(empty($_GET["datum_od"]) || empty($_GET["datum_do"])){
							
							return false;
						}
						
						$datum_1 = $_GET["datum_od"];
						$datum_2 = $_GET["datum_do"];
						
						$datum_od = date("Y-m-d",strtotime($datum_1));
						$datum_do = date("Y-m-d",strtotime($datum_2));
						
						
						if($_GET["tippretrage"]=="ukupno"){
							
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
						on p.vozilo_id = v.vozilo_id where p.datum_prekrsaja between '$datum_od' and '$datum_do'";

										
					$obradi = ObradiUpit($upit);
					
					$podaci = mysqli_num_rows($obradi);	
					echo "<br>Ukupno prekršaja: ".$podaci;
					$brojstrana = ceil($podaci/$velstr);
					
					$upit.=" limit ".$velstr;
					if(isset($_GET['str'])){		
						$upit.=" offset ".(($_GET['str']-1)*$velstr);
					}
					$obradi = ObradiUpit($upit);
					echo "<p><strong>Rezultati pretrage:</strong></p>";
					echo "<table id=\"tablica\">";
					echo "<tr>";
					echo "<th>Kategorija</th><th>Vozilo</th><th>Prekršaj</th><th>Kazna</th><th>Status</th>";
					echo "<th>Datum i vrijeme prekršaja</th><th>Datum i vrijeme plaćanja</th><th>Slika</th><th>Video</th><th>Mogućnosti</th>";
					echo "</tr>";
					while(list($katid,$katnaziv,$vozid,$vlasnik,$vozreg,$prekid,$preknaziv,$prekopis,$prekstatus,$prekkazna,$prekdp,$prekvp,$prekdpl,$prekvpl,$prekslika,$prekvideo)=mysqli_fetch_array($obradi)){
					$prekdp=date("d.m.Y",strtotime($prekdp));
					$prekdpl=date("d.m.Y",strtotime($prekdpl));

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

					$link = "<a href='prekrsaj.php?azurirajprekrsaj=$prekid'>Ažuriraj</a>";

					echo $link;
					echo "</td>";
					echo "</tr>";							
					}
					echo "<tr>";
					echo "<td colspan='10' class='last'>Stranice:";
					for($str=1;$str<=$brojstrana;$str++){
						$strlink="<a href='adminstatistika.php?str=$str";
						if(isset($_GET["tippretrage"]) && $_GET["tippretrage"]=="ukupno"){
								$strlink.="&datum_od=".$datum_1."&datum_do=".$datum_2."&tippretrage=ukupno";
						}
						$strlink.="'>$str</a>";	
						if(isset($_GET['str'])){

							if($_GET['str'] == $str){
							$strlink="<strong><mark><a href='adminstatistika.php?str=$str";
							if(isset($_GET["tippretrage"]) && $_GET["tippretrage"]=="ukupno"){
								$strlink.="&datum_od=".$datum_1."&datum_do=".$datum_2."&tippretrage=ukupno";
							}
							$strlink.="'>$str</a></mark></strong>";	
							}
						}
						
						echo $strlink." ";
					}
					echo "</td>";
					echo "</tr>";
					echo "</table>";
					}
						
						if($_GET["tippretrage"]=="top20"){
							
							$upit = "select
								kor.ime,
								kor.prezime,
								count(kor.korisnik_id)
								from prekrsaj p
								inner join vozilo v
								on p.vozilo_id = v.vozilo_id
								inner join korisnik kor
								on kor.korisnik_id = v.korisnik_id
								where p.datum_prekrsaja between '$datum_od' and '$datum_do'
								group by kor.korisnik_id order by count(kor.korisnik_id) desc limit 20";
								
							$obradi=ObradiUpit($upit);
							echo "<p><strong>Rezultati pretrage:</strong></p>";
							echo "<table id=\"tablica\">";
							echo "<tr>";
							echo "<th>Korisnik</th><th>Broj prekršaja</th>";
							echo "</tr>";
									
							while(list($korime,$korprezime,$brojprek)=mysqli_fetch_array($obradi)){
							echo "<tr>";
							echo "<td>$korime $korprezime</td><td>$brojprek</td>";
							echo "</tr>";									
							}
							
							echo "</table>";
						}
						
						
					}
					
					$zatvori = ZatvoriKonekciju();
					?>
  
  
						</div>
						<br class="clear" />
					</div>
					<br class="clear" />
				</div>
<?php include("footer.php"); ?>				