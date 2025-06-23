<td colspan="11">
    <table class="show-table">
        <thead>
            <tr>
                <th>SL:</th>
                <th>Id</th>
                <th>Name</th>
                <th>Training Title</th>
                <th>Country</th>
                <th>Topic</th>
                <th>Institution Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Training Year</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employeetraining as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->user->user_id }}</td>
                <td>{{ $item->user->user_name }}</td>
                <td>{{ $item->training_title}}</td>
                <td>{{ $item->country }}</td>
                <td>{{ $item->topic }}</td>
                <td>{{ $item->institution_name }}</td>
                <td>{{ $item->start_date }}</td>
                <td>{{ $item->end_date }}</td>
                <td>{{ $item->training_year }}</td>
                <td>
                    <div style="display: flex;gap:5px;">
                        @if(auth()->user()->hasPermission(83))
                            <button class="open-modal" data-modal-id="editModal" id="edit" data-id="{{ $item->id }}"><i
                                class="fas fa-edit"></i></button>
                        @endif
                        @if(auth()->user()->hasPermission(84))
                            <button data-id="{{ $item->id }}" id="delete"><i class="fas fa-trash"></i></button>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</td>