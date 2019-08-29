<?php 

if($peticionAjax){
    require_once '../modelos/componentesModelo.php';
}else{
    require_once './modelos/componentesModelo.php';
}

Class componentesControlador extends componentesModelo {

    /*public function paginador_componentes($paginador,$registros,$privilegio,$buscador,$vista){

        $paginador=mainModel::limpiar_cadena($paginador);
        $registros=mainModel::limpiar_cadena($registros);
        $privilegio=mainModel::limpiar_cadena($privilegio);
        $tabla='';

        $paginador=(isset($paginador) && $paginador>0)?(int)$paginador:1; 
        $inicio=($paginador>0)?(($paginador*$registros)-$registros):0;

        $conexion = mainModel::conectar();
        if($buscador!=""){
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS c.id_comp,c.codigo,c.descripcion,c.nparte1,c.nparte2,c.nparte3,c.unidad_med,ac.stock,ac.fk_idalm,ac.id_ac,CONCAT(ac.u_nombre,'-',ac.u_seccion) as ubicacion,ac.modelo_equipo
                                     FROM componentes c
                                     INNER JOIN almacen_componente ac
                                     ON ac.fk_idcomp = c.id_comp WHERE (c.codigo like '%{$buscador}%' or c.descripcion  like '%{$buscador}%'  or c.nparte1 like '%{$buscador}%' or c.nparte2 like '%{$buscador}%' or ac.modelo_equipo like '%{$buscador}%' or CONCAT(ac.u_nombre,'-',ac.u_seccion) like '%{$buscador}%' ) and ac.est = 1 and ac.fk_idalm=1  order by  c.codigo LIMIT {$inicio},{$registros} ");

        }else{
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS c.id_comp,c.codigo,c.descripcion,c.nparte1,c.nparte2,c.nparte3,c.unidad_med,ac.stock,ac.fk_idalm,ac.id_ac,CONCAT(ac.u_nombre,'-',ac.u_seccion) as ubicacion,ac.modelo_equipo
                                    FROM componentes c
                                    INNER JOIN almacen_componente ac
                                    ON ac.fk_idcomp = c.id_comp WHERE ac.est = 1 and ac.fk_idalm=1  order by  c.codigo LIMIT {$inicio},{$registros} ");

            

        }
        //$datos->execute();
        $datos = $datos->fetchAll();
        $total = $conexion->query("SELECT FOUND_ROWS()");

        $total = (int)$total->fetchColumn();
        //devuel valor entero redondeado hacia arriba 4.2 = 5
        $Npaginas = ceil($total/$registros);

        $tabla.='<div class="table-responsive"><table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Cod.Interno</th>
                <th scope="col">Descripcion</th>               
                <th scope="col">NParte1</th>
                <th scope="col">NParte2</th>
                <th scope="col">NParte3</th>
                <th scope="col">Ubicacion</th>
                <th scope="col">Stock</th>
                <th scope="col">U.medida</th>
                <th scope="col">Modelo equipo</th>';
                //programar privilegios
        $tabla.="</tr>
        </thead>
        <tbody>";
        if($total>=1 && $paginador<=$Npaginas)
        {
        $contador = $inicio+1;
            foreach($datos as $row){
                $tabla .="<tr>
                            <td>{$contador}</td>
                            <td>{$row['codigo']}</td>
                            <td>{$row['descripcion']}</td>                      
                            <td>{$row['nparte1']}</td>
                            <td>{$row['nparte2']}</td>
                            <td>{$row['nparte3']}</td>
                            <td>{$row['ubicacion']}</td>
                            <td>{$row['stock']}</td>
                            <td>{$row['unidad_med']}</td>
                            <td>{$row['modelo_equipo']}</td>";

                            $contador++;
                $tabla.="</tr>";
            }

        }else{
            $tabla.='<tr><td colspan="4"> No existen registros</td></tr>';
        }

        $tabla.='</tbody></table></div>';
        $tabla.= mainModel::paginador($total,$paginador,$Npaginas,$vista);
        return $tabla;
     
    }*/

    public function paginador_componentes($paginador,$registros,$privilegio,$buscador,$vista){

        $paginador=mainModel::limpiar_cadena($paginador);
        $registros=mainModel::limpiar_cadena($registros);
        $privilegio=mainModel::limpiar_cadena($privilegio);
        $tabla='';
        //echo $_SESSION['nombre_sbp'];
        $paginador=(isset($paginador) && $paginador>0)?(int)$paginador:1; 
        $inicio=($paginador>0)?(($paginador*$registros)-$registros):0;

        $conexion = mainModel::conectar();
        $est_baja=($vista=="componentes")?$est_baja=1:$est_baja=0;
        if($buscador!=""){
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS c.id_comp,c.descripcion,c.nparte1,
            c.nparte2,c.nparte3,c.marca,um.abreviado
            FROM componentes c 
            INNER JOIN unidad_medida um ON um.id_unidad_med = c.fk_idunidad_med
            WHERE ( c.id_comp  like '%$buscador%' or c.descripcion  like '%$buscador%' or c.nparte1 like '%$buscador%' or 
            c.nparte2 like '%$buscador%' or c.nparte3 like '%$buscador%'  ) AND est_baja = {$est_baja}
            AND c.est=1 LIMIT {$inicio},{$registros} ");
            
        }else{
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS  c.id_comp,c.descripcion,c.nparte1,
            c.nparte2,c.nparte3,c.marca,um.abreviado
            FROM componentes c 
            INNER JOIN unidad_medida um ON um.id_unidad_med = c.fk_idunidad_med 
            WHERE est_baja = {$est_baja} AND c.est = 1  LIMIT {$inicio},{$registros}");           
        }
        //$datos->execute();
        $datos = $datos->fetchAll();
        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int)$total->fetchColumn();

        
        //devuel valor entero redondeado hacia arriba 4.2 = 5
        $Npaginas = ceil($total/$registros);
        $tabla.="<div><table class='table table-bordered'>
        <thead>
            <tr>
                <th scope='col'>Cod.Interno</th>
                <th scope='col'>Descripcion</th>               
                <th scope='col'>NParte</th>
                <th scope='col'>NParte2</th>
                <th scope='col'>NParte3</th>
                <th scope='col'>Marca</th>
                <th scope='col'>U.M</th>";
                if($privilegio==0 or $privilegio==1){
                $tabla.="
                <th colspan='2' scope='col'>Acciones</th>";
                }
                //programar privilegios
            $tabla.="
            </tr>
        </thead>
        <tbody id='table_componente' >";
        if($total>=1 && $paginador<=$Npaginas)
        {
        
            foreach($datos as $row){
                $tabla .="
            <tr>
                <td>{$row['id_comp']}</td>
                <td>{$row['descripcion']}</td>                      
                <td>{$row['nparte1']}</td>
                <td>{$row['nparte2']}</td>
                <td>{$row['nparte3']}</td>
                <td>{$row['marca']}</td>
                <td>{$row['abreviado']}</td>";
                
                if($privilegio==0 or $privilegio==1){

                    if($est_baja==1){
                $tabla .="
                <td><a style='font-size: 1.5em;'  class='fas fa-edit' href='{$row['id_comp']}' id='EditItem' data-producto='{$row['id_comp']}' data-toggle='modal' data-target='#ModalEdit'></a> </td>";
                    }                                     
                           
                $tabla .="
                <td>
                    <form name='FrmDarBajaComp' action='".SERVERURL."ajax/componentesAjax.php' method='POST' class='FormularioAjax' 
                        data-form='update' entype='multipart/form-data' autocomplete='off'>";
                        if($est_baja==1){
                            $tabla .="
                            <input type='hidden' name='idcomp_DarBaja' value='{$row['id_comp']}'/>
                            <button type='submit' class='btn btn-danger'><i class='fas fa-arrow-circle-down'></i></button>";
                        }else{
                            $tabla .="
                            <input type='hidden' name='idcomp_DarAlta' value='{$row['id_comp']}'/>
                            <button type='submit' class='btn btn-success'><i class='fas fa-arrow-circle-up'></i></button>";
                        }

                        $tabla .="
                        <div class='RespuestaAjax'></div>   
                    </form>
                </td>";
                    
                if($est_baja==0){
                $tabla .="
                <td>
                    <form name='FrmDelComp' action='".SERVERURL."ajax/componentesAjax.php' method='POST' class='FormularioAjax' 
                            data-form='update' entype='multipart/form-data' autocomplete='off'>
                            <input type='hidden' name='idcomp_FrmDelComp' value='{$row['id_comp']}'/>
                        <button type='submit' class='btn btn-danger'><i class='far fa-trash-alt'></i></button>
                        <div class='RespuestaAjax'></div>   
                    </form>
                </td>";
                    }

                }    
            $tabla.="
            </tr>";
                 
            }
        }else{
            $tabla.='<tr><td colspan="7"> No existen registros</td></tr>';
        }

        $tabla.='</tbody></table></div>';
   
        $tabla.= mainModel::paginador_ajax($total,$paginador,$Npaginas,$vista);
        return $tabla;
    }

    public function paginador_datosRerencia($paginador,$registros,$privilegio,$buscador,$vista){

        $paginador=mainModel::limpiar_cadena($paginador);
        $registros=mainModel::limpiar_cadena($registros);
        $privilegio=mainModel::limpiar_cadena($privilegio);
        $tabla='';
        //echo $_SESSION['nombre_sbp'];
        $paginador=(isset($paginador) && $paginador>0)?(int)$paginador:1; 
        $inicio=($paginador>0)?(($paginador*$registros)-$registros):0;

        $conexion = mainModel::conectar();
        
        if($buscador!=""){
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS *
                                    FROM datos_referencia dr 
                                    WHERE ( dr.dato_referencia  like '%$buscador%' or dr.descripcion_dr like '%$buscador%' ) 
                                    LIMIT {$inicio},{$registros} ");
            
        }else{
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS *
                                    FROM datos_referencia LIMIT {$inicio},{$registros}");           
        }
        //$datos->execute();
        $datos = $datos->fetchAll();
        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int)$total->fetchColumn();

        
        //devuel valor entero redondeado hacia arriba 4.2 = 5
        $Npaginas = ceil($total/$registros);
        $tabla.="<div><table class='table table-bordered'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>Referencia</th>               
                <th scope='col'>Descripcion</th>
                <th colspan='2' scope='col'>Acciones</th>";
                //programar privilegios
        $tabla.="</tr>
        </thead>
        <tbody id='table_dr' >";
        if($total>=1 && $paginador<=$Npaginas)
        {
            $contador=1;
            foreach($datos as $row){
                $tabla .="
            <tr>
                            <td>{$contador}</td>
                            <td>{$row['dato_referencia']}</td>                      
                            <td>{$row['descripcion_dr']}</td>";                          
                $tabla .="<td><a style='font-size: 1.5em;'  class='fas fa-edit' href='{$row['id_dr']}' id='EditItem' data-idreferencia='{$row['id_dr']}' data-toggle='modal' data-target='#ModalEdit'></a> </td>";
                            
                $tabla .="
                <td >
                    <form name='FrmDelRef' action='".SERVERURL."ajax/componentesAjax.php' method='POST' class='FormularioAjax' 
                        data-form='delete' entype='multipart/form-data' autocomplete='off'>
                        <input type='hidden' name='id_dr_delete' value='{$row['id_dr']}'/>
                        <button type='submit' class='btn btn-danger'><i class='far fa-trash-alt'></i></button> 
                        <div class='RespuestaAjax'></div>   
                    </form>
                </td>
            </tr>";
            $contador++;
            }
        }else{
            $tabla.='<tr><td colspan="7"> No existen registros</td></tr>';
        }

        $tabla.='</tbody></table></div>';
   
        $tabla.= mainModel::paginador($total,$paginador,$Npaginas,$vista);
        return $tabla;
    }

    //VALIDARA al buscador por variables del paginador,y problemas en la consulta entre limit
    public function validar_paginador_controlador($buscador,$vista,$eliminar_buscador){
        return mainModel::validar_paginador($buscador,$vista,$eliminar_buscador);
    }

    public function save_componente_controlador(){
        
        $descripcion =  mainModel::limpiar_cadena($_POST["descripcion"]);
        $nparte1 =  mainModel::limpiar_cadena($_POST["nparte1"]);
        $nparte2 =  mainModel::limpiar_cadena($_POST["nparte2"]);
        $nparte3 =  mainModel::limpiar_cadena($_POST["nparte3"]);
        $marca =  mainModel::limpiar_cadena($_POST["marca"]);
        $id_unidad_med=  mainModel::limpiar_cadena($_POST["unidad_med_new"]);

        $val_question = "false";
        if(isset($_POST["mydata"])){
            $val_question =  mainModel::limpiar_cadena($_POST["mydata"]);
        }
        
 
        $datos = [
            "descripcion"=>$descripcion,
            "nparte1"=>$nparte1,
            "nparte2"=>$nparte2,
            "nparte3"=>$nparte3,
            "marca"=>$marca,
            "id_unidad_med"=>$id_unidad_med,        
        ];

        

        if($val_question=="false"){

            if($nparte1 !='' or $nparte2 !='' or $nparte3 != '' ){
                $validarNP1 = mainModel::ejecutar_consulta_validar("SELECT * FROM componentes WHERE (nparte1 = '{$nparte1}' OR nparte2 = '{$nparte1}' OR nparte3 = '{$nparte1}' ) AND est = 1");
                $validarNP2 = mainModel::ejecutar_consulta_validar("SELECT * FROM componentes WHERE (nparte1 = '{$nparte2}' OR nparte2 = '{$nparte2}' OR nparte3 = '{$nparte2}' ) AND est = 1");
                $validarNP3 = mainModel::ejecutar_consulta_validar("SELECT * FROM componentes WHERE (nparte1 = '{$nparte3}' OR nparte2 = '{$nparte3}' OR nparte3 = '{$nparte3}' ) AND est = 1");
                
                //VALIDO SI ES VACIO, SI NO LO ES SE REALIZA UN COUNT DE LA CONSULTA
                $validarNP1 = ($nparte1=="")?$nparte1=0:$validarNP1->rowCount();
                $validarNP2 = ($nparte2=="")?$nparte2=0:$validarNP2->rowCount();
                $validarNP3 = ($nparte3=="")?$nparte3=0:$validarNP3->rowCount();

                $totNP_rep = $validarNP1 + $validarNP2 + $validarNP3;
            }
        

            if($totNP_rep>0){

                $validarNP1 = ($validarNP1>0)?$validarNP1=$nparte1:$validarNP1="";
                $validarNP2 = ($validarNP2>0)?$validarNP2=$nparte2:$validarNP2="";
                $validarNP3 = ($validarNP3>0)?$validarNP3=$nparte3:$validarNP3="";
                    $alerta=[
                        "alerta"=>"question",
                        "Titulo"=>"Duplicidad de N° parte",
                        "Texto"=>"El/Los N° parte {$validarNP1} | {$validarNP2} | {$validarNP3}  ya se encuentran registrados ¿Desea continuar de todas maneras?",
                        "Tipo"=>"info",
                        "Variable"=>"true"
                    ];
                    return mainModel::sweet_alert($alerta);   
            }else{

                $validar= componentesModelo::save_componentenes_modelo($datos);

                if($validar->rowCount()>0){
                    $alerta=[
                        "alerta"=>"recargar",
                        "Titulo"=>"Datos guardados",
                        "Texto"=>"Los siguientes datos han sido guardados",
                        "Tipo"=>"success"
                    ];
                    $localStorage = [
                        "BDcomp_gen",
                        "BDproductos",
                        "carritoGen",
                        "carritoIn",
                        "carritoS"
                    ];
                }else{
                    $alerta=[
                        "alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error inesperado",
                        "Texto"=>"No hemos podido registrar el componente",
                        "Tipo"=>"error"
                    ];
                    $localStorage = [];
                }
                echo mainModel::localstorage_reiniciar($localStorage);
                return mainModel::sweet_alert($alerta);
            }

        }else{

            $validar= componentesModelo::save_componentenes_modelo($datos);

            if($validar->rowCount()>0){
                $alerta=[
                    "alerta"=>"recargar",
                    "Titulo"=>"Datos guardados",
                    "Texto"=>"Los siguientes datos han sido guardados",
                    "Tipo"=>"success"
                ];
                $localStorage = [
                    "BDcomp_gen",
                    "BDproductos",
                    "carritoGen",
                    "carritoIn",
                    "carritoS"
                ];
            }else{
                $alerta=[
                    "alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos podido registrar el componente",
                    "Tipo"=>"error"
                ];
                $localStorage = [];
            }
            echo mainModel::localstorage_reiniciar($localStorage);
            return mainModel::sweet_alert($alerta);


        }


 

    }

    public function update_componente_controlador(){
        $id_comp = mainModel::limpiar_cadena($_POST["id_comp_formEdit"]);
        $descripcion = mainModel::limpiar_cadena($_POST["descripcion_formEdit"]);
        $nparte1 = mainModel::limpiar_cadena($_POST["nparte1"]);
        $nparte2 = mainModel::limpiar_cadena($_POST["nparte2"]);
        $nparte3 = mainModel::limpiar_cadena($_POST["nparte3"]);
        $marca = mainModel::limpiar_cadena($_POST["marca"]);
        $id_unidad_med = mainModel::limpiar_cadena($_POST["unidad_med"]);

        $datos = [
            "id_comp"=>$id_comp,
            "descripcion"=>$descripcion,
            "nparte1"=>$nparte1,
            "nparte2"=>$nparte2,
            "nparte3"=>$nparte3,
            "marca"=>$marca,
            "id_unidad_med"=>$id_unidad_med

        ];
        
        $resp = componentesModelo::update_componente_modelo($datos);

        if($resp->rowCount()>=1){
            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Datos Actualizados",
                "Texto"=>"Los siguientes datos han sido Actualizados",
                "Tipo"=>"success"
            ];
        }else{
            $alerta=[
                "alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No hemos podido actualizar el componente seleccionado",
                "Tipo"=>"error"
            ];
        }

        return mainModel::sweet_alert($alerta);
    }


    public function delete_componente_controlador(){

        $id_comp = mainModel::limpiar_cadena($_POST["idcomp_FrmDelComp"]);

        $validar=componentesModelo::delete_componente_modelo($id_comp);
        
        if($validar->rowCount()>0){

            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Eliminado",
                "Texto"=>"El siguiente componente ha sido eliminado del sistema",
                "Tipo"=>"success"
            ];
        }else{
            $alerta=[
                "alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No hemos podido actualizar el componente seleccionado",
                "Tipo"=>"error"
            ];
        }

        return mainModel::sweet_alert($alerta);
    }

    public function darBaja_componente_controlador(){

        $id_comp = mainModel::limpiar_cadena($_POST["idcomp_DarBaja"]);

        $validar=componentesModelo::darBaja_componente_modelo($id_comp);
        
        if($validar->rowCount()>0){

            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Dado de baja",
                "Texto"=>"El siguiente componente ha sido dado de baja del sistema",
                "Tipo"=>"success"
            ];
        }else{
            $alerta=[
                "alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No hemos podido actualizar el componente seleccionado",
                "Tipo"=>"error"
            ];
        }

        return mainModel::sweet_alert($alerta);
    }

    public function darAlta_componente_controlador(){

        $id_comp = mainModel::limpiar_cadena($_POST["idcomp_DarAlta"]);

        $validar=componentesModelo::darAlta_componente_modelo($id_comp);
        
        if($validar->rowCount()>0){

            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Dado de Alta",
                "Texto"=>"El siguiente componente ha sido dado de alta del sistema",
                "Tipo"=>"success"
            ];
        }else{
            $alerta=[
                "alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No hemos podido actualizar el componente seleccionado",
                "Tipo"=>"error"
            ];
        }

        return mainModel::sweet_alert($alerta);
    }

    public function save_datoreferencia_controlador(){
        $datos_referencia = mainModel::limpiar_cadena($_POST["referencia_dr_nuevo"]);
        $descripcion_dr = mainModel::limpiar_cadena($_POST["descripcion_dr_nuevo"]);


        $datos_referencia=(substr($datos_referencia,0,1)=="#")?$datos_referencia:"#".$datos_referencia;

        
        $datos = [
            "dato_referencia"=>$datos_referencia,
            "descripcion_dr"=>$descripcion_dr
        ];

        $validar=mainModel::ejecutar_consulta_validar("SELECT * FROM datos_referencia 
        WHERE dato_referencia  = '{$datos_referencia}' ");
        if($validar->rowCount()>0){
            $alerta=[
                "alerta"=>"simple",
                "Titulo"=>"{$datos_referencia}",
                "Texto"=>"La referencia ya se encuentra registrada",
                "Tipo"=>"info"
            ];
        }else{
            $validar = componentesModelo::save_datoreferencia_modelo($datos);
            if($validar->rowCount()>0){
                $alerta=[
                    "alerta"=>"recargar",
                    "Titulo"=>"Datos guardados",
                    "Texto"=>"Los siguientes datos han sido guardados",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos podido registrar el componente",
                    "Tipo"=>"error"
                ];
            }

        }

        return mainModel::sweet_alert($alerta);
    }

    public function update_datoreferencia_controlador(){

        $id_dr = mainModel::limpiar_cadena($_POST["id_dr_formEdit"]);
        $datos_referencia = mainModel::limpiar_cadena($_POST["dato_referencia_formEdit"]);
        $descripcion_dr = mainModel::limpiar_cadena($_POST["descripcion_dr_formEdit"]);


        $datos_referencia=(substr($datos_referencia,0,1)=="#")?$datos_referencia:"#".$datos_referencia;

        $datos = [
            "id_dr"=>$id_dr,
            "dato_referencia"=>$datos_referencia,
            "descripcion_dr"=>$descripcion_dr
        ];

            $validar = componentesModelo::update_datoreferencia_modelo($datos);
            if($validar->rowCount()>0){
                $alerta=[
                    "alerta"=>"recargar",
                    "Titulo"=>"Datos guardados",
                    "Texto"=>"Los siguientes datos han sido guardados",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos podido registrar el componente",
                    "Tipo"=>"error"
                ];
            }
        
        return mainModel::sweet_alert($alerta);
    }

    public function delete_datoreferencia_controlador(){
        $id_dr = mainModel::limpiar_cadena($_POST["id_dr_delete"]);

        $validar = componentesModelo::delete_datoreferencia_modelo($id_dr);

        if($validar->rowCount()>0){
            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Eliminado",
                "Texto"=>"La referencia ha sido eliminada",
                "Tipo"=>"success"
            ];
        }else{

            $alerta=[
                "alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No hemos podido eliminar la referencia seleccionada",
                "Tipo"=>"error"
            ];
        }
        
        return mainModel::sweet_alert($alerta);
    }

    public function componentes_general(){
        $conexion = mainModel::conectar();
        $datos = $conexion->prepare("call v_comp_general");
        $datos->execute();
        $datos=$datos->fetchAll();
        $contador = 1;
        $dtable = "";
        foreach($datos as $row){
            $dtable .="
                <tr>
                    <td>{$contador}</td>
                    <td>{$row['descripcion']}</td>
                    <td>{$row['id_comp']}</td>
                    <td>{$row['nparte1']}</td>
                    <td>{$row['nparte2']}</td>
                    <td>{$row['nparte3']}</td>
                    <td>{$row['marca']}</td>
                    <td><a href='#' class='card-footer-item' id='addItem'  data-producto='{$row['id_comp']}' data-toggle='modal' data-target='#exampleModalCenter'>+</a></td>
                </tr>
            ";
            $contador++;
        }

        return $dtable;
    }

    public function componentes_gen_json(){
        $consulta = "SELECT * FROM componentes WHERE est = 1";
        return mainModel::obtener_consulta_json($consulta);
    }

    public function dato_componente($id_comp){
        $consulta = "SELECT * FROM componentes WHERE id_comp = {$id_comp}"; 
        return mainModel::obtener_consulta_json($consulta);
    }

    public function select_combo($consulta,$val,$vis){
        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }

    public function obtener_consulta_json_controlador($consulta){
        return mainModel::obtener_consulta_json($consulta);
    }
    
    /*public function validar_equipo($id){
    $consulta = "SELECT e.Nombre_Equipo FROM equipos e WHERE e.Id_equipo = {$id}";
    return mainModel::obtener_consulta_json($consulta);
    }*/

    



}




?>