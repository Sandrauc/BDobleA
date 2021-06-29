<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php');

use App\Models\GeneralFunctions;
use App\Models\Produccion;
use Carbon\Carbon;

class ProduccionController{

    private array $dataProduccion;

    public function __construct(array $_FORM)
    {
        $this->dataProduccion = array();
        $this->dataProduccion['id_produccion'] = $_FORM['id_produccion'] ?? NULL;
        $this->dataProduccion['fecha'] = !empty($_FORM['fecha']) ? Carbon::parse($_FORM['fecha']) : new Carbon();
        $this->dataProduccion['Cantidad'] = $_FORM['cantidad'] ?? 0.0;

    }

    public function create() {
        try {
            if (!empty($this->dataProduccion['nombre']) && !Produccion::produccionRegistrada($this->dataProduccion['fecha'])) {
                $Produccion = new Produccion(); ($this->dataProduccion);
                if ($Produccion->insert()) {
                    unset($_SESSION['frmProduccion']);
                    header("Location: ../../views/modules/productos/index.php?respuesta=success&mensaje=Produccion Registrada con exito!");
                }
            } else {
                header("Location: ../../views/modules/productos/create.php?respuesta=error&mensaje=Producto ya registrado");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    public function edit()
    {
        try {
            $produccion = new Produccion($this->dataProduccion);
            if($produccion->update()){
                unset($_SESSION['frmProduccion']);
            }

            header("Location: ../../views/modules/produccion/show.php?id=" . $produccion->getId_produccion() . "&respuesta=success&mensaje=Produccion Actualizada");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Produccion::searchForId($data['id_produccion']);
            if (!empty($data['request']) and $data['request'] === 'ajax' and !empty($result)) {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result->jsonSerialize());
            }
            return $result;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    static public function getAll (array $data = null){
        try {
            $result = Produccion::getAll();
            if (!empty($data['request']) and $data['request'] === 'ajax') {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result);
            }
            return $result;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    static public function activate (int $id){
        try {
            $ObjProduccion = Produccion::searchForId($id);
            $ObjProduccion->setEstado("Activo");
            if($ObjProduccion->update()){
                header("Location: ../../views/modules/produccion/index.php");
            }else{
                header("Location: ../../views/modules/produccion/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function inactivate (int $id){
        try {
            $ObjProduccion = Produccion::searchForId($id);
            $ObjProduccion->setEstado("Inactivo");
            if($ObjProduccion->update()){
                header("Location: ../../views/modules/productos/index.php");
            }else{
                header("Location: ../../views/modules/productos/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function selectProducto (array $params = []){

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id_produccion'] = $params['id'] ?? "id_produccion";
        $params['name'] = $params['name'] ?? "id_produccion";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrProduccion = array();
        if($params['where'] != ""){
            $base = "SELECT * FROM produccion WHERE ";
            $arrProducto = Produccion::search($base.$params['where']);
        }else{
            $arrProducto = Produccion::getAll();
        }

        $htmlSelect = "<select ".(($params['isMultiple']) ? "multiple" : "")." ".(($params['isRequired']) ? "required" : "")." id= '".$params['id']."' name='".$params['name']."' class='".$params['class']."'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(is_array($arrProduccion) && count($arrProduccion) > 0){
            /* @var $arrProduccion Produccion[] */
            foreach ($arrProduccion as $produccion)
                if (!Produccion::produccionIsInArray($produccion->getId_produccion(),$params['arrExcluir']))
                    $htmlSelect .= "<option ".(($produccion != "") ? (($params['defaultValue'] == $produccion->getId_produccion()) ? "selected" : "" ) : "")." value='".$produccion->getId_produccion()."'>".$produccion->getFecha()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    public static function produccionisInArray($idProduccion, $ArrProduccion){
        if(count($ArrProduccion) > 0){
            foreach ($ArrProduccion as $Produccion){
                if($Produccion->getId() == $idProduccion){
                    return true;
                }
            }
        }
        return false;
    }

}