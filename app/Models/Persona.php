<?php


namespace App\Models;


class Persona
{
    public int $documento;
    public string $nombres;
    public string $apellidos;
    public int  $telefono;
    public string $email;
    public string $rol;
    public string $estado;
    public int $ciudad_id;


    public function __construct($documento = 1233553, $nombres = 'Maria Lucia', $apellidos = 'Fuentes Perez', $telefono= 3145752382, $email = 'Jp02@gmail', $rol = 'Administrador', $estado = "Inactivo" , $ciudad_id = 1233)
    {
        /* try {
             parent::__construct();
         } catch (Exception $e) {
         }*/
        $this->setdocumento($documento);
        $this->setnombres($nombres);
        $this->setapellidos($apellidos);
        $this->settelefono($telefono);
        $this->setemail($email);
        $this->setrol($rol);
        $this->setestado($estado);
        $this->setciudad_id($ciudad_id);
        return $this;
    }

    /**
     * @return int|mixed
     */
    public function getdocumento(): int
    {
        return $this->documento;
    }

    /**
     * @param int|mixed $documento
     */
    public function setdocumento(int $documento): void
    {
        $this->documento = $documento;
    }


    /**
     * @return string|mixed
     */

    public function getnombres(): string
    {
        return $this->nombres;
    }

    /**
     * @param string|mixed $nombres
     */

    public function setnombres(string $nombres): void
    {
        $this->nombres = $nombres;
    }


    /**
     * @return string|mixed
     */
    public function getapellidos(): string
    {
        return $this->apellidos;
    }

    /**
     * @param string|mixed $apellidos
     */
    public function setapellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return string|mixed
     */
    public function gettelefono(): int
    {
        return $this->telefono;
    }

    /**
     * @param int|mixed $telefono
     */
    public function settelefono(int $telefono): void
    {
        $this->telefono = $telefono;
    }


    /**
     * @return string|mixed
     */
    public function getemail(): string
    {
        return $this->email;
    }

    /**
     * @param string|mixed $email
     */
    public function setemail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|mixed
     */
    public function getrol(): string
    {
        return $this->rol;
    }

    /**
     * @param string|mixed $rol
     */
    public function setrol(string $rol): void
    {
        $this->rol = $rol;
    }

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

    public function getciudad_id(): string
    {
        return $this->ciudad_id;
    }

    /**
     * @param string|mixed $ciudad_id
     */
    public function setciudad_id(int $ciudad_id): void
    {
        $this->ciudad_id = $ciudad_id;
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
        return "Hola " . $this->nombres .  " de apellido " . $this->apellidos . " de estado Inactivo<br/>";
    }


    public function __toString(): string
    {
        return "<strong>documento:</strong> " . $this->getdocumento() . "<br/>" .
            "<strong>nombres:</strong> " . $this->getnombres() . "<br/>" .
            "<strong>apellidos:</strong> " . $this->getapellidos() . "<br/>" .
            "<strong>telefono:</strong> " . $this->gettelefono() . "<br/>" .
            "<strong>email:</strong> " . $this->getemail() . "<br/>" .
            "<strong>rol:</strong> " . $this->getrol() . "<br/>";
        "<strong>estado:</strong> " . $this->getestado() . "<br/>";
        "<strong>ciudad_id:</strong> " . $this->getciudad_id() . "<br/>";
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


$Persona = new Persona (10029929, "Maria Lucia",'Fuentes Perez',5432222,'gsgsjssk@gamil.com','Administrador', 'Inactivo');

/*$persona = new persona();
$persona->create();
var_dump($persona->create());*/


echo $Persona;
echo $Persona->saludar();

