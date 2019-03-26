<?php 

class vistasModelo{

    protected function obtener_vistas_modelo($vistas){
        $lista_blanca=["emptrans","inicio","emptranslist","usuariolist","usuario","micuenta"];

        if(in_array($vistas,$lista_blanca)){
            if(is_file("./vistas/contenidos/{$vistas}-view.php")){
                $contenido="./vistas/contenidos/{$vistas}-view.php";
            }else{
                $contenido = "login";
            }
        }elseif($vistas=="login"){
            $contenido="login";
        }elseif($vistas=="index"){
            $contenido="login";
        }else{  
            $contenido="404";
        }
        
        return $contenido;
    }

}


