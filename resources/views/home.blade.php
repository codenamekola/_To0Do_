@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if(session('email_flash'))
                <div class="alert alert-success" role="alert">
                    {{ session('email_flash') }}
                </div>
            @endif

            @if(session('sms_flash'))
                <div class="alert alert-success" role="alert">
                    {{ session('sms_flash') }}
                </div>
            @endif

            @if(session('event'))
                <div class="alert alert-success" role="alert">
                    {{ session('event') }}
                </div>
            @endif

            @if(session('todo-del'))
                <div class="alert alert-success" role="alert">
                    {{ session('todo-del') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header bg-dark text-white">
                    <div class="btn-group float-right">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Notifications
                        @if(Auth::user()->unreadNotifications->count())
                        <span class="badge badge-light">{{Auth::user()->unreadNotifications->count()}}</span>
                        @endif
                        </button>
                        <div class="dropdown-menu">
                            <a style="margin:2px" href="{{route('markAsRead')}}" class="btn btn-sm btn-success">Mark all as read</a>
                            @foreach (Auth::user()->unreadNotifications as $notification)
                                <a style="background-color:gray;border-bottom:1px solid white" class="dropdown-item" href="#">{{$notification->data['message']}}</a>
                            @endforeach

                            @foreach (Auth::user()->readNotifications as $notification)
                                <a class="dropdown-item" href="#">{{$notification->data['message']}}</a>
                            @endforeach
                        </div>
                    </div>
                <span><h3><strong>{{__('header.title',['name' => 'web app'])}}</strong></h3>&nbsp; | 
                    @if(Config::get('app.locale') == 'en')
                    <a href="{{url('/home/'.'fr')}}">Passer au français</a>
                    @elseif(Config::get('app.locale') == 'fr')
                    <a href="{{url('/home/'.'en')}}">Switch to English</a>
                    @endif
                </span>
                <p><code>{{__('header.about')}}</code></p>
                
                    <form method="POST" class="form-group" action="{{route('search')}}">
                        {{csrf_field()}}
                        <input type="text" class="form-control" placeholder="{{__('header.search')}}" name="key">
                    </form>
                    <div>
                        <a href="/sendemail" class="btn btn-sm btn-outline-primary">Send Via Email</a>
                        @can('todo-nitro',Auth::user())
                            <a href="" class="btn btn-sm btn-danger">To@Do Nitro</a>
                        @endcan
                    </div>
                </div>
                
                <div class="card-body bg-grey text-dark">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(count($errors) > 0)
                        @foreach ($errors->all() as $error)
                          <p class="alert alert-danger">{{$error}}</p>
                        @endforeach
                    @endif

                    <form method="POST" action="{{route('home.store')}}" class="form-group">
                        {{ csrf_field() }}
                        <input type="text" class="form-control" placeholder="{{__('header.enter')}}" name="todo">
                        <br>
                        <input type="submit" class="btn btn-sm btn-success" value="{{__('header.submit')}}">
                        @captcha
                    </form>

                    <div>
                        <ul class="list-group">
                            @foreach($todos as $todo)
                        <li class="list-group-item">{{$todo->todo}}
                            <span class="float-right">
                            <a href="{{url('/sendsms/'.$todo->id)}}" class="btn btn-sm btn-outline-primary">sms</a>&nbsp;
                            <a href="{{url('/todo/'.$todo->id.'/delete/')}}" class="btn btn-sm btn-outline-danger">Del</a>
                            </span>
                        </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
