<?php
namespace app\Models;

require(__DIR__ . '/../../vendor/autoload.php');
require_once ('BasicModel.php');


use Carbon\Carbon;

class Produccion extends BasicModel
{
    public int $id_produccion;
    public Carbon $fecha;
    public int $cantidad;
    public int $producto_id;


    public function __construct($produccion = array())
    {
        parent ::_construct();
        $this->id_produccion = $produccion['id'] ?? 0;
        $this->fecha = $produccion['fecha'] ?? new Carbon();
        $this->cantidad = $produccion['cantidad'] ?? 0;
        $this->producto_id = $produccion['producto_id'] ?? 0.0;

    }


    public function __destruct()
    {
        $this->Disconnect();
    }

    /**
     * @return int|mixed
     */
    public function getid_produccion(): int
    {
        return $this->id_produccion;
    }

    /**
     * @param int|mixed $id
     */
    public function setid_produccion(int $id_produccion): void
    {
        $this->id_produccion = $id_produccion;
    }

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
     * @return int|mixed
     */
    public function getcantidad(): int
    {
        return $this->cantidad;
    }

    /**
     * @param int|mixed $cantidad
     */
    public function setcantidad(int $cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @return int|mixed
     */
    public function getproducto_id(): int
    {
        return $this->producto_id;
    }

    /**
     * @param int|mixed $producto_id
     */
    public function setproducto_id(int $producto_id): void
    {
        $this->producto_id = $producto_id;
    }

    protected function create(): string
    {
        $result = $this->insertRow("INSERT INTO dbdoblea.produccion VALUES (NULL, ?, ?, ?)", array(
                $this->fecha->toDateTimeString(), //YYYY-MM-DD HH:MM:SS,
                $this->cantidad,
                $this->producto_id

            )
        );
        $this->Disconnect();
        return $result;
    }

    protected function update()
    {
        $result = $this->updateRow("UPDATE dbdoblea.produccion SET fecha = ?, cantidad = ?, producto_id= ?  WHERE id_produccion = ?", array(
                $this->fecha->toDateTimeString(),
                $this->cantidad,
                $this->producto_id

            )
        );
        $this->Disconnect();
        return $result;
    }

    protected function deleted($id_produccion): bool
    {
        $producto = produccion::searchForId($id_produccion);
        $producto->setfecha('');
        return $producto->update();
    }

    protected static function search($query): array
    {
        $arrproduccion = array();
        $tmp = new Produccion();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $produccion = new Produccion();
            $produccion->id_Produccion = $valor['id_Produccion'];
            $produccion->fecha = $valor['fecha'];
            $produccion->cantidad = $valor['cantidad'];
            $produccion->producto_id = $valor['producto_id'];

            $produccion->Disconnect();

            array_push($arrproducto, $produccion);
        }

        $tmp->Disconnect();
        return $arrproducto;
    }

    /**
     * @param $id
     * @return Produccion
     * @throws \Exception
     */
    public static function searchForId($id_produccion): produccion
    {
        $producto = null;
        if ($id_produccion > 0) {
            $produccion = new produccion();
            $getrow = $produccion->getRow("SELECT * FROM dbdoblea.produccion  WHERE id_produccion =?", array($id_produccion));
            $produccion->id_produccion = $getrow['id_produccion'];
            $produccion->fecha  = Carbon::parse($getrow['fecha']);
            $produccion->cantidad = $getrow['cantidad'];
            $produccion->producto_id = $getrow['producto_id'];
        }
        $producto->Disconnect();
        return $producto;
    }

    protected static function getAll(): array
    {
        return produccion::search("SELECT * FROM BDobleA.produccion");
    }

    public static function produccionRegistrada($fecha): bool
    {
        $result = produccion::search("SELECT id FROM dbdoblea.produccion where fecha = '" . $fecha . "'");
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function jsonSerialize()
    {
        return [
            'fecha' => $this->getfecha(),
            'cantidad' => $this->getcantidad(),
            'producto_id' => $this->getproducto_id()

        ];
    }

    protected function save()
    {
        // TODO: Implement save() method.
    }
}