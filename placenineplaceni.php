<?php include("header.php"); ?>
<?php include("konekcija.php"); ?>
				<div id="main">
					<div id="content">
						<div id="box1">
							<h2>
								<strong>Prekršaji</strong>
							</h2>
							<h2>Plaćeni i neplaćeni prekršaji po korisniku</h2>
            
					<?php
					$spoj = SpojiNaBazu();
					$upit = "select
							kor.korisnik_id,
							kor.ime,
							kor.prezime,
							p.`status`
							from prekrsaj p
							inner join vozilo v
							on p.vozilo_id = v.vozilo_id
							inner join korisnik kor
							on kor.korisnik_id = v.korisnik_id";
							if($aktivni_korisnik_tip==1){
							$upit .= " where p.kategorija_id in (select kategorija_id from kategorija where moderator_id = ".$aktivni_korisnik_id.")";
							}
					$obradi = ObradiUpit($upit);
					
					$podaci = mysqli_num_rows($obradi);
					
					$brojstrana = ceil($podaci/$velstr);
					
					
					$upit .= " limit ".$velstr;
					if(isset($_GET['str'])){		
						$upit.=" offset ".(($_GET['str']-1)*$velstr);
						}
					$obradi = ObradiUpit($upit);
					echo "<table id=\"tablica\">";
					echo "<tr>";
					echo "<th>Korisnik</th><th>Broj plaćenih</th><th>Broj neplaćenih</th>";
					echo "</tr>";
					while(list($korid,$korime,$korprezime)=mysqli_fetch_array($obradi)){
					$plaćenih = BrojPrekrsajaPoStatusu($korid,'P');
					$neplaćenih = BrojPrekrsajaPoStatusu($korid,'N');
					echo "<tr>";
					echo "<td>$korime $korprezime</td><td>$plaćenih</td><td>$neplaćenih</td>";
					echo "</tr>";							
					}
					echo "<tr>";
					echo "<td colspan='3' class='last'>Stranice:";
					for($str=1;$str<=$brojstrana;$str++){
						$strlink="<a href='placenineplaceni.php?str=$str'>$str</a>";	
						if(isset($_GET['str'])){
							if($_GET['str'] == $str){
							$strlink="<strong><mark><a href='placenineplaceni.php?str=$str'>$str</a></mark></strong>";	
							}
						}
						
						echo $strlink." ";
					}
					echo "</td>";
					echo "</tr>";
					echo "</table>";
					
					$zatvori = ZatvoriKonekciju();
					
					function BrojPrekrsajaPoStatusu($korisnik,$status){
						global $aktivni_korisnik_id, $aktivni_korisnik_tip;
						$upit = "select
							kor.ime,
							kor.prezime,
							p.`status`
							from prekrsaj p
							inner join vozilo v
							on p.vozilo_id = v.vozilo_id
							inner join korisnik kor
							on kor.korisnik_id = v.korisnik_id";
							if($aktivni_korisnik_tip==1){
							$upit .= " where p.kategorija_id in (select kategorija_id from kategorija where moderator_id = ".$aktivni_korisnik_id.")";
							}
					   $upit .= " and kor.korisnik_id=".$korisnik." and p.`status` = '$status'";
						
						$obradi=ObradiUpit($upit);
						$brojredova = mysqli_num_rows($obradi);
						
						return $brojredova;
					}
					?>
  
  
						</div>
						<br class="clear" />
					</div>
					<br class="clear" />
				</div>
<?php include("footer.php"); ?>				