<?php 
    $peticionAjax=true;
    
    require_once '../Core/configGeneral.php';
    if(isset($_GET['Token'])){
        require_once '../controladores/loginControlador.php';
        $_GET['Token'];
        $logout = new loginControlador();
        echo $logout->cerrar_sesion_controlador();

    }else{
        session_start();
        session_destroy();
        echo '<script>window.location.href="'.SERVERURL.'login"</script>';
    }


?>