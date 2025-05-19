import {CPFFormatted, CPFValidation, GenderValidation, NameValidation, RegisterPersonValidation } from "./authentications.js";

const registerOverlayPerson = document.getElementById('register-overlay-person');

const nameLabel = document.getElementById('name-label');
const nameInput = document.getElementById('name-input');
let validName = false;

const cpfLabel = document.getElementById('cpf-label');
const cpfInput = document.getElementById('cpf-input');
let validCPF = false;

const genderLabel = document.getElementById('gender-label');
const genderInput = document.getElementById('gender-input');
let validGender = false;

const cancelRegisterPerson = document.getElementById('register-person-cancel');
const confirmRegisterPerson = document.getElementById('register-person-confirm');

cancelRegisterPerson.addEventListener('click', () => {
    
    registerOverlayPerson.style.display = 'none';
});

nameInput.addEventListener('blur', () => {
    validName = NameValidation(nameInput,nameLabel);
});

nameInput.addEventListener('focus', () => {
    nameLabel.innerHTML = 'Name';
    nameInput.style.border = '1px solid black';
});

cpfInput.addEventListener('blur', () => {
    validCPF = CPFValidation(cpfInput,cpfLabel);
});

cpfInput.addEventListener('focus', () => {
    cpfLabel.innerHTML = 'CPF';
    cpfInput.style.border = '1px solid black';
});

cpfInput.addEventListener('input',(e)=>{
    CPFFormatted(e);
});


genderInput.addEventListener('blur', () => {
    validGender=GenderValidation(genderInput,genderLabel);
});

genderInput.addEventListener('focus', () => {
    genderLabel.innerHTML = 'Gender';
    genderInput.style.border = '1px solid black';
});

confirmRegisterPerson.addEventListener('click',(event)=>{
    event.preventDefault();
    validName = NameValidation(nameInput, nameLabel);
    validCPF = CPFValidation(cpfInput, cpfLabel);
    validGender = GenderValidation(genderInput, genderLabel);
    RegisterPersonValidation(validCPF,validGender,validName,nameInput,cpfInput,genderInput);
});
