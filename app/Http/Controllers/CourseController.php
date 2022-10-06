<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseStoreRequest;
use App\Http\Resources\CourseCollection;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a list of the courses with pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return new CourseCollection(Course::paginate(($request->has('limit'))?$request->limit:10));
    }

    /**
     * Save a course.
     * @param CourseStoreRequest $request 
     * @return void 
     */
    public function store(CourseStoreRequest $request)
    {
        $course = Course::create($request->validated());

        return $course;
    }

    /**
     * Display the specified course.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Course::findOrFail($id);
    }

    /**
     * Update the specified course in storage.
     *
     * @param CourseStoreRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseStoreRequest $request, $id)
    {
        $course = Course::findOrFail($id);
        $course->update($request->all());
        
        return $course;
    }

    /**
     * Remove the specified course from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        
        return $course;
    }
}
