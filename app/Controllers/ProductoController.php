<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php');

use App\Models\GeneralFunctions;
use App\Models\Producto;
use Carbon\Carbon;

class ProductoController{

    private array $dataProducto;

    public function __construct(array $_FORM)
    {
        $this->dataProducto = array();
        $this->dataProducto['id_produccion'] = $_FORM['id_produccion'] ?? NULL;
        $this->dataProducto['nombre'] = $_FORM['nombre'] ?? '';
        $this->dataProducto['tamano'] = $_FORM['tamano'] ?? '';
        $this->dataProducto['precio'] = $_FORM['precio'] ?? 0.0;
        $this->dataProducto['descripcion'] = $_FORM['descripcion'] ?? '';
        $this->dataProducto['estado'] = $_FORM['estado'] ?? 'Activo';
        $this->dataProducto['stock'] = $_FORM['stock'] ?? 0.0;
        $this->dataProducto['precio_base'] = $_FORM['precio_base'] ?? 0.0;
        $this->dataProducto['categoria_id'] = $_FORM['categoria_id'] ?? 0;

    }

    public function create() {
        try {
            if (!empty($this->dataProducto['nombre']) && !Producto::productoRegistrado($this->dataProducto['nombre'])) {
                $Producto = new Producto ($this->dataProducto);
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
            $producto = new Productos($this->dataProducto);
            if($producto->update()){
                unset($_SESSION['frmProductos']);
            }

            header("Location: ../../views/modules/productos/show.php?id=" . $producto->getId() . "&respuesta=success&mensaje=Producto Actualizado");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Producto::searchForId($data['id']);
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
            $result = Producto::getAll();
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
            $ObjProducto = Producto::searchForId($id);
            $ObjProducto->setEstado("Activo");
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
            $ObjProducto = Producto::searchForId($id);
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

    static public function selectProducto (array $params = []){

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "id_producto";
        $params['name'] = $params['name'] ?? "id_producto";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrProducto = array();
        if($params['where'] != ""){
            $base = "SELECT * FROM producto WHERE ";
            $arrProducto = Producto::search($base.$params['where']);
        }else{
            $arrProducto = Producto::getAll();
        }

        $htmlSelect = "<select ".(($params['isMultiple']) ? "multiple" : "")." ".(($params['isRequired']) ? "required" : "")." id= '".$params['id']."' name='".$params['name']."' class='".$params['class']."'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(is_array($arrProducto) && count($arrProducto) > 0){
            /* @var $arrProducto Producto[] */
            foreach ($arrProducto as $producto)
                if (!ProductoController::productoIsInArray($producto->getId_producto(),$params['arrExcluir']))
                    $htmlSelect .= "<option ".(($producto != "") ? (($params['defaultValue'] == $producto->getId_producto()) ? "selected" : "" ) : "")." value='".$producto->getId_producto()."'>".$producto->getNombre()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    public static function productoIsInArray($idProducto, $ArrProducto){
        if(count($ArrProducto) > 0){
            foreach ($ArrProducto as $Producto){
                if($Producto->getId() == $idProducto){
                return true;
                }
            }
        }
        return false;
    }

}