@extends('template.template')
@section('page_name', 'User')
@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Roomchat Id</th>
                        <th>Created Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $key => $user)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->roomchat_id }}</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="font-italic text-center">Tidak Ada Users</td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
