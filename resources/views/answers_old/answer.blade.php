@extends('template.template')
@section('page_name', $page_name)
@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row align-items-center mb-3">
                <div class="col-md-6">
                    <form action="" method="get" class="m-0">
                        {{-- Search Box --}}
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn bg-transparent border border-right-0">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                            <input type="search" class="form-control border-left-0 font-weight-light" name="searchbox"
                                placeholder="search name...">
                        </div>

                        {{-- End Search Box --}}

                    </form>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('/answer/add') }}">
                        <button class="btn btn-info float-right">
                            <i class="fa fa-plus" aria-hidden="true"></i> <span>Add Answer</span>
                        </button>
                    </a>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Text</th>
                        <th>Label</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($answers as $key => $answer)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $answer->answer_text }}</td>
                            <td>{{ $answer->label->label_name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="font-italic text-center">Tidak Ada Pertanyaan</td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
