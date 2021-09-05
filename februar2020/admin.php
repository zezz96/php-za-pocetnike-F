<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administrativni panel</title>
    <script src='js/jquery-3.4.1.js'></script>
    <script src='js/admin.js'></script>
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
if(login() and $_SESSION['status']=='Administrator')
    prikaziPodatke();
else
{
    echo "Morate biti prijavljeni kao Administrator da biste videli ovu stranicu<br><a href='index.php'>Prijavite se</a>";
    exit();
}
$poruka="";
if(isset($_POST['btnKanal']))
{
    $id=$_POST['id'];
    $naziv=$_POST['naziv'];
    $opis=$_POST['opis'];
    $cena=$_POST['cena'];
    if($naziv!="" AND $opis!="" AND $cena!="")
    {
        if($id!="")
            $upit="UPDATE kanali SET naziv='{$naziv}', opis='{$opis}', cena={$cena} WHERE id=$id";
        else
            $upit="INSERT INTO kanali (naziv, opis, cena) VALUES ('{$naziv}', '{$opis}', {$cena})";
        //echo $upit;
        $db->query($upit);
        if($db->error())$poruka="GREŠKA!!!!<br>".$db->error();
        else
        {
            $imeSlike=$_FILES['slika']['name'];
            if($imeSlike!="")
            { 
                if($id=="")
                    $imeSlike="slike/".$db->insert_id().".jpg";
                else
                    $imeSlike="slike/$id.jpg";
                if(move_uploaded_file($_FILES['slika']['tmp_name'], $imeSlike))
                    $poruka.="Podaci snimljeni i prebačena slika";
            }
            else
                $poruka="Podaci snimljeni";
        }
    }
    else
        $poruka="Svi podaci su obavezni!!!";
}
?>
<h1>Administrativni panel</h1>
<div>
<div class='opcija'>
    <h3>Dodavanje/izmena/brisanje kanala</h3>
    <form action="admin.php" method="post" enctype="multipart/form-data">
    <select name="kanal" id="kanal"></select> 
    <button id="brisanje" type="button">Obrišite kanal</button><br><br>
    <input type="text" name="id" id="id" readonly/><br><br>
    <input type="text" name="naziv" id="naziv" placeholder="Unesite naziv"/><br><br>
    <textarea name="opis" id="opis" cols="30" rows="10" placeholder="Unesite opis"></textarea><br><br>
    <input type="number" name="cena" id="cena" value="0" min="0"/><br><br>
    <input type="file" name="slika" id="slika"><br><br>
    <div id="prikazSlike"></div><br>
    <button id="btnKanal" name="btnKanal">Snimite kanal</button><br><br>
    </form>
    
    <div id="divKanali"><?=$poruka?></div>
</div>
<div class='opcija'>
    <h3>Logovi</h3>
    <select name="log" id="log">
        <option value="0">--izaberite log--</option>
        <option value="logovanje.txt">Logovanja</option>
        <option value="prijavakanala.txt">Prijava kanala</option>
    </select><br><br>
    <div id='divlogovi'></div>
</div>
<div class='opcija'>
    <h3>Broj prijavljenih korisnika</h3>
    <select name="kanaliBroj" id="kanaliBroj"></select><br><br>
    <div id='divBroj'></div>
</div>
</div>
</body>
</html>
