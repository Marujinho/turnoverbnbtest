@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Transaction Details -
                    <a href="{{ route('transaction.index') }}">previous page</a>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Customer - {{ $transaction_data['user_name'] }}</h5>
                    <h5 class="card-title">Description - {{ $transaction_data['description'] }}</h5>
                    <h5 class="card-title">Amount - {{ $transaction_data['amount'] }}</h5>
                    <h5 class="card-title">Date - {{ $transaction_data['date'] }}</h5>
                    @if($transaction_data['type'] == 'deposit')
                        <img height="250" class="card-img-top" src="{{ asset($transaction_data['check']) }}" >
                    @endif
                </div>

                @if($transaction_data['type'] == 'deposit')
                    @if($transaction_data['authorization_status'] == 'pending')
                        <div class="card-body">
                            {!! Form::open(['route' => ['transaction.authorize', $transaction_data['transaction_id']], 'method'=>'POST', 'onsubmit' => 'disableDoubleClick()']) !!}

                                {!! Form::hidden('authorization', 'authorize') !!}
                                {!! Form::submit('Authorize', ['id'=>'submitBtn1', 'class' => 'btn btn-success btn-block']) !!}

                            {!! Form::close() !!}

                            {!! Form::open(['route' => ['transaction.authorize', $transaction_data['transaction_id']], 'method'=>'POST', 'onsubmit' => 'disableDoubleClick()']) !!}

                                {!! Form::hidden('authorization', 'reject') !!}
                                {!! Form::submit('Reject', ['id'=>'submitBtn2', 'class' => 'btn btn-danger btn-block']) !!}

                            {!! Form::close() !!}
                        </div>
                    @else
                        <div class="card-body">
                            <h3 class="card-title text-center">Transaction  {{ $transaction_data['authorization_status'] }}</h3>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>
function disableDoubleClick()
    {
        var btn1 = document.getElementById('submitBtn1');
        var btn2 = document.getElementById('submitBtn2');
        btn1.disabled = true;
        btn2.disabled = true;

        btn1.value = "please wait...";
        btn2.value = "please wait...";

        return;
    }
</script>

@endsection
