const CancelButton = document.getElementById('register-cancel');
const RegisterContact = document.getElementById('register-confirm');

const typeLabel = document.getElementById('type-label');
const typeInput = document.getElementById('type-input');

const contactLabel = document.getElementById('contact-label');
const contactInput = document.getElementById('contact-input');

const search = document.getElementById('person-search');

CancelButton.addEventListener('click',()=>{
    window.location.href = '../index.html';
    console.log('Clicou')
});

typeInput.addEventListener('change',()=>{
    if (typeInput.value === 'Phone'){
        contactInput.placeholder = '(XX) XXXXX-XXXX';
        contactInput.readOnly= false; 
    }
    else if (typeInput.value === 'Email'){
        contactInput.placeholder = 'ExempleEmail@gmail.com';
        contactInput.readOnly= false; 
    }
    else {
        contactInput.placeholder = 'Select the type';
        contactInput.readOnly= true; 
    }
});

search.addEventListener('input',(element)=>{
    const query = element.target.value;

    fetch('/../scripts/search.php?q=' + encodeURIComponent(query))
    .then(response => response.json())
    .then(data => {
        const datalist = document.getElementById('person-datalist');
        datalist.innerHTML = '',
        
        data.forEach(item=>{
            const option = document.createElement('option');
            option.value = `[${item.id}] ${item.name} - ${item.cpf}`;
            datalist.appendChild(option);
        })
    })
})
