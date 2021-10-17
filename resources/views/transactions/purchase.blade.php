@extends('layouts.app')

@section('content')
@include('components.messages')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('components.balance')
            <div class="card">
                <div class="card-header">Purchase something -
                    <a href="{{ route('home') }}">previous page</a>
                </div>

                <div class="card-body">
                    {!! Form::open(['route' => ['transaction.store.purchase'], 'method'=>'POST', 'onsubmit' => 'disableDoubleClick()']) !!}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Price</label>
                            {!! Form::text('amount', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description of purchase</label>
                            {!! Form::text('description', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>
                        {!! Form::submit('Purchase', ['id'=>'submitBtn', 'class' => 'btn btn-success btn-block']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>
function disableDoubleClick()
    {
        var btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.value = "please wait...";

        return;
    }
</script>

@endsection
