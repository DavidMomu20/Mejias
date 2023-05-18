<?php 
namespace App\Models;

use CodeIgniter\Model;

class M_base extends Model {
    
    /**
     * -- Variables de instancia --
     */

    protected $table = ""; // Tabla
    protected $primaryKey = ""; // Clave primaria
    protected $DBGroup = 'default'; // Base de datos
    
    // --------- MÉTODOS ---------

    /**
     * Método para obtener registros específicos
     * 
     * @param array $where -> Array ASOCIATIVO con aquellas columnas o datos que se quieren escoger:
     *      $where = [
     *          'campo1' => 'valor1',
     *          'campo2 >=' => 'valor2, 
     *          ...
     *      ];
     * 
     * @param array $campos -> Array con las columnas que se quiere obtener:
     *      $campos = [
     *          'campo1', 
     *          'campo2 as miCampo', 
     *          ...
     *      ];
     */

     public function obtenerRegistros(array $where = [], array $campos = ['*'])
     {
        try {
            $query = $this->select($campos)
                        ->where($where);
     
            return $query->findAll(); 
        } catch (\Exception $e) {
            log_message('error', 'Error al obtener los registros: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Método para obtener todos los datos del modelo
     */

    public function obtenerAllRegistros()
    {
        return $this->findAll();
    }

    /**
     * Método para obtener un dato de una tabla a partir del valor de su clave primaria.
     */

    public function obtenerRegistroByPrimaryKey(int $id)
    {
        return $this->where($this->primaryKey, $id)->first();
    }

    /**
     * Método para insertar un nuevo registro para la tabla
     */

    public function insertarRegistro(array $datos)
    {
        try {
            $this->insert($datos);
            $insertId = $this->getInsertID();

            return $insertId; // Devolver el ID del nuevo registro insertado

        } catch (\Exception $e) {

            log_message('error', 'Error al crear el registro: ' . $e->getMessage());
            return false; // Devolver false en caso de error
        }
    }

    /**
     * Método para actualizar un registro de la tabla
     */

    public function updateRegistro(int $id, array $datos)
    {
        try {
            // Verificar que el ID sea válido
            if (!is_numeric($id) || $id <= 0) {
                return false;
            }

            // Verificar que los datos sean un array y no estén vacíos
            if (!is_array($datos) || empty($datos)) {
                return false;
            }

            return $this->update($id, $datos);

        } catch (\Exception $e) {
            log_message('error', 'Error al actualizar el registro: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Método para eliminar un registro de la tabla
     */

     public function deleteRegistro(int $id)
     {
        try {
            return $this->delete($id);

        } catch (\Exception $e) {
            log_message('error', 'Error al eliminar el registro: ' . $e->getMessage());
            return false;
        }
     }
}