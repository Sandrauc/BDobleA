<?php
namespace App\Models;

use App\Models\Interfaces\Model;
use Carbon\Carbon;
use Exception;
use JsonSerializable;

class Produccion extends AbstractDBConnection implements Model, JsonSerializable
{
    /* Tipos de Datos => bool, int, float,  */
    public ?int $id_produccion;
    public carbon $fecha;
    public ?int $cantidad;
    public ?int $producto_id;

    public array $producto;
    public  $updated_at;
    public $created_at;


    /**
     * Usuarios constructor. Recibe un array asociativo
     * @param array $produccion
     */
    public function __construct(array $usuario = [])

    {
        parent::__construct();
        $this->setId_produccion($produccion['id'] ?? NULL);
        $this->setFecha( !empty($produccion['fecha']) ? Carbon::parse($produccion['fecha']) : new Carbon());
        $this->setproducto_id($produccion['produccion_id'] ?? '');
        $this->setCreatedAt(!empty($usuario['created_at']) ? Carbon::parse($usuario['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($usuario['updated_at']) ? Carbon::parse($usuario['updated_at']) : new Carbon());
    }

    public static function productoRegistrado($fecha)
    {
    }

    function __destruct()
    {
        if($this->isConnected){
            $this->Disconnect();
        }
    }

    /**
     * @return int|mixed
     */
    public function getId_produccion() : ?int
    {
        return $this->id_produccion;
    }

    /**
     * @param int|null $id_produccion
     */
    public function setId_produccion(?int $id_produccion): void
    {
        $this->id_produccion = $id_produccion;
    }

    /**
     * @return Carbon|mixed
     */
    public function getFecha() : Carbon
    {
        return $this->fecha->locale('es');
    }

    /**
     * @param Carbon|mixed $fecha
     */
    public function setFecha(Carbon $fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return int|mixed
     */
    public function getcantidad() : ?int
    {
        return $this->cantidad;
    }

    /**
     * @param int|null $cantidad
     */
    public function setcantidad (?int $cantidad): void
    {
        $this->cantidad = $cantidad;
    }
    /**
     * @return int|mixed
     */
    public function getproducto_id() : ?int
    {
        return $this->producto_id;
    }

    /**
     * @param int|null $producto_id
     */
    public function setproducto_id (?int $producto_id): void
    {
        $this->producto_id = $producto_id;
    }


    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->created_at->locale('es');
    }

    /**
     * @param Carbon $created_at
     */
    public function setCreatedAt(Carbon $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at->locale('es');
    }

    /**
     * @param Carbon $updated_at
     */
    public function setUpdatedAt(Carbon $updated_at): void
    {
        $this->updated_at = $updated_at;
    }



    /**
     * @param string $query
     * @return bool|null
     */
    protected function save(string $query): ?bool
    {
        $arrData = [
            ':id' =>    $this->getId_produccion(),
            ':fecha_nacimiento' =>  $this->getFecha()->toDateString(), //YYYY-MM-DD
            ':cantidad' =>   $this->getCantidad(),
            ':producto_id' =>   $this->getproducto_id(),
            ':created_at' =>  $this->getCreatedAt()->toDateTimeString(), //YYYY-MM-DD HH:MM:SS
            ':updated_at' =>  $this->getUpdatedAt()->toDateTimeString()
        ];
        $this->Connect();
        $result = $this->insertRow($query, $arrData);
        $this->Disconnect();
        return $result;
    }

    /**
     * @return bool|null
     */
    public function insert(): ?bool
    {
        $query = "INSERT INTO dbdoblea.produccion VALUES (
            :id_produccion,:fecha,:cantidad,:producto_id
        )";
        return $this->save($query);
    }

    /**
     * @return bool|null
     */
    public function update(): ?bool
    {
        $query = "UPDATEdbdoblea.produccion SET 
           fecha = :fecha, cantidad = :cantidad, producto_id = :producto_id,  WHERE id_produccion = :id_produccion";

        return $this->save($query);
    }

    /**
     * @param $id_produccion
     * @return bool
     * @throws Exception
     */
    public function deleted(): bool
    {
        $this->setFecha(''); //
        return $this->update();                    //
    }

    /**
     * @param $query
     * @return Produccion|array
     * @throws Exception
     */
    public static function search($query) : ?array
    {
        try {
            $arrProduccion = array();
            $tmp = new Produccion();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Produccion = new Produccion($valor);
                array_push($arrProduccion, $Produccion);
                unset($Produccion);
            }
            return $arrProduccion;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    /**
     * @param $id
     * @return Produccion
     * @throws Exception
     */
    public static function searchForId(int $id_Produccion): ?Produccion
    {
        try {
            if ($id_Produccion> 0) {
                $tmpProduccion = new Produccion();
                $tmpProduccion->Connect();
                $getrow = $tmpProduccion->getRow("SELECT * FROM dbdoblea.Produccion WHERE id =?", array($id_Produccion));
                $tmpProduccion->Disconnect();
                return ($getrow) ? new Produccion($getrow) : null;
            }else{
                throw new Exception('Id de usuario Invalido');
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    /**
     * @return array
     * @throws Exception
     */
    public static function getAll(): array
    {
        return Produccion::search("SELECT * FROM dbdoblea.Produccion");
    }

    /**
     * @param $id_produccion
     * @return bool
     * @throws Exception
     */
    public static function Produccionregistrada($id_produccion): bool
    {
        $result = produccion::search("SELECT * FROM dbdoblea.produccion where produccion = " . $id_produccion);
        if ( !empty($result) && count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return "id_produccion: $this->id_produccion, cantidad: $this->cantidad, $this->fecha->toDateTimeString(),producto_id: $this->producto_id";
    }

    public function jsonSerialize()
    {
        return [
            'id_produccion' => $this->getId_produccion(),
            'fecha' => $this->getFecha()->toDateString(),
            'cantidad' => $this->getcantidad(),
            'created_at' => $this->getCreatedAt()->toDateTimeString(),
            'updated_at' => $this->getUpdatedAt()->toDateTimeString(),
        ];
    }
}