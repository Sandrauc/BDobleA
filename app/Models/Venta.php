<?php

class Venta
{
    public int $id_venta;
    public string $fecha;
    public float $valor_total;
    public string $metodo_pago;
    public string $estado;
    public string $persona_id;

    public function __construct($id_venta = 123, $fecha = '20-11-04', $valor_total = '30000', $metodo_pago ='Efectivo', $estado = 'Activo',$persona_id =23456)
    {
        /* try {
             parent::__construct();
         } catch (Exception $e) {
         }*/
        $this->setid_venta($id_venta);
        $this->setfecha($fecha);
        $this->setvalor_total($valor_total);
        $this->setmetodo_pago($metodo_pago);
        $this->setestado($estado);
        $this->setpersona_id($persona_id);

        return $this;
    }

    /**
     * @return int|mixed
     */
    public function getid_venta(): int
    {
        return $this->id_venta;
    }

    /**
     * @param int|mixed $id_venta
     */
    public function setid_venta(int $id_venta): void
    {
        $this->id_venta = $id_venta;
    }


    /**
     * @return string|mixed
     */

    public function getfecha(): string
    {
        return $this->fecha;
    }

    /**
     * @param string|mixed $fecha
     */

    public function setfecha(string $fecha): void
    {
        $this->fecha = $fecha;
    }


    /**
     * @return string|mixed
     */
    public function getvalor_total(): float
    {
        return $this->valor_total;
    }

    /**
     * @param string|mixed $valor_total
     */
    public function setvalor_total(float $valor_total): void
    {
        $this->valor_total = $valor_total;
    }

    /**
     * @return string|mixed
     */
    public function getmetodo_pago(): string
    {
        return $this->metodo_pago;
    }

    /**
     * @param int|mixed $metodo_pago
     */
    public function setmetodo_pago(string $metodo_pago): void
    {
        $this->metodo_pago= $metodo_pago;
    }


    /**
     * @return string|mixed
     */
    public function getestado(): string
    {
        return $this->estado;
    }

    /**
     * @param string|mixed $estado
     */
    public function setestado(string $estado): void
    {
        $this->estado = $estado;
    }
    /**
     * @return string|mixed
     */
    public function getpersona_id(): int
    {
        return $this->persona_id;
    }

    /**
     * @param string|mixed $persona_id
     */
    public function setpersona_id(int $persona_id): void
    {
        $this->persona_id = $persona_id;
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
        return "Hola numero de venta " . $this->id_venta .", Soy de la fecha  " . $this->fecha . " y el estado es " . $this->estado ."<br/>";
    }


    public function __toString(): string
    {
        return "<strong>id_venta:</strong> " . $this->getid_venta() . "<br/>" .
            "<strong>fecha:</strong> " . $this->getfecha() . "<br/>" .
            "<strong>valor_total:</strong> " . $this->getvalor_total() . "<br/>" .
            "<strong>metodo_pago:</strong> " . $this->getmetodo_pago() . "<br/>" .
            "<strong>estado:</strong> " . $this->getestado() . "<br/>" ;
            "<strong>persona_id:</strong> " . $this->getpersona_id() . "<br/>" ;
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


$Venta = new Venta (10029929, "20/11/04",'30000',"Efectivo",'Activo', 56 );

/*$persona = new persona();
$persona->create();
var_dump($persona->create());*/


echo $Venta;
echo $Venta->saludar();