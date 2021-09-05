$(document).ready(function(){
    popuniSelect();
    $("#log").change(function(){
        let fajl=$(this).val();
        if(fajl=="0")
        {
            $("#divlogovi").html("");
            return false;
        }
        $.post("ajax/ajax_admin.php?funkcija=log",{fajl:fajl}, function(response){
            $("#divlogovi").html(response);
        })
    })
    $("#kanaliBroj").change(function(){
        let id=$(this).val();
        if(id=="0")
        {
            $("#divBroj").html("");
            return false;
        }
        $.post("ajax/ajax_admin.php?funkcija=kanaliBroj",{id:id}, function(response){
            $("#divBroj").html(response);
        })
    })

    $("#brisanje").click(function(){
        let id=$("#kanal").val();
        if(id=="0")
        {
            $("#divKanali").html("Niste izabrali kanal za brisanje");
            return false;
        }
        if(!confirm("Da li ste sigurni da želite da izbrišete kanal?")) return false;
        
        $.post("ajax/ajax_admin.php?funkcija=brisanje", {id:id}, function(response){
            $("#divKanali").html(response);
            popuniSelect();
            ocistiPredmet();
        })
    })

    

    $("#kanal").change(function(){
        let id=$(this).val();
        if(id=="0")
        {
            ocistiKanal();
            return false;
        }
        $.post("ajax/ajax_admin.php?funkcija=prikaziKanal", {id:id}, function(response){
            let kanal=JSON.parse(response);
            $("#id").val(kanal[0].id);
            $("#naziv").val(kanal[0].naziv);
            $("#opis").val(kanal[0].opis);
            $("#cena").val(kanal[0].cena);
            $("#prikazSlike").html(kanal[0].prikazSlike);
            $("#divKanali").html("");
        })
    })
})

function popuniSelect()
{
    let kanal=$("#kanal");
    let broj=$("#kanaliBroj");
    $.post("ajax/ajax_admin.php?funkcija=popuniSelect", function(response){
        let kanali=JSON.parse(response);
        kanal.empty();
        kanal.append("<option value='0'>--izaberite kanal--</option>");
        broj.empty();
        broj.append("<option value='0'>--izaberite kanal--</option>");
        for(let i=0;i<kanali.length;i++)
        {
            broj.append("<option value='"+ kanali[i].id +"'>"+ kanali[i].naziv +"</option>");
            kanal.append("<option value='"+ kanali[i].id +"'>"+ kanali[i].naziv +"</option>");
        }
    })
}

function ocistiKanal(){
    $("input").val("");
    $("#kanal").val("0");
    $("#slika").val("");
    $("#prikazSlike").html("");
    $("#opis").val("");
}