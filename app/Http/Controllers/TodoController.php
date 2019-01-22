<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TodoRequest;
use Auth;
use App\Todo;
use App\Events\TodoEvent;
use App\Jobs\SendEmailJob;
use App\Notifications\TodoDeletedNotif;
use App\Notifications\TodoTimeNotif;
use App\Notifications\TodoSmsNotif;
use App\User;

class TodoController extends Controller
{
    //function to create a new todo
    public function store(TodoRequest $request){

        $todo = new Todo;
        $todo->todo = $request->todo;
        $todo->user_id = Auth::id();
        $todo->save();

        if($todo->save()){

            event(new TodoEvent($todo->todo));

            //next code is here temporarily
            $user = Auth::user();

            $todos = Todo::where('user_id',$user->id)->latest()->get();

            foreach($todos as $todo){

                if($todo->created_at < now()->subDay()){

                    User::find(Auth::id())->notify(new TodoTimeNotif($todo->todo));
                }
            }
        }

        return back();

    }

    //function to search for todos
    public function search(Request $request){

        $results = Todo::search($request->key)->get();

        return view('search')->with('results',$results);
    }

    //function to send an email
    public function sendTodoEmail(){

        $job = (new SendEmailJob())->delay(now()->addSeconds(10));

        dispatch($job);

        \Session::flash('email_flash','Your todo list has been successfully sent');

        return redirect('home');
    }

    //send a todo as an sms
    public function sendSms($todo){

        $todo = Todo::find($todo);

        User::find(Auth::id())->notify(new TodoSmsNotif($todo->todo));

        \Session::flash('sms_flash','Your todo has been sent via sms');

        return back();
    }

    //delete a todo
    public function delete($id){

        $todo = Todo::find($id);

        User::find(Auth::user()->id)->notify((new TodoDeletedNotif($todo->todo))->delay(now()->addSeconds(10)));

        $todo->delete();

        \Session::flash('todo-del','To-do Deleted!');

        return back();
    }
}
