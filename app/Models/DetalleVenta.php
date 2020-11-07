<?php



class DetalleVenta
{
    public int $id_detalle_venta;
    public int $cantidad;
    public int $producto_id;
    public int $venta_id;


    public function __construct($id_detalle_venta = 123, $cantidad = 30, $producto_id = 54, $venta_id =25)
    {
        /* try {
             parent::__construct();
         } catch (Exception $e) {
         }*/
        $this->setid_detalle_venta($id_detalle_venta);
        $this->setcantidad($cantidad);
        $this->setproducto_id($producto_id);
        $this->setventa_id($venta_id);


        return $this;
    }

    /**
     * @return int|mixed
     */
    public function getid_detalle_venta(): int
    {
        return $this->id_detalle_venta;
    }

    /**
     * @param int|mixed $id_detalle_venta
     */
    public function setid_detalle_venta(int $id_detalle_venta): void
    {
        $this->id_detalle_venta = $id_detalle_venta;
    }


    /**
     * @return string|mixed
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
     * @return string|mixed
     */
    public function getproducto_id(): int
    {
        return $this->producto_id;
    }

    /**
     * @param string|mixed $producto_id
     */
    public function setproducto_id(int $producto_id): void
    {
        $this->producto_id= $producto_id;
    }

    /**
     * @return string|mixed
     */
    public function getventa_id(): int
    {
        return $this->venta_id;
    }

    /**
     * @param int|mixed $venta_id
     */
    public function setventa_id(int $venta_id): void
    {
        $this->venta_id= $venta_id;
    }





    /* public function create(): bool
     {
         $result = $this->insertRow("INSERT INTO persona.persona VALUES (NULL, ?, ?, ?, ?, ?, ?)", array(
                 $this->getnombres(),
                 $this->getapellidos(),
                 $this->gettelefono(),
                 $this->getemail(),
                 $this->getestado(),
                 $this->getrol(),
             )
         );
         $this->Disconnect();
         return $result;
     }*/
    //public function update()
    //{
    //  $result = $this->updateRow("UPDATE persona.persona SET documento = ?, nombres = ?, apellidos = ?, telefono = ?, email = ?, rol = ?,estado = ?  WHERE id = ?", array(
    //  $this->getdocumento(),
    // $this->getnombres(),
    // $this->getapellidos(),
    // $this->gettelefono(),
    // $this->getemail(),
    // $this->getrol(),
    // $this->getestado()
    // )
    // );
    //$this->Disconnect();
    // return $this;
    //}
    /**
     * @param $id
     * @return mixed
     */
    // public function deleted($id)
    // {
    //  $result = $this->updateRow("UPDATE persona.persona SET estado = ? WHERE id = ?", array(
    // 'Inactivo',
    // $this->getestado()
    //)
    // );
    // $this->Disconnect();
    // return $this;
    // }

    /**
     * @param $query
     * @return mixed
     */
    public static function search($query)
    {
        // TODO: Implement search() method.
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        // TODO: Implement getAll() method.
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function searchForId($id)
    {
        // TODO: Implement searchForId() method.
    }

    //Metodo
    public function saludar(?string $nombre = "venta"): string
    { //Visibilidad, function, nombre metodo(parametros), retorno
        return "Hola detalle de venta" . $this->id_detalle_venta .", Tengo la siguiente cantidad " . $this->cantidad . " y el id de venta es " . $this->venta_id ."<br/>";
    }


    public function __toString(): string
    {
        return "<strong>id_detalle_venta:</strong> " . $this->getid_detalle_venta() . "<br/>" .
            "<strong>cantidad:</strong> " . $this->getcantidad() . "<br/>" .
            "<strong>producto_id:</strong> " . $this->getproducto_id() . "<br/>" .
            "<strong>venta_id:</strong> " . $this->getventa_id() . "<br/>" ;
    }

    protected function update()
    {
        // TODO: Implement update() method.
    }

    protected function deleted($id)
    {
        // TODO: Implement deleted() method.
    }
}


/*$persona = new persona(
    123456,
    "Sandra",
    "Cardenas",
    123567,
    "sjuribe48@misena.edu.co");
var_dump($persona->create());*/
$detalle_venta = new detalleVenta (345, 4,3, 56 );

/*$persona = new persona();
$persona->create();
var_dump($persona->create());*/


echo $detalle_venta;
echo $detalle_venta->saludar();