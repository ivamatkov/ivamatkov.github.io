<?php

session_start();
include_once 'konfiguracijaBP.php';
include_once 'navigacija.php';

$porukaKodKreiranjaUredivanjaProizvodaca = "";
$tipKorisnika = isset($_SESSION['tipKorisnika']) ? $_SESSION['tipKorisnika'] : -1;

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['proizvodac'])){
    $proizvodac_id = $_GET['proizvodac'];
    otvoriBP();
    $upitBP = "select * from proizvodac where proizvodac_id=".$proizvodac_id;
    $rezultatBP = izvrsiBP($upitBP);
    $proizvodac = mysqli_fetch_array($rezultatBP);
    zatvoriBP();
}
else {
    $proizvodac_id = 0;
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['kreiraj_uredi_proizvodaca'])){
    otvoriBP();

    if ($_POST['proizvodac_id'] == 0){
        $upitBP = "insert into proizvodac (moderator_id, naziv) values (".$_POST['moderator_id'].", '".$_POST['naziv']."')";
        izvrsiBP($upitBP);
        $porukaKodKreiranjaUredivanjaProizvodaca = "Uspješno ste dodali novog proizvođača!";
    }
    else {
        $upitBP = "update proizvodac set moderator_id=".$_POST['moderator_id'].", naziv='".$_POST['naziv']."' where proizvodac_id=".$_POST['proizvodac_id'];
        izvrsiBP($upitBP);
        $porukaKodKreiranjaUredivanjaProizvodaca = "Uspješno ste ažurirali postojećeg proizvođača!";
    }

    zatvoriBP();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kreiraj/uredi proizvođača</title>
    <link href="aplikacija.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="zaglavlje">
    <h1>NARUČIVANJE RAČUNALA</h1>
</div>
<div id="navigacija">
    <ul>
        <?php
            prikaziNavigaciju($tipKorisnika);
        ?>
    </ul>
</div>
<section>
    <p><h3 style="text-align: center;">Kreiraj/uredi proizvođača</h3></p>
    <div style="width: 100%;">
        <form method="post" action="<?php $_SERVER['SCRIPT_NAME']; ?>">
            <p><?php echo $porukaKodKreiranjaUredivanjaProizvodaca; ?></p>
            <label>Odaberite moderatora</label>
            <select name="moderator_id">
                <?php
                otvoriBP();
                $upitBP = "select * from korisnik where tip_id=1";
                $rezultatBP = izvrsiBP($upitBP);
                zatvoriBP();

                while ($korisnik = mysqli_fetch_array($rezultatBP)){
                    if ($proizvodac_id != 0 && $proizvodac['moderator_id'] == $korisnik['korisnik_id']){
                        echo "<option value='".$korisnik['korisnik_id']."' selected='selected'>".$korisnik['korisnicko_ime']."</option>";
                    }
                    else {
                        echo "<option value='".$korisnik['korisnik_id']."'>".$korisnik['korisnicko_ime']."</option>";
                    }
                }
                ?>
            </select><br/>
            <label>Naziv proizvođača</label>
            <input type="text" name="naziv" required="required" value="<?php if ($proizvodac_id != 0) echo $proizvodac['naziv']; ?>"><br/>
            <input type="hidden" name="proizvodac_id" value="<?php echo $proizvodac_id; ?>">
            <input type="submit" name="kreiraj_uredi_proizvodaca" value="Kreiraj/uredi proizvođača">
        </form>
    </div>
</section>
<div id="podnozje">
    <div style="width: 30%; float: left;">
        Matković Ivan<br/>
        IWA 2016<br/>
    </div>
    <div style="width: 30%; float: right;">
        <a href="mailto:ivamatkov@foi.hr">ivamatkov@foi.hr</a><br/>
        Varaždin, srpanj 2018.
    </div>
</div>
</body>
</html>