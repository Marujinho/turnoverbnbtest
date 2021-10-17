@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Ops...</h4>
            @foreach ($errors->all() as $error)
                <li class="mb-0">
                    {{ $error }}
                </li>
            @endforeach
        </div>
    @endforeach
@endif

@if(session('success'))
    <div class="alert alert-success" role="success">
        <h4 class="alert-heading">Done</h4>
        <p class="mb-0">
            {{ session('success') }}
        </p>
    </div>
@endif
