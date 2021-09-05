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
if($funkcija=="prijava")
{
    if(isset($_POST['korime']) and isset($_POST['lozinka']))
    {
        $korime=$_POST['korime'];
        $lozinka=$_POST['lozinka'];
        if($korime=="" or $lozinka=="")
        {
            echo "Svi podaci su obavezni";
            exit();
        }
        
        $upit="SELECT * FROM korisnici WHERE korime='{$korime}'";
        $rez=$db->query($upit);
        if($db->num_rows($rez)==0)
        {
            echo "Ne postoji korisnik sa korisničkim imenom <b>'{$korime}'</b>";
            Log::upisiLog("../logovi/logovanje.txt", "Pogrešni podaci: '{$korime}' i '{$lozinka}'");
            exit();
        }
        $red=$db->fetch_object($rez);
        if($red->lozinka!=$lozinka)
        {
            echo "Pogrešna lozinka za korisnika <b>'{$korime}'</b>";
            Log::upisiLog("../logovi/logovanje.txt", "Pogrešni podaci: '{$korime}' i '{$lozinka}'");
            exit();
        }
        $_SESSION['id']=$red->id;
        $_SESSION['ime']="$red->ime $red->prezime";
        $_SESSION['status']=$red->status;
        Log::upisiLog("../logovi/logovanje.txt", "Uspešno logovanje za korisnika {$korime}");
        echo "1";
    }
}
if($funkcija=="prijavaKanala")
{
    if(isset($_POST['id']))
    {
        $idKanala=$_POST['id'];
        $upit="SELECT * FROM kanali WHERE id={$idKanala}";
        $rez=$db->query($upit);
        $red=$db->fetch_object($rez);
        $imeKanala=$red->naziv;
        $upit="SELECT * FROM kanalikorisnici WHERE idKorisnika={$_SESSION['id']} AND idKanala={$idKanala}";
        $rez=$db->query($upit);
        if($db->num_rows($rez)>0)
        {
            Log::upisiLog("../logovi/prijavakanala.txt", "<b>Neuspešna</b> prijava kanala '$imeKanala' za korisnika {$_SESSION['ime']} - <b>Već prijavljen</b>");
            echo "Ovaj kanal je već prijavljen";
            exit();
        }
        $upit="SELECT * FROM kanali WHERE id={$idKanala}";
        $rez=$db->query($upit);
        $red=$db->fetch_object($rez);
        $imeKanala=$red->naziv;
        $upit="INSERT INTO kanalikorisnici (idKorisnika, idKanala ) VALUES ({$_SESSION['id']}, {$idKanala})";
        $db->query($upit);
        if($db->error())
        {
            Log::upisiLog("../logovi/prijavakanala.txt", "Neuspešna prijava kanala '$imeKanala' za korisnika {$_SESSION['ime']} - ".$db->error());
            echo "Neuspešna prijava kanala\n".$db->error();
        }
        else
        {
            Log::upisiLog("../logovi/prijavakanala.txt", "Uspešna prijava kanala '$imeKanala' za korisnika {$_SESSION['ime']}");
            echo "1";
        }
           
    }
}

?>