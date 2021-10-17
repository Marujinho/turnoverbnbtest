@extends('layouts.app')


@section('content')
@include('components.messages')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('components.balance')
            <div class="card">
                <div class="card-header">Make a Deposit -
                    <a href="{{ route('home') }}">previous page</a>
                </div>

                <div class="card-body">
                    {!! Form::open(['route' => ['transaction.deposit'], 'method'=>'POST', 'enctype' => 'multipart/form-data', 'onsubmit' => 'disableDoubleClick()']) !!}
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            {!! Form::text('amount', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            {!! Form::text('description', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>
                        <div class="form-group">
                            <label  class="btn btn-info">
                                <span >upload the check photo</span>
                                {!! Form::file('check', ['class' => '', 'required' => 'required', 'required' => 'required' ]) !!}
                            </label>
                        </div>
                        {!! Form::submit('Submit', ['id'=>'submitBtn', 'class' => 'btn btn-success btn-block']) !!}
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
