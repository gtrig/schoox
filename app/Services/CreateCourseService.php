<?php

namespace App\Services;

use App\Interfaces\CourseRepositoryInterface;
use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class CreateCourseService
{
    /**
     * @var CourseRepositoryInterface
     */
    private $courseRepository;

    /**
     * CreateCourseService constructor.
     * @param CourseRepositoryInterface $courseRepository
     */
    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * @param array $data
     * @return Course
     */
    public function createCourse($data): ?Course
    {
        return $this->courseRepository->createCourse($data);
    }
}