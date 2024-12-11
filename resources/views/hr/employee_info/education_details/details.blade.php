<ul>
    @foreach($personaldetail as $item)
        @if ($loop->first)
        <li data-id="1.1">Personal Details</li>
        <div class="personal">
            <div class="details-head">
                <div class="image-round">
                    <img src="/storage/profiles/{{ $item->image !== null ? $item->image : ($item->gender == 'female' ? 'female.png' : 'male.png') }}" alt="" height="100px" width="100px">
                </div> 
                <div class="highlight">
                    <span class="name"> {{$item->name}} </span><br>
                </div>   
            </div>
            
            <div class="details-table" style="">
                <div class="rows each-row">
                    <div class="c-2 bold">Name</div> 
                    <div class="c-4">{{ $item->name }}</div>
                    <div class="c-2 bold">Father's Name</div> 
                    <div class="c-4">@isset($item->fathers_name)
                                        {{ $item->fathers_name }}
                                    @else
                                        Father's Name unavailable
                                    @endisset</div>
                </div>
                <div class="rows each-row">
                    <div class="c-2 bold">Mother's Name</div> 
                    <div class="c-4">@isset($item->mothers_name)
                                        {{ $item->mothers_name }}
                                    @else
                                        Mother's Name unavailable
                                    @endisset</div>
                    <div class="c-2 bold">Date of Birth</div> 
                    <div class="c-4">{{ $item->date_of_birth }}</div>
                </div>
                <div class="rows each-row">
                    <div class="c-2 bold">Gender</div> 
                    <div class="c-4">{{ $item->gender }}</div>
                    <div class="c-2 bold">Religion</div> 
                    <div class="c-4">{{ $item->religion }}</div>
                </div>
                <div class="rows each-row">
                    <div class="c-2 bold">Marital Status</div> 
                    <div class="c-4">{{ $item->marital_status }}</div>
                    <div class="c-2 bold">Nationality</div> 
                    <div class="c-4">@isset($item->nationality)
                                        {{ $item->nationality }}
                                    @else
                                        Nationality unavailable
                                    @endisset</div>
                </div>
                <div class="rows each-row">
                <div class="c-2 bold">Nid No.</div> 
                    <div class="c-4">@isset($item->nid_no)
                                        {{ $item->nid_no }}
                                    @else
                                        Nid No. unavailable
                                    @endisset</div>
                    <div class="c-2 bold">Phone Number</div> 
                    <div class="c-4">{{ $item->phn_no }}</div>
                </div>
                <div class="rows each-row">
                    <div class="c-2 bold">Blood Group</div> 
                    <div class="c-4">@isset($item->blood_group)
                                        {{ $item->blood_group }}
                                    @else
                                        Blood Group unavailable
                                    @endisset</div>
                    <div class="c-2 bold">Email</div> 
                    <div class="c-4">{{ $item->email }}</div>
                </div>
                <div class="rows each-row">
                <div class="c-2 bold">Work Location</div> 
                    <div class="c-4">{{ $item->Location->upazila }}</div>
                    <div class="c-2 bold">Address</div> 
                    <div class="c-4">{{ $item->address }}</div>
                </div>
            </div>
        </div>
        
    

        <li data-id="1.2">Education Details</li> 
        @endif
    @endforeach 


    @if($employeeeducation->isEmpty())
        <div class="education">
            <div class="details-table" style="">
                <div class="row each-row"> 
                    <div>No Education Details Available!</div>
                </div>
            </div>
        </div>
    @else

        @foreach($employeeeducation as $item)
        <div class="education">
            <div class="details-table" style="">
                <div class="row each-row">
                    <div class="c-2 bold">Level of Education</div> 
                    <div class="c-4">{{ $item->level_of_education }}</div>
                    <div class="c-2 bold">Degree Title</div> 
                    <div class="c-4">{{ $item->degree_title }}</div>
                </div>
                <div class="row each-row">
                    <div class="c-2 bold">Group</div> 
                    <div class="c-4">@isset($item->group)
                                            {{ $item->group }}
                                        @else
                                            Group unavailable
                                        @endisset</div>
                    <div class="c-2 bold">Institution Name</div> 
                    <div class="c-4">{{ $item->institution_name }}</div>
                </div>
                <div class="row each-row">
                    <div class="c-2 bold">Result</div> 
                    <div class="c-4">{{ $item->result }}</div>
                    @if($item->scale !== null)
                        <div class="c-2 bold">Scale</div>
                        <div class="c-4">{{ $item->scale }}</div>
                    @endif
                    @if($item->marks !== null)
                        <div class="c-2 bold">Marks</div>
                        <div class="c-4">{{ $item->marks }}</div>
                    @endif
                </div>
                <div class="row each-row">
                    @if($item->cgpa !== null)
                        <div class="c-2 bold">CGPA</div>
                        <div class="c-4">{{ $item->cgpa }}</div>
                    @endif
                    <div class="c-2 bold">Batch</div> 
                    <div class="c-4">@isset($item->batch)
                                            {{ $item->batch }}
                                        @else
                                            Batch unavailable
                                        @endisset</div>
                    @if($item->marks !== null)
                        <div class="c-2 bold">Passing Year</div> 
                        <div class="c-4">{{ $item->passing_year }}</div>
                    @endif             
                </div>
                @if($item->cgpa !== null)
                <div class="row each-row">
                        <div class="c-2 bold">Passing Year</div> 
                        <div class="c-4">{{ $item->passing_year }}</div>
                </div>
                @endif
            </div>
        </div>  
        @endforeach 
    @endif
</ul
