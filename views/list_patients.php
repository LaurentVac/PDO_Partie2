<!-- Créer une page liste-patients.php et y afficher la liste des patients.
 Inclure dans la page, un lien vers la création de patients. -->

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
        

    try{
        $patient = '`patients`';
        $allPatient = $dbh->prepare('SELECT * FROM '. $patient .'');
        $allPatient->execute(array($patient));
        $patients = $allPatient->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        $error = 'Requête à échouée : ' . $e->getMessage();
    };

    var_dump($patients);
 ?>  

    <!-- $id = $dbh->quote($_GET['id']); -->
 
<?php require 'templates/header.php';?>
<?php if($error):?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php else: ?>
<div class="m-auto">
        <h1>Liste de Patients</h1>
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
             <?php foreach($patients as $value): ?>
            <tr>           
                <td><a href="profil_patient.php?id=<?= $value->id ?>"><?= htmlentities($value->lastname) ?></a> </td>
                <td><?= htmlentities($value->firstname) ?></td>
                <td><?= htmlentities($value->mail) ?></td>
                <td><?= htmlentities($value->birthdate) ?></td>
                <td><?= htmlentities($value->phone) ?></td>
                <td><input type="submit" value="Modifier"></td>
                <td><input type="submit" value="supprimer"></td>               
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<?php endif ?>
<a href="../index.php">Ajouter un patient</a>

    

<?php require 'templates/footer.php';?>