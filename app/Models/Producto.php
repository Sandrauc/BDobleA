<?php

namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Exception;
use JsonSerializable;

class Producto extends AbstractDBConnection implements Model, JsonSerializable
{
    private ?int $id_producto;
    private string $nombre;
    private float $tamano;
    private float $precio;
    private string $descripcion;
    private string $estado;
    private ?int $stock;
    private ?int $precio_base;
    private string $categoria;
    private Carbon $created_at;
    private Carbon $updated_at;

    /* Relaciones */


    /**
     * Producto constructor. Recibe un array asociativo
     * @param array $categoria
     */
    public function __construct(array $categoria = [])
    {
        parent::__construct();
        $this->setId_producto($categoria['id_producto'] ?? NULL);
        $this->setNombre($categoria['nombre'] ?? '');
        $this->settamano($categoria['categoria'] ?? 0.0);
        $this->setPrecio($categoria['precio'] ?? 0.0);
        $this->setDescripcion($categoria['descripcion'] ?? 0);
        $this->setEstado($categoria['estado'] ?? 0);
        $this->setStock($categoria['stock'] ?? '');
        $this->setCreatedAt(!empty($categoria['created_at']) ? Carbon::parse($categoria['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($categoria['updated_at']) ? Carbon::parse($categoria['updated_at']) : new Carbon());
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
    public function getId_producto() : ?int
    {
        return $this->id_producto;
    }

    /**
     * @param int|null $id_Produccion
     */
    public function setId_producto(?int $id_Produccion): void
    {
        $this->id_producto = $id_Produccion;
    }

    /**
     * @return mixed|string
     */
    public function getnombre() : string
    {
        return ucwords($this->nombre);
    }

    /**
     * @param mixed|string $nombre
     */
    public function setnombre(string $nombre): void
    {
        $this->nombre = trim(mb_strtolower($nombre, 'UTF-8'));
    }
    /**
     * @return mixed|string
     */
    public function gettamano() : float
    {
        return $this->tamano;
    }

    /**
     * @param mixed|string $tamano
     * @return float
     */
    public function settamano(string $tamano): float
    {
        $this->tamano = $tamano;
    }
    /**
     * @return float|mixed
     */
    public function getPrecio() : float
    {
        return $this->precio;
    }

    /**
     * @param float|mixed $precio
     */
    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }

    /**
     * @return float|mixed
     */
    public function getdescripcion() : float
    {
        return $this->descripcion;
    }

    /**
     * @param float|mixed $Descripcion
     */
    public function setdescripcion(float $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed|string
     */
    public function getEstado() : string
    {
        return $this->estado;
    }

    /**
     * @param mixed|string $estado
     */
    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }
    /**
     * @return int|mixed
     */
    public function getStock() : int
    {
        return $this->stock;
    }

    /**
     * @param int|mixed $stock
     */
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @return int
     */
    public function getprecio_base(): int
    {
        return $this->precio_base;
    }

    /**
     * @param int $precio_base
     */
    public function setprecio_base(int $precio_base): void
    {
        $this->precio_base = $precio_base;
    }

    /**
     * @return int
     */
    public function getcategoria(): int
    {
        return $this->categoria;
    }

    /**
     * @param int $precio_base
     */
    public function setcategoria(int $categoria): void
    {
        $this->precio_base = $categoria;
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
            ':id' =>    $this->getId_producto(),
            ':nombre' =>   $this->getnombre(),
            ':tamano' =>   $this->gettamano(),
            ':precio' =>   $this->getPrecio(),
            ':descripcion' =>   $this->getdescripcion(),
            ':estado' =>   $this->getestado(),
            ':stock' =>   $this->getStock(),
            ':precio_base' =>   $this->getprecio_base(),
            ':categoria_id' =>   $this->getcategoria(),
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
        $query = "INSERT INTO dbdoblea.producto VALUES (:id_producto,:nombre,:tamano,:precio,:descripcion,:estado,:stok,:precio_base,:categoria,:created_at,:updated_at)";
        return $this->save($query);
    }

    /**
     * @return bool|null
     */
    public function update(): ?bool
    {
        $query = "UPDATE dbdoblea.producto SET 
            nombre = :nombre, tamano = :tamano, precio = :precio, descripcion = :descripcion, estado = :estado, stock = :stock, precio_base = :precio_base, created_at = :created_at, 
            updated_at = :updated_at WHERE id_producto = :id_producto";
        return $this->save($query);
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function deleted(): bool
    {
        $this->setEstado("Inactivo"); //Cambia el estado del Usuario
        return $this->update();                    //Guarda los cambios..
    }

    /**
     * @param $query
     * @return Producto|array
     * @throws Exception
     */
    public static function search($query) : ?array
    {
        try {
            $arrProducto = array();
            $tmp = new Producto();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Producto = new Producto($valor);
                array_push($arrProductos, $Producto);
                unset($Producto);
            }
            return $arrProducto;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    /**
     * @param $id
     * @return Producto
     * @throws Exception
     */
    public static function searchForId($id_producto) : ?Producto
    {
        try {
            if ($id_producto > 0) {
                $Producto = new Producto();
                $Producto->Connect();
                $getrow = $Producto->getRow("SELECT * FROM dbdoblea.producto WHERE id_producto =?", array($id_producto));
                $Producto->Disconnect();
                return ($getrow) ? new Producto($getrow) : null;
            }else{
                throw new Exception('Id de producto Invalido');
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
        return Producto::search("SELECT * FROM dbdoblea.producto");
    }

    /**
     * @param $nombre
     * @return bool
     * @throws Exception
     */
    public static function productoRegistrado($nombre): bool
    {
        $nombre = trim(strtolower($nombre));
        $result = Producto::search("SELECT id FROM dbdoblea.producto where nombre = '" . $nombre. "'");
        if ( !empty($result) && count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }



    public function substractStock(int $quantity)
    {
        $this->setStock( $this->getStock() - $quantity);
        $result = $this->update();
        if($result == false){
            GeneralFunctions::console('Stock no actualizado!');
        }
        return $result;
    }

    public function addStock(int $quantity)
    {
        $this->setStock( $this->getStock() + $quantity);
        $result = $this->update();
        if($result == false){
            GeneralFunctions::console('Stock no actualizado!');
        }
        return $result;
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
            'nombre' => $this->getnombre(),
            'tamano' => $this->gettamano(),
            'precio' => $this->getPrecio(),
            'descripcion' => $this->getdescripcion(),
            'estado' => $this->getEstado(),
            'stock' => $this->getStock(),
            'precio_base' => $this->getprecio_base(),
            'categoria' => $this->getcategoria(),
        ];
    }
}
