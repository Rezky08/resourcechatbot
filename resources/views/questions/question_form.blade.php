@extends('template.template')
@section('page_name', $page_name)
@section('header')
    @parent
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <style>
        textarea {
            resize: none;
        }

    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="" method="POST">
                @method($form_method)
                @csrf
                <div class="form-group">
                    <label for="">Question</label>
                    @isset($question)
                        <textarea class="form-control" name="question_text"
                            rows="5">{{ old('question_text', $question->question_text) }}</textarea>
                    @else
                        <textarea class="form-control" name="question_text" rows="5">{{ old('question_text') }}</textarea>
                    @endisset
                    @error('question_text')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Label</label>
                    <select id="label-select" class="form-control" name="label_id">
                        <option class="disabled" value="" selected disabled>- Select Label -</option>
                        @foreach ($labels as $label)
                            <option value="{{ $label->id }}">{{ $label->label_name }}</option>
                        @endforeach
                    </select>
                    @error('label_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <a href="{{ url('/question') }}">
                    <button type="button" class="btn btn-danger float-right mx-1">Cancel</button>
                </a>
                <button type="submit" class="btn btn-info float-right">Add</button>
            </form>
        </div>
    </div>
@endsection
@section('script')
    @parent
    <script>
        $(document).ready(function() {
            $('#label-select').select2();
            $('#label-select').val("{{ isset($question) ? $question->label_id : '' }}");
            $('#label-select').trigger('change');
        });

    </script>
@endsection
