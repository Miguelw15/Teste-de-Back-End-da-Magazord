import { AppState } from "./authentications.js";

const personbody = document.querySelector('.person-table tbody');
const contactbody = document.querySelector('.contact-table tbody');

const addContact = document.getElementById('add-contact');
const addPerson = document.getElementById('add-person');
const personInput = document.getElementById('person-input');

const searchContactsInput = document.getElementById('search-contacts-input');
const searchContactsSubmit = document.getElementById('search-contacts-submit');
const searchPersonsInput = document.getElementById('search-persons-input');
const searchPersonsSubmit = document.getElementById('search-persons-submit');

const deleteConfirmOverlay = document.getElementById('delete-confirm-overlay');
const confirmDelete = document.getElementById('confirm-delete');
const cancelDelete = document.getElementById('cancel-delete');

let maxRowsPerson = document.getElementById('lines-person');
let maxRowsContact = document.getElementById('lines-contact');

let contacts;
let persons;

const registerOverlayPerson = document.getElementById('register-overlay-person');
const registerOverlayContact = document.getElementById('register-overlay-contact');
const nameLabel = document.getElementById('name-label');
const nameInput = document.getElementById('name-input');
const cpfInput = document.getElementById('cpf-input');
const cpfLabel = document.getElementById('cpf-label');
const genderInput = document.getElementById('gender-input');
const typeInput = document.getElementById('type-input');
const contactInput = document.getElementById('contact-input');
const contactLabel = document.getElementById('contact-label');
const search = document.getElementById('person-input');

function restoreInputs(){
    contactInput.style.border = '1px solid black';
    contactLabel.innerHTML = 'Contact';
    typeInput.value = '';
    contactInput.value = '';
    searchPersonsInput.value = '';
    personInput.value = '';

    nameLabel.value = 'Name';
    nameInput.style.border = '1px solid black';
    nameInput.value = '';
    cpfInput.value = '';
    cpfLabel.value = '';
    genderInput.value = '';
}


function renderEditView()
{
    const editView = document.querySelectorAll('.edit-delete .edit');
    const remove = document.querySelectorAll('.edit-delete .delete');

    editView.forEach(button=>{
        button.addEventListener('click',()=>{
            let data = button.closest('article').dataset;
            AppState.isEditing = true;
            AppState.isRegister = false;
            AppState.registerType = data.class;
            AppState.currentId = data.id;
            restoreInputs();

            if (data.class === 'Contact') {
                contactInput.removeAttribute('readonly');
                registerOverlayContact.querySelector('h1').innerHTML = 'Edit Contact'
                registerOverlayContact.style.display = 'flex';
                typeInput.value = data.type;
                contactInput.value = data.contact;

                if (data.person !== 'null') {
                    search.value = data.person;
                }
            }
            else if (data.class === 'Person'){
                registerOverlayPerson.querySelector('h1').innerHTML = 'Edit Person'
                registerOverlayPerson.style.display = 'flex';
                nameInput.value = data.name;
                cpfInput.value = data.cpf;
                genderInput.value = data.gender;
            }
        })
    })

    remove.forEach(button=>{
        button.addEventListener('click',()=>{
            let data = button.closest('article').dataset;
            deleteConfirmOverlay.dataset.id = data.id;
            deleteConfirmOverlay.dataset.class = data.class;
            deleteConfirmOverlay.style.display = 'flex';
        })
    })
}


function createContactColumns(){
    contactbody.innerHTML = '';
    let lastColor = 'gray';

    for (let i = 0; i < maxRowsContact.value; i++) {
        const row = document.createElement('tr');

        if (typeof contacts !== "undefined" && contacts[i]) {
            const data = contacts[i];
            row.innerHTML = `
                <td>${data.id}</td>
                <td>${data.type}</td>
                <td>${data.contact}</td>
                <td>${data.person? `[${data.person.id}] ${data.person.name}` :null}
                <td>
                <article data-id="${data.id}" data-type="${data.type}"
                data-class="Contact" data-contact="${data.contact}" data-person="${data.person? `${data.person.name} - ${data.person.cpf}`: null }" class="edit-delete">
                    <img class="edit edit-button" src="assets/Edit.svg"></img>
                    <img class="delete edit-button" src="assets/Delete.svg"></img>
                </article>
                </td>
            `;
        } else {
            for (let j = 0; j < document.querySelectorAll('.contact-table thead tr th').length; j++) {
                const column = document.createElement('td');
                row.appendChild(column);
            }
        }
        row.style.backgroundColor = lastColor === 'gray' ? '#F2F1EC' : '#D9D9D9';
        lastColor = lastColor === 'gray' ? 'white' : 'gray';
        contactbody.appendChild(row);
    }
    renderEditView();
}


