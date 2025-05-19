import {RegisterContactValidation, ContactFormatted, SearchPersons, TypeValidation , ContactValidation, AppState} from "./authentications.js";

const registerOverlayContact = document.getElementById('register-overlay-contact');

const CancelButton = document.getElementById('register-cancel');
const RegisterContact = document.getElementById('register-confirm');

const typeLabel = document.getElementById('type-label');
const typeInput = document.getElementById('type-input');
let validType = false;

const contactLabel = document.getElementById('contact-label');
const contactInput = document.getElementById('contact-input');
let validContact = false;

const cancelRegisterContact = document.getElementById('register-contact-cancel');
const confirmRegisterContact = document.getElementById('register-contact-confirm');

const search = document.getElementById('person-input');

cancelRegisterContact.addEventListener('click',()=>{
    contactInput.setAttribute('readonly',true);
    registerOverlayContact.style.display = 'none';
});

typeInput.addEventListener('change',()=>{
    contactInput.value = '';
    validType = TypeValidation(typeInput,contactInput);
});

contactInput.addEventListener('blur', () => {
    validContact = ContactValidation(typeInput,contactInput,contactLabel);
});

contactInput.addEventListener('focus', () => {
    contactLabel.innerHTML = 'Contact';
    contactInput.style.border = '1px solid black';
});

contactInput.addEventListener('input',(e)=>{
    ContactFormatted(typeInput,e);
})

search.addEventListener('input', (e) => {
    SearchPersons(search,e);
});

confirmRegisterContact.addEventListener('click',(event)=>{
    event.preventDefault();
    validType = TypeValidation(typeInput,contactInput);
    validContact = ContactValidation(typeInput,contactInput,contactLabel);
    RegisterContactValidation(validType,validContact,typeInput,contactInput,search);
    
})