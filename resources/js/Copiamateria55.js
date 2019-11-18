var materiaTemplate = `
<tr>
<td>{{NOMBRE}}</td>
<td>{{CREDITOS}}</td>
<td><button id="editar-{{ID}}" class ="btn btn-warning">Editar</button> |
    <button onclick="eliminar({{ID}})" class ="btn btn-danger">Eliminar</button>
</td>
</tr>
`


function buscarMateria(){
    fetch("/materia.php")
    .then( res=> res.json())
    .then( res=>{
        var listaM = document.getElementById('list_materia')
        var temp = '';
        res.forEach(m => {
            temp = temp+materiaTemplate.replace(/{{NOMBRE}}/, m.nombre) 
            .replace(/{{CREDITOS}}/, m.creditos)
            .replace(/{{ID}}/g, m.id)            
        });
        listaM.innerHTML = temp;
    })
    .catch( err => {
        console.log(err);
    });
}

function guardar(){
    // Se debe llamar el metodo guardar del API

}

function eliminar(id){
    fetch("/materia.php?id=${id}&metodo=DELETE")

    //con todo su proceso de fetch
    // Se debe llamar el metodo eliminar del API
alert(`Eliminar la materia ${id}`);
}

window.onload = function (){
    buscarMateria();
}