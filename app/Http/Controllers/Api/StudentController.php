<?php

namespace App\Http\Controllers\Api;



use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required|string|max:191',
            'course'=>'required|string|max:191',
            'email'=>'required|email|string|max:191',
            'phone'=>'required|max:10',
        ]);

        if ($validator->fails()){
            return response()->json([
                'statuse'=>422,
                'errors'=>$validator->messages()
            ], 422);
        }else{
            $student = Student::create([
                'name'=>$request->name,
                'course'=>$request->course,
                'email'=>$request->email,
                'phone'=>$request->phone,
            ]);

            if ($student){
                return response()->json([
                    'statuse' => 200,
                    'message' => 'Student Created Sucessfully'
                ], 200);

            }else{
                return response()->json([
                    'statuse'=> 500,
                    'message'=> 'Faild to Create'
                ], 500);
            };
        };
    }

    public function show($id){
        $student = Student::find($id);
        
        if ($student){
            return response()->json([
                'statuse'=>200,
                'student'=>$student,

            ]);
        }else{
            return response()->json([
                'statuse'=>404,
                'message'=>'No student found!'
            ], 404);

        };

    }


    public function update(Request $request, int $id)
    {
    
        $student = Student::find($id);
    
        if ($student) {
            $student->update([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
    
            return response()->json([
                'status' => 200,
                'message' => 'Student updated successfully'
            ], 200);

        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Failed to update: Student not found'
            ], 404);
        }
    }
    
    public function destroy(int $id){
        $student = Student::find($id);
        if ($student){
            $student->delete();
            return response()->josn([
                'statuse'=>200,
                'message'=>'deleted!',
                'Record'=>"$student",
            ]);

        }else{
            return response()->json([
                'statuse'=>404,
                'Message'=>'Not Found',
            ]);
        };
    }



    public function edit($id){
    
        $student = Student::find($id);
        if ($student){
            return response()->json([
                'statuse'=>200,
                'student'=>$student,

            ]);
        }else{
            return response()->json([
                'statuse'=>404,
                'message'=>'No student found!'
            ], 404);

        };

    }


    public function index(){
        
        $student = Student::all(); // Gets all the data
        
        
        if ($student->count() > 0){
            return response()->json([
                'statse' => 200,
                'message'=> $student,
            ]);
        }else{ return response()->json([
            'statse' => 404,
            'Data'=> 'No Records Found',

        ]);
            
        };
    }
}

?>