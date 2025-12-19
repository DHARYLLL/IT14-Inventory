@forelse ($logData as $row)
<tr>
    <td>{{ $row->id }}</td>
    <td>
        {{ $row->logToEmp->emp_fname }}
        {{ $row->logToEmp->emp_mname }}
        {{ $row->logToEmp->emp_lname }}
    </td>
    <td>{{ $row->transaction }}</td>
    <td>{{ $row->tx_desc }}</td>
    <td>{{ $row->tx_date }}</td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center text-secondary py-3">
        No results found.
    </td>
</tr>
@endforelse

<tr>
    <td colspan="5">
        @include('alar.partials.custom-pagination', ['data' => $logData])
    </td>
</tr>
