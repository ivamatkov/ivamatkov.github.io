<?php
$serverBP = 'localhost';
$bazaBP = 'iwa_2016_vz_projekt';
$korisnikBP = 'iwa_2016';
$lozinkaBP = 'foi2016';
$konekcijaBP = "";

function otvoriBP(){
    global $serverBP;
    global $bazaBP;
    global $korisnikBP;
    global $lozinkaBP;
    global $konekcijaBP;

    $konekcijaBP = mysqli_connect($serverBP, $korisnikBP, $lozinkaBP, $bazaBP);
    $konekcijaBP->set_charset("utf8");
}

function izvrsiBP($upitBP){
    global $konekcijaBP;

    return mysqli_query($konekcijaBP, $upitBP);
}

function zatvoriBP(){
    global $konekcijaBP;

    mysqli_close($konekcijaBP);
}

?>