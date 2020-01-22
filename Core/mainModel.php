<?php 
    
    if($peticionAjax){
        require_once '../core/configAPP.php';
    }else{
        require_once './core/configAPP.php';
    }
    class mainModel{

        protected function conectar(){
            try{
                
            $gbd = new PDO(SGBD,USER,PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",PDO::ATTR_EMULATE_PREPARES,TRUE));

            }catch(PDOException $e){
                
            }
            return $gbd;
        }

        protected function ejecutar_consulta_simple($consulta){
            $respuesta = self::conectar()->prepare($consulta);
            $respuesta->execute();
            $respuesta=$respuesta->fetch();
            return $respuesta;
        }

        protected function ejecutar_consulta_validar($consulta){
            $respuesta = self::conectar()->prepare($consulta);
            $respuesta->execute();
            return $respuesta;
        }



        protected function obtener_consulta_json($consulta){
    
            $respuesta = self::conectar()->prepare($consulta);
            $respuesta->execute();
            $respuesta=$respuesta->fetchAll(PDO::FETCH_ASSOC);

            $json = json_encode($respuesta,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
            $error = json_last_error_msg();
            return $json;
        }

        protected function ejecutar_combo($consulta,$val,$vis){
            $respuesta = self::conectar()->prepare($consulta);
            $respuesta->execute();
            $respuesta=$respuesta->fetchAll();
            $contenido ="";
            foreach($respuesta as $row){
            $contenido .= "<option value='{$row[$val]}'>{$row[$vis]}</option>";
            }

            return $contenido;
        }

        protected function privilegios_transact($privilegio){
           
            if($privilegio>=0 and $privilegio<=2){
                $valor = true;
            }else{
                $valor = false;
            }
            
            return $valor;
        }

        protected function paginador($total,$paginador,$Npaginas,$vista){
            
            $tabla='';
            if($total>=1 && $paginador<=$Npaginas)
            {  
                $tabla.='<nav aria-label="Page navigation example"><ul class="pagination">';
    
                if($paginador==1){
              
                    $tabla.='<li class="page-item"><a class="page-link">Atras</a></li>';
                }else{
                
                    $tabla.='<li class="page-item"><a class="page-link" href="'.SERVERURL.''.$vista.'/'.($paginador-1).'">Atras</a></li>';
                }
                for($i=1;$i<=$Npaginas;$i++){
                    
                    if($Npaginas<=5){
                        if($paginador!=$i){
                            $tabla.='<li class="active"><a class="page-link" href="'.SERVERURL.''.$vista.'/'.$i.'">'.$i.'</a></li>';
                        }else{
                            $tabla.='<li class="page-item active"><a class="page-link">'.$i.'</a></li>';
                        }
                    }
                 
                }
                if ($Npaginas>=6){
                    if($paginador!=$i){
                        $tabla.='<li class="active"><a class="page-link" href="'.SERVERURL.''.$vista.'/1">inicio</a></li>';
                        $tabla.='<li class="page-item active"><a class="page-link" href="'.SERVERURL.''.$vista.'/'.$paginador.'">'.$paginador.'</a></li>';
                        $tabla.='<li class="active"><a class="page-link" href="'.SERVERURL.''.$vista.'/'.($paginador+1).'">'.($paginador+1).'</a></li>';
                        $tabla.='<li class="active"><a class="page-link" href="'.SERVERURL.''.$vista.'/'.($paginador+2).'">'.($paginador+2).'</a></li>';
                        $tabla.='<li class="active"><a class="page-link" href="'.SERVERURL.''.$vista.'/'.($paginador+3).'">'.($paginador+3).'</a></li>';
                        $tabla.='<li class="active"><a class="page-link" href="'.SERVERURL.''.$vista.'/'.($paginador+4).'">'.($paginador+4).'</a></li>';
                    }else{
                        $tabla.='<li class="page-item"><a class="page-link">'.$paginador.'</a></li>';
                    }
                }
                    
                if($paginador==$Npaginas){
                    $tabla.='<li class="page-item"><a class="page-link">Siguiente</a></li>';
                }else{
                    $tabla.='<li class="page-item"><a class="page-link" href="'.SERVERURL.''.$vista.'/'.($paginador+1).'">Siguiente</a></li>';
                  
                }
                
                $tabla.='</ul></nav>';
            }
            
            return $tabla;
        }

        protected function paginador_ajax($total,$paginador,$Npaginas,$vista){
            
            $tabla='';
            if($total>=1 && $paginador<=$Npaginas)
            {  
                $tabla.='<nav aria-label="Page navigation example" id="paginador"><ul class="pagination">';
    
                if($paginador==1){
              
                    $tabla.='<li class="page-item"><a class="page-link">Atras</a></li>';
                }else{
                
                    $tabla.='<li class="page-item"><a class="page-link" id="page" data-page="'.($paginador-1).'" href="#" >Atras</a></li>';
                }
                for($i=1;$i<=$Npaginas;$i++){
                    
                    if($Npaginas<=5){
                        if($paginador!=$i){
                            $tabla.='<li class="active"><a class="page-link" id="page" data-page="'.$i.'" href="#" >'.$i.'</a></li>';
                        }else{
                            $tabla.='<li class="page-item active"><a class="page-link" id="page" data-page="'.$i.'" href="#">'.$i.'</a></li>';
                        }
                    }
                 
                }
                if ($Npaginas>=6){
                    if($paginador!=$i){
                        $tabla.='<li class="active"><a class="page-link" id="page" data-page="1" href="#">inicio</a></li>';
                        $tabla.='<li class="page-item active"><a class="page-link" id="page" data-page="'.$paginador.'" href="#">'.$paginador.'</a></li>';
                        $tabla.='<li class="active"><a class="page-link" id="page" data-page="'.($paginador+1).'" href="#"  >'.($paginador+1).'</a></li>';
                        $tabla.='<li class="active"><a class="page-link" id="page" data-page="'.($paginador+2).'" href="#" >'.($paginador+2).'</a></li>';
                        $tabla.='<li class="active"><a class="page-link" id="page" data-page="'.($paginador+3).'" href="#" >'.($paginador+3).'</a></li>';
                        $tabla.='<li class="active"><a class="page-link" id="page" data-page="'.($paginador+4).'"  href="#">'.($paginador+4).'</a></li>';
                    }else{
                        $tabla.='<li class="page-item"><a class="page-link" id="page" data-page="'.$paginador.' href="#">'.$paginador.'</a></li>';
                    }
                }
                    
                if($paginador==$Npaginas){
                    $tabla.='<li class="page-item"><a class="page-link">Siguiente</a></li>';
                }else{
                    $tabla.='<li class="page-item"><a class="page-link" id="page" data-page="'.($paginador+1).'" href="#" >Siguiente</a></li>';
                  
                }
                
                $tabla.='</ul></nav>';
            }
            
            return $tabla;
        }
            
         //VALIDARA al buscador por variables del paginador,y problemas en la consulta entre limit
        protected function validar_paginador($buscador,$vista,$eliminar_buscador){
            $reload = "<script>window.location.replace('".SERVERURL."{$vista}/');</script>";
            if(isset($buscador) && $buscador !=""){
                //se crea una sesion con la palabra de busqueda
                $_SESSION['session_'.$vista] = $buscador;
                return $reload;
            }
            if(isset($eliminar_buscador)){
                unset($_SESSION['session_'.$vista]);
                return $reload;
            }
        }


       /*protected function agregar_emptrans($datos){
            $sql = self::conectar->prepare("insert into emptransporte (razonsocial,ruc) values (:razonsocial,:ruc)")
            $sql->bindParam(":razonsocial",$datos["razonsocial"]);
            $sql->bindParam(":ruc",$datos["ruc"]);
            $sql->execute();
            return $sql;
        }*/
        
        /*protected function eliminar_emptrans($codigo){
            $sql = self::conectar->prepare("delete from emptransporte where id_emptrans = :codigo");
            $sql->bindParam(":codigo",$codigo);
            $sql->execute();
            return $sql;

        }*/

        public function encryption($string){
            $output=FALSE;
            $key=hash('sha256',SECRET_KEY);
            $iv=substr(hash('sha256',SECRET_IV),0,16);
            $output=openssl_encrypt($string,METHOD,$key,0,$iv);
            $output=base64_encode($output);
            return $output;

        }

        protected function decryption($string){
            $key=hash('sha256',SECRET_KEY);
            $iv=substr(hash('sha256',SECRET_IV),0,16);
            $output=openssl_decrypt(base64_decode($string),METHOD,$key,0,$iv); 
            return $output;    
        }

        protected function generar_codigo_aleatorio($letra,$longitud,$num){
            for($i=1;$i<=$longitud;$i++){
                $numero = rand(0,9);
                $letra.= $numero; 
                return $letra.$num;          
            }

        }

        protected function limpiar_cadena($cadena){
            $cadena = trim($cadena);  
            $cadena = stripslashes($cadena);
            $cadena = str_ireplace("<script>","",$cadena);
            $cadena = str_ireplace("</script>","",$cadena);   
            $cadena = str_ireplace("<script src","",$cadena);   
            $cadena = str_ireplace("<script type=","",$cadena);
            $cadena = str_ireplace("SELECT * FROM","",$cadena);
            $cadena = str_ireplace("DELETE FROM","",$cadena);
            $cadena = str_ireplace("INSERT INTO","",$cadena);
            $cadena = str_ireplace("--","",$cadena);
            $cadena = str_ireplace("^","",$cadena);
            $cadena = str_ireplace("[","",$cadena);  
            $cadena = str_ireplace("]","",$cadena);  
            $cadena = str_ireplace("==","",$cadena);
   

            return $cadena;
        }

        protected function sweet_alert($datos){

            if($datos["alerta"]=="simple"){
                $alerta = "
                    <script>
                        Swal.fire(
                            '{$datos['Titulo']}',
                            '{$datos['Texto']}',
                            '{$datos['Tipo']}'
                        )
                    </script>    
                ";
            }else if($datos["alerta"]=="recargar_tiempo"){
                $alerta ="
                <script>
            
                Swal.fire({
                    title: '{$datos['Titulo']}',
                    text: '{$datos['Texto']}',
                    type: '{$datos['Tipo']}',
                    showCancelButton: true,     
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        setTimeout('document.location.reload()',{$datos['tiempo']});
                      }
                    });
                </script>";
                
            }
            else if($datos["alerta"]=="recargar"){
                $alerta ="
                <script>
            
                Swal.fire({
                    title: '{$datos['Titulo']}',
                    text: '{$datos['Texto']}',
                    type: '{$datos['Tipo']}',
                    showCancelButton: true,     
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        location.reload();
                      }
                    });
                </script>";
                
            }else if($datos["alerta"]=="limpiar"){
                $alerta ="
                <script>
                Swal.fire({
                    title: '{$datos['Titulo']}',
                    text: '{$datos['Texto']}',
                    type: '{$datos['Tipo']}',
                    showCancelButton: true,     
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar'
                  }).then((result) => {
                    if (result.value) {
                        $('.FormularioAjax')[0].reset();
                    }
                  })
                </script>
                ";
            }else if($datos["alerta"]=="question"){
                $alerta ="
                <script>
                Swal.fire({
                    title: '{$datos['Titulo']}',
                    text: '{$datos['Texto']}',
                    type: '{$datos['Tipo']}',
                    showCancelButton: true,     
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar'
                  }).then((result) => {

                    if (result.value) {

                        var input = $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', 'mydata').val('{$datos['Variable']}');
                        $('#FormularioAjax').append(input);
                        $('#FormularioAjax').submit();
                      
                    }
                  })
                </script>
                ";
            }else if($datos["alerta"]=="redire"){
                $alerta ="
                <script>
                Swal.fire({
                    title: '{$datos['Titulo']}',
                    text: '{$datos['Texto']}',
                    type: '{$datos['Tipo']}',
                    showCancelButton: true,     
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                     
                        window.location.replace('".SERVERURL."{$datos['vista']}/');
                      }
                    });
                </script>";
                
            }

            

            return $alerta;
        }

        protected function bootstrap_alert($datos){

            $alerta= "<div class='alert alert-{$datos['tipo']} alert-dismissible fade show' role='alert'>
                        {$datos['mensaje']}
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";
            return $alerta;
        }

        protected function localstorage_reiniciar($localstorage){
            foreach($localstorage as $local){
             echo $vaciar=  
                "<script>
                    localStorage.setItem('$local','[]')
                </script>";
            }  
        }

        protected function localstorage_set($localstorage,$datos){
            $i=0;
            $ls=[];
            $ls2=[];
            foreach($datos["id_comp"][0] as $valor){
                    $ls = [
                           "id_comp"=>$datos["id_comp"][0][$i],
                           "d_descripcion"=>$datos["d_descripcion"][0][$i],
                           "d_nparte"=>$datos["d_nparte"][0][$i],
                           "d_stock"=>$datos["d_stock"],
                           "d_nserie"=>$datos["d_nserie"][0][$i],
                           "d_cant"=>$datos["d_cant"][0][$i],
                           "d_u_nom"=>$datos["d_u_nom"][0][$i],
                           "d_u_sec"=>$datos["d_u_sec"][0][$i],
                           "d_fk_idflota"=>$datos["d_fk_idflota"][0][$i],
                           "d_nom_equipo"=>$datos["d_nom_equipo"][0][$i],
                           "d_referencia"=>$datos["d_referencia"][0][$i],
                           "d_id_ac"=>$datos["d_id_ac"][$i],  
                    ];
                    array_push($ls2,$ls);
                    $i++;
            }
            
            $ls2;
            $json = json_encode($ls2); 
            echo $set=  
            "<script>
                localStorage.setItem('$localstorage','$json');
                console.log('$json');
            </script>";
           
        }


        protected function dateFormat($date){
            return date("d/m/Y", strtotime($date));
        }

        protected function dateFormat2($tipo,$date){
            if($tipo=='fecha'){
            $date = new DateTime($date);
            $date=$date->format('d-m-Y');
            }else{
            $date = new DateTime($date);
            $date=$date->format('H:i:s');
            }
            return $date;
        }
        
    
    }

?>