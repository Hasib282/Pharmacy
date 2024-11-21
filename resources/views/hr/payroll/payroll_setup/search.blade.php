<table class="show-table">
    <caption class="caption">Additional Payroll Details</caption>
    <thead>
        <tr>
            <th>SL:</th>
            <th>Employee Id</th>
            <th>Employee Name</th>
            <th>Payroll Category</th>
            <th>Amount</th>
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

                    @php
                        $lastEmpId = $item->emp_id;
                    @endphp
                @else
                    <td></td>
                    <td></td>
                @endif
                
                
                
                <td>{{ $item->Head->tran_head_name }}</td>
                <td>{{ $item->amount }}</td>
                <td>
                    <div style="display: flex;gap:5px;">
                        @if(Auth::user()->hasPermissionToRoute('update.payrollSetup'))
                            <button class="open-modal" data-modal-id="editModal" id="edit"
                                data-id="{{ $item->id }}"><i class="fas fa-edit"></i></button>
                        @endif
                        @if(Auth::user()->hasPermissionToRoute('delete.payrollSetup'))
                            <button data-id="{{ $item->id }}" id="delete"><i class="fas fa-trash"></i></button>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="center paginate" id="paginate">
    {!! $payroll->links() !!}
</div>
