

var carreraTemplate = `
    <tr id="row-carrera-{{ID}}">
    <td>{{NOMBRE}}</td>
     <td>
        <button id="editar-{{ID}}" onclick='editar({{ID}})' data-carrera='{{DATA}}' class="btn btn-warning">Editar</button> | 
        <button onclick="eliminar({{ID}})" class="btn btn-danger">Eliminar</button>
    </td>
    </tr>
`
var selectTemplate='<option value=="{{ID}}">{{NOMBRE}}</option>';

function buscarcarrera() {
    fetch("/carrera.php")
        .then( res => res.json())
        .then( res => {
            var listaM = document.getElementById('list_carrera');
            var listaMa = document.getElementById('lista_carreras');
            var temp = '';
            var tempo = '';

            res.forEach(m => {
                temp = temp + carreraTemplate.replace(/{{NOMBRE}}/, m.nombre)
                    .replace(/{{ID}}/g, m.id)
                    .replace(/{{DATA}}/, JSON.stringify(m));
            
                tempo= tempo + selectTemplate.replace(/{{NOMBRE}}/, m.nombre)
                    .replace(/{{ID}}/g, m.id)
                    .replace(/{{DATA}}/, JSON.stringify(m));

            });
            listaM.innerHTML = temp;
            listaMa.innerHTML = tempo;
        })
        .catch( err => {
            console.log(err);
        });
}

var carrera = null;

function guardar(){

    nombre = document.getElementById("nombre").value;
    
    var nueva = true;
    if (carrera != null && carrera.id ){
        nueva = false;
        var btnEditar = document.getElementById("editar-"+carrera.id);
    } else {
        carrera = {};
    }

    carrera.nombre = nombre;
    console.log(carrera);
   
    if (nueva == false) {
        btnEditar.dataset.carrera = JSON.stringify(carrera);
    }

   fetch('/carrera.php'+(nueva ? '' : `?id=${carrera.id}`), {
        method: (nueva ? 'POST' : 'PUT'),
        body: JSON.stringify(carrera),
        headers: {
            'Content-Type': 'application/json'
          }
    })
    .then( res => res.json())
    .then( res => {
        console.log(res);
    })
    .catch( err => {
        console.log(err);
    });


    carrera = null;
    document.getElementById("nombre").value="";
    buscarcarrera();
}

function editar(id){
    var btnEditar = document.getElementById("editar-"+id);

    var data = btnEditar.dataset.carrera;
    carrera = JSON.parse(data);

    document.getElementById("nombre").value = carrera.nombre;
    this.buscarcarrera();
    buscarcarrera();
}

function eliminar(id){
    fetch(`/carrera.php?id=${id}`, {
        method: 'DELETE'
    })
    .then( res => res.json())
    .then( res => {
        var row = document.getElementById("row-carrera-"+id).rowIndex;

        document.getElementById('tabla_carreras').deleteRow(row);
        console.log(res);
    })
    .catch( err => {
        console.log(err);
    });
    
    buscarcarrera();
}


window.onload = function(){
    buscarcarrera();

    document.getElementById("guardarCarrera")
    .addEventListener("click", guardar);

    
}
