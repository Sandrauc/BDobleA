<?php
namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Exception;
use JsonSerializable;

class Usuarios extends AbstractDBConnection implements Model, JsonSerializable
{
    /* Tipos de Datos => bool, int, float,  */
    private ?int $id;
    private string $nombres;
    private string $apellidos;
    private int $documento;
    private int $telefono;
    private string $email;
    private ?string $user;
    private ?string $password;
    private string $rol;
    private string $estado;
    private int $ciudad_id;
    private Carbon $created_at;
    private Carbon $updated_at;

    /* Relaciones */
    private ?Ciudad $ciudad;

    /**
     * Usuarios constructor. Recibe un array asociativo
     * @param array $usuario
     */
    public function __construct(array $usuario = [])
    {
        parent::__construct();
        $this->setId($usuario['id'] ?? NULL);
        $this->setNombres($usuario['nombres'] ?? '');
        $this->setApellidos($usuario['apellidos'] ?? '');
        $this->setDocumento($usuario['documento'] ?? 0);
        $this->setTelefono($usuario['telefono'] ?? 0);
        $this->setEmail($usuario['email'] ?? '');
        $this->setUser($usuario['user'] ?? null);
        $this->setPassword($usuario['password'] ?? null);
        $this->setRol($usuario['rol'] ?? '');
        $this->setEstado($usuario['estado'] ?? '');
        $this->setCiudadId($usuario['ciudad_id'] ?? 0);
        $this->setCreatedAt(!empty($usuario['created_at']) ? Carbon::parse($usuario['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($usuario['updated_at']) ? Carbon::parse($usuario['updated_at']) : new Carbon());
    }

    function __destruct()
    {
        if($this->isConnected){
            $this->Disconnect();
        }
    }

    /**
     * @return int|mixed
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed|string
     */
    public function getNombres() : string
    {
        return ucwords($this->nombres);
    }

    /**
     * @param mixed|string $nombres
     */
    public function setNombres(string $nombres): void
    {
        $this->nombres = trim(mb_strtolower($nombres, 'UTF-8'));
    }

    /**
     * @return mixed|string
     */
    public function getApellidos() : string
    {
        return ucwords($this->apellidos);
    }

    /**
     * @param mixed|string $apellidos
     */
    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = trim(mb_strtolower($apellidos, 'UTF-8'));
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
     * @return int
     */
    public function getCiudadId(): int
    {
        return $this->ciudad_id;
    }

    /**
     * @param int $ciudad_id
     */
    public function setCiudadId(int $ciudad_id): void
    {
        $this->ciudad_id = $ciudad_id;
    }


    /**
     * @return Carbon|mixed
     */
    public function getCreatedAt() : Carbon
    {
        return $this->created_at->locale('es');
    }

    /**
     * @param Carbon|mixed $created_at
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
     * @return Ciudad
     */
    public function getCiudad(): ?Ciudad
    {
        if(!empty($this->ciudad_id)){
            $this->ciudad = Ciudad::searchForId($this->ciudad_id) ?? new Ciudad();
            return $this->ciudad;
        }
        return NULL;
    }



    protected function save(string $query): ?bool
    {
        $arrData = [
            ':id' =>    $this->getId(),
            ':nombres' =>   $this->getNombres(),
            ':apellidos' =>   $this->getApellidos(),
            ':documento' =>   $this->getDocumento(),
            ':telefono' =>   $this->getTelefono(),
            ':email' =>   $this->getEmail(),
            ':user' =>  $this->getUser(),
            ':password' =>   $this->getPassword(),
            ':rol' =>   $this->getRol(),
            ':estado' =>   $this->getEstado(),
            ':ciudad_id' =>   $this->getCiudadId(),
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
    public function insert(): ?bool
    {
        $query = "INSERT INTO dbdoblea.usuarios VALUES (
            :id,:nombres,:apellidos,:documento, :telefono,:email,:user,
            :password,:rol,:estado,ciudad_id,:created_at,:updated_at
        )";
        return $this->save($query);
    }

    /**
     * @return bool|null
     */
    public function update(): ?bool
    {
        $query = "UPDATE dbdoblea.usuarios SET 
            nombres = :nombres, apellidos = :apellidos,  
            documento = :documento, telefono = :telefono, email = :email, 
            user = :user,  password = :password, foto = :foto, rol = :rol, estado = :estado, ciudad_id = :ciudad_id, created_at = :created_at, 
            updated_at = :updated_at WHERE id = :id";
        return $this->save($query);
    }

    /**
     * @param $id
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
     * @return Usuarios|array
     * @throws Exception
     */
    public static function search($query) : ?array
    {
        try {
            $arrUsuarios = array();
            $tmp = new Usuarios();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Usuario = new Usuarios($valor);
                array_push($arrUsuarios, $Usuario);
                unset($Usuario);
            }
            return $arrUsuarios;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    /**
     * @param $id
     * @return Usuarios
     * @throws Exception
     */
    public static function searchForId(int $id): ?Usuarios
    {
        try {
            if ($id > 0) {
                $tmpUsuario = new Usuarios();
                $tmpUsuario->Connect();
                $getrow = $tmpUsuario->getRow("SELECT * FROM dbdoblea.usuarios WHERE id =?", array($id));
                $tmpUsuario->Disconnect();
                return ($getrow) ? new Usuarios($getrow) : null;
            }else{
                throw new Exception('Id de usuario Invalido');
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
    public static function getAll(): array
    {
        return Usuarios::search("SELECT * FROM dbdoblea.usuarios");
    }

    /**
     * @param $documento
     * @return bool
     * @throws Exception
     */
    public static function usuarioRegistrado($documento): bool
    {
        $result = Usuarios::search("SELECT * FROM dbdoblea.usuarios where documento = " . $documento);
        if ( !empty($result) && count ($result) > 0 ) {
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
        return "Nombres: $this->nombres, Apellidos: $this->nombres, Documento: $this->documento, Telefono: $this->telefono, Email: $this->email,()";
    }

    public function Login($User, $Password){
        try {
            $resultUsuarios = Usuarios::search("SELECT * FROM usuarios WHERE user = '$User'");
            if(count($resultUsuarios) >= 1){
                if($resultUsuarios[0]->password == $Password){
                    if($resultUsuarios[0]->estado == 'Activo'){
                        return $resultUsuarios[0];
                    }else{
                        return "Usuario Inactivo";
                    }
                }else{
                    return "Contraseña Incorrecta";
                }
            }else{
                return "Usuario Incorrecto";
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
            return "Error en Servidor";
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'nombres' => $this->getNombres(),
            'apellidos' => $this->getApellidos(),
            'documento' => $this->getDocumento(),
            'telefono' => $this->getTelefono(),
            'email' => $this->getEmail(),
            'user' => $this->getUser(),
            'password' => $this->getPassword(),
            'rol' => $this->getRol(),
            'estado' => $this->getEstado(),
            'ciudad_id' => $this->getCiudadId(),
            'created_at' => $this->getCreatedAt()->toDateTimeString(),
            'updated_at' => $this->getUpdatedAt()->toDateTimeString(),
        ];
    }
}