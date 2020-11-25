@extends('template.template')
@section('page_name', 'User')
@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Created Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $key => $user)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $user->user_id }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
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
