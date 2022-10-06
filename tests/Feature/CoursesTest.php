<?php

namespace Tests\Feature;

use Database\Factories\CourseFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoursesTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_list_of_courses_is_shown()
    {
        $courses = CourseFactory::new()->count(5)->create();

        $response = $this->getJson('/api/courses');
        
        // check the titles is correct
        $response->assertJson([
            'data' => [
                [
                    'title' => $courses[0]->title,
                ],
                [
                    'title' => $courses[1]->title,
                ],
                [
                    'title' => $courses[2]->title,
                ],
                [
                    'title' => $courses[3]->title,
                ],
                [
                    'title' => $courses[4]->title,
                ],
            ],
        ]);

        // check the total is correct
        $response->assertJson([
            'meta' => [
                'total' => 5,
            ],
        ]);

        $response->assertStatus(200);
    }

    public function test_a_course_is_created()
    {
        $response = $this->postJson('/api/courses', [
            'title' => 'Test Course',
            'description' => 'Test Course Description',
            'status' => 'Published',
            'is_premium' => false,
        ]);
        
        // check the title is correct
        $response->assertJson([
            'title' => 'Test Course',
        ]);
        
        $response->assertStatus(201);
    }

    // Test a course is not created if the any input is missing
    public function test_a_course_is_not_created_if_any_input_is_missing()
    {
        $response = $this->postJson('/api/courses', [
            'title' => 'Test Course',
            'description' => 'Test Course Description',            
        ]);

        $response->assertJsonMissingValidationErrors(['is_premium', 'status']);
        $response->assertStatus(422);

        $response = $this->postJson('/api/courses', [
            'title' => 'Test Course',
            'status' => 'Published',
        ]);

        $response->assertJsonMissingValidationErrors(['description', 'is_premium']);
    }

    public function test_a_course_is_updated()
    {
        $course = CourseFactory::new()->create();

        $response = $this->putJson('/api/courses/' . $course->id, [
            'title' => 'Test Course',
            'description' => 'Test Course Description',
            'status' => 'Published',
            'is_premium' => false,
        ]);
        
        // check the title is correct
        $response->assertJson([
            'title' => 'Test Course',
        ]);
        
        $response->assertStatus(200);
    }

    // Test a course is not updated if the any input is missing
    public function test_a_course_is_not_updated_if_any_input_is_missing()
    {
        $course = CourseFactory::new()->create();

        $response = $this->putJson('/api/courses/' . $course->id, [
            'title' => 'Test Course',
            'description' => 'Test Course Description',            
        ]);

        $response->assertJsonMissingValidationErrors(['is_premium', 'status']);
        $response->assertStatus(422);

        $response = $this->putJson('/api/courses/' . $course->id, [
            'title' => 'Test Course',
            'status' => 'Published',
        ]);

        $response->assertJsonMissingValidationErrors(['description', 'is_premium']);
    }

    public function test_a_course_is_deleted()
    {
        $course = CourseFactory::new()->create();

        $response = $this->deleteJson('/api/courses/' . $course->id);
        
        $response->assertStatus(200);
    }

    // Test a course is not deleted if the id is wrong
    public function test_a_course_is_not_deleted_if_id_is_wrong()
    {
        $response = $this->deleteJson('/api/courses/1');
        
        $response->assertStatus(404);
    }

    public function test_a_course_is_shown()
    {
        $course = CourseFactory::new()->create();

        $response = $this->getJson('/api/courses/' . $course->id);
        
        $response->assertStatus(200);
    }

    // Test a course is not shown if the id is wrong
    public function test_a_course_is_not_shown_if_id_is_wrong()
    {
        $response = $this->getJson('/api/courses/1');
        
        $response->assertStatus(404);
    }
}
