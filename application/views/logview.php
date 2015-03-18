<h3>Please log in</h3>

<?php if (array_key_exists("error", $_SESSION)) : ?>
    <h2><?= $_SESSION["error"] ?></h2>
    <?php unset($_SESSION["error"]) ?>
<?php endif ?>

<div class="col-sm-4">

<form action="" method="post" class="form-signin">
    <input type="text" placeholder="username" name="username" class="form-control">
    <input type="password" placeholder="password" name="password" class="form-control">
    <input type="submit" value="login">
</form>

    <a href="<?= site_url("/user/account")?>">I don't have an account</a>
</div>

