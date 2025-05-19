<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/table.css">
    <link rel="stylesheet" href="styles/fonts.css">
    <link rel="stylesheet" href="styles/register.css">
    <script type="module" src="scripts/table.js" defer></script>
    <script type="module" src="scripts/registerContact.js" defer></script>
    <script type="module" src="scripts/registerPerson.js" defer></script>
    <title>Magazord Back-End Test</title>
</head>

<body>
    <!-- //EDIT -->
    <div id="register-overlay-person">
        <div class="register-container">
        <h1>Register Person</h1>
        <form class='register-form'>
            <div class="register-info-container" id="register-name-container">
                <label id="name-label" for="name">Name</label>
                <input id="name-input" type="text" name="name" placeholder="Name Surname">
            </div>
            <div class="register-info-container" id="register-cpf-container">
                <label id="cpf-label" for="cpf">CPF</label>
                <input id="cpf-input" type="text" name="cpf" placeholder="XXX.XXX.XXX-XX"> 
            </div>
            <div class="register-info-container">
                <label id="gender-label" for="sexo">Gender</label>
                <select id="gender-input" name="sexo">
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </form>
        <div class="register-buttons-container">
            <input id="register-person-confirm" class="register-submit" type="submit" value="Confirm">
            <input id="register-person-cancel" class="register-submit" type="submit" value="Cancel" placeholder="Cancel"> 
        </div>
    </div>
    </div>
    <div id="register-overlay-contact">
        <div class="register-container">
            <h1>Register Contact</h1>
            <form class='register-form' >
                <div class="register-info-container" id="register-type-container">
                    <label id="type-label" for="type">Type</label>
                    <select id="type-input" name="Type">
                    <option value="">Select</option>
                    <option value="Email">Email</option>
                    <option value="Phone">Phone</option>
                    </select>
                </div>
                <div class="register-info-container" id="register-contact-container">
                    <label id="contact-label" for="contact">Contact</label>
                    <input id="contact-input" type="text" name="contact" placeholder="Select the type" readonly> 
                </div>
                <div class="register-info-container">
                    <label for="person">Person (optional)</label>
                    <input type="text" id="person-input" name="person" list="person-datalist" placeholder="Searcth Person">
                    <datalist id="person-datalist" name="person">
                        <option value=""></option>
                        
                    </datalist>
                </div>
            </form>
            <div class="register-buttons-container">
                <input id="register-contact-confirm" class="register-submit" type="submit" value="Confirm">
                <input id="register-contact-cancel" class="register-submit" type="submit" value="Cancel"> 
            </div>
        </div>
    </div>
    
    
    <!-- EDIT END\\ -->

    <!-- //DELETE START-->
    <div id="delete-confirm-overlay">
        <div id="delete-confirm-modal">
            <h2>Are you sure you want to delete the data?</h2>
            <div class="confirm-cancel-button-container"> 
                <input value="Confirm" id="confirm-delete" type="submit" class="confirm-cancel-button">
                <input value="Cancel" id="cancel-delete" type="submit" class="confirm-cancel-button">
            </div>
        </div>
    </div>
    <!-- DELETE END//-->

    <!-- //TABLE START -->
    <div class="tables">
        
        <div class="table-manager person-container">
            
            <div class="header-table">
                <div class="left-content">
                    <h2>Person</h2>
                    <div id="add-person" class="edit-button">
                        <img src="assets/Add.svg" alt="Add Person">
                    </div>
                </div>
                <div class="select-lines-container">
                    <label for="lines-person">Rows</label>
                    <select id="lines-person" name="lines-person">
                        <option value="5">5</option>
                        <option value="15">15</option>
                        <option value="30">30</option>
                    </select>  
                </div>
                <div id="search-persons">
                    <input id="search-persons-input" type="text">
                    <input id="search-persons-submit" type="submit" value="Search">
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
        </div>

    <div class="table-manager contact-container">
        <div class="header-table">
            <div class="left-content">
                <h2>Contacts</h2>
                <div id="add-contact" class="edit-button">
                    <img src="assets/Add.svg" alt="Add Contact">
                </div>
            </div>
            <div class="select-lines-container">
                    <label for="lines-contact">Rows</label>
                    <select id="lines-contact" name="lines-contact">
                        <option value="5">5</option>
                        <option value="15">15</option>
                        <option value="30">30</option>
                    </select>  
                </div>
            <div id="search-contacts">
                <input id="search-contacts-input" type="text">
                <input id="search-contacts-submit" type="submit" value="Search">
            </div>
        </div>

        <table class="contact-table">
            <thead>
                <tr>
                    <th class="contact-id-column">Id</th>
                    <th class="contact-type-column">Type</th>
                    <th class="contact-content-column">Contact</th>
                    <th class="contact-person-column">Person</th>
                    <th class="contact-edit_delete-column">Edit/Delete</th>
                </tr>
            </thead>
            <tbody></tbody>      
        </table>
        
    </div>
    </div>
    <!-- TABLE END\\ -->

</body>
</html>
