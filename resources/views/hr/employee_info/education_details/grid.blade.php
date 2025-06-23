<td colspan="11">
    <table class="show-table">
        <thead>
            <tr>
                <th>SL:</th>
                <th>Degree Title</th>
                <th>Group</th>
                <th>Institution Name</th>
                <th>Result</th>
                <th>Marks</th>
                <th>CGPA</th>
                <th>Batch</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employeeeducation as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->degree }}</td>
                <td>{{ $item->group }}</td>
                <td>{{ $item->institution }}</td>
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
                <td>{{ $item->batch }}</td>
                <td>
                    <div style="display: flex;gap:5px;">
                        @if(auth()->user()->hasPermission(79))
                            <button class="open-modal" data-modal-id="editModal" id="edit" data-id="{{ $item->id }}" data-form-id="form_{{ $item->id }}"><i class="fas fa-edit"></i></button>
                        @endif
                        @if(auth()->user()->hasPermission(80))
                            <button data-id="{{ $item->id }}" id="delete"><i class="fas fa-trash"></i></button>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</td>