<?php

session_start();
include_once 'konfiguracijaBP.php';
include_once 'navigacija.php';

$tipKorisnika = isset($_SESSION['tipKorisnika']) ? $_SESSION['tipKorisnika'] : -1;

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['prihvati'])){
    otvoriBP();

    $upitBP = "select * from konfiguracija where konfiguracija_id=".$_GET['prihvati'];
    $rezultatBP = izvrsiBP($upitBP);
    $konfiguracija = mysqli_fetch_array($rezultatBP);

    $upitBP = "update narudzba set status='P', datum_isporuke='".date('Y-m-d', time()+15*24*60*60)."', vrijeme_isporuke='".date('H:i:s')."' where narudzba_id=".$konfiguracija['narudzba_id'];
    $rezultatBP = izvrsiBP($upitBP);
    zatvoriBP();
}
else if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['odbij'])){
    otvoriBP();

    $upitBP = "select * from konfiguracija where konfiguracija_id=".$_GET['odbij'];
    $rezultatBP = izvrsiBP($upitBP);
    $konfiguracija = mysqli_fetch_array($rezultatBP);

    $upitBP = "update narudzba set status='N' where narudzba_id=".$konfiguracija['narudzba_id'];
    $rezultatBP = izvrsiBP($upitBP);
    zatvoriBP();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Prihvati/odbij kreirane narudžbe</title>
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
    <p><h3 style="text-align: center;">Prihvati/odbij kreirane narudžbe</h3></p>
    <div style="width: 100%;">
        <table>
            <thead><th>Proizvođač konfiguracije</th><th>Naziv konfiguracije</th><th>Procesor</th><th>Radna memorija</th><th>Tvrdi disk</th><th>Grafička kartica</th><th>Trajanje baterije</th><th>Boja</th><th>Ekran</th><th>Datum kreiranja</th><th>Prihvati/odbij narudžbu</th></thead>
            <tbody>
            <?php
                otvoriBP();
                if ($tipKorisnika == 1){
                    $upitBP = "select k.*, p.naziv as nazivProizvodaca, n.datum_kreiranja from konfiguracija k, proizvodac p, narudzba n where  k.proizvodac_id=p.proizvodac_id and p.moderator_id=".$_SESSION['idKorisnika']." and k.narudzba_id=n.narudzba_id and n.status='K' order by n.datum_kreiranja ASC";
                    $rezultatBP = izvrsiBP($upitBP);
                }
                else {
                    $upitBP = "select k.*, p.naziv as nazivProizvodaca, n.datum_kreiranja from konfiguracija k, proizvodac p, narudzba n where k.proizvodac_id=p.proizvodac_id and k.narudzba_id=n.narudzba_id and n.status='K' order by n.datum_kreiranja asc";
                    $rezultatBP = izvrsiBP($upitBP);
                }
                zatvoriBP();

                if (mysqli_num_rows($rezultatBP) == 0){
                    echo "<tr>";
                    echo "<td colspan='11'>Nemate niti jednu narudžbu koju možete prihvatiti ili odbiti!</td>";
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
                        echo "<td>";
                            echo "<a href='prihvati_odbij_narudzbe.php?prihvati=".$konfiguracija['konfiguracija_id']."'>Prihvati narudžbu<br/><br/></a>";
                            echo "<a href='prihvati_odbij_narudzbe.php?odbij=".$konfiguracija['konfiguracija_id']."'>Odbij narudžbu</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                }
            ?>
            </tbody>
        </table>
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
