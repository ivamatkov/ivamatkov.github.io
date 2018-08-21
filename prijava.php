<?php
session_start();
include_once 'konfiguracijaBP.php';
include_once 'navigacija.php';

$tipKorisnika = isset($_SESSION['tipKorisnika']) ? $_SESSION['tipKorisnika'] : -1;
$pogreskaKodPrijave = "";

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['prijava'])){
    otvoriBP();
    $upitBP = "select * from korisnik where korisnicko_ime='".$_POST['korisnicko_ime']."' and lozinka='".$_POST['lozinka']."'";
    $rezultatBP = izvrsiBP($upitBP);
    zatvoriBP();

    if (mysqli_num_rows($rezultatBP) == 1){
        $prijava = mysqli_fetch_array($rezultatBP);
        $_SESSION['idKorisnika'] = $prijava['korisnik_id'];
        $_SESSION['tipKorisnika'] = $prijava['tip_id'];
        $_SESSION['prijava'] = $prijava;

        header("Location: kreirane_konfiguracije.php");
    }
    else {
        $pogreskaKodPrijave = "Pogrešni podaci za prijavu!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Prijava</title>
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
    <p><h3 style="text-align: center;">Prijava</h3></p>
    <div style="width: 100%;">
        <form method="post" action="<?php $_SERVER['SCRIPT_NAME']; ?>">
            <p><?php echo $pogreskaKodPrijave; ?></p>
            <input type="text" name="korisnicko_ime" placeholder="Korisničko ime" required="required"><br/>
            <input type="password" name="lozinka" placeholder="Lozinka" required="required"><br/>
            <input type="submit" name="prijava" value="Prijava">
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
