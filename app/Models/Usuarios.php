<?php

namespace App\Models;

require_once (__DIR__ .'/../../vendor/autoload.php');
require_once('BasicModel.php');

use Carbon\Carbon;
use JsonSerializable;

class Usuarios extends BasicModel implements JsonSerializable
{
    /* Tipos de Datos => bool, int, float,  */
    private int $id;
    private string $nombres;
    private string $apellidos;
    private int $documento;
    private int $telefono;
    private string $email;
    private ?string $user;
    private ?string $password;
    private string $rol;
    private string $estado;


    /* Relaciones */
    private $CiudadUsuarios;


    /**
     * usuarios constructor.
     * @param int $id
     * @param string $nombres
     * @param string $apellidos
     * @param int $documento
     * @param int $telefono
     * @param string $email
     * @param string $user
     * @param string $password
     * @param string $rol
     * @param string $estado


     */
    public function __construct($usuario = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->id = $usuario['id'] ?? 0;
        $this->nombres = $usuario['nombres'] ?? '';
        $this->apellidos = $usuario['apellidos'] ?? '';
        $this->documento = $usuario['documento'] ?? 0;
        $this->telefono = $usuario['telefono'] ?? 0;
        $this->email = $usuario['email'] ?? '';
        $this->user = $usuario['user'] ?? null;
        $this->password = $usuario['password'] ?? null;
        $this->rol = $usuario['rol'] ?? '';
        $this->estado = $usuario['estado'] ?? '';

    }

    /* Metodo destructor cierra la conexion. */
    /**
     *
     */
    function __destruct()
    {
        $this->Disconnect();
    }

    /**
     * @return int|mixed
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int|mixed $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed|string
     */
    public function getNombres() : string
    {
        return $this->nombres;
    }

    /**
     * @param mixed|string $nombres
     */
    public function setNombres(string $nombres): void
    {
        $this->nombres = $nombres;
    }

    /**
     * @return mixed|string
     */
    public function getApellidos() : string
    {
        return $this->apellidos;
    }

    /**
     * @param mixed|string $apellidos
     */
    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }


    /**
     * @return int|mixed
     */
    public function getDocumento() : int
    {
        return $this->documento;
    }

    /**
     * @param int|mixed $documento
     */
    public function setDocumento(int $documento): void
    {
        $this->documento = $documento;
    }

    /**
     * @return int|mixed
     */
    public function getTelefono() : int
    {
        return $this->telefono;
    }

    /**
     * @param int|mixed $telefono
     */
    public function setTelefono(int $telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed|string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @param mixed|string $direccion
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }



    /**
     * @return mixed|string
     */
    public function getUser() : ?string
    {
        return $this->user;
    }

    /**
     * @param mixed|string $user
     */
    public function setUser(?string $user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed|string
     */
    public function getPassword() : ?string
    {
        return $this->password;
    }

    /**
     * @param mixed|string $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed|string
     */
    public function getRol() : string
    {
        return $this->rol;
    }

    /**
     * @param mixed|string $rol
     */
    public function setRol(string $rol): void
    {
        $this->rol = $rol;
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
     * @return bool
     * @throws \Exception
     */
    public function create(): bool
    {
        $result = $this->insertRow("INSERT INTO dbdoblea.usuarios VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
                $this->nombres,
                $this->apellidos,
                $this->documento,
                $this->telefono,
                $this->email,
                $this->user,
                $this->password,
                $this->rol,
                $this->estado,
            )
        );
        $this->Disconnect();
        return $result;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        $result = $this->updateRow("UPDATE dbdoblea.usuarios SET nombres = ?, apellidos = ?, documento = ?, telefono = ?, email = ?,  user = ?, password = ?, rol = ?, estado = ? WHERE id = ?", array(
                $this->nombres,
                $this->apellidos,
                $this->documento,
                $this->telefono,
                $this->email,
                $this->user,
                $this->password,
                $this->rol,
                $this->estado,
                $this->id,
            )
        );
        $this->Disconnect();
        return $result;
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleted($id): bool
    {
        $User = Usuarios::searchForId($id); //Buscando un usuario por el ID
        $User->setEstado("Inactivo"); //Cambia el estado del usuarios
        return $User->update();                    //Guarda los cambios..
    }

    /**
     * @param $query
     * @return Usuarios|array
     * @throws \Exception
     */
    public static function search($query) : array
    {
        $arrUsuarios = array();
        $tmp = new Usuarios();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Usuario = new Usuarios();
            $Usuario->id = $valor['id'];
            $Usuario->nombres = $valor['nombres'];
            $Usuario->apellidos = $valor['apellidos'];
            $Usuario->documento = $valor['documento'];
            $Usuario->telefono = $valor['telefono'];
            $Usuario->email = $valor['email'];
            $Usuario->user = $valor['user'];
            $Usuario->password = $valor['password'];
            $Usuario->rol = $valor['rol'];
            $Usuario->estado = $valor['estado'];
            $Usuario->Disconnect();
            array_push($arrUsuarios, $Usuario);
        }
        $tmp->Disconnect();
        return $arrUsuarios;
    }

    /**
     * @param $id
     * @return Usuarios
     * @throws \Exception
     */
    public static function searchForId($id): Usuarios
    {
        $Usuario = null;
        if ($id > 0) {
            $Usuario = new Usuarios();
            $getrow = $Usuario->getRow("SELECT * FROM dbdoblea.usuarios WHERE id =?", array($id));
            $Usuario->id = $getrow['id'];
            $Usuario->nombres = $getrow['nombres'];
            $Usuario->apellidos = $getrow['apellidos'];
            $Usuario->documento = $getrow['documento'];
            $Usuario->telefono = $getrow['telefono'];
            $Usuario->email = $getrow['email'];
            $Usuario->user = $getrow['user'];
            $Usuario->password = $getrow['password'];
            $Usuario->rol = $getrow['rol'];
            $Usuario->estado = $getrow['estado'];
        }
        $Usuario->Disconnect();
        return $Usuario;
    }

    /**
     * @return array
     */
    public static function getAll(): array
    {
        return Usuarios::search("SELECT * FROM dbdoblea.usuarios");
    }

    /**
     * @param $documento
     * @return bool
     * @throws \Exception
     */
    public static function usuarioRegistrado($documento): bool
    {
        $result = Usuarios::search("SELECT * FROM dbdoblea.usuarios where documento = " . $documento);
        if ( count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function nombresCompletos() : string
    {
        return $this->nombres . " " . $this->apellidos;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return "Nombres: $this->nombres, Apellidos: $this->apellidos, Documento: $this->documento, Telefono: $this->telefono, email: $this->email()";
    }

    public function Login($User, $Password){
        $resultUsuarios = Usuarios::search("SELECT * FROM usuarios WHERE user = '$User'");
        if(count($resultUsuarios) >= 1){
            if($resultUsuarios[0]->password == $Password){
                if($resultUsuarios[0]->estado == 'Activo'){
                    return $resultUsuarios[0];
                }else{
                    return "usuarios Inactivo";
                }
            }else{
                return "Contraseña Incorrecta";
            }
        }else{
            return "usuarios Incorrecto";
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
            'id' => $this->getId(),
            'nombres' => $this->getNombres(),
            'apellidos' => $this->getApellidos(),
            'documento' => $this->getDocumento(),
            'telefono' => $this->getTelefono(),
            'direccion' => $this->getEmail(),
            'user' => $this->getUser(),
            'password' => $this->getPassword(),
            'rol' => $this->getRol(),
            'estado' => $this->getEstado(),

        ];
    }
}