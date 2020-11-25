<?php

namespace App\Models;

require_once (__DIR__ .'/../../vendor/autoload.php');
require_once ('Ciudad.php');
require_once('BasicModel.php');


class Ciudad extends BasicModel
{
    private int $id;
    private string $departamento;
    private string $nombre_ciudad;
    private int $cod_dane;
    private string $estado;

    /**
     * Ventas constructor.
     * @param int $id
     * @param string $departamento
     * @param string $nombre_ciudad
     * @param int $codigo_dane
     * @param string $estado
     */
    public function __construct($venta = array())
    {
        parent::__construct();
        $this->id = $Ciudad['id'] ?? 0;
        $this->departamento = $Ciudad['departamento'] ?? '';
        $this->nombre_ciudad = $Ciudad['nommbre_ciudad'] ?? '';
        $this->cod_dane = $Ciudad['cod_dane'] ?? '';
        $this->estado = $Ciudad['estado'] ?? '';
    }

    /**
     *
     */
    function __destruct()
    {
        $this->Disconnect();
    }

    /**
     * @return int|mixed
     * @return int|mixed
     */
    public function getId(): int
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
    public function getDepartamento(): string
    {
        return $this->departamento;
    }

    /**
     * @param mixed|string $departamento
     */
    public function setDepartamento(string $departamento): void
    {
        $this->departamento = $departamento;
    }

    /**
     * @return mixed|string $nombre_ciudad
     */
    public function getNombreCiudad(): Usuarios
    {
        return $this->nombre_ciudad;
    }

    /**
     * @param mixed|string $nombre_ciudad
     */
    public function setNombreCiudad(Ciudad $nombre_ciudad): void
    {
        $this->nombre_ciudad = $nombre_ciudad;
    }
    /**
     * @return mixed|int $cod_dane
     */
    public function getCodDane(): int
    {
        return $this->cod_dane;
    }

    /**
     * @param mixed|int $cod_dane
     */
    public function setCodDane(Ciudad $cod_dane): void
    {
        $this->cod_dane = $cod_dane;
    }

    /**
     * @return mixed|string $estado
     */
    public function getEstado(): string
    {
        return $this->estado;
    }

    /**
     * @param mixed|string $estado
     */
    public function setEstado(float $estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @return mixed
     */
    public function create(): bool
    {
        $result = $this->insertRow("INSERT INTO dbdoblea.ciudad VALUES (NULL, ?, ?, ?, ?)", array(
                $this->departamento,
                $this->nombre_ciudad->getNombreCiudad(),
                $this->cod_dane->getCodDane(),
                $this->estado
            )
        );
        $this->setId(($result) ? $this->getLastId() : null);
        $this->Disconnect();
        return $result;
    }

    /**
     * @return mixed
     */
    public function update(): bool
    {
        $result = $this->updateRow("UPDATE dbdoblea.ciudad SET departamento = ?, nombre_ciudad= ?, cod_dane= ?, estado = ? WHERE id = ?", array(
                $this->departamento,
                $this->nombre_ciudad,
                $this->cod_dane,
                $this->estado,
                $this->id
            )
        );
        $this->Disconnect();
        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleted($id): bool
    {
        $Venta = Ciudad::searchForId($id); //Buscando un usuario por el ID
        $Venta->setEstado("Inactivo"); //Cambia el estado del Usuario
        return $Venta->update();                    //Guarda los cambios..
    }

    /**
     * @param $query
     * @return mixed
     */
    public static function search($query): array
    {
        $arrVentas = array();
        $tmp = new Ciudad();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Ciudad = new Ciudad();
            $Ciudad->id = $valor['id'];
            $Ciudad->departamento = $valor['departamento'];
            $Ciudad->nombre_ciudad = $valor['nombre_ciudad'];
            $Ciudad->cod_dane = $valor['cod_dane'];
            $Ciudad->estado = $valor['estado'];
            $Ciudad->Disconnect();
            array_push($arrCiudad, $Ciudad);
        }

        $tmp->Disconnect();
        return $arrCiudad;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function searchForId($id): Ciudad
    {
        $Ciudad = null;
        if ($id > 0) {
            $Ciudad = new Ciudad();
            $getrow = $Ciudad->getRow("SELECT * FROM dbdoblea.ciudad WHERE id =?", array($id));
            $Ciudad->id = $getrow['id'];
            $Ciudad->departamento = $getrow['departamento'];
            $Ciudad->nombre_ciudad = $getrow['nombre_ciudad'];
            $Ciudad->cod_dane = $getrow['cod_dane'];
            $Ciudad->estado = $getrow['estado'];
        }
        $Ciudad->Disconnect();
        return $Ciudad;
    }

    /**
     * @return mixed
     */
    public static function getAll(): array
    {
        return Ciudad::search("SELECT * FROM dbdoblea.ciudad");
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "Departamento: $this->departamento, NombreCiudad: $this->nombre_ciudad, CodDane: $this->cod_dane, Estado: $this->estado";
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
            'departamento' => $this->getDepartamento(),
            'nombre_ciudad' => $this->getNombreCiudad(),
            'cod_dane' => $this->getCodDane(),
            'estado' => $this->getEstado(),
        ];
    }
}