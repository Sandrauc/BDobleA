<?php
namespace App\Models;

use App\Models\Interfaces\Model;
use Carbon\Carbon;
use Exception;
use JsonSerializable;

final class Ciudad extends AbstractDBConnection implements Model, JsonSerializable
{
    private int $id;
    private string $departamento;
    private string $nombre_ciudad;
    private int  $cod_dane;
    private string $estado;
    private Carbon $created_at;
    private Carbon $updated_at;
    private Carbon $deleted_at;



    /**
     * Municipios constructor. Recibe un array asociativo
     * @param array $Ciudad
     * @throws Exception
     */
    public function __construct(array $Ciudad = [])
    {
        parent::__construct();
        $this->setId($Ciudad['id'] ?? NULL);
        $this->setDepartamento($Ciudad['departamento_id'] ?? '');
        $this->setNombreCiudad($Ciudad['nombre_ciudad'] ?? '');
        $this->setCodDane($Ciudad['cod_dane'] ?? '');
        $this->setEstado($Ciudad['estado'] ?? '');
        $this->setCreatedAt(!empty($Ciudad['created_at']) ? Carbon::parse($Ciudad['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($Ciudad['updated_at']) ? Carbon::parse($Ciudad['updated_at']) : new Carbon());
        $this->setDeletedAt(!empty($Ciudad['deleted_at']) ? Carbon::parse($Ciudad['deleted_at']) : new Carbon());
    }

    public function __destruct()
    {
        if($this->isConnected){
            $this->Disconnect();
        }
    }

    /**
     * @return int $id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id

     */
    public function setId(int $id): void
    {
        $this->id = $id;

    }

    /**
     * @return string
     */
    public function getDepartamento(): string
    {
        return $this->departamento;
    }

    /**
     * @param string $departamento

     */
    public function setDepartamento(string $departamento): void
    {
        $this->departamento = $departamento;

    }

    /**
     * @return string
     */
    public function getNombreCiudad(): string
    {
        return $this->nombre_ciudad;
    }

    /**
     * @param string $nombre_ciudad
     */
    public function setNombreCiudad(int $nombre_ciudad): void
    {
        $this->nombre_ciudad = $nombre_ciudad;
    }

    /**
     * @return int
     */
    public function getCodDane(): string
    {
        return $this->cod_dane;
    }

    /**
     * @param int $cod_dane
     */
    public function setCodDane(int $cod_dane): void
    {
        $this->cod_dane = $cod_dane;
    }

    /**
     * @return string
     */
    public function getEstado(): string
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     */
    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
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
     * @return Carbon
     */
    public function getDeletedAt(): Carbon
    {
        return $this->deleted_at->locale('es');
    }

    /**
     * @param Carbon $deleted_at
     */
    public function setDeletedAt(Carbon $deleted_at): void
    {
        $this->deleted_at = $deleted_at;
    }



    static function search($query): ?array
    {
        try {
            $arrCiudad= array();
            $tmp = new Ciudad();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Ciudad = new Ciudad($valor);
                array_push($arrCiudad, $Ciudad);
                unset($Ciudad);
            }
            return $arrCiudad;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    static function getAll(): array
    {
        return Ciudad::search("SELECT * FROM dbdoblea.ciudad");
    }

    static function searchForId(int $id): ?object
    {
        try {
            if ($id > 0) {
                $tmpMun = new Ciudad();
                $tmpMun->Connect();
                $getrow = $tmpMun->getRow("SELECT * FROM dbdoblea. WHERE id =?", array($id));
                $tmpMun->Disconnect();
                return ($getrow) ? new Ciudad($getrow) : null;
            }else{
                throw new Exception('Id de municipio Invalido');
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    public function __toString() : string
    {
        return "Nombre: $this->nombre_ciudad, Estado: $this->estado";
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'departamento' => $this->getDepartamento(),
            'nombre_ciudad' => $this->getNombreCiudad(),
            'cod_dane' => $this->getCodDane(),
            'estado' => $this->getEstado(),
            'created_at' => $this->getCreatedAt()->toDateTimeString(),
            'updated_at' => $this->getUpdatedAt()->toDateTimeString(),
            'deleted_at' => $this->getDeletedAt()->toDateTimeString(),
        ];
    }

    protected function save(string $query): ?bool { return null; }
    function insert(){ }
    function update() { }
    function deleted() { }
}