/**
 * Created by wap17 on 20/02/15.
 */

$(function(){

    $("#prix").on("click", myScript);
    $("#valide").on("click", retourScript);
    $(".btn").on("click", recupval);
    $(".close").on("click", suppr);
    $(".nbrProduct").on("change",changeProduct);
    $("#logopanier").on("click", hiddenPanier);
    $(".rating li").on("click",star);
    $(".suprcommande").on("click",supprcmd)
});

function supprcmd(){
    var contenu=$(this).val();
    var config= { url:base_url+"index.php/home/supprCommande/" + contenu};
    $.ajax(config).done(showCommande).fail(ajaxError);
}
function showCommande(data)
{
    data=JSON.parse(data);
    console.log(data);
    for(var i =0; i<data.length; i++)
    {
        if(data[i].length !=0)
        {
            $('#commande').prepend("<tr><td>"+data[i]['username']+"</td> <td>"+data[i]['name']+"</td><td>"+data[i]['prix']+"</td><td>"+data[i]['number']+"</td><td><button value='"+data[i]['id']+"' class='suprcommande'><i class='fa fa-times'></i></button></td></tr>");
        }
    }
}
function changeProduct()
{
    var ctn=$(this).val();
    var id = $(this).attr('name');
    var config= { url:base_url+"index.php/home/inputProduct/" + ctn+"/"+id};
    $.ajax(config).done(showPanier).fail(ajaxError);
}

function myScript (){
    $("#container").toggleClass("sombre");
    $("#divprice").toggleClass('show');
}

function retourScript(){
    $("#container").removeClassName("sombre");
    $("#divprice").removeClassName('show');
}


function recupval()
{
    var contenu=$(this).attr('name');
    var config= { url:base_url+"index.php/home/panierProduct/" + contenu};
    $.ajax(config).done(showPanier).fail(ajaxError);
}

function suppr()
{
    var contenu=$(this).val();
    var config= { url:base_url+"index.php/home/supprSession/" + contenu};
    $.ajax(config).done(showPanier).fail(ajaxError);
}

function showPanier(data)
{

    $('#share').empty();
    var total=0;
    var nbrpanier=0;
    data=JSON.parse(data);
    for(var i =0; i<data.length; i++)
    {
        if(data[i].length !=0)
        {
                $('#share').prepend("<tr><td>"+data[i][0]['prix']+" €</td><td>"+data[i][0]['name']+"</td><td><button value='"+ i +"' class='close'><i class='fa fa-times'></i></button></td><td><form><input type='number' value='"+data[i][0]['mult']+"' name='"+ data[i][0]['id'] +"' class='nbrProduct' min='0' max='"+ data[i][0]['quantity'] +"'></form></td><td>reste : "+ data[i][0]['quantity'] +"</td></tr>");
                total=total+parseInt(data[i][0]['prix']);
                nbrpanier=nbrpanier+parseInt(data[i][0]['mult']);
        }
    }

    $(".close").on("click", suppr);
    $("#total").html(total);
    $("#nbrProduit").html(nbrpanier);
    $(".nbrProduct").on("change",changeProduct);
}

/*function Share()
{
    location.reload();
}*/


function hiddenPanier()
{
    $('#panier').toggle('movpanier');
    $('#container').toggleClass('showcontner');
}

function star()
{
    $(this).toggleClass('trust');
    if($(this).hasClass('trust')){
     var number=$(this).val();
    }
    else{
        var number=0;
    }
    var config= { url:base_url+"index.php/home/numberEtoile/" + number};
    $.ajax(config).done().fail(ajaxError);
}

function ajaxError()
{
    console.log("Erreur ajax");
}
