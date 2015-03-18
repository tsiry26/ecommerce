<h1>Bienvenue <?= $_SESSION['login'] ?></h1>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?= site_url("/home")?>">InfoTech</a>
        </div>
        <div>
            <ul class="nav nav-tabs">
                <li class="active"><a href="<?= site_url("/home/ctgProduct/Phone")?>">Phone</a></li>
                <li><a href="<?= site_url("/home/ctgProduct/Tablette")?>">Tablette</a></li>
                <li><a href="<?= site_url("/home/ctgProduct/Laptop")?>">Laptop</a></li>
                <li  class="dropdown"><a href="#">
                        <i class="fa fa-angle-double-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li id="prix"><a href="#">Prix</a></li>
                    </ul>
                </li>
                <li id="droit">
                    <form action="<?= site_url("/home/searchProduct")?>" method="post">
                        <input list="browsers" name="browser" id="product" placeholder="search....">
                        <datalist id="browsers">
                            <?php for($n=0; $n<sizeof($res); $n++) : ?>
                            <option value="<?= $res[$n]['id'] ?>"><?= $res[$n]['name'] ?></option>
                            <?php endfor ?>
                        </datalist>
                    </form>
                </li>
                <li><a href="<?= site_url("/user/ajoutProduct")?>">Ajouter un article</a></li>
                <li><a href="<?= site_url("/user/logout")?>">Logout</a></li>
                <li id="logopanier"><a href="#"><i class="fa fa-cart-arrow-down"></i> <span id="nbrProduit"><?= $nbr ?></span></a></li>
            </ul>
        </div>
    </div>
</nav>
<div id="container">
<?php for($i=0; $i<sizeof($res); $i++) : ?>
<div class="article">
    <?php
        $this->load->model("Model_user", '', true);
        $img=$this->Model_user->getone_image($res[$i]['id']);?>

    <?php if(empty($img)==false){ ?>

    <div class="flexslider">
        <ul class="slides">
    <?php for($j=0; $j<sizeof($img); $j++) : ?>
            <li>
                <img src="<?=  base_url()?>picture/<?= $img[$j]['jpeg'] ?>" width="100" height= auto >
            </li>
    <?php endfor ?>
        </ul>
    </div>

    <?php } ?>

    <div id="contenu">
        <h2><a href="<?= site_url("/home/oneProduct/".$res[$i]['id'])?>"><?= $res[$i]['name'] ?></a></h2>
        <p id="description"><?= $res[$i]['description'] ?></p>
    </div>

    <div>
        <p id="price">prix: <?= $res[$i]['prix'] ?> €</p>
        <form>
           <!--<a href="/*= site_url("/home/panierProduct/".$res[$i]['id']) */?>">--><input type="button" name="<?=$res[$i]['id']?>" value="" class="btn">
        </form>
        <!--<a href="#"><button id="essais"><i class="fa fa-cart-arrow-down"></i></button></a>-->
    </div>
</div>
<?php endfor ?>
</div>
<div id="divprice">
    <form action="<?= site_url("/home/priceProduct")?>">
        <label for="price1">min</label><input type="number" name="price1">
        <label for="price2">max</label><input type="number" name="price2">
        <input type="submit" value="valider" id="valide">

    </form>
</div>

<div id="panier">
    <table>
        <tr>
            <th>Prix</th>
            <th>Produit</th>
            <th></th>
            <th>Quantity</th>
            <th></th>
        </tr>
    </table>
    <table id="share">
        <?php for($s=sizeof($panier); $s>=0; $s--) : ?>
            <?php if(empty($panier[$s][0])==false) { ?>
                <tr>
                    <?php if(array_key_exists('mult', $panier[$s][0])) { ?>
                    <td><?= $panier[$s][0]['prix']?> €</td><td><?= $panier[$s][0]['name'] ?></td><td><button value="<?= $s ?>" class="close"><i class="fa fa-times"></i></button></td><td><input type="number" value="<?= $panier[$s][0]['mult'] ?>" name="<?= $panier[$s][0]['id'] ?>" class="nbrProduct" min="1" max="<?= $panier[$s][0]['quantity'] ?>"></td><td class="rst">reste : <?= $panier[$s][0]['quantity'] ?> </td>
                    <?php } else {?>
                    <td><?= $panier[$s][0]['prix']?> €</td><td><?= $panier[$s][0]['name'] ?></td><td><button value="<?= $s ?>" class="close"><i class="fa fa-times"></i></button></td><td><input type="number" value="1" name="<?= $panier[$s][0]['id'] ?>" class="nbrProduct" min="1" max="<?= $panier[$s][0]['quantity'] ?>"></td><td class="rst">reste : <?= $panier[$s][0]['quantity'] ?> </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        <?php endfor ?>
    </table>

    <p id="somme">Total :<span id="total"><?= $total ?></span> €</p>
    <!--<a href="<?/*= site_url("/mail/send")*/?>"><button id="valider">Valider</button><br></a>-->
    <a href="<?= site_url("/home/commande")?>"><button id="valider">Valider</button><br></a>
    <a href="<?= site_url("/home/annulPanier")?>">Annuler la commande</a>
</div>
</div>