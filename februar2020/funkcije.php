<?php
function login(){
    if(isset($_SESSION['id']) AND isset($_SESSION['ime']) AND isset($_SESSION['status']) )
        return true;
    else
        return false;
}
function odjaviKorisnika(){
    session_unset();
    session_destroy();
}

function prikaziPodatke(){
    echo "<div class='podaciPrijava'>";
    echo "Prijavljeni ste kao {$_SESSION['ime']} ({$_SESSION['status']})<br>";
    echo "<a href='index.php'>Početna</a> | ";
    if($_SESSION['status']=='Administrator') echo "<a href='admin.php'>Administracija</a> | ";
    echo "<a href='index.php?odjava'>Odjava</a>";
    echo "</div>";
}


?>