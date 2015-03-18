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

    <?php

    $this->load->model("Model_user", '', true);
    $img=$this->Model_user->getone_image($res[0]['id']);?>

    <?php if(empty($img)==false){ ?>

        <div class="flexslider">
            <ul class="slides">
                <?php for($j=0; $j<sizeof($img); $j++) : ?>
                    <li>
                        <img src="<?=  base_url()?>picture/<?= $img[$j]['jpeg'] ?>" width="400" height="auto">
                    </li>
                <?php endfor ?>
            </ul>
        </div>

    <?php } ?>

    <div>
        <h2><?= $res[0]['name'] ?></h2>
        <p><?= $res[0]['description'] ?></p>
        <p>prix: <?= $res[0]['prix'] ?> €</p>
        <?php
        if($moyenne==0)
        {
            $j=0;
            $moy=0;
            $value=0;
        }
        else{

            $j=5;
            $moy=round($moyenne);
            $value=$moyenne-$moy;
        }
        ?>
        <?php for($mn=0; $mn<$moy; $mn++) : ?>
            <i class="fa fa-star"></i>
            <?php $j--; endfor ?>
        <?php if ($value!=0) { ?>
            <meter class="fa fa-star-o"  value="<?= $value ?>" min="0" max="1">
            </meter>
        <?php $j--;} ?>
        <?php for($none=0; $none<$j; $none++) : ?>
            <i class="fa fa-star-o"></i>
        <?php endfor ?>




        <form>
            <input type="button" name="<?=$res[0]['id']?>" value="" class="btn">
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
    <button id="valider">Valider</button><br>
    <a href="<?= site_url("/home/annulPanier")?>">Annuler la commande</a>
</div>
<?php for($c=0; $c<sizeof($commentaire); $c++) : ?>
    <div class="row well">
        <blockquote>
            <span class="glyphicon glyphicon-user"></span>
            tsiry
            <?php
            if($commentaire==0)
            {
                $j=0;
            }
            else{
                $j=5;
            }
            ?>
            <?php for($etoil=0; $etoil<$commentaire[$c]['nbretoile']; $etoil++) : ?>
                <i class="fa fa-star"></i>
            <?php $j--; endfor ?>
            <?php for($blc=0; $blc<$j; $blc++) : ?>
                <i class="fa fa-star-o"></i>
            <?php endfor ?>
            <p><?= $commentaire[$c]['comment'] ?></p>
        </blockquote>
    </div>
<?php endfor ?>
<div class="row well">
        <blockquote>
                <span class="glyphicon glyphicon-user"></span>
                tsiry
            <ul class="rating">
                <li value="5">☆</li><li value="4">☆</li><li value="3">☆</li><li value="2">☆</li><li value="1">☆</li>
            </ul>
        </blockquote>
        <div class="container">
            <form action="<?= site_url("/home/commentaire/".$res[0]['id'])?>" method="post" role="form">
                <div class="form-group">
                    <label for="comment">Comment:</label>
                    <textarea class="form-control" rows="4" id="comment" name="commentaire"></textarea>
                    <input type="submit" value="comment" id="commentaire">
                </div>
            </form>
        </div>
</div>
