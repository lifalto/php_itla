

var estudianteTemplate = `
    <tr id="row-estudiante-{{ID}}">
    <td>{{NOMBRE}}</td>
    <td>{{MATRICULA}}</td>
    <td>{{EDAD}}</td>
    <td>{{CARRERA_ID}}</td>
    <td>{{CARRERA}}</td>
     <td>
        <button id="editar-{{ID}}" onclick='editar({{ID}})' data-estudiante='{{DATA}}' class="btn btn-warning">Editar</button> | 
        <button onclick="eliminar({{ID}})" class="btn btn-danger">Eliminar</button>
    </td>
    </tr>
`
var selectTemplate='<option value=="{{ID}}">{{NOMBRE}}</option>';

function myFunction() {
    //   var x= document.getElementById("lista_carreras").options.selectedIndex;
    //  document.getElementById("demo").innerHTML = x;
            // y.querySelectorAll
    // var y=document.getElementById("lista_carreras");
    // // y.selectedIndex='1'; FUNCIONA
    // y.selectedIndex=i;

                var select = document.getElementById("lista_carreras");
                var currentOpt = select.options[select.selectedIndex]; 
                console.log(currentOpt.text);

    //   document.getElementById("2").selected = "true";
    
    }


function buscaCarrera() {
    fetch("/carrera.php")
        .then( res => res.json())
        .then( res => {
            var listaMa = document.getElementById('lista_carreras');
            var tempo = '';
            tempo = tempo + '<option value==" "> </option>';

            res.forEach(m => {         
                tempo= tempo + selectTemplate.replace(/{{NOMBRE}}/, m.nombre)
                    .replace(/{{ID}}/g, m.id)
                    .replace(/{{DATA}}/, JSON.stringify(m));

            });
            listaMa.innerHTML = tempo;
        })
        .catch( err => {
            console.log(err);
        });
}


function buscarestudiante() {
    fetch("/estudiante.php")
        .then( res => res.json())
        .then( res => {
            var listaM = document.getElementById('list_estudiante');
            var listaC = document.getElementById('lista_carreras');
            var temp = '';
            
            res.forEach(m => {
                temp = temp + estudianteTemplate.replace(/{{NOMBRE}}/, m.nombre)
                    .replace(/{{MATRICULA}}/, m.matricula)
                    .replace(/{{EDAD}}/, m.edad)
                    .replace(/{{CARRERA_ID}}/, m.carrera_id)
                    .replace(/{{CARRERA}}/, m.carrera)
                    .replace(/{{ID}}/g, m.id)
                    .replace(/{{DATA}}/, JSON.stringify(m));
            
                
            });
            listaM.innerHTML = temp;
           // listaC.selectedIndex='-1';
        })
        .catch( err => {
            console.log(err);
        });

        buscaCarrera();
}

var estudiante = null;

function guardar(){

    nombre = document.getElementById("nombre").value;
    matricula = document.getElementById("matricula").value;
    edad = document.getElementById("edad").value;
    carrera_id = document.getElementById("lista_carreras").value;
    console.log(carrera_id);
    
    var nueva = true;
    if (estudiante != null && estudiante.id ){
        nueva = false;
        var btnEditar = document.getElementById("editar-"+estudiante.id);
    } else {
        estudiante = {};
    }

    estudiante.nombre = nombre;
    estudiante.matricula = matricula;
    estudiante.edad = edad;
    estudiante.carrera_id = carrera_id;

    console.log(estudiante);
   
    if (nueva == false) {
        btnEditar.dataset.estudiante = JSON.stringify(estudiante);
    }

   fetch('/estudiante.php'+(nueva ? '' : `?id=${estudiante.id}`), {
        method: (nueva ? 'POST' : 'PUT'),
        body: JSON.stringify(estudiante),
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


    estudiante = null;
    document.getElementById("nombre").value="";
    document.getElementById("matricula").value="";
    document.getElementById("edad").value="";
    document.getElementById("lista_carreras").value="";



    buscarestudiante();
}

                    function setSelectedIndex(s, i)
                    {        s.options[i-1].selected = true;
                             return;
                    }


function editar(id){
    var btnEditar = document.getElementById("editar-"+id);

    var data = btnEditar.dataset.estudiante;
    estudiante = JSON.parse(data);

    document.getElementById("nombre").value = estudiante.nombre;
    document.getElementById("matricula").value = estudiante.matricula;
    document.getElementById("edad").value = estudiante.edad;
  //  document.getElementById("carrera_id").value = estudiante.carrera_id;
   // document.getElementById("carrera").value = estudiante.carrera;

//    var y=document.getElementById("lista_carreras");
//    y.selectedIndex='1';

   // document.getElementById("lista_carreras").value = "DERECHO";

//     var lc= document.getElementById("lista_carreras");
//     lc.options[0].text = estudiante.carrera;

        var sel = document.getElementById('lista_carreras');
         for(var i = 0, j = sel.options.length; i < j; ++i) {
// //         console.log( sel.options[i].value );
// //         console.log( sel.options[i].text );
// //         console.log( estudiante.carrera_id);
// //         console.log( estudiante.carrera);
           if(sel.options[i].text === estudiante.carrera) {
            console.log(i);


                var select = document.getElementById("lista_carreras");
               // var currentOpt = select.options[select.selectedIndex];
               // var currentOpt = select.options['1'];
                select.selectedIndex= i;
                console.log(currentOpt.text);


            // var y=document.getElementById("lista_carreras");
            // y.selectedIndex='1';
           // sel.options[i].selected = true;
            //sel.selectedIndex= '2';
//             // sel.options[i].text = estudiante.carrera;
           }
        }
                    
                    

//                     setSelectedIndex(document.getElementById("lista_carreras"),3);
                   



//             //document.querySelector('#lista_carreras').options[i].selected = true;
//            // document.querySelector('#lista_carreras').value = estudiante.carrera_id;
//             console.log( sel.value );
//             console.log( sel.options[sel.selectedIndex].value);
//             console.log( sel.options[sel.selectedIndex].text );
//             break;
     //}
      

//        sel.addEventListener('change', function() {
//         var index = sel.selectedIndex;
        
//            })
//    }

    this.buscarestudiante();
    buscarestudiante();
}

function eliminar(id){
    fetch(`/estudiante.php?id=${id}`, {
        method: 'DELETE'
    })
    .then( res => res.json())
    .then( res => {
        var row = document.getElementById("row-estudiante-"+id).rowIndex;

        document.getElementById('tabla_estudiantes').deleteRow(row);
        console.log(res);
    })
    .catch( err => {
        console.log(err);
    });
    
    buscarestudiante();
}



window.onload = function(){
    buscarestudiante();

    document.getElementById("guardarEstudiante")
    .addEventListener("click", guardar);

    
}
