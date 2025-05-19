const AppState = {
  isEditing: false,
  editType: null,
  currentId: null, 
  isRegister: false,
  registerType: null,
};



// ================= CONTACT VALIDATION ================= //
const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const phoneRegex = /^\(\d{2}\)\s?\d{4,5}-\d{4}$/;

function ContactFormatted(typeInput,event){
    if (typeInput.value === 'Phone'){
        let value = event.target.value.replace(/\D/g, ""); 

        if (value.length > 11) value = value.slice(0, 11);

        let formatted = "";

        if (value.length > 0) formatted += "(" + value.substring(0, 2);
        if (value.length >= 3) formatted += ") " + value.substring(2, 7);
        if (value.length >= 8) formatted += "-" + value.substring(7);

        event.target.value = formatted;
    }
}

function TypeValidation(typeInput,contactInput){
    if (typeInput.value === 'Phone')
    {
        contactInput.placeholder = '(XX) XXXXX-XXXX';
        contactInput.readOnly= false; 
        return true;
    }
    else if (typeInput.value === 'Email')
    {
        contactInput.placeholder = 'ExempleEmail@gmail.com';
        contactInput.readOnly= false; 
        return true;
    }
    else 
    {
        contactInput.placeholder = 'Select the type';
        contactInput.readOnly= true; 
        return false;
    }

}
function ContactValidation(typeInput,contactInput,contactLabel){
    if (typeInput.value === 'Phone' && phoneRegex.test(contactInput.value) && contactInput.value !== "") {
        contactInput.style.border = '1px solid black';
        contactLabel.innerHTML = 'Contact';
        return true;
    } 
    else if (typeInput.value === 'Email' && emailRegex.test(contactInput.value) && contactInput.value !== "") {
        contactInput.style.border = '1px solid black';
        contactLabel.innerHTML = 'Contact';
        return true;
    }
    else{
        contactInput.style.border = '1px solid red';
        contactLabel.innerHTML = 'Contact (Invalid Format!)';
        return false;
    }
}

function SearchPersons(search,element){
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
        })
        .catch(error=>{
            console.log('Error: ', error);
        });
}


function RegisterContactValidation(validType,validContact,typeInput,contactInput,search){
    if (validType && validContact){
        if (AppState.isRegister){
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
                if (data.success!=true){
                    alert(data.message);
                }
                else {
                    location.reload();
                    alert(data.message);
                }
            })
            .catch(error=>{
                console.log('Erro na requisição: ', error)
            })
        }
        else if (AppState.isEditing) {
            fetch('/scripts/apis/update.php',{
                method: 'POST',
                headers: {'ContentType':'application/json'},
                body: JSON.stringify({
                    class: AppState.registerType,
                    id: AppState.currentId,
                    type: typeInput.value,
                    contact: contactInput.value,
                    person: search.value,
                    
                })
            })
            .then(response=>{return response.json()})
            .then(data=>{
                if (data.success){
                    location.reload();
                    alert(data.message);
                }
                else {
                    alert(data.message

                    );
                }

            })
            .catch(error=>{

                alert('catch'+error);
            })
        }
    }
}
// ================= PERSON VALIDATION ================= //
const nameRegex = /^[a-zA-ZÀ-Öà-ö]{2,100}\s[a-zA-ZÀ-Öà-ö]{2,100}$/;
const cpfRegex = /^\d{3}\.\d{3}\.\d{3}\-\d{2}$/; 
const genderRegex = /^(Male|Female|Other)$/i;

function GenderValidation(genderInput,genderLabel){
    if (!genderRegex.test(genderInput.value) && genderInput.value !== "") {
        genderInput.style.border = '1px solid red';
        return false;
    } else {
        genderInput.style.border = '1px solid black';
        genderLabel.innerHTML = 'Gender';
        return true;
    }
}

function CPFValidation(cpfInput,cpfLabel){
    if (!cpfRegex.test(cpfInput.value) && cpfInput.value !== "") {
        cpfInput.style.border = '1px solid red';
        cpfLabel.innerHTML = 'CPF (Invalid Format!)';
        return false;
    } 
    else {
        cpfInput.style.border = '1px solid black';
        cpfLabel.innerHTML = 'CPF';
        return true;
    }
}

function CPFFormatted(e){
    
    let value = e.target.value.replace(/\D/g, "");

    if (value.length > 11) value = value.slice(0, 11); 

    let formatted = '';

    if (value.length > 0) formatted += value.substring(0, 3);
    if (value.length > 3) formatted += '.' + value.substring(3, 6);
    if (value.length > 6) formatted += '.' + value.substring(6, 9);
    if (value.length > 9) formatted += '-' + value.substring(9, 11);

    e.target.value = formatted;
}
function NameValidation(nameInput,nameLabel){
    if (!nameRegex.test(nameInput.value) && nameInput.value !== "") {
        nameInput.style.border = '1px solid red';
        nameLabel.innerHTML = 'Name (Invalid Format!)';
        return false;
    } else { 
        nameInput.style.border = '1px solid black';
        nameLabel.innerHTML = 'Name';
        return true;
    }
}
function RegisterPersonValidation(validCPF,validGender,validName,nameInput,cpfInput,genderInput){
    if (validCPF&&validGender&&validName){
        if (AppState.isRegister){
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
                if (data.success!==true){
                    alert(data.message);
                }
                else {
                    alert(data.message);
                    location.reload();
                }
            })
            .catch(error=>{
                console.log('Erro na requisição: ', error)
            })
        }
        else if (AppState.isEditing) {
            fetch('/scripts/apis/update.php',{
                method: 'POST',
                headers: {'ContentType':'application/json'},
                body: JSON.stringify({
                    class: AppState.registerType,
                    id: AppState.currentId,
                    name: nameInput.value,
                    cpf: cpfInput.value,
                    gender: genderInput.value,
                })
            })
            .then(response=>{return response.json()})
            .then(data=>{
                if (data.success){
                    location.reload();
                    alert(data.message);
                }
                else {
                    alert(data.message);
                }
            })
            .catch(error=>{
                alert(error);
            })
        }
    }
}

export {
    TypeValidation,
    ContactValidation,
    ContactFormatted,
    SearchPersons,
    RegisterContactValidation,
    CPFValidation,
    CPFFormatted,
    NameValidation,
    GenderValidation,
    RegisterPersonValidation,
    AppState
};