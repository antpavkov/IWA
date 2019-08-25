<?php include("header.php"); ?>
<?php include("konekcija.php"); ?>
				<div id="main">
					<div id="content">
						<div id="box1">
							<h2>
								<strong>Vozila</strong>
							</h2>
							<h2>Popis vozila</h2>
            
					<?php
					$spoj = SpojiNaBazu();
					$upit = "select * from vozilo";
					if($aktivni_korisnik_tip==2 || $aktivni_korisnik_tip==1){
						$upit.=" where korisnik_id = ".$aktivni_korisnik_id;
					}
					
					$obradi = ObradiUpit($upit);
					
					$podaci = mysqli_num_rows($obradi);
					
					$brojstrana = ceil($podaci/$velstr);
					
					
					$upit = "select * from vozilo";
					if($aktivni_korisnik_tip==2 || $aktivni_korisnik_tip==1){
					$upit.=" where korisnik_id = ".$aktivni_korisnik_id;
					}
					$upit.=" limit ".$velstr;
					if(isset($_GET['str'])){		
						$upit.=" offset ".(($_GET['str']-1)*$velstr);
						}
					$obradi = ObradiUpit($upit);
					echo "<table id=\"tablica\">";
					echo "<tr>";
					echo "<th>Registracija</th><th>Marka</th><th>Tip</th><th>Mogućnosti</th>";
					echo "</tr>";
					while(list($idvoz,$vlasnik,$reg,$marka,$tip)=mysqli_fetch_array($obradi)){
					$prekpovozilu="<a title='Klikni da pogledaš prekršaje' href='prekrsaji.php?vozilo_id=$idvoz'>Prekršaji</a>";
					$azurvozilo="<a title='' href='vozilo.php?azurvozilo=$idvoz'>Ažuriraj vozilo</a>";
					echo "<tr>";
					echo "<td>$reg</td><td>$marka</td><td>$tip</td><td>$prekpovozilu | $azurvozilo</td>";
					echo "</tr>";							
					}
					echo "<tr>";
					echo "<td colspan='4' class='last'>Stranice:";
					for($str=1;$str<=$brojstrana;$str++){
						$strlink="<a href='vozila.php?str=$str'>$str</a>";	
						if(isset($_GET['str'])){
							if($_GET['str'] == $str){
							$strlink="<strong><mark><a href='vozila.php?str=$str'>$str</a></mark></strong>";	
							}
						}
						
						echo $strlink." ";
					}
					echo "</td>";
					echo "</tr>";
					echo "</table>";
					
					echo "<p><a href='vozilo.php?novo=1'>Dodaj novo vozilo</a></p>";
					$zatvori = ZatvoriKonekciju();
					?>
  
  
						</div>
						<br class="clear" />
					</div>
					<br class="clear" />
				</div>
<?php include("footer.php"); ?>				