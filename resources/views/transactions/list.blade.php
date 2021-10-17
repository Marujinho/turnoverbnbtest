@extends('layouts.app')

@section('content')
@include('components.messages')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if($user_data['role'] == 'customer')
                @include('components.balance')
            @endif
            <div class="card">
                <div class="card-header">Transactions -
                    <a href="{{ route('home') }}">previous page</a>
                </div>

                <div class="card-content">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>TYPE</th>
                                    <th>AMOUNT</th>
                                    <th>DESCRIPTION</th>
                                    <th>STATUS</th>
                                    <th>DATE</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($transactions as $transaction)
                                  <tr>
                                      <td>{{ $transaction->type }}</td>
                                      <td>{{ $transaction->amount }}</td>
                                      <td>{{ $transaction->description }}</td>
                                      <td>{{ $transaction->authorization_status }}</td>
                                      <td>{{ $transaction->created_at }}</td>
                                      @if($user_data['role'] == 'admin')
                                          <td>
                                              <a href="{{ route('transaction.show', $transaction->id) }}">
                                                  <button class="btn btn-info">DETAILS</button>
                                              </a>
                                          </td>
                                      @endif
                                  </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
