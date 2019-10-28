var url = 'http://192.168.56.101/carrera.php';
# var data = {username: 'example'};
var data { 	nombre: 'DELMIRA LUNA', matricula: '200222333', edad: '35', carrera_id: '1'}

fetch(url, {
  method: 'POST', // or 'PUT'
  body: JSON.stringify(data), // data can be `string` or {object}!
  headers:{
    'Content-Type': 'application/json'
  }
}).then(res => res.json())
.catch(error => console.error('Error:', error))
.then(response => console.log('Success:', response));