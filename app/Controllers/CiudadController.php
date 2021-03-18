
<?php




require(__DIR__ . '/../../vendor/autoload.php');

use App\Models\GeneralFunctions;
use App\Models\Municipios;

class CiudadController
{

    static public function searchForID(array $data)
    {
        try {
            $result = Ciudad::searchForId($data['id']);
            if (!empty($data['request']) and $data['request'] === 'ajax' and !empty($result)) {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result->jsonSerialize());
            }
            return $result;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }

    static public function getAll(array $data = null)
    {
        try {
            $result =Ciudad::getAll();
            if (!empty($data['request']) and $data['request'] === 'ajax') {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result);
            }
            return $result;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
        return null;
    }

    static public function selectCiudad($isMultiple = false,
                                            $isRequired = true,
                                            $id = "_id",
                                            $nombre = "ciudad_id",
                                            $defaultValue = "",
                                            $class = "form-control",
                                            $where = "",
                                            $arrExcluir = array(),
                                            $request = 'html')
    {
        $arrCiudad = array();
        if ($where != "") {
            $arrCiudad = Ciudad::search("SELECT * FROM ciudad WHERE " . $where);
        } else {
            $arrCiudad = Ciudad::getAll();
        }
        $htmlSelect = "<select " . (($isMultiple) ? "multiple" : "") . " " . (($isRequired) ? "required" : "") . " id= '" . $id . "' name='" . $nombre . "' class='" . $class . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (count($arrCiudad) > 0) {
            /* @var $arrCiudad Ciudad[] */
            foreach ($arrCiudad as $ciudad)
                if (!CiudadController::ciudadIsInArray()($ciudad->getId(), $arrExcluir))
                    $htmlSelect .= "<option " . (($ciudad != "") ? (($defaultValue == $ciudad->getId()) ? "selected" : "") : "") . " value='" . $ciudad->getId() . "'>" . $ciudad->getNombre() . "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    private static function ciudadIsInArray($idCiudad, $ArrCiudad)
    {
        if (count($ArrCiudad) > 0) {
            foreach ($ArrCiudad as $Usuario) {
                if ($Usuario->getId() == $idCiudad) {
                    return true;
                }
            }
        }
        return false;
    }

}