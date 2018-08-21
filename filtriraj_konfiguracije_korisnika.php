<?php

session_start();
include_once 'konfiguracijaBP.php';
include_once 'navigacija.php';

$tipKorisnika = isset($_SESSION['tipKorisnika']) ? $_SESSION['tipKorisnika'] : -1;

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Filtriraj konfiguracije korisnika</title>
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
    <p><h3 style="text-align: center;">Filtriraj konfiguracije korisnika</h3></p>
    <form method="post" action="<?php $_SERVER['SCRIPT_NAME']; ?>">
        <label>Odaberite proizvođača</label>
        <select name="proizvodac_id">
            <?php
            otvoriBP();
            $upitBP = "select * from proizvodac";
            $rezultatBP = izvrsiBP($upitBP);
            zatvoriBP();

            while ($proizvodac = mysqli_fetch_array($rezultatBP)){
                echo "<option value='".$proizvodac['proizvodac_id']."'>".$proizvodac['naziv']."</option>";
            }
            ?>
        </select><br/>
        <input type="submit" name="filtiraj" value="Filtriraj konfiguracije korisnika">
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['filtiraj'])): ?>
        <table>
            <thead><th>Proizvođač</th><th>Naziv konfiguracije</th><th>Procesor</th><th>Radna memorija</th><th>Tvrdi disk</th><th>Grafička kartica</th><th>Trajanje baterije</th><th>Boja</th><th>Ekran</th><th>Datum kreiranja</th></thead>
            <tbody>
                <?php
                    otvoriBP();
                    $upitBP = "SELECT p.naziv as nazivProizvodaca, k.*, n.datum_kreiranja FROM proizvodac p, konfiguracija k, narudzba n WHERE p.proizvodac_id=".$_POST['proizvodac_id']." AND p.proizvodac_id = k.proizvodac_id AND k.narudzba_id = n.narudzba_id AND n.status <> '' ORDER BY n.datum_isporuke ASC";
                    $rezultatBP = izvrsiBP($upitBP);
                    zatvoriBP();

                    if (mysqli_num_rows($rezultatBP) == 0){
                        echo "<tr>";
                        echo "<td colspan='10'>Za odabranog proizvođača nema niti jedna konfiguracija!</td>";
                        echo "</tr>";
                    }
                    else {
                        while ($konfiguracija = mysqli_fetch_array($rezultatBP)){
                            echo "<tr>";
                                echo "<td>".$konfiguracija['nazivProizvodaca']."</td>";
                                echo "<td>".$konfiguracija['naziv']."</td>";
                                echo "<td>".$konfiguracija['procesor']."</td>";
                                echo "<td>".$konfiguracija['radna_memorija']."</td>";
                                echo "<td>".$konfiguracija['tvrdi_disk']."</td>";
                                echo "<td>".$konfiguracija['graficka_kartica']."</td>";
                                echo "<td>".$konfiguracija['trajanje_baterije']."</td>";
                                echo "<td>".$konfiguracija['boja']."</td>";
                                echo "<td>".$konfiguracija['ekran']."</td>";
                                echo "<td>".date("d.m.Y", strtotime($konfiguracija['datum_kreiranja']))."</td>";
                            echo "</tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
    <?php endif; ?>
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
