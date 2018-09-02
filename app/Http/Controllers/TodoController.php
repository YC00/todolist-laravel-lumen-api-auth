<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Todo;
use Auth;

class TodoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $todo = Auth::user()->todo()->get();
        return response()->json(['status' => 'success','result' => $todo]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        'title' => 'required',
        'content' => 'required',
        'attachment' => 'filled'
        ]);
        
        //upload attachment to s3
        $file = $request->file('attachment');
        $imageName = 'uploads/' .str_random(5).'_'.$file->getClientOriginalName();
        Storage::disk('s3')->getDriver()->put($imageName, file_get_contents($request->file('attachment')));
        Storage::disk('s3')->setVisibility($imageName, 'public');
        $url = Storage::disk('s3')->url($imageName);
        //upload attachment to s3 end

        $input = $request->all();
        $input['attachment'] = $url;
        if(Auth::user()->todo()->Create($input)){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = Todo::where('id', $id)->get();
        return response()->json($todo);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = Todo::where('id', $id)->get();
        return view('todo.edittodo',['todos' => $todo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'filled',
            'content' => 'filled',
            'attachment' => 'filled',
            'done_at' => 'filled'
        ]);
        
        $input = $request->all();

        //upload attachment to s3
        if($request->hasFile('attachment')){
            $file = $request->file('attachment');
            $imageName = 'uploads/' .str_random(5).'_'.$file->getClientOriginalName();
            Storage::disk('s3')->getDriver()->put($imageName, file_get_contents($request->file('attachment')));
            Storage::disk('s3')->setVisibility($imageName, 'public');
            $url = Storage::disk('s3')->url($imageName);
            $input['attachment'] = $url;
        }
        //upload attachment to s3 end

        $todo = Todo::find($id);
        if($todo->fill($input)->save()){
           return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'failed']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Todo::destroy($id)){
             return response()->json(['status' => 'success']);
        }
    }

    /**
     * Remove the all resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyall()
    {   
        $todo = Auth::user()->todo()->get();
        $deleteSuccess = false;
        foreach($todo as $key => $value){
            if(Todo::destroy($value['id'])){
                $deleteSuccess = true;
            }else{
                $deleteSuccess = false;
            }
        }
        if($deleteSuccess){
            return response()->json(['status' => 'success']);
        }
    }
}
