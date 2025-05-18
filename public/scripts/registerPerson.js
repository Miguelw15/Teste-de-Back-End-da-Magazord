const CancelButton = document.getElementById('register-cancel');
const RegisterPerson = document.getElementById('register-confirm');

const nameLabel = document.getElementById('name-label');
const nameInput = document.getElementById('name-input');
let validName = false;

const cpfLabel = document.getElementById('cpf-label');
const cpfInput = document.getElementById('cpf-input');
let validCPF = false;

const genderLabel = document.getElementById('gender-label');
const genderInput = document.getElementById('gender-input');
let validGender = false;

CancelButton.addEventListener('click', () => {
    window.location.href = '../index.html';
});

// ==== NAME VALIDATION ==== //
nameInput.addEventListener('blur', () => {
    const nameRegex = /^[a-zA-ZÀ-Öà-ö]{2,100}\s[a-zA-ZÀ-Öà-ö]{2,100}$/;
    if (!nameRegex.test(nameInput.value) && nameInput.value !== "") {
        validName = false
        nameInput.style.border = '1px solid red';
        nameLabel.innerHTML = 'Name (Invalid Format!)';
    } else {
        validName = true
        nameInput.style.border = '1px solid black';
        nameLabel.innerHTML = 'Name';
    }
});

nameInput.addEventListener('focus', () => {
    nameLabel.innerHTML = 'Name';
    nameInput.style.border = '1px solid black';
});

// ==== CPF VALIDATION ==== //
cpfInput.addEventListener('blur', () => {
    const cpfRegex = /^\d{3}\.\d{3}\.\d{3}\-\d{2}$/; 
    if (!cpfRegex.test(cpfInput.value) && cpfInput.value !== "") {
        validCPF = false;
        cpfInput.style.border = '1px solid red';
        cpfLabel.innerHTML = 'CPF (Invalid Format!)';
    } else {
        validCPF = true;
        cpfInput.style.border = '1px solid black';
        cpfLabel.innerHTML = 'CPF';
    }
});

cpfInput.addEventListener('focus', () => {
    cpfLabel.innerHTML = 'CPF';
    cpfInput.style.border = '1px solid black';
});

cpfInput.addEventListener('input',(e)=>{
    let value = e.target.value.replace(/\D/g, "");

    if (value.length > 11) value = value.slice(0, 11); 

    let formatted = '';

    if (value.length > 0) formatted += value.substring(0, 3);
    if (value.length > 3) formatted += '.' + value.substring(3, 6);
    if (value.length > 6) formatted += '.' + value.substring(6, 9);
    if (value.length > 9) formatted += '-' + value.substring(9, 11);

    e.target.value = formatted;
});


// === GENDER VALIDATION === //
genderInput.addEventListener('blur', () => {
    const genderRegex = /^(Male|Female|Other)$/i;
    if (!genderRegex.test(genderInput.value) && genderInput.value !== "") {
        validGender = false;
        genderInput.style.border = '1px solid red';
    } else {
        validGender = true;
        genderInput.style.border = '1px solid black';
        genderLabel.innerHTML = 'Gender';
    }
});

genderInput.addEventListener('focus', () => {
    genderLabel.innerHTML = 'Gender';
    genderInput.style.border = '1px solid black';
});

RegisterPerson.addEventListener('click',(event)=>{
    event.preventDefault();
    if (validCPF&&validGender&&validName){
        console.log(nameInput.value,cpfInput.value,genderInput.value)
        fetch('/scripts/apis/registerPerson.php',{
            method: 'POST',
            headers: {
                'Content-Type':'application/json'
            },
            body: JSON.stringify({
                name: nameInput.value,
                cpf: cpfInput.value,
                gender: genderInput.value,
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
});
