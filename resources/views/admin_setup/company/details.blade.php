<ul>
    {{-- General Info Part Starts --}}
    <li data-id="1">General Information</li>
    <div class="general">
        <div class="details-head">
            <div class="image-round">
                <img src="/storage/{{$company->logo !== null ? $company->logo : 'tsbd.png' }}" alt="" height="100px" width="100px">
            </div> 
            <div class="highlight">
                <span class="name"> {{$company->company_name}} </span><br>
                <span> {{$company->company_type ? $company->Type->name : ""}} </span><br>
            </div>   
        </div>
        <div class="details-table" style="">
            <div class="rows each-row"> 
                <div class="c-2 bold">Name</div>
                <div class="c-10">{{$company->company_name}}</div>
            </div>
            <div class="rows each-row">
                <div class="c-2 bold">Email</div>
                <div class="c-10">{{$company->company_email}}</div>
            </div>
            <div class="rows each-row">
                <div class="c-2 bold">Phone No</div>
                <div class="c-10">{{$company->company_phone}}</div>
            </div>
            <div class="rows each-row"> 
                <div class="c-2 bold">Address</div>
                <div class="c-10">{{$company->address}}</div>
            </div>
            <div class="rows each-row"> 
                <div class="c-2 bold">Website</div>
                <div class="c-10">{{$company->website}}</div>
            </div>
            <div class="rows each-row"> 
                <div class="c-2 bold">Domain</div>
                <div class="c-10">{{$company->domain}}</div>
            </div>
        </div>
    </div>
</ul>