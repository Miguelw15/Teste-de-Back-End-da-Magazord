const CancelButton = document.getElementById('register-cancel');
const RegisterContact = document.getElementById('register-confirm');

const nameLabel = document.getElementById('name-label');
const nameInput = document.getElementById('name-input');

const cpfLabel = document.getElementById('cpf-label');
const cpfInput = document.getElementById('cpf-input');

const genderLabel = document.getElementById('gender-label');
const genderInput = document.getElementById('gender-input');

// Cancelar e voltar para a página inicial
CancelButton.addEventListener('click', () => {
    window.location.href = '../index.html';
});

// ==== NAME VALIDATION ====
nameInput.addEventListener('blur', () => {
    const nameRegex = /^[a-zA-ZÀ-Öà-ö]{2,100}\s[a-zA-ZÀ-Öà-ö]{2,100}$/;
    if (!nameRegex.test(nameInput.value) && nameInput.value !== "") {
        nameInput.style.border = '1px solid red';
        nameLabel.innerHTML = 'Name (Invalid Format!)';
    } else {
        nameInput.style.border = '1px solid black';
        nameLabel.innerHTML = 'Name';
    }
});

nameInput.addEventListener('focus', () => {
    nameLabel.innerHTML = 'Name';
    nameInput.style.border = '1px solid black';
});

// ==== CPF VALIDATION ====
cpfInput.addEventListener('blur', () => {
    const cpfRegex = /^\d{3}\.\d{3}\.\d{3}\-\d{2}$/; // Ex: 123.456.789-00
    if (!cpfRegex.test(cpfInput.value) && cpfInput.value !== "") {
        cpfInput.style.border = '1px solid red';
        cpfLabel.innerHTML = 'CPF (Invalid Format!)';
    } else {
        cpfInput.style.border = '1px solid black';
        cpfLabel.innerHTML = 'CPF';
    }
});

cpfInput.addEventListener('focus', () => {
    cpfLabel.innerHTML = 'CPF';
    cpfInput.style.border = '1px solid black';
});

// ==== GENDER VALIDATION ====
genderInput.addEventListener('blur', () => {
    const genderRegex = /^(Masculino|Feminino)$/i;
    if (!genderRegex.test(genderInput.value) && genderInput.value !== "") {
        genderInput.style.border = '1px solid red';
        genderLabel.innerHTML = 'Gender (Invalid: Use "Masculino" or "Feminino")';
    } else {
        genderInput.style.border = '1px solid black';
        genderLabel.innerHTML = 'Gender';
    }
});

genderInput.addEventListener('focus', () => {
    genderLabel.innerHTML = 'Gender';
    genderInput.style.border = '1px solid black';
});
