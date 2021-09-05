<?php
session_start();
require_once("../klase/classBaza.php");
require_once("../klase/classLog.php");
$db=new Baza();
if(!$db->connect())
{
    echo "Baza trenutno nije dostupna!!!!";
    exit();
}
$funkcija=$_GET['funkcija'];
if($funkcija=="log")
{
    $fajl=$_POST['fajl'];
    if(file_exists("../logovi/".$fajl))
    {
        $odgovor=file_get_contents("../logovi/".$fajl);
        $odgovor=str_replace("\r\n", "<br>", $odgovor);
        echo $odgovor;
    }
    else
        echo "Fajl ne postoji!!!!";
    
}

if($funkcija=="kanaliBroj")
{
    $id=$_POST['id'];
    $upit="SELECT * FROM kanalikorisnici WHERE idKanala=$id";
    $rez=$db->query($upit);
    echo "Broj prijavljenih: <b>".$db->num_rows($rez)."</b>";
}

if($funkcija=="popuniSelect")
{
    $upit="SELECT * FROM kanali";
    $rez=$db->query($upit);
    $sve=$db->fetch_all($rez);
    echo JSON_encode($sve, 256);
}

if($funkcija=="brisanje")
{
    $id=$_POST['id'];
    $upit="DELETE FROM kanalikorisnici WHERE idKanala=$id";
    $db->query($upit);
    $upit="DELETE FROM kanali WHERE id=$id";
    $db->query($upit);
    if($db->affected_rows()==1)
        echo "Uspešno izbrisan kanal";  
    else
        echo "Greška prilikom brisanja kanala<br>".$db->error();
}

if($funkcija=="kanal")
{
    $id=$_POST['id'];
    $naziv=$_POST['naziv'];
    $datum=$_POST['opis'];
    $cena=$_POST['cena'];
    if($id=="")
        $upit="INSERT INTO predmeti (naziv, datum, nacinpolaganja, idProfesora) VALUES ('{$naziv}', '{$datum}', {$nacinpolaganja}, {$_SESSION['id']})";
    else
        $upit="UPDATE predmeti SET naziv='{$naziv}', datum='{$datum}', nacinpolaganja={$nacinpolaganja} WHERE id=$id";
    $db->query($upit);
    if($db->error())
        echo "GREŠKA<br>".$db->error();
    else if($id=="")
        echo "Uspešno snimljeni podaci";
        else echo "Uspešno izmenjeni podaci";

}

if($funkcija=="prikaziKanal")
{
    $id=$_POST['id'];
    $upit="SELECT * FROM kanali WHERE id=$id";
    $rez=$db->query($upit);
    $sve=$db->fetch_all($rez);
    if(file_exists("../slike/$id.jpg"))$slika="slike/$id.jpg";
    else $slika="slike/noimage.jpg";
    $sve[0]['prikazSlike']="<img src='$slika' alt='' width='200px'/>";
    echo JSON_encode($sve, 256);
}