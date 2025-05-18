const personbody = document.querySelector('.person-table tbody');
const contactbody = document.querySelector('.contact-table tbody');

const addContact = document.getElementById('add-contact');
const addPerson = document.getElementById('add-person');

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
 

function renderEditView()
{
    const editView = document.querySelectorAll('.edit-delete .edit');
    const remove = document.querySelectorAll('.edit-delete .delete');

    editView.forEach(button=>{
        button.addEventListener('click',()=>{
            data = button.closest('article').dataset;
            window.location.href = `/templates/editView.html?class=${data.class}&id=${data.id}`
        })
    })

    remove.forEach(button=>{
        button.addEventListener('click',()=>{
            data = button.closest('article').dataset;
            data.id = button.closest('article').dataset.id;
            data.class = button.closest('article').dataset.class;
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
                <td>${data.person? `[${data.person.id}] ${data.person.name}` : 'NULL'}
                <td>
                <article data-id="${data.id}" data-type="${data.type}"
                data-class="Contact" data-contact="${data.contact}" class="edit-delete">
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
                data-class="Person" data-id="${data.id}" data-name="${data.name}" data-cpf=${data.cpf}>
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
        console.log(data.message);
        location.reload();
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
    window.location.href = "../templates/registerContact.html";
});
addPerson.addEventListener('click',()=>{
    window.location.href = "../templates/registerPerson.html";
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