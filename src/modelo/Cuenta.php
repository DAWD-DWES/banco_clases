<?php

require_once "Operacion.php";
require_once "../src/excepciones/SaldoInsuficienteException.php";

/**
 * Clase Cuenta 
 */
class Cuenta {

    /**
     * Id de la cuenta
     * @var string
     */
    private string $id;

    /**
     * Saldo de la cuenta
     * @var float
     */
    private float $saldo;

    /**
     * Id del cliente dueño de la cuenta
     * @var string
     */
    private string $idCliente;

    /**
     * Operaciones bancarias realizadas en la cuenta
     * @var array $operaciones
     */
    private array $operaciones;

    public function __construct(string $idCliente, float $cantidad = 0) {
        $this->setId(uniqid());
        $this->setSaldo(0);
        $this->setOperaciones();
        $this->ingreso($cantidad, "Ingreso inicial de $cantidad € en la cuenta");
        $this->setIdCliente($idCliente);
    }

    public function getId(): string {
        return $this->id;
    }

    public function getSaldo(): float {
        return $this->saldo;
    }

    public function getIdCliente(): string {
        return $this->idCliente;
    }

    public function getOperaciones(): array {
        return $this->operaciones;
    }

    public function setId(string $id) {
        $this->id = $id;
    }

    public function setSaldo(float $saldo) {
        $this->saldo = $saldo;
    }

    public function setIdCliente(string $idCliente) {
        $this->idCliente = $idCliente;
    }

    public function setOperaciones(array $operaciones = []) {
        $this->operaciones = $operaciones;
    }

    /**
     * Ingreso de una cantidad en una cuenta
     * @param type $cantidad Cantidad de dinero
     * @param type $descripcion Descripción del ingreso
     */
    public function ingreso(float $cantidad, string $descripcion) {
        if ($cantidad > 0) {
            $operacion = new Operacion(TipoOperacion::INGRESO, $cantidad, $descripcion);
            $this->agregaOperacion($operacion);
            $this->setSaldo($this->getSaldo() + $cantidad);
        }
    }

    /**
     * 
     * @param type $cantidad Cantidad de dinero a retirar
     * @param type $descripcion Descripcion del debito
     * @throws SaldoInsuficienteException
     */
    public function debito(float $cantidad, string $descripcion) {
        if ($cantidad <= $this->getSaldo()) {
            $operacion = new Operacion(TipoOperacion::DEBITO, $cantidad, $descripcion);
            $this->agregaOperacion($operacion);
            $this->setSaldo($this->getSaldo() - $cantidad);
        } else {
            throw new SaldoInsuficienteException($this->getId(), $cantidad);
        }
    }

    public function __toString() {
        $saldoFormatted = number_format($this->getSaldo(), 2); // Formatear el saldo con dos decimales
        $operacionesStr = implode("</br>", array_map(fn($operacion) => "{$operacion->__toString()}", $this->getOperaciones())); // Convertir las operaciones en una cadena separada por saltos de línea

        return "Cuenta ID: {$this->getId()}</br>" .
                // "Cliente ID: {$this->getIdCliente()}</br>" .
                "Saldo: $saldoFormatted</br>" .
                "$operacionesStr";
    }

    /**
     * Agrega operación a la lista de operaciones de la cuenta
     * @param type $operacion Operación a añadir
     */
    private function agregaOperacion(Operacion $operacion) {
        $this->operaciones[] = $operacion;
    }
}
