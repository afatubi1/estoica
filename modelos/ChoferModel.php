<?php
class ChoferModel {
    public $tipo_persona;
    public $nombre;
    public $tipo_documento;
    public $direccion;
    public $telefono;
    public $email;
    public $ine;
    public $licencia;
    public $imgChofer;
    public $tia;
    public $telefonoReferencia;
    public $Curp;
    public $antecedentesPenales;
    public $aptitudPsicofisica;
    public $comprobanteDomicilio;

    public function __construct($tipo_persona, $nombre, $tipo_documento, $direccion, $telefono, $email, $ine, $licencia, $imgChofer, $tia, $telefonoReferencia, $Curp, $antecedentesPenales, $aptitudPsicofisica, $comprobanteDomicilio) {
        $this->tipo_persona = $tipo_persona;
        $this->nombre = $nombre;
        $this->tipo_documento = $tipo_documento;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->ine = $ine;
        $this->licencia = $licencia;
        $this->imgChofer = $imgChofer;
        $this->tia = $tia;
        $this->telefonoReferencia = $telefonoReferencia;
        $this->Curp = $Curp;
        $this->antecedentesPenales = $antecedentesPenales;
        $this->aptitudPsicofisica = $aptitudPsicofisica;
        $this->comprobanteDomicilio = $comprobanteDomicilio;
    }
}
?>