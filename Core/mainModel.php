<?php 
    

    if($peticionAjax){
        require_once '../core/configAPP.php';
    }else{
        require_once './core/configAPP.php';
    }
    class mainModel{

        protected function conectar(){
            try{
            $gbd = new PDO(SGBD,USER,PASS);
            }catch(PDOException $e){
                
            }
            return $gbd;
        }

        protected function ejecutar_consulta_simple($consulta){
            $respuesta = self::conectar()->prepare($consulta);
            $respuesta->execute();
            return $respuesta;
        }

       /* protected function agregar_emptrans($datos){
            $sql = self::conectar->prepare("insert into emptransporte (razonsocial,ruc) values (:razonsocial,:ruc)")
            $sql->bindParam(":razonsocial",$datos["razonsocial"]);
            $sql->bindParam(":ruc",$datos["ruc"]);
            $sql->execute();
            return $sql;
        }*/
        /*
        protected function eliminar_emptrans($codigo){
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
            }else if($datos["alerta"]=="recargar"){
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
            }

            return $alerta;
        }
    }

?>