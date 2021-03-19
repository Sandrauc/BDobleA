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
        $this->dataProduccion['fecha'] = $_FORM['fecha'] ?? '';
        $this->dataProduccion['cantidad'] = $_FORM['cantidad'] ?? 0.0;
        $this->dataProduccion['producto_id'] = $_FORM['producto_id'] ?? 0.0;

    }

    public function create() {
        try {
            if (!empty($this->dataProducto['nombre']) && !Produccion::productoRegistrado($this->dataProduccion['nombre'])) {
                $Producto = new Produccion ($this->dataProduccion);
                if ($Producto->insert()) {
                    unset($_SESSION['frmProductos']);
                    header("Location: ../../views/modules/productos/index.php?respuesta=success&mensaje=Producto Registrado!");
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
            $producto = new Produccion($this->dataProduccion);
            if($producto->update()){
                unset($_SESSION['frmProductos']);
            }

            header("Location: ../../views/modules/productos/show.php?id=" . $producto->getId_produccion() . "&respuesta=success&mensaje=Producto Actualizado");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Produccion::searchForId($data['id']);
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
            $ObjProducto = Produccion::searchForId($id);
            $ObjProducto->setId_produccion("Activo");
            if($ObjProducto->update()){
                header("Location: ../../views/modules/productos/index.php");
            }else{
                header("Location: ../../views/modules/productos/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function inactivate (int $id){
        try {
            $ObjProducto = Produccion::searchForId($id);
            $ObjProducto->setEstado("Inactivo");
            if($ObjProducto->update()){
                header("Location: ../../views/modules/productos/index.php");
            }else{
                header("Location: ../../views/modules/productos/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function selectProduccion (array $params = []){

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "producto_id";
        $params['name'] = $params['name'] ?? "producto_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrProducto = array();
        if($params['where'] != ""){
            $base = "SELECT * FROM produccion WHERE ";
            $arrProducto = Produccion::search($base.$params['where']);
        }else{
            $arrProducto = Produccion::getAll();
        }

        $htmlSelect = "<select ".(($params['isMultiple']) ? "multiple" : "")." ".(($params['isRequired']) ? "required" : "")." id= '".$params['id']."' name='".$params['name']."' class='".$params['class']."'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrProducto) > 0){
            /* @var $arrProducto Produccion[] */
            foreach ($arrProducto as $producto)
                if (!ProductoController::productoIsInArray($producto->getId_produccion(),$params['arrExcluir']))
                    $htmlSelect .= "<option ".(($producto != "") ? (($params['defaultValue'] == $producto->getId_produccion()) ? "selected" : "" ) : "")." value='".$producto->getId()."'>".$producto->getNombre()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    public static function produccionIsInArray($idProduccion, $ArrProduccion){
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