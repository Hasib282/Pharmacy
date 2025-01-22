<td colspan="11">
    <table class="show-table">
        <thead>
            <tr>
                <th>SL:</th>
                <th>Level of Education</th>
                <th>Degree Title</th>
                <th>Group</th>
                <th>Institution Name</th>
                <th>Result</th>
                <th>Marks</th>
                <th>CGPA</th>
                <th>Passing Year</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employeeeducation as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->level_of_education}}</td>
                <td>{{ $item->degree_title }}</td>
                <td>{{ $item->group }}</td>
                <td>{{ $item->institution_name }}</td>
                <td>{{ $item->result }}</td>
                <td>@isset($item->marks)
                    {{ $item->marks }}
                    @else
                    N/A
                    @endisset
                </td>
                <td>@isset($item->cgpa)
                    {{ $item->cgpa }}
                    @else
                    N/A
                    @endisset
                </td>
                <td>{{ $item->passing_year }}</td>
                <td>
                    <div style="display: flex;gap:5px;">
                        {{-- @if(Auth::user()->hasPermissionToRoute('update.employeeEducation')) --}}
                        <button class="open-modal" data-modal-id="editModal" id="edit" data-id="{{ $item->id }}"
                            data-form-id="form_{{ $item->id }}"><i class="fas fa-edit"></i></button>
                        {{-- @endif --}}
                        {{-- @if(Auth::user()->hasPermissionToRoute('delete.employeeEducation')) --}}
                        <button data-id="{{ $item->id }}" id="delete"><i class="fas fa-trash"></i></button>
                        {{-- @endif --}}
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</td>