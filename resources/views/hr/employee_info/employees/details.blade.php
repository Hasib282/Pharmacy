@if(!$employee && !$employee->personalDetail && !$education->isNotEmpty() && !$training->isNotEmpty() && !$experience->isNotEmpty() && !$employee->organizationDetail)
    <div class="details-table">
        <div class="rows each-row"> 
            <div class="c-12 text-center bold">Employee details do not exist.</div>
        </div>
    </div>
@else

<ul>
    {{-- Personal Details Part Starts --}}
    <li data-id="1.1">Personal Details</li>
    <div class="personal">
        <div class="details-head">
            <div class="image-round">
                <img src="{{ rtrim(env('API_URL'), '/api') }}/storage/profiles/{{ $employee->image !== null ? $employee->image : ($employee->gender == 'female' ? 'female.png' : 'male.png') }}" alt="" height="100px" width="100px">
            </div> 
            <div class="highlight">
                <span class="name"> {{$employee->user_name}} </span><br>
                
            </div>   
        </div>
        <div class="details-table" style="">
            <div class="rows each-row"> 
                <div class="c-2 bold">Name</div>
                <div class="c-4">{{$employee->user_name}}</div>
                <div class="c-2 bold">Father's Name</div>
                <div class="c-4">@isset($employee->personalDetail->fathers_name)
                                    {{ $employee->personalDetail->fathers_name }}
                                @else
                                    Father's Name unavailable
                                @endisset</div>
            </div>
            <div class="rows each-row"> 
                <div class="c-2 bold">Mother's Name</div>
                <div class="c-4">@isset($employee->personalDetail->mothers_name)
                                    {{ $employee->personalDetail->mothers_name }}
                                @else
                                    Mother's Name unavailable
                                @endisset</div>
                <div class="c-2 bold">DOB</div>
                <div class="c-4">{{$employee->personalDetail->date_of_birth}}</div>
            </div>
            <div class="rows each-row"> 
                <div class="c-2 bold">Gender</div>
                <div class="c-4">{{$employee->personalDetail->gender}}</div>
                <div class="c-2 bold">Religion</div>
                <div class="c-4">{{ $employee->personalDetail->religion}}</div>
            </div>
            <div class="rows each-row"> 
                <div class="c-2 bold">Marital Status</div>
                <div class="c-4">{{$employee->personalDetail->marital_status}}</div>
                <div class="c-2 bold">Nationality</div>
                <div class="c-4">@isset($employee->personalDetail->nationality)
                                    {{ $employee->personalDetail->nationality }}
                                @else
                                    Nationality unavailable
                                @endisset</div>
            </div>
            <div class="rows each-row">
                <div class="c-2 bold">Phone Number</div> 
                <div class="c-4 ">{{ $employee->personalDetail->phn_no }}</div>
                <div class="c-2 bold">Nid No.</div> 
                <div class="c-4 ">@isset($employee->personalDetail->nid_no)
                                    {{ $employee->personalDetail->nid_no }}
                                @else
                                    Nid No. unavailable
                                @endisset</div>
                
            </div>
            <div class="rows each-row">
                <div class="c-2 bold">Blood Group</div> 
                <div class="c-4 ">@isset($employee->personalDetail->blood_group)
                                    {{ $employee->personalDetail->blood_group }}
                                @else
                                    Blood Group unavailable
                                @endisset</div>
                <div class="c-2 bold">Email</div> 
                <div class="c-4 ">{{ $employee->personalDetail->email }}</div>
            </div>
            <div class="rows each-row">
                <div class="c-2 bold">Address</div> 
                <div class="c-4 ">{{ $employee->personalDetail->address }}</div>
            </div>
        </div>
        </div>
    </div>


    <li data-id="1.2">Education Details</li>
    @if($education->isNotEmpty())
        @foreach($education as $employees)
        {{-- Education Details part starts --}}
        <div class="education">
            <div class="details-table" style="">
            <div class="row each-row">
                    <div class="c-2 bold">Level of Education</div> 
                    <div class="c-4">{{ $employees->level_of_education }}</div>
                    <div class="c-2 bold">Degree Title</div> 
                    <div class="c-4">{{ $employees->degree_title }}</div>
                </div>
                <div class="row each-row">
                    <div class="c-2 bold">Group</div> 
                    <div class="c-4">@isset($employees->group)
                                            {{ $employees->group }}
                                        @else
                                            Group unavailable
                                        @endisset</div>
                    <div class="c-2 bold">Institution Name</div> 
                    <div class="c-4">{{ $employees->institution_name }}</div>
                </div>
                <div class="row each-row">
                    <div class="c-2 bold">Result</div> 
                    <div class="c-4">{{ $employees->result }}</div>
                    @if($employees->scale !== null)
                        <div class="c-2 bold">Scale</div>
                        <div class="c-4">{{ $employees->scale }}</div>
                    @endif
                    @if($employees->marks !== null)
                        <div class="c-2 bold">Marks</div>
                        <div class="c-4">{{ $employees->marks }}</div>
                    @endif
                </div>
                <div class="row each-row">
                    @if($employees->cgpa !== null)
                        <div class="c-2 bold">CGPA</div>
                        <div class="c-4">{{ $employees->cgpa }}</div>
                    @endif
                    <div class="c-2 bold">Batch</div> 
                    <div class="c-4">@isset($employees->batch)
                                            {{ $employees->batch }}
                                        @else
                                            Batch unavailable
                                        @endisset</div>
                    @if($employees->marks !== null)
                        <div class="c-2 bold">Passing Year</div> 
                        <div class="c-4">{{ $employees->passing_year }}</div>
                    @endif             
                </div>
                @if($employees->cgpa !== null)
                <div class="row each-row">
                        <div class="c-2 bold">Passing Year</div> 
                        <div class="c-4">{{ $employees->passing_year }}</div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    @else
    <div class="education">
        <div class="details-table" style="">
            <div class="rows each-row"> 
                <div>No Education Details Available!</div>
            </div>
        </div>
    </div>
    @endif


    {{-- Training Details part starts --}}
    <li data-id="1.3">Training Details</li>
    @if($training->isNotEmpty())
        @foreach($training as $employees)
        <div class="training">
            <div class="details-table" style="">
                <div class="rows each-row"> 
                    <div class="c-2 bold">Training Title</div>
                    <div class="c-4">{{$employees->training_title}}</div>
                    <div class="c-2 bold">Country</div>
                    <div class="c-4">@isset($employees->country)
                                            {{ $employees->country }}
                                        @else
                                            Country unavailable
                                        @endisset</div>
                </div>
                <div class="rows each-row"> 
                    <div class="c-2 bold">Topic</div>
                    <div class="c-4">{{$employees->topic}}</div>
                    <div class="c-2 bold">Institution Name</div>
                    <div class="c-4">{{$employees->institution_name}}</div>
                </div>
                <div class="rows each-row"> 
                    <div class="c-2 bold">Start Date</div>
                    <div class="c-4">@isset($employees->start_date)
                                            {{ $employees->start_date }}
                                        @else
                                            Start date unavailable
                                        @endisset</div>
                    <div class="c-2 bold">End Date</div>
                    <div class="c-4">@isset($employees->end_date)
                                            {{ $employees->end_date }}
                                        @else
                                            End date unavailable
                                        @endisset</div>
                </div>
                <div class="rows each-row"> 
                    <div class="c-2 bold">Training Year</div>
                    <div class="c-4">{{$employees->training_year}}</div>
                </div>
            </div>
        </div>
        @endforeach
    @else
    <div class="training">
        <div class="details-table" style="">
            <div class="rows each-row"> 
                <div>No Training Details Available!</div>
            </div>
        </div>
    </div>
    @endif


    
    {{-- Experience Details part starts --}}
    <li data-id="1.4">Experience Details</li>
    @if($experience->isNotEmpty())
        @foreach($experience as $employees)
        <div class="experience">
            <div class="details-table" style="">
                <div class="rows each-row"> 
                    <div class="c-2 bold">Company Name</div>
                    <div class="c-4">{{$employees->company_name}}</div>
                    <div class="c-2 bold">Designation</div>
                    <div class="c-4">{{$employees->designation}}</div>
                </div>
                <div class="rows each-row"> 
                    <div class="c-2 bold">Start Date</div>
                    <div class="c-4">@isset($employees->start_date)
                                        {{ $employees->start_date }}
                                    @else
                                        Start date unavailable
                                    @endisset</div>
                    <div class="c-2 bold">End Date</div>
                    <div class="c-4">@isset($employees->end_date)
                                        {{ $employees->end_date }}
                                    @else
                                        End date unavailable
                                    @endisset</div>
                </div>
                <div class="rows each-row"> 
                    <div class="c-2 bold">Department</div>
                    <div class="c-4">{{$employees->department}}</div>
                    <div class="c-2 bold">Company Location</div>
                    <div class="c-4">{{$employees->company_location}}</div>
                </div>
            </div>
        </div>
        @endforeach
    @else
    <div class="experience">
        <div class="details-table" style="">
            <div class="rows each-row"> 
                <div>No Experience Details Available!</div>
            </div>
        </div>
    </div>
    @endif


    {{-- Organization Details part starts --}}
    <li data-id="1.5">Organization Details</li>
    @isset($employee->organizationDetail)
    <div class="organization">
        <div class="details-table" style="">
            <div class="rows each-row"> 
                <div class="c-2 bold">Joining Date</div>
                <div class="c-4">{{$employee->organizationDetail->joining_date}}</div>
                <div class="c-2 bold">Joining Location</div>
                <div class="c-4">{{$employee->organizationDetail->Location->upazila}}</div>
            </div>
            <div class="rows each-row"> 
                <div class="c-2 bold">Department</div>
                <div class="c-4">{{$employee->organizationDetail->Department->dept_name}}</div>
                <div class="c-2 bold">Designation</div>
                <div class="c-4">{{$employee->organizationDetail->Designation->designation}}</div>
            </div>
        </div>
    </div>
    @else
    <div class="organization">
        <div class="details-table" style="">
            <div class="rows each-row"> 
                <div>No Organization Details Available!</div>
            </div>
        </div>
    </div>
    @endif

    {{-- Payroll details part starts --}}
    <li data-id="1.6">Payroll Details</li>
    <div class="payroll">
        <table class="show-table">
            <thead>
                <tr>
                    <th>Income Description</th>
                    <th>Income Rate</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payroll as $pay)
                    <tr>
                        <td>{{ $pay->Head->tran_head_name }}</td>
                        <td>{{ $pay->amount }} Tk.</td>
                    </tr>   
                @endforeach
            </tbody>
        </table>
    </div>
@endif
</ul>