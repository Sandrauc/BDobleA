<?php


require_once ('BasicModel.php');


class Ciudad
{
    public int $id_ciudad;
    public string $departamento;
    public string $nombre;
    public int  $cod_dane;
    public string $estado;

    public function __construct($id_ciudad = 1233553, $departamento = 'Cundinamarca', $nombre = 'Bogota', $cod_dane = 3145752382, $estado = 'Activo')
    {
        /* try {
             parent::__construct();
         } catch (Exception $e) {
         }*/
        $this->setid_ciudad($id_ciudad);
        $this->setdepartamento($departamento);
        $this->setnombre($nombre);
        $this->setcod_dane($cod_dane);
        $this->setestado($estado);

        return $this;
    }

    /**
     * @return int|mixed
     */
    public function getid_ciudad(): int
    {
        return $this->id_ciudad;
    }

    /**
     * @param int|mixed $id_ciudad
     */
    public function setid_ciudad(int $id_ciudad): void
    {
        $this->id_ciudad = $id_ciudad;
    }


    /**
     * @return string|mixed
     */

    public function getdepartamento(): string
    {
        return $this->departamento;
    }

    /**
     * @param string|mixed $departamento
     */

    public function setdepartamento(string $departamento): void
    {
        $this->departamento = $departamento;
    }


    /**
     * @return string|mixed
     */
    public function getnombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param string|mixed $nombre
     */
    public function setnombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string|mixed
     */
    public function getcod_dane(): int
    {
        return $this->cod_dane;
    }

    /**
     * @param int|mixed $code_dane
     */
    public function setcod_dane(int $cod_dane): void
    {
        $this->cod_dane= $cod_dane;
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
    public function saludar(?string $nombre = "Persona"): string
    { //Visibilidad, function, nombre metodo(parametros), retorno
        return "Hola " . $this->departamento . ", Soy " . $this->nombre . " de estado " . $this->estado . "  <br/>";
    }


    public function __toString(): string
    {
        return "<strong>id_ciudad:</strong> " . $this->getid_ciudad() . "<br/>" .
            "<strong>departamento:</strong> " . $this->getdepartamento() . "<br/>" .
            "<strong>nombre:</strong> " . $this->getnombre() . "<br/>" .
            "<strong>cod_dane:</strong> " . $this->getcod_dane() . "<br/>" .
            "<strong>estado:</strong> " . $this->getestado() . "<br/>" ;

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


$Ciudad = new Ciudad (10029929, "Cundinamarca",'Bogota',5432222,'Activo');

/*$persona = new persona();
$persona->create();
var_dump($persona->create());*/


echo $Ciudad;
echo $Ciudad->saludar();
