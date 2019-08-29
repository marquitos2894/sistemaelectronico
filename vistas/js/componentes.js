( async function(){

    /*$(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTableComp tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });*/

    function render(){
        
        /*this.renderComponentes = async function(){
            const datos = new FormData();
            datos.append('comp_gen','true');
            let response = await fetch('../ajax/componentesAjax.php',{
                method: 'POST',
                body : datos
            });
            let data = await  response.json();
            console.log(data);

            //datables json example
            $(document).ready(function() {
                $('#DTComponentes').DataTable( {
                    data: data,
                    columns: [
                        { data: 'id_comp' },
                        { data: 'descripcion' },
                        { data: 'nparte1' },
                        { data: 'nparte2' },
                        { data: 'nparte3' },
                        { data: 'marca' },
                        { data: 'unidad_med' },
                        { data: 'control_stock' },
                        {
                        data: 'id_comp',
                        render: function ( data, type, row, meta ) {
                            return `<a href="#" id='EditItem' data-producto='${data}' data-toggle="modal" data-target="#ModalEdit">Editar</a>`;
                          }
                        }
                    ]
                });
            });
            //let template = ``;
            /*for(i of data){ 
                template += `
                    <tr class="pd-list-grid">
                        <td>${i.id_comp}</td>
                        <td>${i.descripcion}</td>
                        <td>${i.nparte1}</td>
                        <td>${i.nparte2}</td>
                        <td>${i.nparte3}</td>
                        <td>${i.marca}</td>
                        <td>editar</td>
                    </tr>  
                `;   
            }*/
            //document.querySelector('#myTableComp').innerHTML=template;
            //$('#data-container').html(template);    
        //}

        this.renderComponentes = async function(){

            document.querySelector('#buscador_comp').addEventListener("Onkeyup",function(ev){
                ev.preventDefault();
                console.log("1");
                console.log(document.querySelector('#buscador_comp').value)
            })

        }

    }

    
    render = new render();
 
    await document.addEventListener("DOMContentLoaded", async function(){
       //render.renderComponentes();
        
       console.log(document.querySelector('#buscador_comp_text').value)
       let buscar = document.querySelector('#buscador_comp_text').value;
       //let paginador = document.querySelector('#data-page').getAttribute('href');
       let vista = document.querySelector('#vista').value
       let privilegio = document.querySelector('#privilegio').value

      
       console.log(vista);

       const datos = new FormData();
       datos.append('buscarcompajax',buscar);
       datos.append('paginadorajax',"");
       datos.append('vistaajax',vista);
       datos.append('privilegioajax',privilegio);
       let response = await fetch('../ajax/componentesAjax.php',{
           method : 'POST',
           body : datos
       })
       let data = await response.text();
       //console.log(data);

       document.querySelector('#table_componente').innerHTML = data;
    })

   await document.querySelector('#buscador_comp_text').addEventListener("keyup", async function(ev){
        //ev.preventDefault();
        //console.log("1");
        //console.log(document.querySelector('#buscador_comp_text').value)
        let buscar = document.querySelector('#buscador_comp_text').value;
        let paginador = document.querySelector('#paginador').value
        let vista = document.querySelector('#vista').value
        let privilegio = document.querySelector('#privilegio').value

        const datos = new FormData();
        datos.append('buscarcompajax',buscar);
        datos.append('paginadorajax',paginador);
        datos.append('vistaajax',vista);
        datos.append('privilegioajax',privilegio);
        let response = await fetch('../ajax/componentesAjax.php',{
            method : 'POST',
            body : datos
        })
        let data = await response.text();
        //console.log(data);

        document.querySelector('#table_componente').innerHTML = data;
      
    })

    await document.querySelector('#table_componente').addEventListener("click", async function(ev){
      
        console.log(ev.target.dataset.page);
        if(ev.target.id=='page'){
            console.log(ev.target.dataset.page);
            let buscar = document.querySelector('#buscador_comp_text').value;
            let paginador = ev.target.dataset.page;
            let vista = document.querySelector('#vista').value
            let privilegio = document.querySelector('#privilegio').value
    
            const datos = new FormData();
            datos.append('buscarcompajax',buscar);
            datos.append('paginadorajax',paginador);
            datos.append('vistaajax',vista);
            datos.append('privilegioajax',privilegio);
            let response = await fetch('../ajax/componentesAjax.php',{
                method : 'POST',
                body : datos
            })
            let data = await response.text();
            //console.log(data);
    
            document.querySelector('#table_componente').innerHTML = data;
        }


        if(ev.target.id == 'DeleteItem'){
            document.querySelector('#frmDeleteComp').submit();
        }

        
        if(ev.target.id == 'EditItem'){
            let id_comp = ev.target.dataset.producto;
            //console.log(id_comp);
            const datos = new FormData();
            datos.append('id_comp',id_comp);
            let response = await fetch('../ajax/componentesAjax.php',{
                method: 'POST',
                body : datos
            });
            let data = await response.json();
            console.log(data);

            const datos0 = new FormData();
            datos0.append('combounidad',data[0].id_unidad_med);
            let response0 = await fetch('../ajax/unidadmedidaAjax.php',{
                method: 'POST',
                body : datos0
            });
            let data0 = await response0.text();
            console.log(data0);


            let template = `
                <input type="hidden" value="${data[0].id_comp}" name="id_comp_formEdit" />
                <div class="form-group">
                    <label for="inputAddress">Descripcion</label>
                    <input type="text" value="${data[0].descripcion}" name="descripcion_formEdit"  id="descripcion"  class="form-control" placeholder="Descripcion">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Nparte1</label>
                        <input type="text" value="${data[0].nparte1}" name="nparte1" id="nparte1"  class="form-control"  placeholder="Nparte 1">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">Nparte2</label>
                        <input type="text" value="${data[0].nparte2}" name="nparte2" id="nparte2"  class="form-control" placeholder="Nparte 2" >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">Nparte3</label>
                        <input type="text" value="${data[0].nparte3}" name="nparte3"  id="nparte3"  class="form-control" placeholder="Nparte 3" >
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Marca</label>
                        <input type="text" value="${data[0].marca}" name="marca" id="marca" class="form-control"   placeholder="Nparte 1">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Unidad Medida</label>
                        <select name="unidad_med" class="form-control" >
                            <option value="${data[0].id_unidad_med}">${data[0].abreviado}</option>
                            ${data0}
                        </select>
                        
                    </div>
                </div>                          
            `;
         document.querySelector('#modal-body').innerHTML=template;   
        }
    });
    




})();

