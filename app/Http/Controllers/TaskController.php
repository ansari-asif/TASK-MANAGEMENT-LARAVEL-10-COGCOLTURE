<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    function taskList(){
        $data=[];
        $user_type=Auth::user()->user_type;
        if($user_type=='admin'){
            $tasks=Task::orderBy('id', 'desc')->get();
        }else{
            $tasks=Task::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->get();
        }
        $data['tasks']=$tasks;
        return view('admin.task.task_list',$data);
    }

    function add_task(Request $req){
        if($req->isMethod('post')){
            $validator=Validator::make($req->all(),[
                "title"=>"required|string|min:5",
                // "status"=>"required|string",
                "deadline"=>"required|date",
                "description"=>"required|string|min:5",
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $post_data=[
                "title"=>$req->title,
                "status"=>'pending',
                "deadline"=>$req->deadline,
                "description"=>$req->description,
                "user_id"=>Auth::user()->id,
            ];
            $task=Task::create($post_data);
            if($task){
                return redirect()->route('tasks')->with([
                    "success"=>"Task has been created successfully"
                ]);
            }else{
                return redirect()->back()->with([
                    "error"=>"Something went wrong..."
                ]);
            }
        }
        return view('admin.task.add_task');
    }

    function edit_task(Request $req,$id=null){
        $data=[];
        if($id){
            $user_type=Auth::user()->user_type;
            $task=Task::find($id);
            if(($user_type!='admin') && $task->user_id!=Auth::user()->id){
                return redirect()->route('tasks')->with([
                    "warning"=>"Task not found.",
                ]);
            }          
            $data['task']=$task;
            if($req->isMethod('post')){
                $validator=Validator::make($req->all(),[
                    "title"=>"required|string|min:5",
                    // "status"=>"required|string",
                    "deadline"=>"required|date",
                    "description"=>"required|string|min:5",
                ]);
                if($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $task->title=$req->title;
                $task->status=$req->status;
                $task->deadline=$req->deadline;
                $task->description=$req->description;
                $task->save();
                return redirect()->route('tasks')->with([
                    "success"=>"Task has been updated successfully"
                ]);
            }
            return view('admin.task.edit_task',$data);
        }else{
            return redirect()->route('tasks')->with([
                "success"=>"Please check the url."
            ]);
        }
    }

    function delete_task(Request $req){
        try {
            $response=[
                'status'=>false,
                "message"=>''
            ];
            if($req->isMethod('post') && $req->id){
                $id=$req->id;
                $user_type=Auth::user()->user_type;
                $task=Task::find($id);
                if(($user_type!='admin') && $task->user_id!=Auth::user()->id){
                    $response=[
                        'status'=>false,
                        "message"=>'You are not allowed to delete this task.'
                    ];
                    return response()->json($response);
                }
                if($task){
                    $task->delete();
                    $response=[
                        'status'=>true,
                        "message"=>'Task has been deleted successfully'
                    ];
                }else{
                    $response=[
                        'status'=>false,
                        "message"=>'Task not found.'
                    ];
                }
            }else{
                $response=[
                    'status'=>false,
                    "message"=>'Invalid parameters.'
                ];
            }
        }catch (\Throwable $th) {
            $response=[
                'status'=>false,
                "message"=>'Something went wrong.Try Later...!'
            ];
        }
        return response()->json($response);
    }

}
