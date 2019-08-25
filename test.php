<?php

$url = parse_url($_SERVER["REQUEST_URI"]);

$data = $url["fragment"];

echo "<br>Podatak: ".$data;

?>