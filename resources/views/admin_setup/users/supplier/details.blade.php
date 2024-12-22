<ul>
    {{-- General Info Part Starts --}}
    <li data-id="1">General Information</li>
    <div class="general">
        <div class="details-head">
            <div class="image-round">
            <img src="{{ asset('storage/profiles/' . ($supplier->image ? $supplier->image : ($supplier->gender == 'female' ? 'female.png' : 'male.png'))) }}" alt="" height="100px" width="100px">
            </div> 
            <div class="highlight">
                <span class="name"> {{$supplier->user_name}} </span><br>
                <div class="designation">{{$supplier->Withs->tran_with_name}}</div>
            </div>   
        </div>
        <div class="details-table" style="">
            <div class="rows each-row"> 
                <div class="c-2 bold">Name</div>
                <div class="c-4">{{$supplier->user_name}}</div>
                <div class="c-2 bold">Work Location</div>
                <div class="c-4">{{$supplier->location->upazila}}, {{$supplier->location->district}}, {{$supplier->location->division}} </div>
            </div>
            <div class="rows each-row"> 
                <div class="c-2 bold">Gender</div>
                <div class="c-4">{{$supplier->gender}}</div>
                <div class="c-2 bold">Supplier Type</div>
                <div class="c-4">{{$supplier->Withs->tran_with_name}}</div>
            </div>
            <div class="rows each-row"> 
                <div class="c-2 bold">Phone No</div>
                <div class="c-4">{{$supplier->user_phone}}</div>
                <div class="c-2 bold">Email</div>
                <div class="c-4">{{$supplier->user_email}}</div>
            </div>
            <div class="rows each-row"> 
                <div class="c-2 bold">Address</div>
                <div class="c-10">{{$supplier->address}}</div>
            </div>
        </div>
    </div>


    {{-- Transaction info part starts --}}
    <li data-id="4">Transaction Information</li>
    <div class="transaction">
        <div class="transaction" style="overflow-x:auto;">
            <table class="show-table">
                <thead>
                    <caption class="caption">Transaction Details</caption>
                    <tr>
                        <th>SL:</th>
                        <th>Id</th>
                        <th>Type</th>
                        <th>Total</th>
                        <th>Discount</th>
                        <th>Balance</th>
                        <th>Advance</th>
                        <th>Due</th>
                        <th>Due Collect</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->tran_id }}</td>
                            <td>{{ $item->tran_type }}</td>
                            <td>{{ $item->bill_amount }}</td>
                            <td>{{ $item->discount }}</td>
                            <td>{{ $item->net_amount }}</td>
                            <td>{{ $item->receive }} {{ $item->payment }}</td>
                            <td>{{ $item->due }}</td>
                            <td>{{ $item->due_col !== null ? $item->due_col : '0' }}</td>
                            <td>{{ date('Y-m-d', strtotime($item->tran_date)) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</ul>