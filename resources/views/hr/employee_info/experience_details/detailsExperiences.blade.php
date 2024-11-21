<table class="show-table">
    <thead>
        <tr>
            <th>SL:</th>
            <th>Id</th>
            <th>Name</th>
            <th>Company Name</th>
            <th>Designation</th>
            <th>Department</th>
            <th>Company Location</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($employeeexperience as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->user->user_id }}</td>
                <td>{{ $item->user->user_name }}</td>
                <td>{{ $item->company_name}}</td>
                <td>{{ $item->designation }}</td>
                <td>{{ $item->department }}</td>
                <td>{{ $item->company_location }}</td>
                <td>{{ $item->start_date }}</td>
                <td>{{ $item->end_date }}</td>
                <td>
                    <div style="display: flex;gap:5px;">
                        {{-- @if(Auth::user()->hasPermissionToRoute('update.employeeExperience')) --}}
                            <button class="open-modal" data-modal-id="editModal" id="edit"
                                data-id="{{ $item->id }}"><i class="fas fa-edit"></i></button>
                        {{-- @endif --}}
                        {{-- @if(Auth::user()->hasPermissionToRoute('delete.employeeExperience')) --}}
                            <button data-id="{{ $item->id }}" id="delete"><i class="fas fa-trash"></i></button>
                        {{-- @endif --}}
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
