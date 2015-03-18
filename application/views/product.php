<form method="post" id="ajtproduct">
    <label for="title">Titre</label>
    <input type="text" name="title"><br>
    <textarea rows="4" cols="50" name="comment" placeholder="Description"></textarea><br>
    <label for="price">Prix</label>
    <input type="number" name="price" placeholder="€" step="any"><br>
    <input type="radio" name="radio" value="Phone" checked>Phone
    <input type="radio" name="radio" value="Tablette" checked>Tablette
    <input type="radio" name="radio" value="Laptop" checked>Laptop
    <br><input type="file" name="fichier[]" multiple><br>
    <input type="submit" value="Ajouter">
    <a href="<?= site_url("/home")?>"><input type="button" value="Retour"></a>

</form>