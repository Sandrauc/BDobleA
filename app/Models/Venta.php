<?php

namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Exception;
use JsonSerializable;

class Venta extends AbstractDBConnection implements Model, JsonSerializable
{
    private ?int $id;
    private string $id_venta;
    private carbon $fecha;
    private int $valor_total;
    private string $metodo_pago;
    private string $estado;
    private string $persona_documento;
    private Carbon $created_at;
    private Carbon $updated_at;

    /* Relaciones */
    private ?Venta $cliente; // Objeto de cliente (Nombres, Telefono, direccion)
    private ?array $detalleVenta;

    /**
     * Venta constructor. Recibe un array asociativo
     * @param array $Venta
     */
    public function __construct(array $Venta = [])
    {
        parent::__construct();
        $this->setId_venta($Venta['id'] ?? NULL);
        $this->setFecha(!empty($Venta['created_at']) ? Carbon::parse($Venta['created_at']) : new Carbon());
        $this->setvalor_total($Venta['valor_total'] ?? NULL);
        $this->setmetodo_pago(Venta['metodo_pago'] ?? 0);
        $this->setEstado($Venta['estado'] ?? 'En progreso');
        $this->setpersona_documento($venta['persona_documento'] ?? NULL);
        $this->setCreatedAt(!empty($Venta['created_at']) ? Carbon::parse($Venta['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($venta['updated_at']) ? Carbon::parse($Venta['updated_at']) : new Carbon());

    }

    /**
     *
     */
    function __destruct()
    {
        if($this->isConnected){
            $this->Disconnect();
        }
    }

    /**
     * @return int|mixed
     * @return int|mixed
     */
    public function getId_venta() : ?int
    {
        return $this->id_venta;
    }

    /**
     * @param int|mixed $id
     */
    public function setId_venta(?int $id_venta): void
    {
        $this->id_venta =$id_venta;
    }

    /**
    /**
     * @return Carbon|mixed
     */
    public function getfecha() : Carbon
    {
        return $this->fecha->locale('es');
    }

    /**
     * @param Carbon|mixed $fecha
     */
    public function setfecha(Carbon $fecha): void
    {
        $this->fecha = $fecha;
    }


    /**
     * @return int
     */
    public function getvalor_total() : int
    {
        return $this->valor_total;
    }

    /**
     * @param int $valor_total
     */
    public function setvalor_total(int $valor_total): void
    {
        $this->valor_total = $valor_total;
    }

    /**
     * @return int
     */
    public function getmetodo_pago() : int
    {
        return $this->metodo_pago;
    }

    /**
     * @param int $metodo_pago
     */
    public function setmetodo_pago(int $metodo_pago): void
    {
        $this->metodo_pago = $metodo_pago;
    }

    /**
     * @return mixed|string
     */
    public function getestado() : string
    {
        return $this->estado;
    }

    /**
     * @param mixed|string $estado
     */
    public function setestado(string $estado): void
    {
        $this->estado = $estado;
    }
    /**
     * @return int
     */
    public function persona_documento() : int
    {
        return $this->persona_documento();
    }

    /**
     * @param int $persona_documento
     */
    public function setpersona_documento(int $persona_documento): void
    {
        $this->persona_documento= $persona_documento;
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

    /* Relaciones */
    /**
     * Retorna el objeto usuario del empleado correspondiente a la venta
     * @return |null
     */
    public function getEmpleado(): ?venta
    {
        if(!empty($this->empleado_id)){
            $this->empleado = venta::searchForId($this->empleado_id) ?? new venta();
            return $this->venta;
        }
        return NULL;
    }

    /**
     * Retorna el objeto usuario del cliente correspondiente a la venta
     * @return venta|null
     */
    public function getCliente(): ?venta
    {
        if(!empty($this->cliente_id)){
            $this->cliente = venta::searchForId($this->cliente_id) ?? new venta();
            return $this->cliente;
        }
        return NULL;
    }

    /**
     * retorna un array de detalles venta que perteneces a una venta
     * @return array
     */
    public function getDetalleVenta(): ?array
    {

        $this->detalleVenta = DetalleCompras::search('SELECT * FROM dbdoblea.detalle_venta where venta_id = '.$this->id);
        return $this->detalleVenta;
    }

    /**
     * @param string $query
     * @return bool|null
     */
    protected function save(string $query): ?bool
    {
        $arrData = [
            ':id' =>    $this->getid(),
            ':id_venta' =>   $this->getId_venta(),
            ':fecha' =>  $this->getFecha()->toDateTimeString(), //YYYY-MM-DD HH:MM:SS
            ':valor_total' =>   $this->getvalor_total(),
            ':metodo_pago' =>   $this->getmetodo_pago(),
            ':estado' =>   $this->getestado(),
            ':persona_documento' =>   $this->getpersona_documento(),
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
    function
    insert(): ?bool
    {
        $query = "INSERT INTO dbdoblea VALUES (:id_venta,:fecha,:valor_total,:metodo_pago,:estado,:persona_documento,:created_at,:updated_at)";
        return $this->save($query);
    }

    /**
     * @return bool|null
     */
    public function update() : ?bool
    {
        $query = "UPDATE dbdoblea.venta SET 
            numero_serie = :numero_serie, cliente_id = :cliente_id,
            empleado_id = :empleado_id, fecha_venta = :fecha_venta,
            monto = :monto, estado = :estado,
            created_at = :created_at, updated_at = :updated_at WHERE id = :id";
        return $this->save($query);
    }

    /**
     *
     *
     * @return mixed
     */
    public function deleted() : bool
    {
        $this->setEstado("Inactivo"); //Cambia el estado del Usuario
        return $this->update();                    //Guarda los cambios..
    }

    /**
     * @param $query
     * @return mixed
     */
    public static function search($query) : ?array
    {
        try {
            $arrVenta= array();
            $tmp = new Venta();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Venta = new Venta($valor);
                array_push($arrVenta, $Venta);
                unset($Venta);
            }
            return $arrVenta;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return NULL;
    }

    /**
     * @param $id
     * @return Venta
     * @throws Exception
     */
    public static function searchForId($id) : ?Venta
    {
        try {
            if ($id > 0) {
                $Venta = new Venta();
                $Venta->Connect();
                $getrow = $Venta->getRow("SELECT * FROM bddoblea.venta WHERE id =?", array($id));
                $Venta->Disconnect();
                return ($getrow) ? new Venta($getrow) : null;
            }else{
                throw new Exception('Id de venta Invalido');
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return NULL;
    }

    /**
     * @return array
     * @throws Exception
     */
    public static function getAll() : array
    {
        return Venta::search("SELECT * FROM dbdoblea.venta");
    }

    /**
     * @param $numeroSerie
     * @return bool
     * @throws Exception
     */
    public static function facturaRegistrada($numeroSerie): bool
    {
        $numeroSerie = trim(strtolower($numeroSerie));
        $result = Compras::search("SELECT id FROM dbdoblea.venta where numero_serie = '" . $numeroSerie. "'");
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
        return "Numero Serie: $this->numero_serie, Cliente: ".$this->getCliente()->nombresCompletos().", Empleado: ".$this->getEmpleado()->nombresCompletos().", Fecha Venta: $this->fecha_venta->toDateTimeString(), Monto: $this->monto, Estado: $this->estado";
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
            'id' => $this->getid(),
            'id_venta' => $this->getid_venta()->jsonSerialize(),
            'fecha' => $this->getFecha()->toDateTimeString(),
            'valor_total' => $this->getvalor_total(),
            'metodo_pago' => $this->getmetodo_pago(),
            'estado' => $this->getEstado(),
            'persona_documento' => $this->getpersona_documento(),
            'created_at' => $this->getCreatedAt()->toDateTimeString(),
            'updated_at' => $this->getUpdatedAt()->toDateTimeString(),
        ];
    }
}