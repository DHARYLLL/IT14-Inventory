@if ($stoData->isEmpty())
    <tr>
        <td colspan="5" class="text-center text-secondary py-3">
            No Stock Item Available.
        </td>
    </tr>
@else
    @foreach ($stoData as $row)
        <tr>
            <td>{{ $row->item_name }}</td>
            <td>{{ $row->item_size }}</td>
            <td>{{ $row->item_net_content }}</td>
            <td>
                @if ($row->item_qty == 0)
                    <p class="cust-empty">
                        {{ $row->item_qty }} (No stock)
                    </p>
                @elseif ($row->item_qty <= $row->item_low_limit)
                    <p class="cust-warning">
                        {{ $row->item_qty }} (Low Stock)
                    </p>
                @else
                    <p>{{ $row->item_qty }}</p>
                @endif
            </td>
            <td>
                <a href="{{ route('Stock.edit', $row->id) }}"
                   class="cust-btn cust-btn-secondary btn-md"
                   data-bs-toggle="tooltip"
                   title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>
            </td>
        </tr>
    @endforeach
@endif
