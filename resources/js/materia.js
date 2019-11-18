

var materiaTemplate = `
    <tr id="row-materia-{{ID}}">
    <td>{{NOMBRE}}</td>
    <td>{{CREDITOS}}</td>
    <td>
        <button id="editar-{{ID}}" onclick='editar({{ID}})' data-materia='{{DATA}}' class="btn btn-warning">Editar</button> | 
        <button onclick="eliminar({{ID}})" class="btn btn-danger">Eliminar</button>
    </td>
    </tr>
`

function buscarMateria() {
    fetch("/materia.php")
        .then( res => res.json())
        .then( res => {
            var listaM = document.getElementById('list_materia');
            var temp = '';
            res.forEach(m => {
                temp = temp + materiaTemplate.replace(/{{NOMBRE}}/, m.nombre)
                    .replace(/{{CREDITOS}}/, m.creditos)
                    .replace(/{{ID}}/g, m.id)
                    .replace(/{{DATA}}/, JSON.stringify(m));

            });
            listaM.innerHTML = temp;
        })
        .catch( err => {
            console.log(err);
        });
}

var materia = null;

function guardar(){

    nombre = document.getElementById("nombre").value;
    creditos = document.getElementById("creditos").value;

    var nueva = true;
    if (materia != null && materia.id ){
        nueva = false;
        var btnEditar = document.getElementById("editar-"+materia.id);
    } else {
        materia = {};
    }

    materia.nombre = nombre;
    materia.creditos = creditos;
    console.log(materia);
   
    if (nueva == false) {
        btnEditar.dataset.materia = JSON.stringify(materia);
    }

   fetch('/materia.php'+(nueva ? '' : `?id=${materia.id}`), {
        method: (nueva ? 'POST' : 'PUT'),
        body: JSON.stringify(materia),
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


    materia = null;
    document.getElementById("nombre").value="";
    document.getElementById("creditos").value="";
    buscarMateria();
}

function editar(id){

    var btnEditar = document.getElementById("editar-"+id);

    var data = btnEditar.dataset.materia;
    materia = JSON.parse(data);

    document.getElementById("nombre").value = materia.nombre;
    document.getElementById("creditos").value = materia.creditos;
    this.buscarMateria();
    buscarMateria();
}

function eliminar(id){
    fetch(`/materia.php?id=${id}`, {
        method: 'DELETE'
    })
    .then( res => res.json())
    .then( res => {
        var row = document.getElementById("row-materia-"+id).rowIndex;

        document.getElementById('tabla_materias').deleteRow(row);
        console.log(res);
    })
    .catch( err => {
        console.log(err);
    });
    
    buscarMateria();
}


window.onload = function(){
    buscarMateria();

    document.getElementById("guardarMateria")
    .addEventListener("click", guardar);

    
}
