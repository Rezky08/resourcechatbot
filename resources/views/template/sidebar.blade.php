@section('sidebar')
    <div class="row my-3">
        <div class="col-2">
            <button class="btn btn-info d-block d-md-none" data-toggle="collapse" data-target="#sidebar">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <div class="col-10 col-md-12 justify-content-center">
            <aside class="collapse" id="sidebar">
                <span class="font-weight-bold text-muted">
                    Administration
                </span>
                <ul class="list-unstyled pl-3">
                    <li><a href="{{ url('/user') }}" class="text-decoration-none text-reset">Users</a></li>
                    <li><a href="{{ url('/chat') }}" class="text-decoration-none text-reset">Chats History</a></li>
                    <li><a href="{{ url('/label') }}" class="text-decoration-none text-reset">labels</a></li>
                    <li><a href="{{ url('/question', []) }}" class="text-decoration-none text-reset">Questions</a></li>
                    <li><a href="{{ url('/answer', []) }}" class="text-decoration-none text-reset">Answers</a></li>
                    <li><a href="{{ url('/chatbot', []) }}" class="text-decoration-none text-reset">Chatbot</a></li>
                </ul>
            </aside>

        </div>
    </div>
@endsection
@section('script')
<script>
    function updateMobileClass(screenSize, target) {
        if (screenSize < 765) {
            target.classList.remove('show')
        } else {
            target.classList.add('show')
        }
    }

    window.addEventListener('resize', function() {
        let sidebar = document.getElementById('sidebar')
        screenSize = this.innerWidth;
        updateMobileClass(screenSize, sidebar)
    })
    window.addEventListener('load', function() {
        let sidebar = document.getElementById('sidebar')
        screenSize = this.innerWidth;
        updateMobileClass(screenSize, sidebar)
    })

</script>
@endsection
