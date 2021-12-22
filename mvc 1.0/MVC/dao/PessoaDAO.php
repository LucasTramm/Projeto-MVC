<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('Conexao.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '\mvc 1.0\MVC\dao\PessoaDAO.php');

class PessoaDAO
{

    private $sql;
    private $tabela = 'pessoas';
    private $campos = ['nome', 'email', 'datanascimento', 'telefone'];
    public $colunas;
    public $values;
    public $parameters = [];
    public $colunas_update;

    public function __construct()
    {

        foreach ($this->campos as $campo) {
            $this->colunas .=  "$campo, ";
            $this->values .= ":$campo, ";
            $this->colunas_update .= "$campo = :$campo, ";
        }

        $this->colunas = substr($this->colunas, 0, -2);
        $this->values = substr($this->values, 0, -2);
        $this->colunas_update = substr($this->colunas_update, 0, -2);
    }

    public function insert(Pessoa $obj)
    {

        foreach ($this->campos as $campo) {
            $this->parameters[$campo] = $obj->$campo;
        }

        try {
            $this->sql = 'INSERT INTO ' . $this->tabela . ' (' . $this->colunas . ') VALUES (' . $this->values . ')';
            $operacao = Conexao::getInstance()->prepare($this->sql);
            $operacao->execute($this->parameters);
            return Conexao::getInstance()->lastInsertId();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function update(Pessoa $obj)
    {

        foreach ($this->campos as $campo) {
            $this->parameters[':' . $campo] = $obj->$campo;
        }

        $this->parameters[':id'] = $obj->id;
        
        try {
            $this->sql = 'UPDATE ' . $this->tabela . ' SET ' . $this->colunas_update . ' WHERE id = :id ';
            $operacao = Conexao::getInstance()->prepare($this->sql);
            $operacao->execute($this->parameters);
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function delete($id)
    {

        try {
            $this->sql = 'DELETE FROM ' . $this->tabela . ' WHERE id = :id';
            $operacao = Conexao::getInstance()->prepare($this->sql);
            $operacao->execute([':id' => $id]);
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function getById($id)
    {

        try {
            $this->sql = 'SELECT * FROM ' . $this->tabela . ' WHERE id = :id';
            $operacao = Conexao::getInstance()->prepare($this->sql);
            $operacao->execute([':id' => $id]);

            if ($row = $operacao->fetch(PDO::FETCH_ASSOC)) {
                $obj = new Pessoa();
                $obj->id = $id;
                foreach ($this->campos as $campo) {
                    $obj->$campo = $row[$campo];
                }
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $obj;
    }

    public function getLista($inicio = 0, $qnt = 9999)
    {

        try {
            $this->sql = 'SELECT * FROM ' . $this->tabela . " ORDER BY id DESC LIMIT $inicio, $qnt";   
            $rs = Conexao::getInstance()->prepare($this->sql);
            $rs->execute();
            return $rs;
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

}
