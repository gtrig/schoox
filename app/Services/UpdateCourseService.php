<?php

namespace App\Services;

use App\Interfaces\CourseRepositoryInterface;
use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class UpdateCourseService
{
    /**
     * @var CourseRepositoryInterface
     */
    private $courseRepository;

    /**
     * UpdateCourseService constructor.
     * @param CourseRepositoryInterface $courseRepository
     */
    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Course
     */
    public function updateCourse($data, $id): bool
    {
        if($this->courseRepository->updateCourse($data, $id)) {
            return true;
        }
        return false;
    }
}