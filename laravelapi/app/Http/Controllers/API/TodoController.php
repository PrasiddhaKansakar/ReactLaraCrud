<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function index(){
        $todos = Todo::all();
        return response()->json([
            'status'=> 200,
            'todos'=>$todos,
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'title'=>'required|max:191',
            'importance'=>'required|max:191',
            'deadline'=>'required|date_format:Y-m-d|after_or_equal:1920-01-01',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=> 422,
                'validate_err'=> $validator->errors(),
            ]);
        }
        else{
            $todo = new Todo;
            $todo->title = $request->input('title');
            $todo->importance = $request->input('importance');
            $todo->deadline = $request->input('deadline');
            $todo->save();
    
            return response()->json([
                'status'=> 200,
                'message'=> 'Todo Added Successfully',
            ]);
        }
    }

    public function edit($id){
        $todo = Todo::find($id);
        if($todo){
            return response() -> json([
                'status' => 200,
                'todo' => $todo
            ]);
        } else{
            return response()->json([
                'status'=> 404,
                'message' => 'No Todo ID Found',
            ]);
        }
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'title'=>'required|max:191',
            'importance'=>'required|max:191',
            'deadline'=>'required|date_format:Y-m-d|after_or_equal:1920-01-01',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=> 422,
                'validationErrors'=> $validator->errors(),
            ]);
        } else{
            $todo = Todo::find($id);
            if($todo){
                $todo->title = $request->input('title');
                $todo->importance = $request->input('importance');
                $todo->deadline = $request->input('deadline');
                $todo->update();
                
                return response()->json([
                    'status'=> 200,
                    'message'=> 'Todo Updated Successfully',
                ]);
            } else {
                return response()->json([
                    'status'=> 404,
                    'message' => 'No Todo ID Found',
                ]);
            }
        }
    }
    public function destroy($id)
    {
        $todo = Todo::find($id);
        if($todo)
        {
            $todo->delete();
            return response()->json([
                'status'=> 200,
                'message'=>' Todo Deleted Successfully',
            ]);
        }
        else
        {
            return response()->json([
                'status'=> 404,
                'message' => 'No Todo ID Found',
            ]);
        }
    }
    // public function complete(Request $request, $id){
    //     $todo = Todo::find($id);
    //     if($todo){
    //         $todo->completed = $request->todo['completed'] ? true : false;
    //         $todo->save();
    //         return response()->json([
    //             'status'=> 200,
    //             'message'=> 'Todo Completed',
    //         ]);
    //     }
    //     else{
    //         return response()->json([
    //             'status'=>404,
    //             'message'=>'No todo found',
    //         ]);
    //     }
    // }
}
