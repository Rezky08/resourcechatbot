@extends('template.template')
@section('page_name', $page_name)
@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="" method="post">
                @csrf
                <button class="btn btn-info mb-3 pull-right"> <i class="fa fa-code"></i> Train</button>
            </form>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Score</th>
                        <th>Train Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($trains as $key => $train)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $train->score }}</td>
                            <td>{{ $train->created_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="font-italic text-center">Trains Not Found</td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
