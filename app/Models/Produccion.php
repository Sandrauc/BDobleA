<?php

namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Exception;
use JsonSerializable;

class Produccion extends AbstractDBConnection implements Model, JsonSerializable
{
    private ?int $id_produccion;
    private carbon $fecha;
    private int $cantidad;
    private Carbon $created_at;
    private Carbon $updated_at;

    /* Relaciones */


    /**
     * Producto constructor. Recibe un array asociativo
     * @param array $produccion
     */
    public function __construct(array $produccion = [])
    {
        parent::__construct();
        $this->setId_produccion($produccion['id_produccion'] ?? NULL);
        $this->setFecha(!empty($produccion['fecha']) ? Carbon::parse($produccion['fecha']) : new Carbon());
        $this->setCantidad($produccion['cantidad'] ?? 0.0);
        $this->setCreatedAt(!empty($produccion['created_at']) ? Carbon::parse($produccion['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($produccion['updated_at']) ? Carbon::parse($produccion['updated_at']) : new Carbon());
    }

    function __destruct()
    {
        if($this->isConnected){
            $this->Disconnect();
        }
    }

    /**
     * @return int|null
     */
    public function getId_produccion() : ?int
    {
        return $this->id_produccion;
    }

    /**
     * @param int|null $id_Produccion
     */
    public function setId_produccion(?int $id_Produccion): void
    {
        $this->id_produccion = $id_Produccion;
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
     * @return mixed|string
     */
    public function getcantidad() : float
    {
        return $this->cantidad;
    }

    /**
     * @param mixed|string $cantidad
     * @return float
     */
    public function setcantidad(string $cantidad): float
    {
        $this->cantidad = $cantidad;
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
     * retorna un array de fotos que pertenecen al producto
     * @return array
     */

    protected function save(string $query): ?bool
    {
        $arrData = [
            ':id' =>    $this->getId_produccion(),
            ':fecha' =>   $this->getfecha(),
            ':cantidad' =>   $this->getcantidad(),
            ':created_at' =>  $this->getCreatedAt()->toDateTimeString(), //YYYY-MM-DD HH:MM:SS
            ':updated_at' =>  $this->getUpdatedAt()->toDateTimeString() //YYYY-MM-DD HH:MM:SS
        ];
        $this->Connect();
        $result = $this->insertRow($query, $arrData);
        $this->Disconnect();
        return $result;
    }

    /**
     * @return bool|null
     */
    function insert(): ?bool
    {
        $query = "INSERT INTO dbdoblea.produccion VALUES (:id_produccion,:fecha,:cantidad,:created_at,:updated_at)";
        return $this->save($query);
    }

    /**
     * @return bool|null
     */
    public function update(): ?bool
    {
        $query = "UPDATE dbdoblea.produccion SET 
            fecha = :fecha, cantidad = :cantidad, created_at = :created_at,updated_at = :updated_at WHERE id_produccion = :id_produccion";
        return $this->save($query);
    }


    /*                                OJO
     * ---------------------------------------------------------------------
     * @return bool
     * @throws Exception

    public function deleted(): bool
    {
        $this->setEstado("Inactivo"); //Cambia el estado del Usuario
        return $this->update();                    //Guarda los cambios..
    }
    -------------------------------------------------------------------------
     **/

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
    public static function searchForId($id_produccion) : ?Producto
    {
        try {
            if ($id_produccion > 0) {
                $Produccion = new Produccion();
                $Produccion->Connect();
                $getrow = $Produccion->getRow("SELECT * FROM dbdoblea.produccion WHERE id_produccion =?", array($id_produccion));
                $Produccion->Disconnect();
                return ($getrow) ? new Produccion($getrow) : null;
            }else{
                throw new Exception('Id de produccion Invalido');
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
    public static function getAll() : ?array
    {
        return Produccion::search("SELECT * FROM dbdoblea.produccion");
    }

    /**
     * @param $nombre
     * @return bool
     * @throws Exception
     */
    public static function produccionRegistrada($fecha): bool
    {
        $fecha = trim(strtolower($fecha));
        $result = Produccion::search("SELECT id FROM dbdoblea.produccion where fecha = '" . $fecha. "'");
        if ( !empty($result) && count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4
     */
    public function jsonSerialize()
    {
        return [
            'fecha' => $this->getFecha(),
            'cantidad' => $this->getcantidad(),

        ];
    }

    function deleted()
    {

    }
}
