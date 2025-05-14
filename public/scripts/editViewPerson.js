const params = new URLSearchParams(window.location.search);
const id = params.get('id');
const name = params.get('name');
const cpf = params.get('cpf');

console.log(id,name,cpf)