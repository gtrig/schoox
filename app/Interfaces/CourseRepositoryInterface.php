<?php

namespace App\Interfaces;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

interface CourseRepositoryInterface
{
    /** @return Collection  */
    public function getAll(): Collection;

    // get paginated courses
    public function getPaginated(int $perPage);

    /** @return Collection  */
    public function getAllTrashed(): Collection;
    
    /**
     * @param int $id 
     * @return Course  
     */
    public function getById($id): ?Course;
    
    /**
     * @param array $data 
     * @return Course  
     */
    public function createCourse($data): ?Course;
    
    /**
     * @param array $data 
     * @param int $id 
     * @return Course  
     */
    public function updateCourse($data, $id): bool;
    
    /**
     * @param int $id 
     * @return Course  
     */
    public function deleteCourse($id): bool;

    /**
     * @param int $id 
     * @return Course  
     */
    public function restoreCourse($id): bool;

    /**
     * @param int $id 
     * @return Course  
     */
    public function permanentDeleteCourse($id): bool;
    

}