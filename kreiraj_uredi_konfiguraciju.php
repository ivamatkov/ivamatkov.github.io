<?php

session_start();
include_once 'konfiguracijaBP.php';
include_once 'navigacija.php';

$porukaKodKreiranjaUredivanjaKonfiguracije = "";
$tipKorisnika = isset($_SESSION['tipKorisnika']) ? $_SESSION['tipKorisnika'] : -1;

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['konfiguracija'])){
    $konfiguracija_id = $_GET['konfiguracija'];
    otvoriBP();
    $upitBP = "select * from konfiguracija where konfiguracija_id=".$konfiguracija_id;
    $rezultatBP = izvrsiBP($upitBP);
    $konfiguracija = mysqli_fetch_array($rezultatBP);
    zatvoriBP();
}
else {
    $konfiguracija_id = 0;
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['kreiraj_uredi_konfiguraciju'])){
    otvoriBP();

    if ($_POST['konfiguracija_id'] == 0){
        $upitBP = "insert into narudzba (status) values ('')";
        $rezultatBP = izvrsiBP($upitBP);

        $upitBP = "select MAX(narudzba_id) as nova_narudzba from narudzba";
        $rezultatBP = izvrsiBP($upitBP);
        $narudzba = mysqli_fetch_array($rezultatBP);

        $upitBP = "insert into konfiguracija (korisnik_id, proizvodac_id, narudzba_id, naziv, procesor, radna_memorija, tvrdi_disk, boja, ekran, graficka_kartica, trajanje_baterije) values (".$_SESSION['idKorisnika'].", ".$_POST['proizvodac_id'].", ".$narudzba['nova_narudzba'].", '".$_POST['naziv']."', '".$_POST['procesor']."', '".$_POST['radna_memorija']."', '".$_POST['tvrdi_disk']."', '".$_POST['boja']."', '".$_POST['ekran']."', '".$_POST['graficka_kartica']."', '".$_POST['trajanje_baterije']."')";
        izvrsiBP($upitBP);
        $porukaKodKreiranjaUredivanjaKonfiguracije = "Uspješno ste dodali novu konfiguraciju!";
    }
    else {
        $upitBP = "update konfiguracija set proizvodac_id=".$_POST['proizvodac_id'].", naziv='".$_POST['naziv']."', procesor='".$_POST['procesor']."', radna_memorija='".$_POST['radna_memorija']."', tvrdi_disk='".$_POST['tvrdi_disk']."', boja='".$_POST['boja']."', ekran='".$_POST['ekran']."', graficka_kartica='".$_POST['graficka_kartica']."', trajanje_baterije='".$_POST['trajanje_baterije']."' where konfiguracija_id=".$_POST['konfiguracija_id'];
        izvrsiBP($upitBP);
        $porukaKodKreiranjaUredivanjaKonfiguracije = "Uspješno ste ažurirali postojeću konfiguraciju!";
    }

    zatvoriBP();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kreiraj/uredi konfiguraciju</title>
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
    <p><h3 style="text-align: center;">Kreiraj/uredi konfiguraciju</h3></p>
    <div style="width: 100%;">
        <form method="post" action="<?php $_SERVER['SCRIPT_NAME']; ?>">
            <p><?php echo $porukaKodKreiranjaUredivanjaKonfiguracije; ?></p>
            <label>Odaberite željenog proizvođača</label>
            <select name="proizvodac_id">
                <?php
                    otvoriBP();
                    $upitBP = "select * from proizvodac";
                    $rezultatBP = izvrsiBP($upitBP);
                    zatvoriBP();

                    while ($proizvodac = mysqli_fetch_array($rezultatBP)){
                        if ($konfiguracija_id != 0 && $konfiguracija['proizvodac_id'] == $proizvodac['proizvodac_id']){
                            echo "<option value='".$proizvodac['proizvodac_id']."' selected='selected'>".$proizvodac['naziv']."</option>";
                        }
                        else {
                            echo "<option value='".$proizvodac['proizvodac_id']."'>".$proizvodac['naziv']."</option>";
                        }
                    }
                ?>
            </select><br/>
            <label>Naziv konfiguracije</label>
            <input type="text" name="naziv" required="required" value="<?php if ($konfiguracija_id != 0) echo $konfiguracija['naziv']; ?>"><br/>
            <label>Procesor</label>
            <input type="text" name="procesor" required="required" value="<?php if ($konfiguracija_id != 0) echo $konfiguracija['procesor']; ?>"><br/>
            <label>Veličina radne memorije</label>
            <input type="number" name="radna_memorija" required="required" value="<?php if ($konfiguracija_id != 0) echo $konfiguracija['radna_memorija']; ?>"><br/>
            <label>Veličina tvrdog diska</label>
            <input type="number" name="tvrdi_disk" required="required" value="<?php if ($konfiguracija_id != 0) echo $konfiguracija['tvrdi_disk']; ?>"><br/>
            <label>Grafička kartica</label>
            <input type="text" name="graficka_kartica" required="required" value="<?php if ($konfiguracija_id != 0) echo $konfiguracija['graficka_kartica']; ?>"><br/>
            <label>Trajanje baterije</label>
            <input type="number" name="trajanje_baterije" required="required" value="<?php if ($konfiguracija_id != 0) echo $konfiguracija['trajanje_baterije']; ?>"><br/>
            <label>Boja</label>
            <input type="text" name="boja" required="required" value="<?php if ($konfiguracija_id != 0) echo $konfiguracija['boja']; ?>"><br/>
            <label>Veličina ekrana</label>
            <input type="number" name="ekran" required="required" value="<?php if ($konfiguracija_id != 0) echo $konfiguracija['ekran']; ?>"><br/>
            <input type="hidden" name="konfiguracija_id" value="<?php echo $konfiguracija_id; ?>">
            <input type="submit" name="kreiraj_uredi_konfiguraciju" value="Kreiraj/uredi konfiguraciju">
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
