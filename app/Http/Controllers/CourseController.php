<?php

namespace App\Http\Controllers;

use App\Exceptions\CourseNotFoundException;
use App\Http\Requests\CourseStoreRequest;
use App\Http\Resources\CourseCollection;
use App\Models\Course;
use App\Repositories\CourseRepository;
use App\Services\CreateCourseService;
use App\Services\DeleteCourseService;
use App\Services\UpdateCourseService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * @var CourseRepository
     */
    private $courseRepository;

    /**
     * CourseController constructor.
     * @param CourseRepository $courseRepository
     */
    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * Display a list of the courses with pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        // if request limit is set, use it, otherwise use default
        if($request->has('per_page'))
        {
            $limit = $request->per_page;
            $courses = $this->courseRepository->getPaginated($limit);
        }
        else
        {
            $courses = $this->courseRepository->getAll();
        }
        

        return new CourseCollection($courses);
    }

    /**
     * Save a course.
     * @param CourseStoreRequest $request 
     * @return void 
     */
    public function store(CourseStoreRequest $request, CreateCourseService $createCourseService)
    {
        $course = $createCourseService->createCourse($request->validated());

        return response()->json([
            'message' => 'Course created successfully',
            'course' => $course
        ], 201);
    }

    /**
     * Display the specified course.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $course = $this->courseRepository->getById($id);
        }
        catch(ModelNotFoundException $e)
        {
            throw new CourseNotFoundException();
        }

        return response()->json([
            'course' => $course      
        ], 200);
    }

    /**
     * Update the specified course in storage.
     *
     * @param CourseStoreRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseStoreRequest $request, $id, UpdateCourseService $updateCourseService)
    {
        try{
            $course = $updateCourseService->updateCourse($request->validated(), $id);
        }
        catch(ModelNotFoundException $e)
        {
            throw new CourseNotFoundException();
        }
        
        return response()->json([
            'message' => 'Course updated successfully',
            'course' => $course
        ]);
    }

    /**
     * Remove the specified course from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, DeleteCourseService $service)
    {
        try{
            $service->deleteCourse($id);
        }
        catch(ModelNotFoundException $e)
        {
            throw new CourseNotFoundException();
        }

        return response()->json([
            'message' => 'Course deleted successfully'
        ]);        
    }
}
