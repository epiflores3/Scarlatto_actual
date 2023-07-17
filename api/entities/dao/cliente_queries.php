<?php
require_once('../../helpers/database.php');

class ClienteQuerie
{

    public function checkUser($correo)
    {
        $sql = 'SELECT id_cliente, estado_cliente FROM cliente WHERE correo_cliente = ?';
        $params = array($correo);

        $data = Database::getRow($sql, $params);
        if($data) {
            $this->id = $data['id_cliente'];
            $this->estado = $data['estado_cliente'];
            $this->correo = $correo;
            
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT clave_cliente FROM cliente WHERE id_cliente = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        if ($password==$data['clave_cliente']) {
            return true;
        } else {
            return false;
        }
    }

     /*
    *   Métodos para realizar las operaciones de buscar(search) de pedido
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, fecha_nac_cliente, direccion_cliente, clave_cliente, estado_cliente
        FROM cliente
        WHERE nombre_cliente ILIKE ? OR apellido_cliente ILIKE ? OR correo_cliente ILIKE ? OR telefono_cliente ILIKE ?';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, fecha_nac_cliente, direccion_cliente, clave_cliente, estado_cliente
        FROM cliente';
        return Database::getRows($sql);
    }

    public function readOne(){
        $sql='SELECT id_cliente, nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, fecha_nac_cliente, direccion_cliente, clave_cliente, estado_cliente
        FROM cliente
        WHERE id_cliente=?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO cliente(nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, fecha_nac_cliente, direccion_cliente, clave_cliente, estado_cliente)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->apellido, $this->dui, $this->correo, $this->telefono, $this->nacimiento, $this->direccion, $this->clave, $this->estado);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE cliente
                SET nombre_cliente = ?, apellido_cliente = ?, dui_cliente = ?, correo_cliente = ?, telefono_cliente = ?, fecha_nac_cliente = ?, direccion_cliente = ?, clave_cliente = ?, estado_cliente = ?
                WHERE id_cliente = ?';
        $params = array($this->nombre, $this->apellido, $this->dui, $this->correo, $this->telefono, $this->nacimiento, $this->direccion, $this->clave, $this->estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM cliente
                WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function createCuenta()
    {
        $sql = "INSERT INTO cliente(nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, fecha_nac_cliente, direccion_cliente, clave_cliente, estado_cliente)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'true')";
        $params = array($this->nombre, $this->apellido, $this->dui, $this->correo, $this->telefono, $this->nacimiento, $this->direccion, $this->clave);
        return Database::executeRow($sql, $params);
    }

}