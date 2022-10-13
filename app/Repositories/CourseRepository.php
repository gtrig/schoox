<?php

namespace App\Repositories;

use App\Interfaces\CourseRepositoryInterface;
use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CourseRepository implements CourseRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        //Return a course collection
        return Course::all();
    }

    /**
     * @param int $perPage 
     * @return mixed 
     */
    public function getPaginated(int $perPage = 10)
    {
        return Course::paginate($perPage);
    }

    /**
     * @return Collection
     */
    public function getAllTrashed(): Collection
    {
        return Course::onlyTrashed()->get();
    }

    /**
     * @param int $id
     * @return Course
     */
    public function getById($id): ?Course
    {
        $course = Course::find($id);
        if($course == null) {
            throw new ModelNotFoundException('Course  with id ' . $id . ' not found');
        }
        return $course;
    }

    /**
     * @param array $data
     * @return Course
     */
    public function createCourse($data): ?Course
    {
        return Course::create($data);
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function updateCourse($data, $id): bool
    {
        $course = $this->getById($id);
        
        if($course->update($data)) {
            return true;
        }
        
        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteCourse($id): bool
    {

        $course = $this->getById($id);

        if($course->delete())
        {
            return true;
        }
        return false;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function restoreCourse($id): bool
    {
        return Course::onlyTrashed()->find($id)->restore();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function permanentDeleteCourse($id): bool
    {
        return Course::find($id)->forceDelete();
    }
}