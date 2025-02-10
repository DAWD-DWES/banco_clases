<?php

class CuentaNoEncontradaException extends Exception {
    private string $idCuenta;
    
    public function __construct(string $idCuenta) {
        $this->idCuenta = $idCuenta;

        $message = "La cuenta $idCuenta no existe.";
        parent::__construct($message);
    }

    public function getIdCuenta(): string {
        return $this->idCuenta;
    }
}

