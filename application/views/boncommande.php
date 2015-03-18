<table id="commande">
    <?php for ($cmd=0; $cmd<sizeof($commande); $cmd++) : ?>
    <tr>
        <td><?= $commande[$cmd]['username'] ?></td> <td><?= $commande[$cmd]['name'] ?></td><td><?= $commande[$cmd]['prix'] ?></td><td><?= $commande[$cmd]['number'] ?></td><td><button value="<?= $commande[$cmd]['id'] ?>" class="suprcommande"><i class="fa fa-times"></i></button></td>
    </tr>
    <?php endfor ?>
</table>