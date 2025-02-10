<?php

class SaldoInsuficienteException extends Exception {

    private string $idCuenta;
    private float $cantidad;

    public function __construct(string $idCuenta, float $cantidad) {
        $this->idCuenta = $idCuenta;

        $message = "No hay suficiente saldo en la cuenta $idCuenta para extraer $cantidad €";
        parent::__construct($message);
    }
    
    public function getIdCuenta(): string {
        return $this->idCuenta;
    }
    public function getCantidad(): float {
        return $this->cantidad;
    }
}
