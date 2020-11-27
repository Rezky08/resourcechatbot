@include('template.header')
@include('template.navigation')
@include('template.sidebar')
<!DOCTYPE html>
<html>
<head>
    @section('header')
    @show
</head>

<body class="bg-light">

    @section('nav')

    @show
    <div class="container-fluid px-4">
        <div class="row py-3">
            <div class="col-md-2">
                @section('sidebar')
                @show
            </div>
            <div class="col-md-10">
                <span class="h3 text-info">@yield('page_name')</span>
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-pill" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>{{ Session::get('success') }}</strong>
                    </div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-pill" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>{{ Session::get('error') }}</strong>
                    </div>
                @endif

                @section('content')
                @show
            </div>
        </div>
    </div>
    <footer class="fixed-bottom bg-dark text-white text-center py-1">
        <p>
            Created with <strong class="text-danger"> ❤ </strong> by Rezky Setiawan
        </p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    @section('script')

    @show
</body>

</html>
