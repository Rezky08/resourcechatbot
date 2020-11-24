@extends('template.template')
@section('page_name', $page_name)

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            {{-- Search Box --}}
                            <form action="" method="get" class="p-0">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn bg-transparent border border-right-0">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                    <input type="search" class="form-control border-left-0 rounded-right font-weight-light"
                                        name="searchbox" id="searchbox" placeholder="search name..."
                                        value="{{ Request::get('searchbox') }}">
                            </form>
                            <div class="input-group-append">
                                <form action="{{ url('/label/add') }}" method="post"
                                    class="input-group-text p-0 bg-transparent border-left-0 d-none" id="addBtn">
                                    @csrf
                                    <input type="hidden" name="label_name" id="inputLabel">
                                    <button class="btn bg-transparent">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                        {{-- End Search Box --}}
                        <div class="col-12">
                            @error('label_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-12 overflow-auto mt-1" style="max-height: 23em">
                            @forelse ($labels as $key => $label)
                                <div class="row">
                                    <div class="col-10">
                                        <span id="{{ $key }}"
                                            ondblclick="addClass(this,'d-none');removeClass('form#form-{{ $key }}','d-none')">{{ $label->label_name }}</span>
                                        <form action="{{ url('/label/update/' . $label->id) }}" method="post"
                                            id="form-{{ $key }}" class="d-none">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="label_name"
                                                    value="{{ $label->label_name }}"
                                                    onblur="addClass('form#form-{{ $key }}','d-none');removeClass('span#{{ $key }}','d-none')">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-2">
                                        <form action="{{ url('/label/delete/' . $label->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" name="id">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="row">
                                    <div class="col text-center">
                                        <span class="text-muted font-italic">Tidak Ada Label Ditemukan</span>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
@parent
<script>
    function removeClass(element, className) {
        $(element).removeClass(className);
    }

    function addClass(element, className) {
        $(element).addClass(className);
    }

    function displayBtn(el) {
        let addBtn = $('#addBtn');
        let inputLabel = $('#inputLabel').val($(el).val());
        if ($(el).val() != '') {
            if ($(el).hasClass('rounded-right')) {
                $(el).removeClass('rounded-right');
            }
            if (!$(el).hasClass('border-right-0')) {
                $(el).addClass('border-right-0');
            }
            if (addBtn.hasClass('d-none')) {
                $(addBtn).removeClass('d-none');
            }
        } else {
            if (!$(el).hasClass('rounded-right')) {
                $(el).addClass('rounded-right');
            }
            if ($(el).hasClass('border-right-0')) {
                $(el).removeClass('border-right-0');
            }

            if (!addBtn.hasClass('d-none')) {
                $(addBtn).addClass('d-none');
            }
        }
    }

    $('#searchbox').keyup(function() {
        displayBtn(this);
    });

</script>
@endsection
