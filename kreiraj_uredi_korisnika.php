<?php

session_start();
include_once 'konfiguracijaBP.php';
include_once 'navigacija.php';

$porukaKodKreiranjaUredivanjaKorisnika = "";
$tipKorisnika = isset($_SESSION['tipKorisnika']) ? $_SESSION['tipKorisnika'] : -1;

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['korisnik'])){
    $korisnik_id = $_GET['korisnik'];
    otvoriBP();
    $upitBP = "select * from korisnik where korisnik_id=".$korisnik_id;
    $rezultatBP = izvrsiBP($upitBP);
    $korisnik = mysqli_fetch_array($rezultatBP);
    zatvoriBP();
}
else {
    $korisnik_id = 0;
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['kreiraj_uredi_korisnika'])){
    otvoriBP();
    $slika = "korisnici/".$_FILES['slika']['name'];
    move_uploaded_file($_FILES['slika']['tmp_name'], 'korisnici/'.$_FILES['slika']['name']);

    if ($_POST['korisnik_id'] == 0){
        $upitBP = "insert into korisnik (tip_id, korisnicko_ime, lozinka, ime, prezime, email, slika) values (".$_POST['tip_id'].", '".$_POST['korisnicko_ime']."', '".$_POST['lozinka']."', '".$_POST['ime']."', '".$_POST['prezime']."', '".$_POST['email']."', '".$slika."')";
        izvrsiBP($upitBP);
        $porukaKodKreiranjaUredivanjaKorisnika = "Uspješno ste dodali novog korisnika!";
    }
    else {
        $upitBP = "update korisnik set tip_id=".$_POST['tip_id'].", korisnicko_ime='".$_POST['korisnicko_ime']."', lozinka='".$_POST['lozinka']."', ime='".$_POST['ime']."', prezime='".$_POST['prezime']."', email='".$_POST['email']."', slika='".$slika."' where korisnik_id=".$_POST['korisnik_id'];
        izvrsiBP($upitBP);
        $porukaKodKreiranjaUredivanjaKorisnika = "Uspješno ste ažurirali postojećeg korisnika!";
    }

    zatvoriBP();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kreiraj/uredi korisnika</title>
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
    <p><h3 style="text-align: center;">Kreiraj/uredi korisnika</h3></p>
    <div style="width: 100%;">
        <form method="post" action="<?php $_SERVER['SCRIPT_NAME']; ?>" enctype="multipart/form-data">
            <p><?php echo $porukaKodKreiranjaUredivanjaKorisnika; ?></p>
            <label>Odaberite željeni tip korisnika</label>
            <select name="tip_id">
                <?php
                    otvoriBP();
                    $upitBP = "select * from tip_korisnika";
                    $rezultatBP = izvrsiBP($upitBP);
                    zatvoriBP();

                    while ($tip = mysqli_fetch_array($rezultatBP)){
                        if ($korisnik_id != 0 && $korisnik['tip_id'] == $tip['tip_id']){
                            echo "<option value='".$tip['tip_id']."' selected='selected'>".$tip['naziv']."</option>";
                        }
                        else {
                            echo "<option value='".$tip['tip_id']."'>".$tip['naziv']."</option>";
                        }
                    }
                ?>
            </select><br/>
            <label>Korisničko ime</label>
            <input type="text" name="korisnicko_ime" required="required" value="<?php if ($korisnik_id != 0) echo $korisnik['korisnicko_ime']; ?>"><br/>
            <label>Lozinka</label>
            <input type="text" name="lozinka" required="required" value="<?php if ($korisnik_id != 0) echo $korisnik['lozinka']; ?>"><br/>
            <label>Ime</label>
            <input type="text" name="ime" required="required" value="<?php if ($korisnik_id != 0) echo $korisnik['ime']; ?>"><br/>
            <label>Prezime</label>
            <input type="text" name="prezime" required="required" value="<?php if ($korisnik_id != 0) echo $korisnik['prezime']; ?>"><br/>
            <label>Email</label>
            <input type="email" name="email" value="<?php if ($korisnik_id != 0) echo $korisnik['email']; ?>"><br/>
            <label>Slika</label>
            <input type="file" name="slika" required="required"><br/>
            <input type="hidden" name="korisnik_id" value="<?php echo $korisnik_id; ?>">
            <input type="submit" name="kreiraj_uredi_korisnika" value="Kreiraj/uredi korisnika">
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