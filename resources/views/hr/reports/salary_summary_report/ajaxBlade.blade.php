@section('style')
    <style>
        .add-search {
            margin: 15px 10px;
        }

        #search {
            width: 100%;
            margin: 0;
        }

        .rows {
            width: 60%;
            justify-content: center;
            /* Center horizontally */
            align-items: center;
            /* Center vertically */
            display: flex;
            flex-wrap: wrap;
        }

        @media print {
            .sidenav {
                display: none;
            }

            @page {
                size: auto;
                /* auto is the current printer page size */
                margin: 0;
                /* margin you want for the content */
            }

            html,
            body {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }

            body * {
                visibility: hidden;
            }

            .show-table,
            .show-table * {
                visibility: visible;
            }

            .show-table {
                position: absolute;
                left: 0;
                top: 0;
                width: 100vw;
                /* Full viewport width */
                height: auto;
                border-collapse: collapse;
                border: 1px solid #000;
            }

            .show-table th,
            .show-table td {
                border: 1px solid #000;
                padding: 8px;
            }

            .caption {
                text-align: center;
                font-weight: bold;
                font-size: 1.5em;
                margin-bottom: 10px;
            }

            .paginate {
                display: none;
            }

            .print-button {
                display: none;
            }
        }
    </style>
@endsection


@php
    $searchValue = request()->query('search');
    $monthValue = request()->query('month');
    $yearValue = request()->query('year');
@endphp


<div class="add-search">
    <div class="center">
        <div class="rows">
            <div class="c-2">
                <label for="month">Month</label>
                <select name="month" id="month">
                    <option value="01" {{ date('m')=='01' ? 'selected' : '' }}>January</option>
                    <option value="02" {{ date('m')=='02' ? 'selected' : '' }}>February</option>
                    <option value="03" {{ date('m')=='03' ? 'selected' : '' }}>March</option>
                    <option value="04" {{ date('m')=='04' ? 'selected' : '' }}>April</option>
                    <option value="05" {{ date('m')=='05' ? 'selected' : '' }}>May</option>
                    <option value="06" {{ date('m')=='06' ? 'selected' : '' }}>June</option>
                    <option value="07" {{ date('m')=='07' ? 'selected' : '' }}>July</option>
                    <option value="08" {{ date('m')=='08' ? 'selected' : '' }}>August</option>
                    <option value="09" {{ date('m')=='09' ? 'selected' : '' }}>September</option>
                    <option value="10" {{ date('m')=='10' ? 'selected' : '' }}>October</option>
                    <option value="11" {{ date('m')=='11' ? 'selected' : '' }}>November</option>
                    <option value="12" {{ date('m')=='12' ? 'selected' : '' }}>December</option>
                </select>
            </div>
            <div class="c-1">
                <label for="year">Year</label>
                <select name="year" id="year">
                    @for ($year = date('Y'); $year >= 2000; $year--)
                    <option value="{{ $year }}">{{ $year }}</option>
                    @endfor
                </select>
            </div>
            <div class="c-6">
                <label for="search">Search</label>
                <input type="text" name="search" id="search" class="form-input" placeholder="Search Employee here..."
                    value="{{ $searchValue ? $searchValue : '' }}">
            </div>
        </div>
        <div class="print-button">
            <button onclick="window.print()" class="btn-blue"> <i class="fa-solid fa-print"></i> Print</button>
        </div>
    </div>
</div>

<!-- table show -->
<div class="load-data" style="overflow-x:auto;">
    <table class="show-table">
        <caption class="caption">Salary Report</caption>
        <thead>
            <tr>
                <th>SL:</th>
                <th>Id</th>
                <th>Name</th>
                <th>Salary Amount</th>
                <th>Process Date</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot></tfoot>
    </table>

    <div class="center paginate" id="paginate"></div>
</div>

<!-- ajax part start from here -->
<script src="{{ asset('js/ajax/hr/report/salary_summary_report.js') }}"></script>