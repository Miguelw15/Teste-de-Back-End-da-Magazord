const CancelButton = document.getElementById('register-cancel');
const RegisterContact = document.getElementById('register-confirm');

const typeLabel = document.getElementById('type-label');
const typeInput = document.getElementById('type-input');
let validType = false;

const contactLabel = document.getElementById('contact-label');
const contactInput = document.getElementById('contact-input');
const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
const phoneRegex = /^\(\d{2}\)\s?\d{4,5}-\d{4}$/
let validContact = false;

const search = document.getElementById('person-input');

CancelButton.addEventListener('click',()=>{
    window.location.href = '../index.php';
    console.log('Clicou')
});

typeInput.addEventListener('change',()=>{
    contactInput.value = '';
    if (typeInput.value === 'Phone'){
        contactInput.placeholder = '(XX) XXXXX-XXXX';
        contactInput.readOnly= false; 
        validType = true;
    }
    else if (typeInput.value === 'Email'){
        contactInput.placeholder = 'ExempleEmail@gmail.com';
        contactInput.readOnly= false; 
        validType= true;
    }
    else {
        contactInput.placeholder = 'Select the type';
        contactInput.readOnly= true; 
        validType = false;
    }
});

contactInput.addEventListener('blur', () => {
    
    if (typeInput.value === 'Phone' && phoneRegex.test(contactInput.value) && contactInput.value !== "") {
        validContact = true;
        contactInput.style.border = '1px solid black';
        contactLabel.innerHTML = 'Contact';
    } 
    else if (typeInput.value === 'Email' && emailRegex.test(contactInput.value) && contactInput.value !== "") {
        validContact = true;
        contactInput.style.border = '1px solid black';
        contactLabel.innerHTML = 'Contact';
    }
    else{
        validContact = false;
        contactInput.style.border = '1px solid red';
        contactLabel.innerHTML = 'Contact (Invalid Format!)';
    }
});

contactInput.addEventListener('focus', () => {
    contactLabel.innerHTML = 'Contact';
    contactInput.style.border = '1px solid black';
});

contactInput.addEventListener('input',(e)=>{
    if (typeInput.value === 'Phone'){
        let value = e.target.value.replace(/\D/g, ""); 

        if (value.length > 11) value = value.slice(0, 11);

        let formatted = "";

        if (value.length > 0) formatted += "(" + value.substring(0, 2);
        if (value.length >= 3) formatted += ") " + value.substring(2, 7);
        if (value.length >= 8) formatted += "-" + value.substring(7);

        e.target.value = formatted;

    }

})

search.addEventListener('input', (element) => {
    const query = element.target.value;

    fetch('/scripts/apis/search.php?class=Person&search=' + encodeURIComponent(query))
        .then(data => { return data.json() })
        .then(data => {
            const datalist = document.getElementById('person-datalist');
            datalist.innerHTML = '';

            if (data.length > 0) {
                data.forEach(item => {
                    const option = document.createElement('option');
                    search.dataset.id = item.id;
                    search.dataset.name = item.name;
                    search.dataset.cpf = item.cpf;
                    search.dataset.gender = item.gender;
                    option.value = ` ${item.name} - ${item.cpf}`;
                    datalist.appendChild(option);
                });
            }
        });
});

RegisterContact.addEventListener('click',(event)=>{
    event.preventDefault();
    console.log(contactInput.value);
    if (validType && validContact){
        fetch('/scripts/apis/registerContact.php',{
            method: 'POST',
            headers: {
                'Content-Type':'application/json'
            },
            body: JSON.stringify({
                type: typeInput.value,
                contact: contactInput.value,
                person: search.value,
            })
        })
        .then(response=>{return response.json()})
        .then(data=>{
            if (data.sucess!=true){
                alert(data.message);
            }
            else {
                alert(data.message);
                window.location.href= "/../index.php";
            }
        })
        .catch(error=>{
            console.log('Erro na requisição: ', error)
        })
    }
})