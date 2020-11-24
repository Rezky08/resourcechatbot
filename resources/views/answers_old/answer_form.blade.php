@extends('template.template')
@section('page_name', $page_name)
@section('header')
    @parent
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
                    <label for="">answer</label>
                    @isset($answer)
                        <textarea class="form-control" name="answer_text"
                            rows="5">{{ old('answer_text', $answer->answer_text) }}</textarea>
                    @else
                        <textarea class="form-control" name="answer_text" rows="5">{{ old('answer_text') }}</textarea>
                    @endisset
                    @error('answer_text')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Label</label>
                    <select class="form-control" name="label_id">
                        <option class="disabled" value="" selected disabled>- Select Label -</option>
                        <option value="a">a</option>
                    </select>
                    @error('label_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <a href="{{ url('/answer') }}">
                    <button type="button" class="btn btn-danger float-right mx-1">Cancel</button>
                </a>
                <button type="submit" class="btn btn-info float-right">Add</button>
            </form>
        </div>
    </div>
@endsection
