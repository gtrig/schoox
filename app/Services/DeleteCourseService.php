<?php

namespace App\Services;

use App\Interfaces\CourseRepositoryInterface;
use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class DeleteCourseService
{
    /**
     * @var CourseRepositoryInterface
     */
    private $courseRepository;

    /**
     * DeleteCourseService constructor.
     * @param CourseRepositoryInterface $courseRepository
     */
    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * @param int $id
     * @return Course
     */
    public function deleteCourse($id): bool
    {
        if($this->courseRepository->deleteCourse($id)) {
            return true;
        }
        return false;
    }
}