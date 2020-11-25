@extends('template.template')
@section('header')
    @parent
    <style>
        .chat-item {
            border-radius: 0.4em;
        }

        .chat-from {
            background-color: #dbf6e9;
        }

        .chat-to {
            background-color: #d9ecf2;
        }

    </style>
@endsection
@section('page_name', 'Chat')
@section('content')
    <div class="card border-0 shadow rounded mb-5">
        <div class="card-body p-0 ">
            <div class="row">
                <div class="col-md-3 bg-white py-3">
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

                    <div id="chat-list" class="overflow-auto d-none d-md-block collapse" style="max-height: 28em">
                        @forelse ($users as $user)
                            <a href="{{ url()->current() . '?user_id=' . $user->id }}" class="text-reset text-decoration-none">
                                <div class="block my-1">
                                    <span>{{ $user->username }}</span>
                                    <p class="font-weight-light">{{ $user->chat->last()->text }}</p>
                                </div>
                            </a>
                        @empty


                        @endforelse
                    </div>
                    <button class="d-block d-md-none btn btn-block" data-toggle="collapse" data-target="#chat-list">
                        <i class="fa fa-chevron-down"></i>
                    </button>
                </div>
                <div class="col-md-9 bg-light p-0">
                    <div id="chat-box" class="overflow-auto" style="height: 28em">
                        @forelse ($chats as $chat)
                            <div class="row mx-3 justify-content-end">
                                <div class="col">
                                </div>
                                <div class="col-auto">
                                    <div class="row justify-content-end">
                                        <div class="col-auto bg-info rounded-pill my-2 p-3 px-4 text-white">
                                            {{ $chat->text }}
                                        </div>
                                    </div>

                                    {{-- <span
                                        class="badge badge-pill badge-primary">{{ $chat->chat_label ? $chat->chat_label : 'undefined' }}</span>
                                    --}}
                                    <small class="text-muted">{{ $chat->created_at }}</small>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function statusSet(element, from, to) {
            if (element.classList.contains(from)) {
                element.classList.remove(from)
                element.classList.add(to)
            } else {
                element.classList.remove(to)
                element.classList.add(from)
            }
        }

        function scrollToBottom(element) {
            element.scrollTop = element.scrollHeight
            console.log(element);
        }
        $(window).resize(function() {
            if ($(this).innerWidth() < 766) {
                $('#chat-list').removeClass('d-none');
            } else {
                $('#chat-list').addClass('d-none');
            }
        });
        $(window).on('load', function() {
            scrollToBottom(document.getElementById('chat-box'))
            if ($(this).innerWidth() < 766) {
                $('#chat-list').removeClass('d-none');
            } else {
                $('#chat-list').addClass('d-none');
            }
        });

    </script>
@endsection
