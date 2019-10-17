<?php
$peticionAjax = true;
require_once '../core/configGeneral.php';
require_once '../controladores/componentesControlador.php';

$compCont = new componentesControlador();

if(isset($_POST["descripcion"]) && isset($_POST["unidad_med_new"])){
  echo $compCont->save_componente_controlador();
}

if(isset($_POST["descripcion_formEdit"]) && isset($_POST["nparte1"])){
  echo $compCont->update_componente_controlador();
}

if(isset($_POST["dataReferencia"])){
  echo $compCont->select_combo("SELECT * FROM datos_referencia WHERE id_dr != 1 ",1,1);
}

if(isset($_POST["comp_gen"])){
   //echo $compCont->componentes_gen_json();
   echo $compCont->obtener_consulta_json_controlador("SELECT * FROM componentes WHERE est = 1 ");
}

if(isset($_POST["idunidad_compgen"])){
    echo $compCont->select_combo("SELECT eu.id_equipounidad,eu.alias_equipounidad
    FROM equipo_unidad eu
    WHERE (eu.fk_idunidad = 7 OR eu.fk_idunidad = {$_POST["idunidad_compgen"]} ) 
    AND eu.est_baja = 1 AND eu.est = 1 AND eu.fk_idequipo !=1 ",0,1);
}
//VISTA COMPONENTES MODAL EDIT 

if(isset($_POST["id_comp"])){
  echo $compCont->obtener_consulta_json_controlador("SELECT c.id_comp,c.descripcion,c.nparte1,
  c.nparte2,c.nparte3,c.marca,um.id_unidad_med,um.abreviado,c.nserie,cc.id_categoria,cc.nombre,c.medida
  FROM componentes c 
  INNER JOIN unidad_medida um ON um.id_unidad_med = c.fk_idunidad_med
  INNER JOIN categoriacomp cc ON cc.id_categoria = c.fk_idcategoria
  WHERE c.id_comp = {$_POST["id_comp"]}");
}

if(isset($_POST["medida_neumatico"])){
  echo $compCont->select_combo("SELECT * FROM medida_neumaticos WHERE descripcion !='{$_POST["medida_neumatico"]}' ",1,1);
}

//VISTA COMPONENTES MODAL EDIT  - FIN


//VISTA INGRESO ALMACEN

if(isset($_POST["buscarcompajax"])){
  echo $compCont->paginador_componentes($_POST["paginadorajax"],10,$_POST["privilegioajax"],$_POST["buscarcompajax"],$_POST["vistaajax"]);
}



//VISTA DATOSREFERENCIA-VIEW


if(isset($_POST["id_dr_datosReferencia"])){

$id_dr = $_POST["id_dr_datosReferencia"];
$consulta="SELECT * FROM datos_referencia WHERE id_dr = {$id_dr}";
  echo  $compCont->obtener_consulta_json_controlador($consulta);
}

if(isset($_POST["id_dr_formEdit"]) && isset($_POST["dato_referencia_formEdit"])){
  echo $compCont->update_datoreferencia_controlador();
}

if(isset($_POST["referencia_dr_nuevo"]) && isset($_POST["descripcion_dr_nuevo"])){
  echo $compCont->save_datoreferencia_controlador();
}

if(isset($_POST["id_dr_delete"])){
  echo $compCont->delete_datoreferencia_controlador($_POST["id_dr_delete"]);
}

//FrmDelComp

if(isset($_POST["idcomp_FrmDelComp"])){
  echo $compCont->delete_componente_controlador();
}

if(isset($_POST["idcomp_DarBaja"])){
  echo $compCont->darBaja_componente_controlador();
}

if(isset($_POST["idcomp_DarAlta"])){
  echo $compCont->darAlta_componente_controlador();
}


/*if(isset($_POST["id_equipo"])){
    echo $compCont->validar_equipo($_POST["id_equipo"]);
}*/

