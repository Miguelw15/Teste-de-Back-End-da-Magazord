
const personbody = document.querySelector('.person-table tbody');
const contactbody = document.querySelector('.contact-table tbody');
const addContact = document.querySelector('.add-contact');
const addPerson = document.querySelector('.add-person');
let maxRows = document.getElementById('lines');

function renderEditView()
{
    const editView = document.querySelectorAll('.edit-delete .edit');
    const remove = document.querySelectorAll('.edit-delete .delete');

    editView.forEach(button=>{
        button.addEventListener('click',()=>{
            const data = button.closest('article').dataset;
            window.location.href = `../templates/editView.html?id${data.id}&name=${encodeURIComponent(data.name)}&cpf=${data.cpf}`
        })
    })

    remove.forEach(button=>{
        button.addEventListener('click',()=>{
            
        })
    })
}


function createContactColumns(){
    contactbody.innerHTML = '';
    let lastColor = 'gray';

    for (let i = 0; i < maxRows.value; i++) {
        const row = document.createElement('tr');

        if (typeof contacts !== "undefined" && contacts[i]) {
            const data = contacts[i];
            row.innerHTML = `
                <td>${data.id}</td>
                <td>${data.type}</td>
                <td>${data.contact}</td>
                <td>
                <article data-id="${data.id}" data-type="${data.type}"
                data-contact="${data.contact}" class="edit-delete">
                    <img class="edit" src="assets/Edit.svg"></img>
                    <img class="delete" src="assets/Delete.svg"></img>
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
}


function createPersonColumns(){
    personbody.innerHTML = '';
    let lastColor = 'gray';
    
    for (let i = 0; i < maxRows.value; i++) {
        const row = document.createElement('tr');

        if (typeof persons !== "undefined" && persons[i]) {
            const data = persons[i];
            row.innerHTML = `
                <td style="text-align:center">${data.id}</td>
                <td>${data.name}</td>
                <td>${data.cpf}</td>
                <td>${data.gender}</td>
                <td style="text-align: center">
                <article class="edit-delete" 
                data-id="${data.id}" data-name="${data.name}" data-cpf=${data.cpf}>
                <img class="edit" src="assets/Edit.svg"></img>
                <img class="delete" src="assets/Delete.svg"></img>
                </article>
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

};



maxRows.addEventListener('change',()=>{

    createPersonColumns();
    createContactColumns();  
    renderEditView();

});

addContact.addEventListener('click',()=>{
    window.location.href = "../templates/registerContact.html";
});
addPerson.addEventListener('click',()=>{
    window.location.href = "../templates/registerPerson.html";
});

createPersonColumns();
createContactColumns();
renderEditView();