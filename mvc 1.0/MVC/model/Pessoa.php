<?php

class Pessoa
{

    public $id;
    public $nome;
    public $email;
    public $datanascimento;
    public $telefone;

    public function __construct()
    {
        $this->id = 0;
        $this->nome = "";
        $this->email = "";
        $this->datanascimento = "";
        $this->telefone = "";
    }

    public function validarCampos()
    {
        if (strlen($this->nome) < 3) {
            return false;
        }
        if (strlen($this->email) == 0) {
            return false;
        }
        if (strlen($this->datanascimento) == 0) {
            return false;
        }
        if (strlen($this->telefone) == 0) {
            return false;
        }
        return true;
    }

}
