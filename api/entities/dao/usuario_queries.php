<?php
require_once('../../helpers/database.php');

class UsuarioQueries
{

    public function checkUser($alias)
    {
        $sql = 'SELECT id_usuario FROM usuario WHERE correo_usuario = ?';
        $params = array($alias);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_usuario'];
            $this->correo = $alias;
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT clave_usuario FROM usuario WHERE id_usuario = ?';
        $params = array($this->id);
        $data= Database::getRow($sql,$params);
    if ($password==$data['clave_usuario']) {
    return true;
        }else{
     return false;
     }
    }

    public function readAll()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, estado_usuario, tipo_usuario
        FROM usuario
        INNER JOIN estado_usuario USING(id_estado_usuario)
        INNER JOIN tipo_usuario USING(id_tipo_usuario)';
        return Database::getRows($sql);
    }

    
    public function deleteRow()
    {
        $sql = 'DELETE FROM usuario
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
    
    public function readOne()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, clave_usuario, tipo_usuario, estado_usuario, id_estado_usuario, id_tipo_usuario
        FROM usuario
        INNER JOIN tipo_usuario USING(id_tipo_usuario)
        INNER JOIN estado_usuario USING(id_estado_usuario)
        WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO usuario(nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, clave_usuario, id_tipo_usuario, id_estado_usuario)
            VALUES (?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->alias, $this->clave, $this->tipousuario, $this->estadousuario);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE usuario
                SET nombre_usuario=?, apellido_usuario=?, correo_usuario=?, alias_usuario=?, clave_usuario=?, id_tipo_usuario=?, id_estado_usuario=?
                WHERE id_usuario=?';
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->alias, $this->clave, $this->tipousuario, $this->estadousuario, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function searchRows($value)
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, tipo_usuario, estado_usuario
        FROM usuario
        INNER JOIN tipo_usuario USING(id_tipo_usuario)
        INNER JOIN estado_usuario USING(id_estado_usuario)
        WHERE nombre_usuario ILIKE ? OR apellido_usuario ILIKE ? OR alias_usuario ILIKE ? OR correo_usuario ILIKE ?
        ORDER BY apellido_usuario';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }
}