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
                    {{-- options will be display dynamically --}}
                </select>
            </div>
            <div class="c-2">
                <label for="searchOption">Search Option</label>
                <select name="searchOption" id="searchOption">
                    <option value="1" {{ $searchOptionValue == '1' ? 'selected' : '' }}>Groupe</option>
                    <option value="2" {{ $searchOptionValue == '2' ? 'selected' : '' }}>Product / Service</option>
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
        <hr>
        <table class="show-table">
            <thead>
                <caption class="caption">Accounts Summary Statement</caption>
            </thead>
        </table>
        
        {{-- <table class="show-table">
            <tfoot>
                <tr>
                    <td style="text-align: right;">Opening Balance</td>
                    <td style="text-align: right; width:12%;">{{ number_format($opening->total_receive - $opening->total_payment, 0, '.', ',') }}</td>
                </tr>
            </tfoot>
        </table>

        @php
            $grandReceive = 0;
            $grandPayment = 0;
        @endphp --}}

        {{-- general account part start --}}
        {{-- @isset($general)
            @if($general->isNotEmpty())
                <table class="show-table">
                    <thead>
                        <caption class="sub-caption">General Account</caption>
                        <tr>
                            <th style="width: 4%;">SL:</th>
                            <th style="text-align: center; width:70%;">Groupe</th>
                            <th style="text-align: center; width:12%;">Receive</th>
                            <th style="text-align: center; width:12%;">Payment</th>
                        </tr>
                    </thead>
                    @php
                        $lastGroupeId = null;
                    @endphp
                    <tbody>
                        @foreach ($general as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->Groupe->tran_groupe_name }}</td>
                                <td style="text-align: right">{{ number_format($item->total_receive, 0, '.', ',') }}</td>
                                <td style="text-align: right">{{ number_format($item->total_payment, 0, '.', ',') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            @php
                                $totalReceive = 0;
                                $totalPayment = 0;
                            @endphp
                            @foreach ($general as $key => $item)
                                @php
                                    $totalReceive += $item->total_receive;
                                    $totalPayment += $item->total_payment;
                                @endphp
                            @endforeach
                            @php
                                $grandReceive += $totalReceive;
                                $grandPayment += $totalPayment;
                            @endphp
                            <td colspan="2" style="text-align: right">Sub Total:</td>
                            <td style="text-align: right">{{ number_format($totalReceive, 0, '.', ',') }}</td>
                            <td style="text-align: right">{{ number_format($totalPayment, 0, '.', ',') }}</td>
                        </tr>     
                    </tfoot> 
                </table>
            @endif
        @endisset --}}

        {{-- Party Payment part start --}}
        {{-- @isset($party)
            @if($party->isNotEmpty())
                <table class="show-table">
                    <thead>
                        <caption class="sub-caption">Party Payments</caption>
                        <tr>
                            <th style="width: 4%;">SL:</th>
                            <th style="text-align: center; width:70%;">Groupe</th>
                            <th style="text-align: center; width:12%;">Receive</th>
                            <th style="text-align: center; width:12%;">Payment</th>
                        </tr>
                    </thead>
                    @php
                        $lastGroupeId = null;
                    @endphp
                    <tbody>
                        @foreach ($party as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->Groupe->tran_groupe_name }}</td>
                                <td style="text-align: right">{{ number_format($item->total_receive, 0, '.', ',') }}</td>
                                <td style="text-align: right">{{ number_format($item->total_payment, 0, '.', ',') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            @php
                                $totalReceive = 0;
                                $totalPayment = 0;
                            @endphp
                            @foreach ($party as $key => $item)
                                @php
                                    $totalReceive += $item->total_receive;
                                    $totalPayment += $item->total_payment;
                                @endphp
                            @endforeach
                            @php
                                $grandReceive += $totalReceive;
                                $grandPayment += $totalPayment;
                            @endphp
                            <td colspan="2" style="text-align: right">Sub Total:</td>
                            <td style="text-align: right">{{ number_format($totalReceive, 0, '.', ',') }}</td>
                            <td style="text-align: right">{{ number_format($totalPayment, 0, '.', ',') }}</td>
                        </tr>     
                    </tfoot> 
                </table>
            @endif
        @endisset --}}


        {{-- Payroll part start --}}
        {{-- @isset($payroll)
            @if($payroll->isNotEmpty())
                <table class="show-table">
                    <thead>
                        <caption class="sub-caption">Payroll</caption>
                        <tr>
                            <th style="width: 4%;">SL:</th>
                            <th style="text-align: center; width:70%;">Groupe</th>
                            <th style="text-align: center; width:12%;">Receive</th>
                            <th style="text-align: center; width:12%;">Payment</th>
                        </tr>
                    </thead>
                    @php
                        $lastGroupeId = null;
                    @endphp
                    <tbody>
                        @foreach ($payroll as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->Groupe->tran_groupe_name }}</td>
                                <td style="text-align: right">{{ number_format($item->total_receive, 0, '.', ',') }}</td>
                                <td style="text-align: right">{{ number_format($item->total_payment, 0, '.', ',') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            @php
                                $totalReceive = 0;
                                $totalPayment = 0;
                            @endphp
                            @foreach ($payroll as $key => $item)
                                @php
                                    $totalReceive += $item->total_receive;
                                    $totalPayment += $item->total_payment;
                                @endphp
                            @endforeach
                            @php
                                $grandReceive += $totalReceive;
                                $grandPayment += $totalPayment;
                            @endphp
                            <td colspan="2" style="text-align: right">Sub Total:</td>
                            <td style="text-align: right">{{ number_format($totalReceive, 0, '.', ',') }}</td>
                            <td style="text-align: right">{{ number_format($totalPayment, 0, '.', ',') }}</td>
                        </tr>     
                    </tfoot> 
                </table>
            @endif
        @endisset --}}


        {{-- Bank Transaction part start --}}
        {{-- @isset($bank)
            @if($bank->isNotEmpty())
                <table class="show-table">
                    <thead>
                        <caption class="sub-caption">Bank</caption>
                        <tr>
                            <th style="width: 4%;">SL:</th>
                            <th style="text-align: center; width:70%;">Groupe</th>
                            <th style="text-align: center; width:12%;">Receive</th>
                            <th style="text-align: center; width:12%;">Payment</th>
                        </tr>
                    </thead>
                    @php
                        $lastGroupeId = null;
                    @endphp
                    <tbody>
                        @foreach ($bank as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->Groupe->tran_groupe_name }}</td>
                                <td style="text-align: right">{{ number_format($item->total_receive, 0, '.', ',') }}</td>
                                <td style="text-align: right">{{ number_format($item->total_payment, 0, '.', ',') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            @php
                                $totalReceive = 0;
                                $totalPayment = 0;
                            @endphp
                            @foreach ($bank as $key => $item)
                                @php
                                    $totalReceive += $item->total_receive;
                                    $totalPayment += $item->total_payment;
                                @endphp
                            @endforeach
                            @php
                                $grandReceive += $totalReceive;
                                $grandPayment += $totalPayment;
                            @endphp
                            <td colspan="2" style="text-align: right">Sub Total:</td>
                            <td style="text-align: right">{{ number_format($totalReceive, 0, '.', ',') }}</td>
                            <td style="text-align: right">{{ number_format($totalPayment, 0, '.', ',') }}</td>
                        </tr>     
                    </tfoot> 
                </table>
            @endif
        @endisset --}}

        {{-- Inventory part start --}}
        {{-- @isset($inventory)
            @if($inventory->isNotEmpty())
                <table class="show-table">
                    <thead>
                        <caption class="sub-caption">Inventory</caption>
                        <tr>
                            <th style="width: 4%;">SL:</th>
                            <th style="text-align: center; width:70%;">Groupe</th>
                            <th style="text-align: center; width:12%;">Receive</th>
                            <th style="text-align: center; width:12%;">Payment</th>
                        </tr>
                    </thead>
                    @php
                        $lastGroupeId = null;
                    @endphp
                    <tbody>
                        @foreach ($inventory as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->Groupe->tran_groupe_name }}</td>
                                <td style="text-align: right">{{ number_format($item->total_receive, 0, '.', ',') }}</td>
                                <td style="text-align: right">{{ number_format($item->total_payment, 0, '.', ',') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            @php
                                $totalReceive = 0;
                                $totalPayment = 0;
                            @endphp
                            @foreach ($inventory as $key => $item)
                                @php
                                    $totalReceive += $item->total_receive;
                                    $totalPayment += $item->total_payment;
                                @endphp
                            @endforeach
                            @php
                                $grandReceive += $totalReceive;
                                $grandPayment += $totalPayment;
                            @endphp
                            <td colspan="2" style="text-align: right">Sub Total:</td>
                            <td style="text-align: right">{{ number_format($totalReceive, 0, '.', ',') }}</td>
                            <td style="text-align: right">{{ number_format($totalPayment, 0, '.', ',') }}</td>
                        </tr>     
                    </tfoot> 
                </table>
            @endif
        @endisset --}}


        {{-- Pharmacy part start --}}
        {{-- @isset($pharmacy)
            @if($pharmacy->isNotEmpty())
                <table class="show-table">
                    <thead>
                        <caption class="sub-caption">Pharmacy</caption>
                        <tr>
                            <th style="width: 4%;">SL:</th>
                            <th style="text-align: center; width:70%;">Groupe</th>
                            <th style="text-align: center; width:12%;">Receive</th>
                            <th style="text-align: center; width:12%;">Payment</th>
                        </tr>
                    </thead>
                    @php
                        $lastGroupeId = null;
                    @endphp
                    <tbody>
                        @foreach ($pharmacy as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->Groupe->tran_groupe_name }}</td>
                                <td style="text-align: right">{{ number_format($item->total_receive, 0, '.', ',') }}</td>
                                <td style="text-align: right">{{ number_format($item->total_payment, 0, '.', ',') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            @php
                                $totalReceive = 0;
                                $totalPayment = 0;
                            @endphp
                            @foreach ($pharmacy as $key => $item)
                                @php
                                    $totalReceive += $item->total_receive;
                                    $totalPayment += $item->total_payment;
                                @endphp
                            @endforeach
                            @php
                                $grandReceive += $totalReceive;
                                $grandPayment += $totalPayment;
                            @endphp
                            <td colspan="2" style="text-align: right">Sub Total:</td>
                            <td style="text-align: right">{{ number_format($totalReceive, 0, '.', ',') }}</td>
                            <td style="text-align: right">{{ number_format($totalPayment, 0, '.', ',') }}</td>
                        </tr>     
                    </tfoot> 
                </table>
            @endif
        @endisset --}}


        {{-- Mischellaneous part start --}}
        {{-- @isset($miscellaneous)
            @if($miscellaneous->isNotEmpty())
                <table class="show-table">
                    <caption class="sub-caption">Miscellaneous</caption>
                    <thead>
                        <tr>
                            <th style="width: 4%;">SL:</th>
                            <th style="text-align: center; width:70%;">Groupe</th>
                            <th style="text-align: center; width:12%;">Receive</th>
                            <th style="text-align: center; width:12%;">Payment</th>
                        </tr>
                    </thead>
                    @php
                        $lastGroupeId = null;
                    @endphp
                    <tbody>
                        @foreach ($miscellaneous as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->Groupe->tran_groupe_name }}</td>
                                <td style="text-align: right">{{ number_format($item->total_receive, 0, '.', ',') }}</td>
                                <td style="text-align: right">{{ number_format($item->total_payment, 0, '.', ',') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            @php
                                $totalReceive = 0;
                                $totalPayment = 0;
                            @endphp
                            @foreach ($miscellaneous as $key => $item)
                                @php
                                    $totalReceive += $item->total_receive;
                                    $totalPayment += $item->total_payment;
                                @endphp
                            @endforeach
                            @php
                                $grandReceive += $totalReceive;
                                $grandPayment += $totalPayment;
                            @endphp
                            <td colspan="2" style="text-align: right">Sub Total:</td>
                            <td style="text-align: right">{{ number_format($totalReceive, 0, '.', ',') }}</td>
                            <td style="text-align: right">{{ number_format($totalPayment, 0, '.', ',') }}</td>
                        </tr>     
                    </tfoot> 
                </table>
            @endif
        @endisset --}}


        {{-- <table class="show-table">
            <tfoot>
                <tr>
                    <td style="text-align: right;">Grand Total:</td>
                    <td style="text-align: right; width:12%;">{{ number_format($grandReceive, 0, '.', ',') }}</td>
                    <td style="text-align: right; width:12%;">{{ number_format($grandPayment, 0, '.', ',') }}</td>
                </tr>
            </tfoot>
        </table>


        <table class="show-table">
            <tfoot>
                <tr>
                    <td style="text-align: right;">Closing Balance</td>
                    <td style="text-align: right; width:12%;">{{ number_format(($opening->total_receive - $opening->total_payment) + ($grandReceive - $grandPayment), 0, '.', ',') }}</td>
                </tr>
            </tfoot>
        </table> --}}
    </div>


    <!-- ajax part start from here -->
    <script src="{{ asset('js/ajax/report/account_statement/summary_groupe.js') }}"></script>
@endsection
