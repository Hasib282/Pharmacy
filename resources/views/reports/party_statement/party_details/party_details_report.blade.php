@php
    $searchValue = request()->query('search');
    $searchOptionValue = request()->query('searchOption');
    $searchTypeValue = request()->query('type');
    $startDateValue = request()->query('startDate');
    $endDateValue = request()->query('endDate');
@endphp


@extends('layouts.layout')
@section('main-content')
    <div class="add-search">
        <div class="rows">
            <div class="c-2">
                <label for="startDate">Start Date</label>
                <input type="date" name="startDate" id="startDate" class="form-input" value="{{ $startDateValue ? $startDateValue : date('Y-m-d') }}">
            </div>
            <div class="c-2" >
                <label for="endDate">End Date</label>
                <input type="date" name="endDate" id="endDate" class="form-input" value="{{ $endDateValue ? $endDateValue : date('Y-m-d') }}">
            </div>
            <div class="c-2">
                <label for="typeOption">Transaction Type</label>
                <select name="typeOption" id="typeOption">
                    <option value="">Select type</option>
                    <option value="Receive" {{ $searchTypeValue == 'Receive' ? 'selected' : '' }}>Receive</option>
                    <option value="Payment" {{ $searchTypeValue == 'Payment' ? 'selected' : '' }}>Payment</option>
                </select>
            </div>
            <div class="c-2">
                <label for="searchOption">Search Option</label>
                <select name="searchOption" id="searchOption">
                    <option value="1" {{ $searchOptionValue == '1' ? 'selected' : '' }}>Transaction User</option>
                    <option value="2" {{ $searchOptionValue == '2' ? 'selected' : '' }}>Transaction Id</option>
                </select>
            </div>
            <div class="c-3">
                <label for="search">Search Here</label>
                <input type="text" name="search" id="search" class="form-input" placeholder="Search here..."
                    value="{{ $searchValue ? $searchValue : '' }}" style="width: 100%; margin: 0;">
            </div>
            <div class="c-1">
                <div class="print-button">
                    <button class="btn btn-primary waves-effect waves-light" onclick="window.print()"><i class="fa-solid fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </div>


    <!-- table show -->
    <div class="load-data" style="overflow-x:auto;">
        <table class="show-table">
            <caption class="caption">Party Details Report</caption>
            <thead>
                <tr>
                    <td>Party Details Report</td>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($groupedTransactions as $key => $transaction)
                    <tr>
                        <td>
                            <table>
                                <thead>
                                    <caption class="sub-caption">{{$key}}</caption>
                                    <tr>
                                        <th>Transaction Id</th>
                                        <th>Tran User</th>
                                        <th>Bill Amount</th>
                                        <th>Discount</th>
                                        <th>Net Amount</th>
                                        <th>Advance</th>
                                        <th>Party Discount</th>
                                        <th>Party Payment</th>
                                        <th>Net Col</th>
                                        <th>Balance / Due</th>
                                        <th>Batch ID</th>
                                        <th>Transaction Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaction as $keys =>$tran)
                                    <tr>
                                        <td>{{$tran->tran_id}}</td>
                                        <td>{{$tran->tran_type == 4 ? $tran->Bank->name : $tran->User->user_name}}</td>
                                        <td>{{$tran->bill_amount}}</td>
                                        <td>{{$tran->main_discount}}</td>
                                        <td>{{$tran->net_amount}}</td>
                                        <td>{{$tran->tran_method == "Receive" ? $tran->main_receive : $tran->main_payment }}</td>
                                        <td>{{$tran->due_discount}}</td>
                                        <td>{{$tran->tran_method == "Receive" ? $tran->due_receive : $tran->due_payment}}</td>
                                        <td>{{$tran->due_receive + $tran->due_payment + $tran->due_discount}}</td>
                                        <td>
                                            @php
                                            $due = $tran->bill_amount - $tran->main_discount - $tran->main_receive - $tran->main_payment - $tran->due_discount - $tran->due_receive - $tran->due_payment
                                            @endphp
                                            {{$due}}
                                        </td>
                                        <td>{{$tran->batch_id}}</td>
                                        <td>{{date('Y-m-d', strtotime($tran->tran_date))}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach  --}}
            </tbody>
            <tfoot></tfoot>
        </table>
        
        <div class="center paginate" id="paginate"></div>
    </div>


    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax/report/party_statement/party_details_report.js') }}"></script>
@endsection
