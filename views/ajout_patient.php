<?php if($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
<?php endif ?>
<?php if($error):?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif ?>
        <div class="m-auto col-12">
            <h1>Ajout de patient</h1>
            <form class="col-8" method="POST">
                <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" pattern="[A-Za-z-éèêëàâäôöûüç' ]+" required value="<?= $name ?? ''?>">
                        <div id="name_error" class="form-text"><?= $errorsArray['name_error'] ?? ''?></div>
                    </div>
                
                    <!-- prénom -->
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" pattern="[A-Za-z-éèêëàâäôöûüç' ]+" required value="<?= $firstname ?? ''?>">
                        <div id="firstname_error" class="form-text"><?= $errorsArray['firstname_error'] ?? ''?></div>
                    </div>

                    <!-- Mail -->
                    <div class="mb-3">
                        <label for="mail" class="form-label">Mail</label>
                        <input type="mail" class="form-control" id="mail" name="mail"  required value="<?= $mail ?? ''?>">
                        <div id="mail_error" class="form-text"><?= $errorsArray['mail_error'] ?? '' ?></div>
                        <div id="mail_error" class="form-text"><?= $errorMailExist ?? '' ?></div>
                    </div>

                    <!-- date de naissance -->
                    <div class="mb-3">
                        <label for="birthDate" class="form-label">Date de naissance</label>
                        <input type="date" class="form-control" id="birthDate" name="birthDate" value="<?= $birthDate ?? ''?>">
                        <div id="birthDate_error" class="form-text"><?= $errorsArray['birthDate_error'] ?? ''?></div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" pattern="^((\+)33|0|0033)[1-9](\d{2}){4}$" value="<?= $phone ?? ''?>">
                        <div id="phone_error" class="form-text"><?= $errorsArray['phone_error'] ?? ''?></div>
                    </div>         
                <button type="submit" class="btn btn-primary ">Enregistrer</button><a href="views/list_patients.php">Liste des patients</a>
            </form> 
        </div>
  