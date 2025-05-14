<?php
use App\Services\EntityManagerFactory;
require_once __DIR__.'/../vendor/autoload.php';
$entityManager = EntityManagerFactory::create();

use App\Controller\ContactController;
use App\Controller\PersonController;

$ContactManager = new ContactController($entityManager);
$PersonManager = new PersonController($entityManager);

$contactList = $ContactManager->getAllContacts();
$personList = $PersonManager->getAllPersons();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/table.css">
    <script src="scripts/table.js" defer></script>
    <title>Magazord Back-End Test</title>
</head>

<body>
    <script>
        contacts = <?= json_encode($contactList,JSON_UNESCAPED_UNICODE)?>;
        persons = <?= json_encode($personList,JSON_UNESCAPED_UNICODE)?>;
    </script>
    <div class="tables">
        <div class="table-manager person-container">
            
            <div class="header-table">
                <div class="left-content">
                    <h2>Person</h2>
                    <div class="edit-button add-person">
                        <img src="assets/Add.svg" alt="Add Person">
                    </div>
                </div>

                <div class="search-persons">
                    <input type="text">
                    <input type="submit" value="Search">
                </div>
            </div>

            <table class="person-table">
                <thead>
                    <tr>
                        <th class="person-id-column">Id</th>
                        <th class="person-name-column">Name</th>
                        <th class="person-cpf-column">Cpf</th>
                        <th class="person-gender-column">Gender</th>
                        <th class="person-edit_delete-column">Edit/Delete</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <div class="select-lines-container">
            <label for="lines">Rows</label>
                <select id="lines" name="lines">
                    <option value="5">5</option>
                    <option value="15">15</option>
                    <option value="30">30</option>
                </select>  
            </div>
        </div>

    <div class="table-manager contact-container">
        <div class="header-table">
            <div class="left-content">
                <h2>Contacts</h2>
                <div class="edit-button add-contact">
                    <img src="assets/Add.svg" alt="Add Contact">
                </div>
            </div>
            <div class="search-contacts">
                <input type="text">
                <input type="submit" value="Search">
            </div>
        </div>

        <table class="contact-table">
            <thead>
                <tr>
                    <th class="contact-id-column">Id</th>
                    <th class="contact-type-column">Type</th>
                    <th class="contact-content-column">Contact</th>
                    <th class="contact-edit_delete-column">Edit/Delete</th>
                </tr>
            </thead>
            <tbody></tbody>      
        </table>
        
    </div>
    </div>
</body>
</html>
