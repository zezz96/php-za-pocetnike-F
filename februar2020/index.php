<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Početna</title>
    <script src='js/jquery-3.4.1.js'></script>
    <script src='js/index.js'></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
session_start();
require_once("funkcije.php");
require_once("klase/classBaza.php");
require_once("klase/classLog.php");
$db=new Baza();
if(!$db->connect())
{
    echo "Greška prilikom konekcije na bazu!!!<br>".$db->error();
    exit();
}
if(login() AND isset($_GET['odjava']))
{
    Log::upisiLog("logovi/logovanje.txt", "Odjava korisnika '{$_SESSION['ime']}'");
    odjaviKorisnika();
}
if(login())
    prikaziPodatke();
else
{
    ?>
    <div class='podaciPrijava'>
        <input type="text" name='korime' id='korime' placeholder="Unesite korisničko ime"/> 
        <input type="text" name='lozinka' id='lozinka' placeholder="Unesite lozinku"/> 
        <button type='button' id='dugmeZaPrijavu'>Prijavite se</button><br>
        <div id="odgovor"></div>
    </div>
    <?php
}
?>
<h1>VIŠER - kablovski operater</h1>
<?php
$upit="SELECT * FROM kanali order by naziv asc";
$rez=$db->query($upit);
if($db->num_rows($rez)>0)
{
    while($red=$db->fetch_object($rez))
    {
        
        $dugme="";
        
        if(login() AND $_SESSION['status']=='Korisnik') $dugme="<div class='dugme' onclick='prijaviKanal($red->id)'>Prijavite kanal</div>";//$dugme="<button type='button' onclick='prijaviKanal($red->id)'>Prijavite se za kanal</button>";
        echo "<div class='prikazKanala'>";
        echo "<h2>$red->naziv</h2>";
        $slika="slike/noimage.jpg";
        if(file_exists("slike/$red->id.jpg"))$slika="slike/$red->id.jpg";
        echo "<img src='$slika' height='150px' ><br>";
        echo "$red->opis<br>";
        echo "$red->cena din.";
        echo "<br>".$dugme;
        echo "</div>";
    }
}
else
    echo "Nema ni jedan kanal u bazi";
if(login() AND $_SESSION['status']=="Korisnik")
{
    echo "<h3>Prijavljeni kanali</h3>";
    $upit="SELECT * FROM kanalikorisnici WHERE idKorisnika=".$_SESSION['id'];
    $rez=$db->query($upit);
    if($db->num_rows($rez)==0)
        echo "Niste prijavljeni ni za jedan kanal";
    else
    {
        echo "<h4>Broj prijavljenih kanala: ".$db->num_rows($rez)."</h4>";
        echo "<br>";
        $i=1;
        while($red=$db->fetch_object($rez))
        {
            $upit="SELECT * FROM kanali WHERE id=$red->idKanala";
            $pomrez=$db->query($upit);
            $pomred=$db->fetch_object($pomrez);
            echo "$i: $pomred->naziv<br>";
            $i++;
        }
    }
}
?>
</body>
</html>
