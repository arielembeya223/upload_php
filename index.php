<?php
require 'vendor/autoload.php';
$pdo = new PDO('mysql:host=localhost;dbname=pictures;port=3308','root','root',[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
if(!empty($_FILES)){
$name= $_FILES['file']['name'];
$tmp_name= $_FILES['file']['tmp_name'];
$extension = strrchr($name,".");
$tableau = ['.jpg'];
$resulte = null;
if(in_array($extension,$tableau)){
    $chemin = 'image/' . $name;
    move_uploaded_file($tmp_name,$chemin);
   
    $query = $pdo->prepare('INSERT INTO images SET name=:name');
    $query->execute([
        'name'=>$chemin
    ]);
    $resulte = "enregistrement reussi";
}

}
$selects = $pdo->query('SELECT name FROM  images')->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="POST" enctype="multipart/form-data">
        <label><input type="file" name="file" ></label>
        <button type="submit">enregistrer</button>
    </form>

    <?php foreach($selects as $select):?>
        <img src="<?=$select->name?>">
    <?php endforeach ?>
</body>
</html>