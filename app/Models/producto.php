<?php
namespace app\Models;



require(__DIR__ . '/../../vendor/autoload.php');
require_once ('BasicModel.php');

class Producto extends BasicModel
{

    public int $id_producto;
    public string $nombre;
    public int $tamano;
    public int $precio;
    public string $descripcion;
    public int $stock;
    public float $precio_base;
    public string $categoria;
    public string $estado;

    public function __construct($producto = array())
    {
        $this->id_producto = $producto['id'] ?? 0;
        $this->nombre = $producto['nombre'] ?? '';
        $this->tamano = $producto['tamano'] ?? 0;
        $this->precio = $producto['precio'] ?? 0.0;
        $this->descripcion = $producto['descripcion'] ?? 0;
        $this->stock = $producto['stock'] ?? 0;
        $this->precio_base = $producto['precio_base'] ?? 0;
        $this->categoria = $producto['categoria'] ?? '';
        $this->estado = $producto['estado'] ?? '';
    }

    public function __destruct()
    {
        $this->Disconnect();
    }

    /**
     * @return int|mixed
     */
    public function getid_producto(): int
    {
        return $this->id_producto;
    }

    /**
     * @param int|mixed $id
     */
    public function setid_producto(int $id_producto): void
    {
        $this->id_producto = $id_producto;
    }

    /**
     * @return int|mixed
     */
    public function getnombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param int|mixed $id
     */
    public function setnombre(int $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return int|mixed
     */
    public function gettamano(): int
    {
        return $this->gettamano();
    }

    /**
     * @param int|mixed $tamano
     */
    public function settamano(int $tamano): void
    {
        $this->tamano = $tamano;
    }

    /**
     * @return int|mixed
     */
    public function getprecio(): int
    {
        return $this->precio;
    }

    /**
     * @param int|mixed $id
     */
    public function setprecio(int $precio): void
    {
        $this->precio = $precio;
    }

    /**
     * @return int|mixed
     */
    public function getdescripcion(): int
    {
        return $this->descripcion;
    }

    /**
     * @param int|mixed $descripcion
     */
    public function setdescripcion(int $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return int|mixed
     */
    public function getstock(): int
    {
        return $this->stock;
    }

    /**
     * @param int|mixed $stock
     */
    public function setstock(int $stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @return int|mixed
     */
    public function getpreciobase(): int
    {
        return $this->precio_base;
    }

    /**
     * @param int|mixed $precio_base
     */
    public function setprecio_base(int $precio_base): void
    {
        $this->precio_base= $precio_base;
    }


    /**
     * @return int|mixed
     */
    public function getcategoria(): int
    {
        return $this->categoria;
    }

    /**
     * @param int|mixed $categoria
     */
    public function setcategoria(int $categoria): void
    {
        $this->categoria= $categoria;
    }

    /**
     * @return int|mixed
     */
    public function getestado(): string
    {
        return $this->estado;
    }

    /**
     * @param int|mixed $estado
     */
    public function setestado(string $estado): void
    {
        $this->estado = $estado;
    }


    protected function create(): string
    {
        $result = $this->insertRow("INSERT INTO dbdoblea.producto VALUES (NULL, ?, ?, ?, ?, ?, ?, ?,?)", array(
                $this->nombre,
                $this->tamano,
                $this->precio,
                $this->descripcion,
                $this->stock,
                $this->precio_base,
                $this->categoria,
                $this->estado
            )
        );
        $this->Disconnect();
        return $result;
    }

    public function update()
    {
        $result = $this->updateRow("UPDATE BDobleA.producto SET nombre = ?, tamano = ?, precio= ?, descripcion= ?,precio_base = ?,categoria= ?,estado = ? WHERE id_producto = ?", array(
                $this->nombre,
                $this->tamano,
                $this->precio,
                $this->descripcion,
                $this->stock,
                $this->precio_base,
                $this->categoria,
                $this->estado
            )
        );
        $this->Disconnect();
        return $result;
    }

    protected function deleted($id_producto): bool
    {
        $producto = producto::searchForId($id_producto);
        $producto->setEstado("Activo");
        return $producto->update();
    }

    protected static function search($query): array
    {
        $arrproductos = array();
        $tmp = new Producto();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $producto = new Producto();
            $producto->id_producto = $valor['id_producto'];
            $producto->nombre = $valor['nombre'];
            $producto->tamano = $valor['tamano'];
            $producto->precio = $valor['precio'];
            $producto->descripcion = $valor['descripcion'];
            $producto->stock = $valor['stock'];
            $producto->precio_base = $valor['precio_base'];
            $producto->categoria = $valor['categoria'];
            $producto->estado = $valor['estado'];
            $producto->Disconnect();

            array_push($arrproducto, $producto);
        }

        $tmp->Disconnect();
        return $arrproducto;
    }

    /**
     * @param $id
     * @return Productos
     * @throws \Exception
     */
    public static function searchForId($id_producto): producto
    {
        $producto = null;
        if ($id_producto > 0) {
            $producto = new producto();
            $getrow = $producto->getRow("SELECT * FROM dbdoblea.producto  WHERE id_producto =?", array($id_producto));
            $producto->id_producto = $getrow['id_producto'];
            $producto->nombre = $getrow['nombre'];
            $producto->tamano = $getrow['tamano'];
            $producto->precio = $getrow['precio'];
            $producto->descripcion = $getrow['descripcion'];
            $producto->stock = $getrow['stock'];
            $producto->precio_base = $getrow['precio_base'];
            $producto->categoria = $getrow['categoria'];
            $producto->estado = $getrow['estado'];
        }
        $producto->Disconnect();
        return $producto;
    }

    protected static function getAll(): array
    {
        return Producto::search("SELECT * FROM dbdoblea.producto");
    }

    public static function productoRegistrado($nombres): bool
    {
        $result = Producto::search("SELECT id FROM dbdoblea.producto where nombre = '" . $nombres. "'");
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function jsonSerialize()
    {
        return [
            'nombre' => $this->getnombre(),
            'tamano' => $this->gettamano(),
            'precio' => $this->getprecio(),
            'descripcion' => $this->getdescripcion(),
            'stock' => $this->getstock(),
            'precio_base' => $this->getprecio_base(),
            'categoria' => $this->getcategoria(),
            'estado' => $this->getestado(),

        ];
    }

    protected function save()
    {
        // TODO: Implement save() method.
    }
}
