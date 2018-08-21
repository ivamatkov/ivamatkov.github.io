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
    <title>Ukupno narudžbi u periodu</title>
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
    <p><h3 style="text-align: center;">Ukupno narudžbi u periodu</h3></p>
    <div style="width: 100%;">
        <form method="post" action="<?php $_SERVER['SCRIPT_NAME']; ?>">
            <label>Datum početka razdoblja</label>
            <input type="text" name="datum_pocetka_razdoblja" required="required" value="<?php if (isset($_POST['datum_pocetka_razdoblja'])) echo date("d.m.Y", strtotime($_POST['datum_pocetka_razdoblja'])); ?>"><br/>
            <label>Datum završetka razdoblja</label>
            <input type="text" name="datum_zavrsetka_razdoblja" required="required" value="<?php if (isset($_POST['datum_zavrsetka_razdoblja'])) echo date("d.m.Y", strtotime($_POST['datum_zavrsetka_razdoblja'])); ?>"><br/>
            <input type="submit" name="ukupno_narudzbi_period" value="Prikaži broj narudžbi korisnika u periodu">
        </form>
    </div>

    <div style="width: 100%;">
        <?php if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ukupno_narudzbi_period'])): ?>
        <table>
            <caption>Narudžbe i naručitelji u odabranom periodu od <b><?php echo date("d.m.Y", strtotime($_POST['datum_pocetka_razdoblja'])); ?></b> - <b><?php echo date("d.m.Y", strtotime($_POST['datum_zavrsetka_razdoblja'])); ?></b></caption>
            <thead><th>Ukupan broj narudžbi</th><th>Top 10 naručitelja</th></thead>
            <tbody>
                <tr>
                    <?php
                        $datum_pocetka_razdoblja = date("Y-m-d", strtotime($_POST['datum_pocetka_razdoblja']));
                        $datum_zavrsetka_razdoblja = date("Y-m-d", strtotime($_POST['datum_zavrsetka_razdoblja']));

                        if ($tipKorisnika == 1){
                            otvoriBP();

                            $upitBP = "SELECT COUNT(*) AS ukupno FROM proizvodac p, konfiguracija k, narudzba n WHERE p.proizvodac_id IN (SELECT proizvodac_id FROM proizvodac WHERE moderator_id = ".$_SESSION['idKorisnika'].") AND p.proizvodac_id = k.proizvodac_id AND k.narudzba_id = n.narudzba_id AND n.datum_dostave BETWEEN '".$datum_pocetka_razdoblja."' AND '".$datum_zavrsetka_razdoblja."'";
                            $rezultatBP = izvrsiBP($upitBP);
                            $ukupno = mysqli_fetch_array($rezultatBP);

                            $upitBP = "SELECT COUNT(*) as ukupno, k.ime, k.prezime FROM korisnik k, proizvodac p, konfiguracija f, narudzba n WHERE p.proizvodac_id IN (SELECT proizvodac_id FROM proizvodac WHERE moderator_id = ".$_SESSION['idKorisnika'].") AND p.proizvodac_id = f.proizvodac_id AND k.korisnik_id = f.korisnik_id AND f.narudzba_id=n.narudzba_id AND n.datum_dostave BETWEEN '".$datum_pocetka_razdoblja."' AND '".$datum_zavrsetka_razdoblja."' GROUP BY k.korisnik_id ORDER BY COUNT(*) DESC LIMIT 10";
                            $rezultatBP = izvrsiBP($upitBP);

                            zatvoriBP();
                        }
                        else {
                            otvoriBP();

                            $upitBP = "SELECT COUNT(*) AS ukupno FROM proizvodac p, konfiguracija k, narudzba n WHERE p.proizvodac_id = k.proizvodac_id AND k.narudzba_id = n.narudzba_id AND n.datum_dostave BETWEEN '".$datum_pocetka_razdoblja."' AND '".$datum_zavrsetka_razdoblja."'";
                            $rezultatBP = izvrsiBP($upitBP);
                            $ukupno = mysqli_fetch_array($rezultatBP);

                            $upitBP = "SELECT COUNT(*) as ukupno, k.ime, k.prezime FROM korisnik k, proizvodac p, konfiguracija f, narudzba n WHERE p.proizvodac_id = f.proizvodac_id AND k.korisnik_id = f.korisnik_id AND f.narudzba_id=n.narudzba_id AND n.datum_dostave BETWEEN '".$datum_pocetka_razdoblja."' AND '".$datum_zavrsetka_razdoblja."' GROUP BY k.korisnik_id ORDER BY COUNT(*) DESC LIMIT 10";
                            $rezultatBP = izvrsiBP($upitBP);

                            zatvoriBP();
                        }

                        echo "<td>".$ukupno['ukupno']."</td>";
                        echo "<td><ol>";
                        while ($korisnik = mysqli_fetch_array($rezultatBP)){
                            echo "<li>".$korisnik['ime']." ".$korisnik['prezime']." (".$korisnik['ukupno']." narudžbi)</li>";
                        }
                        echo "</ol></td>";
                    ?>
                </tr>
            </tbody>
        </table>
        <?php endif; ?>
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
