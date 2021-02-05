<?php
    
    $dsn = 'mysql:dbname=hospitale2n;host=127.0.0.1';
    $user = 'root';
    $password = '';
    $error = null; 
    try {
        // connexion a la db 
        $dbh = new PDO($dsn, $user, $password);
         //gestion des erreurs
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE ,PDO::FETCH_OBJ) ;
    } catch (PDOException $e) {
       $error = 'Connexion échouée : ' . $e->getMessage();
    };
    

 $id = $dbh->quote($_GET['id']);


    try {
        $query = $dbh->query('SELECT * FROM `patients` WHERE `id` = '.$id.'' );
        $query->execute([
            'id' => $id
        ]);
        
            $cool = $query->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
       $error = 'Connexion échouée : ' . $e->getMessage();
    };
var_dump(PDO::FETCH_OBJ);
var_dump($cool);
?>
<?php require 'templates/header.php';?>

<?php if($error):?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php else: ?>

<div class="m-auto">
        <h1>Profil de Du Patient <?= htmlentities($cool->firstname).' '.htmlentities($cool->lastname) ?></h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Mail</th>
                <th scope="col">Date de naissance</th>
                <th scope="col">Téléphone</th>
            </tr>
        </thead>
        <tbody>
        
            <tr>
              
                <td><?= htmlentities($cool->lastname) ?></td>
                <td><?= htmlentities($cool->firstname) ?></td>
                <td><?= htmlentities($cool->mail) ?></td>
                <td><?= htmlentities($cool->birthdate) ?></td>
                <td><?= htmlentities($cool->phone) ?></td>
                <td><input type="submit" value="Modifier"></td>
                <td><input type="submit" value="supprimer"></td>
                
            </tr>
            
        </tbody>
    </table>
    <?php endif; ?>

    <a href="../index.php">Ajouter un patient</a>

<?php require 'templates/footer.php';?>