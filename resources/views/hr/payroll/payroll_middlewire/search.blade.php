<table class="show-table">
    <caption class="caption">Additional Payroll Middlewire</caption>
    <thead>
        <tr>
            <th>SL:</th>
            <th>Employee Id</th>
            <th>Payroll Category</th>
            <th>Amount</th>
            <th>Month</th>
            <th>Year</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php
            $lastEmpId = null;
        @endphp

        @foreach ($payroll as $key => $item)
            <tr>
                <td>{{ $payroll->firstItem() + $key }}</td>
                
                @if($item->emp_id != $lastEmpId)
                    <td>{{ $item->emp_id }}</td>
                    <td>{{ $item->Employee->user_name }}</td>
                @else
                    <td></td>
                    <td></td>
                @endif
                
                @php
                    $lastEmpId = $item->emp_id;
                @endphp

                <td>{{ $item->amount }}</td>
                @if ($item->date != null)
                    <td>{{ date('m', strtotime($item->date)) }}</td>
                    <td>{{ date('Y', strtotime($item->date)) }}</td>
                @else
                    <td></td>
                    <td></td>
                @endif
                
                <td>
                    <div style="display: flex;gap:5px;">
                        @if(Auth::user()->hasPermissionToRoute('update.payrollMiddlewire'))
                            <button class="open-modal" data-modal-id="editModal" id="edit"
                                data-id="{{ $item->id }}"><i class="fas fa-edit"></i></button>
                        @endif
                        @if(Auth::user()->hasPermissionToRoute('delete.payrollMiddlewire'))
                            <button data-id="{{ $item->id }}" id="delete"><i class="fas fa-trash"></i></button>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>