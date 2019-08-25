<?php include("header.php"); ?>
<?php include("konekcija.php"); ?>
				<div id="main">
					<div id="content">
						<div id="box1">
							<h2>
								<strong>Korisnici</strong>
							</h2>
							<h2>Popis korisnika</h2>
		  <?php
	  $spoj = SpojiNaBazu();
	 
	 $kolone = 7;
	$upit = "SELECT count(*) FROM korisnik";

	$obradi=ObradiUpit($upit);	
	$red = mysqli_fetch_row($obradi);
	$broj_redaka = $red[0];
	
	$broj_str = ceil($broj_redaka / $velstr);
	
	$upit = "SELECT * FROM korisnik order by korisnik_id LIMIT " . $velstr;
	
	if (isset($_GET['str'])){
		$upit = $upit . " OFFSET " . (($_GET['str'] - 1) * $velstr);
		$aktivna = $_GET['str'];
	} else {
		$aktivna = 1;
	}
	

	$obradi=ObradiUpit($upit);
	echo "<table id='tablica'>";
	echo "<tr>
		 <th>Korisničko ime</th>
		 <th>Ime</th>";
	echo " <th>Prezime</th>
	<th>E-mail</th>
	<th>Lozinka</th>		 
		 <th>Slika</th>
		 <th>Akcija</th>
	</tr>";
	while(list($id, $tip, $kor_ime,$lozinka,$ime,$prezime,$email, $slika) = 
		mysqli_fetch_row($obradi)) {
				
		echo "<tr  >
			 <td>$kor_ime</td>
			 <td>$ime</td>";
		
			
		
		echo " <td>" .  (empty($prezime) ? "&nbsp;" : "$prezime") . "</td>
			 <td>" .  (empty($email) ? "&nbsp;" : "$email") . "</td>";
		echo "<td>$lozinka</td>";
		echo "<td><img src='$slika' width='100px' height='120px'></td>";
		if ($aktivni_korisnik_tip==0) {
			echo " <td><a  href='korisnik.php?korisnik=$id'>Uredi</a></td>";
		}
		echo	"</tr>";
	}

		echo "<tr>";
			echo " <td colspan='$kolone'  >Stranice: ";
			if ($aktivna != 1) { 
			$prethodna = $aktivna - 1;
			echo "<a href=\"korisnici.php?str=" .$prethodna . "\">&lt;</a>";	
			}
			for ($i = 1; $i <= $broj_str; $i++) {
			echo "<a ";
			if ($aktivna == $i) {
				$glavnastr="<mark>$i</mark>";
			}
			else
			{
				$glavnastr = $i;
			}
			echo "' href=\"korisnici.php?str=" .$i . "\"> $glavnastr </a>";
			}
			if ($aktivna < $broj_str) {
			$sljedeca = $aktivna + 1;
			echo "<a href=\"korisnici.php?str=" .$sljedeca . "\">&gt;</a>";	
			}
			echo "</td>";
			echo "</tr>";
			echo "</table>";
	
	if ($aktivni_korisnik_tip==0) {
		echo '<p><a href="korisnik.php">Dodaj korisnika</a></p>';
	} else if(isset($_SESSION["aktivni_korisnik_id"])) {
		echo '<a href="korisnik.php?korisnik=' . $_SESSION["aktivni_korisnik_id"] . '">Uredi moje podatke</a>';
	}

$zatvori = ZatvoriKonekciju();
		  echo "<p><a href='javascript:history.back(-1)'>Natrag</a></p>";
?>
						</div>
						<br class="clear" />
					</div>
					<br class="clear" />
				</div>
<?php include("footer.php"); ?>	