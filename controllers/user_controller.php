<?php
include('utils\regexp.php');

    $dsn = 'mysql:dbname=hospitale2n;host=127.0.0.1';
    $user = 'root';
    $password = '';

    try {
        // connexion a la db 
        $dbh = new PDO($dsn, $user, $password);
         //gestion des erreurs
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE ,PDO::FETCH_OBJ) ;
    } catch (PDOException $e) {
       $error = 'Connexion échouée : ' . $e->getMessage();
    };
    $errorsArray = array();

//On ne controle que s'il y a des données envoyées 
if($_SERVER['REQUEST_METHOD'] == 'POST'){

   // NAME
    // On verifie l'existance et on nettoie
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

    //On test si le champ n'est pas vide
    if(!empty($name)){
        // On test la valeur
        $testRegexName = preg_match(REGEXP_STR_NO_NUMBER,$name);

        if($testRegexName == false){
            $errorsArray['name_error'] = 'Le nom n\'est pas valide';
        }
    }else{
        $errorsArray['name_error'] = 'Le champ n\'est pas rempli';
    }

    // ***************************************************************

    // FIRSTNAME
    // On verifie l'existance et on nettoie
    $firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

    //On test si le champ n'est pas vide
    if(!empty($firstname)){
        // On test la valeur
        $testRegexFirstname = preg_match(REGEXP_STR_NO_NUMBER,$firstname);

        if($testRegexFirstname == false){
            $errorsArray['firstname_error'] = 'Le prénom n\'est pas valide';
        }
    }else{
        $errorsArray['firstname_error'] = 'Le champ n\'est pas rempli';
    }

    // ***************************************************************

    // DATE D'ANNIVERSAIRE 
    // On verifie l'existance et on nettoie
    $birthDate = trim(filter_input(INPUT_POST, 'birthDate', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

    //On test si le champ n'est pas vide
    if(!empty($birthDate)){
        // On test la valeur
        $testRegexBirthDate = preg_match(REGEXP_DATE,$birthDate);

        // On peut aller plus loin sur le test de la date à cet endroit

        if($testRegexBirthDate == false){
            $errorsArray['birthDate_error'] = 'Le date n\'est pas valide, le format attendu est YYYY-MM-JJ';
        }
    }

    // ***************************************************************
   
      
    // TELEPHONE
    // On verifie l'existance et on nettoie
    $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));

    //On test si le champ n'est pas vide
    if(!empty($phone)){
        // On test la valeur
        $testRegexPhone = preg_match(REGEXP_PHONE,$phone);

        if($testRegexPhone == false){
            $errorsArray['phone_error'] = 'Le numero n\'est pas valide, les séparateur sont - . /';
        }
    }

    // ***************************************************************
    
    // EMAIL
    // On verifie l'existance et on nettoie
    $mail = trim(filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL));

    //On test si le champ n'est pas vide
    if(!empty($mail)){
        // On test la valeur
        $testMail = filter_var($mail, FILTER_VALIDATE_EMAIL);

        if($testMail == false){
            $errorsArray['mail_error'] = 'Le mail n\'est pas valide';
        }
    }else{
        $errorsArray['mail_error'] = 'Le champ n\'est pas rempli';
    }

    // ***************************************************************
    
};

    $error = null;
    $success = null ;         
   // ON VERIFIE SI LE MAIL EST DANS LA TABLE

    if(isset($mail)){

        $mailExist = $dbh->prepare('SELECT COUNT(*) AS `nbr`  FROM `patients` WHERE `mail` =?');
        $mailExist->execute(array($mail));
        $req = $mailExist->fetch(PDO::FETCH_ASSOC);
 // UNE BOUCLE POUR INFORMER L'UTLISATEUR ou ENREGISTRER DANS LA BASE DE DONNEES SI LE MAIL N'EXISTE PAS
      if($req['nbr'] == 0 ){
        
         
         try {
            //  Insertion de nouvelle données si validation
            if(isset( $testMail , $testRegexPhone ,$testRegexFirstname , $testRegexName )== true) {
                $query = $dbh->prepare('INSERT INTO `patients` ( lastname, firstname, birthdate, phone , mail  ) VALUES ( :lastname, :firstname, :birthdate, :phone , :mail)');
                $query->execute([
                 'lastname' => $name,
                  'firstname' => $firstname,
                   'birthdate' => $birthDate,
                    'phone'  => $phone,
                     'mail' => $mail,
                ]);  
                $success = 'Votre formulaire à bien était enregistré'  ;
                
            }
         } catch (PDOException $e) {
             $error = 'Connexion échouée : '.$e->getMessage();
         };
        }else{
            
           $errorMailExist = "Ce pseudo est déjà utilisé !";
        };
    };
      
    


 
?>