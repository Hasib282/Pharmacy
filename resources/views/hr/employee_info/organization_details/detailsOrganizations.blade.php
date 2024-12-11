<td colspan="11">
    <table class="show-table">
        <thead>
            <tr>
                <th>SL:</th>
                <th>Id</th>
                <th>Name</th>
                <th>Joining Date</th>
                <th>Joining Location</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($employeeorganization as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->user->user_id }}</td>
                    <td>{{ $item->user->user_name }}</td>
                    <td>{{ $item->joining_date }}</td>
                    <td>{{ $item->Location->upazila }}</td>
                    <td>{{ $item->Department->dept_name }}</td>
                    <td>{{ $item->Designation->designation }}</td>
                    <td>
                        <div style="display: flex;gap:5px;">
                            {{-- @if(Auth::user()->hasPermissionToRoute('update.employeeOrganization')) --}}
                                <button class="open-modal" data-modal-id="editModal" id="edit"
                                    data-id="{{ $item->id }}"><i class="fas fa-edit"></i></button>
                            {{-- @endif --}}
                            {{-- @if(Auth::user()->hasPermissionToRoute('delete.employeeOrganization')) --}}
                                <button data-id="{{ $item->id }}" id="delete"><i class="fas fa-trash"></i></button>
                            {{-- @endif --}}
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</td>