function createPersonColumns(){
    personbody.innerHTML = '';
    let lastColor = 'gray';
    
    for (let i = 0; i < maxRowsPerson.value; i++) {
        const row = document.createElement('tr');

        if (typeof persons !== "undefined" && persons[i]) {
            const data = persons[i];
            row.innerHTML = `
                <td style="text-align:center">${data.id}</td>
                <td>${data.name}</td>
                <td>${data.cpf}</td>
                <td>${data.gender}</td>
                <td>
                <article class="edit-delete" 
                data-class="Person" data-id="${data.id}" data-name="${data.name}" data-cpf=${data.cpf}
                data-gender="${data.gender}">
                <img class="edit edit-button" src="assets/Edit.svg"></img>
                <img class="delete edit-button" src="assets/Delete.svg"></img>
                </article>
                </td>
            `;
        } else {
            for (let j = 0; j < document.querySelectorAll('.person-table thead tr th').length; j++) {
                const column = document.createElement('td');
                row.appendChild(column);
            }
        }

        row.style.backgroundColor = lastColor === 'gray' ? '#F2F1EC' : '#D9D9D9';
        lastColor = lastColor === 'gray' ? 'white' : 'gray';
        personbody.appendChild(row);
    }

    renderEditView();
};

searchContactsSubmit.addEventListener('click',(event)=>{
    event.preventDefault();

    const query = encodeURIComponent(searchContactsInput.value);
    fetch('/scripts/apis/search.php?class=Contact&search='+query)
    .then(data=>{return data.json()})
    .then(data=>{
        if (data) {
            contacts = data;
            createContactColumns();
        } else {
                console.log(data.message);
                console.log('Nenhum contato encontrado.');
        }
    })
    
})

searchPersonsSubmit.addEventListener('click', (event) => {
    event.preventDefault();

    const query = encodeURIComponent(searchPersonsInput.value);

    fetch('/scripts/apis/search.php?class=Person&search='+query)
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                persons = data;
                createPersonColumns();
            } else {
                console.log('Nenhuma pessoa encontrada.');
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
        });

});

cancelDelete.addEventListener('click',()=>{
    deleteConfirmOverlay.style.display = 'none';
});

confirmDelete.addEventListener('click',()=>{
    fetch('/scripts/apis/delete.php',{
        method: 'POST',
        headers: {
            'Content-Type':'application/json'
        },
        body: JSON.stringify({
            class: deleteConfirmOverlay.dataset.class,
            id: deleteConfirmOverlay.dataset.id,
        })
    })
    .then(response=>{return response.json()})
    .then(data=>{
        if (data.success){
            location.reload();
        }
        else {
            alert(data.message)
        }
    })
    .catch(error=>{
        console.log(`Unable to delete the data, error: ${error}`);
    })
});


maxRowsContact.addEventListener('change',()=>{
    createContactColumns();  
});

maxRowsPerson.addEventListener('change',()=>{
    createPersonColumns();
});

addContact.addEventListener('click',()=>{
    restoreInputs();
    AppState.isRegister = true;
    AppState.isEditing = false;
    registerOverlayContact.querySelector('h1').innerHTML = 'Register Contact';
    registerOverlayContact.style.display = 'flex';
});

addPerson.addEventListener('click',()=>{
    restoreInputs();
    AppState.isRegister = true;
    AppState.isEditing = false;
    registerOverlayPerson.querySelector('h1').innerHTML = 'Register Person';
    registerOverlayPerson.style.display = 'flex';
});

fetch('/scripts/apis/get.php')
.then(response=>{return response.json()})
.then(data=>{
    contacts = data['ContactList'];
    persons = data['PersonList'];
    createPersonColumns();
    createContactColumns();
    renderEditView();
})   