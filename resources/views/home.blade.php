@extends('template.template')
@section('page_name', 'Home')
@section('content')
    <section class="bg-info text-white p-3 rounded shadow">
        <div class="container">
            <span class="h1 font-weight-bold d-block">
                Hello, Admin.
            </span>
            <span class="h5 font-weight-bold">
                I hope you are having a great day!
            </span>
        </div>
    </section>
    <section class="row my-3">
        <div class="col-md-3 text-center">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <span class="h2 font-weight-bold d-block">{{$users->count()}}</span>
                    <span class="h5 font-weight-light text-muted d-block">Users</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <span class="h2 font-weight-bold d-block">{{$chats->count()}}</span>
                    <span class="h5 font-weight-light text-muted d-block">Chat Inbox</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <span class="h2 font-weight-bold d-block">{{$questions->count()}}</span>
                    <span class="h5 font-weight-light text-muted d-block">Question</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <span class="h2 font-weight-bold d-block">{{$answers->count()}}</span>
                    <span class="h5 font-weight-light text-muted d-block">Answer</span>
                </div>
            </div>
        </div>

    </section>
@endsection
