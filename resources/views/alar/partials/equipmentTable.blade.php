@if ($eqData->isEmpty())
    <tr>
        <td colspan="5" class="text-center text-secondary py-3">
            No Equipment available.
        </td>
    </tr>
@else
    @foreach ($eqData as $row)
        <tr>
            <td>{{ $row->eq_name }}</td>
            <td>{{ $row->eq_size }}</td>
            <td>
                @if ($row->eq_available == 0)
                    <p class="cust-empty">
                        {{ $row->eq_available }} (No stock)
                    </p>
                @elseif ($row->eq_available <= $row->eq_low_limit)
                    <p class="cust-warning">
                        {{ $row->eq_available }} (Low Stock)
                    </p>
                @else
                    <p>{{ $row->eq_available }}</p>
                @endif
            </td>
            <td>{{ $row->eq_in_use }}</td>
            <td>
                <a href="{{ route('Equipment.edit', $row->id) }}"
                   class="cust-btn cust-btn-secondary btn-md"
                   data-bs-toggle="tooltip"
                   title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>
            </td>
        </tr>
    @endforeach
@endif
