
const personbody = document.querySelector('#person-table tbody');
const contactbody = document.querySelector('#contact-table tbody');
const addContact = document.getElementById('add-contact');
const addPerson = document.getElementById('add-person');
let maxRows = document.getElementById('lines');

function ucfirst(str) {
    if (str.length === 0) return str; // Evita erro se a string estiver vazia
    return str.charAt(0).toUpperCase() + str.slice(1);
}
function renderEditView()
{
const editView = document.querySelectorAll('.edit-view');
editView.forEach(button=>{

    button.addEventListener('click',()=>{
        const data = button.dataset.id;
        console.log(data);
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
                <td>${ucfirst(data.type)}</td>
                <td>${data.content}</td>
                <td>
                <article data-id="${data.id}" data-type="${data.type}"
                data-content="${data.content}" class="edit-view"
                style="display: flex; align-items:center; 
                justify-content: center;">
                <img src="assets/Edit.svg" style="width:30px;height:30px"></img>
                </article>
                </td>
            `;
        } else {
            for (let j = 0; j < document.querySelectorAll('#contact-table thead tr th').length; j++) {
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
                <article class="edit-view" 
                data-id="${data.id}" data-name="${data.name}"
                data-cpf=${data.cpf}>
                    <img style="width: 30px; height: 30px;" src="assets/Edit.svg"></img>
                </article>
                </td>
            `;
        } else {
            for (let j = 0; j < document.querySelectorAll('#person-table thead tr th').length; j++) {
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