<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index() 
    {   
        $students = Student::all();
        if ($students->count() > 0) {
            return response()->json([
                'status' => 201,
                'students' => $students
            ],201);
        }else {
            return response()->json([
                'status' => 404,
                'message' => 'No Records Found'
            ],404);
        }
    }

    public function store(Request $request) {
       
        $validator = validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ],422);
        } else {
            $student = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            if ($student) {
                return response()->json([
                    'status' => 201,
                    'message' => "Student Created Successfully"
                ],201);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => "Something went wrong!"
                ],500);
            }
            
        }
        
    }

    public function show($id) {
         $students = Student::find($id);
         if ($students) {
            return response()->json([
                'status' => 201,
                'student' => $students
            ],201);
         } else {
           return response()->json([
            'status' => 404,
            'message' => "No such student found!"
           ],404);
         }
         
    }

    public function edit($id) {
        $students = Student::find($id);
        if ($students) {
           return response()->json([
               'status' => 201,
               'student' => $students
           ],201);
        } else {
          return response()->json([
           'status' => 404,
           'message' => "No such student found!"
          ],404);
        }
    }


    public function update(Request $request, int $id) {
        $validator = validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ],422);
        } else {

            $student = Student::find($id);

            $student ->update([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            if ($student) {
                return response()->json([
                    'status' => 201,
                    'message' => "Student Updated Successfully"
                ],201);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "No such Student found"
                ],500);
            }
            
        }
    }

    public function destroy($id) {
        $student = Student::find($id);
        if ($student) {
            $student->delete();
            return response()->json([
                'status' => 201,
                'message' => "Student Deleted Successfully!"
            ]);
        } else {
           return response()->json([
            'status' => 404,
            'message' => "No Such Student Found!"
           ],404);
        }
        
    }
 
}
