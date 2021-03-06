@extends('template.template')
@section('page_name', $page_name)
@section('content')
    <div class="card border-0 shadow-sm mt-3 mb-5">
        <div class="card-body">
            <div class="row align-items-center mb-3">
                <div class="col-md-6 col-12 pb-2">
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
                <div class="col-md-6 col-12">
                    <div class="row justify-end-around px-3">
                        <div class="col-6 text-center">
                            <button class="btn btn-outline-success " data-toggle='modal' data-target='#importData'>
                                <i class="fa fa-download" aria-hidden="true"></i>
                                <span> Import Answer</span>
                            </button>
                        </div>
                        <div class="col-6 text-center">
                            <a href="{{ url('/answer/add') }}">
                                <button class="btn btn-info">
                                    <i class="fa fa-plus" aria-hidden="true"></i> <span>Add Answer</span>
                                </button>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th width='10%'>No</th>
                        <th width='40%'>Text</th>
                        <th width='40%'>Label</th>
                        <th width='10%'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($answers as $key => $answer)
                        <tr>
                            <td>{{ $key + 1 + $answers->lastItem() - $answers->perPage() }}</td>
                            <td class="text-left">{{ $answer->answer_text }}</td>
                            <td>{{ $answer->label->label_name }}</td>
                            <td>
                                <div class="row">
                                    <div class="col p-0">
                                        <a href="{{ url('/answer/edit/' . $answer->id) }}">
                                            <button class="btn btn-info">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="col p-0">
                                        <form action="{{ url('/answer/delete/' . $answer->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="font-italic text-center">Tidak Ada Pertanyaan</td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
            <div class="row justify-content-center">
                <div class="col-auto">
                    {{ $answers->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="importData">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Import Answer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/answer/import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="custom-file">
                            <input name="import_data" id="import_data"
                                class="custom-file-input btn btn-primary form-control" type="file">
                            <label for="import_data" class="custom-file-label">Choose File</label>
                        </div>
                        <small class="text-muted">only .xlsx , .xls , .csv </small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
