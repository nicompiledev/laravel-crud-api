<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;

class studentController extends Controller
{
    public function index()
    {
        $student = Student::all();

        // if ($student->isEmpty()) {

        //     $data = [
        //         'message' => 'No students found',
        //         'status' => 404
        //     ];
        //     return response()->json($data, 404);
        // }

        $data = [
            'message' => 'Students found',
            'status' => 200,
            'data' => $student
        ];

        return response()->json($data, 200);
    }

    public function show($id)
    {
        $student = Student::find($id);
        if(!$student) {
            $data = [
                'message' => 'Student not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => 'Student found',
            'status' => 200,
            'data' => $student
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator= Validator::make($request->all(), [
            'name' => 'required|max:255',
            'age' => 'required',
            'email' => 'required|email|unique:student',
            'phone' => 'required|min:10|max:15',
            'language' => 'required|in:English,Spanish,French'
        ]);

        if($validator->fails()) {
            $data = [
                'message' => 'Validation error',
                'status' => 400,
                'errors' => $validator->errors()
            ];
            return response()->json($data, 400);
        }
        $student = Student::create([
            'name' => $request->name,
            'age' => $request->age,
            'email' => $request->email,
            'phone' => $request->phone,
            'language' => $request->language
        ]);

        if(!$student) {
            $data = [
                'message' => 'Error creating student',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Student created',
            'status' => 201,
            'data' => $student
        ];

        return response()->json($data, 201);

    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        if(!$student) {
            $data = [
                'message' => 'Student not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator= Validator::make($request->all(), [
            'name' => 'required|max:255',
            'age' => 'required',
            'email' => 'required|email|unique:student,email,'.$id,
            'phone' => 'required|min:10|max:15',
            'language' => 'required|in:English,Spanish,French'
        ]);

        if($validator->fails()) {
            $data = [
                'message' => 'Validation error',
                'status' => 400,
                'errors' => $validator->errors()
            ];
            return response()->json($data, 400);
        }

        $student->name = $request->name;
        $student->age = $request->age;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->language = $request->language;

        $student->save();

        $data = [
            'message' => 'Student updated',
            'status' => 200,
            'data' => $student
        ];

        return response()->json($data, 200);


    }

    public function updatePartial(Request $request, $id)
    {
        $student = Student::find($id);
        if(!$student) {
            $data = [
                'message' => 'Student not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator= Validator::make($request->all(), [
            'name' => 'max:255',
            'age' => '',
            'email' => 'email|unique:student,email,'.$id,
            'phone' => 'min:10|max:15',
            'language' => 'in:English,Spanish,French'
        ]);

        if($validator->fails()) {
            $data = [
                'message' => 'Validation error',
                'status' => 400,
                'errors' => $validator->errors()
            ];
            return response()->json($data, 400);
        }

        if($request->has('name')) {
            $student->name = $request->name;
        }

        if($request->has('age')) {
            $student->age = $request->age;
        }

        if($request->has('email')) {
            $student->email = $request->email;
        }

        if($request->has('phone')) {
            $student->phone = $request->phone;
        }

        if($request->has('language')) {
            $student->language = $request->language;
        }

        $student->save();

        $data = [
            'message' => 'Student updated',
            'status' => 200,
            'data' => $student
        ];

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $student = Student::find($id);
        if(!$student) {
            $data = [
                'message' => 'Student not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $student->delete();

        $data = [
            'message' => 'Student deleted',
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
