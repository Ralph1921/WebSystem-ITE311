<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['course_id', 'file_name', 'file_path', 'created_at', 'updated_at'];

    /**
     * Insert a new material record
     * 
     * @param array $data
     * @return int|false
     */
    public function insertMaterial($data)
    {
        return $this->insert($data);
    }

    /**
     * Get all materials for a specific course
     * 
     * @param int $course_id
     * @return array
     */
    public function getMaterialsByCourse($course_id)
    {
        return $this->where('course_id', $course_id)->findAll();
    }

    /**
     * Get a single material by ID
     * 
     * @param int $material_id
     * @return array|null
     */
    public function getMaterialById($material_id)
    {
        return $this->where('id', $material_id)->first();
    }

    /**
     * Delete a material by ID
     * 
     * @param int $material_id
     * @return bool
     */
    public function deleteMaterial($material_id)
    {
        return $this->delete($material_id);
    }
}
