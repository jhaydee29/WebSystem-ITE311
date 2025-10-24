<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'course_id',
        'title',
        'description',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'uploaded_by'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get all materials for a specific course
     *
     * @param int $courseId
     * @return array
     */
    public function getCourseMaterials($courseId)
    {
        return $this->select('materials.*, users.name as uploader_name')
                    ->join('users', 'materials.uploaded_by = users.id')
                    ->where('materials.course_id', $courseId)
                    ->orderBy('materials.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get a single material with uploader info
     *
     * @param int $materialId
     * @return array|null
     */
    public function getMaterialWithUploader($materialId)
    {
        return $this->select('materials.*, users.name as uploader_name')
                    ->join('users', 'materials.uploaded_by = users.id')
                    ->where('materials.id', $materialId)
                    ->first();
    }

    /**
     * Delete material and its file
     *
     * @param int $materialId
     * @return bool
     */
    public function deleteMaterial($materialId)
    {
        $material = $this->find($materialId);
        
        if ($material) {
            // Delete the physical file
            $filePath = FCPATH . $material['file_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            // Delete the database record
            return $this->delete($materialId);
        }
        
        return false;
    }
}
