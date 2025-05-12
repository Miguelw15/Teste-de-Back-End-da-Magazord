<?php

require_once __DIR__.'/../vendor/autoload.php';
$entityManager = require_once __DIR__."/../src/Services/entity-manager.php";

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
        contacts = <?=json_encode($contactList,JSON_UNESCAPED_UNICODE)?>;
        persons = <?=json_encode($personList,JSON_UNESCAPED_UNICODE)?>;
    </script>

    <div class="tables">
        <div class="table-manager" div="person-container">
            <div class="header-table">
                <div class="left-content">
                    <h2>Person</h2>
                    <div class="edit-button" id="add-person">
                        <img src="assets/Add.svg" alt="Add Person">
                    </div>
                </div>
                <div id="search-persons">
                    <input type="text">
                    <input type="submit" value="Search">
                </div>
            </div>
            <table id="person-table">
                <thead>
                    <tr>
                        <th id="person-id-column">Id</th>
                        <th id="person-name-column">Name</th>
                        <th id="person-cpf-column">Cpf</th>
                        <th id="contact-gender-column">Gender</th>
                        <th id="person-contacts-column">Edit/View</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div id="select-lines-container">
            <label for="lines">Rows</label>
                <select id="lines" name="lines">
                    <option value="5">5</option>
                    <option value="15">15</option>
                    <option value="30">30</option>
                </select>  
            </div>
            
        </div>
    <div class="table-manager" id="contact-container">
        <div class="header-table">
            <div class="left-content">
                <h2>Contacts</h2>
                <div class="edit-button" id="add-contact">
                    <img src="assets/Add.svg" alt="Add Contact">
                </div>
            </div>
            <div id="search-contacts">
                <input type="text">
                <input type="submit" value="Search">
            </div>
        </div>
        
        <table id="contact-table">
            <thead>
                <tr>
                    <th id="contact-id-column">Id</th>
                    <th id="contact-type-column">Type</th>
                    <th id="contact-content-column">Contact</th>
                    <th id="contacts-persons-column">Edit/View</th>
                </tr>
            </thead>
            <tbody></tbody>      
        </table>
        
    </div>
    </div>
    
    
   

    
</body>
</html>