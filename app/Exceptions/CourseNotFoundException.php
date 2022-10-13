<?php

namespace App\Exceptions;

use Exception;

class CourseNotFoundException extends Exception
{
    public function render()
    {
        return response()->json([
            'error' => 'Course not found'
        ], 404);
    }
}