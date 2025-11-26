<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Export Purchase Order</title>
</head>
    <style>
        table, th, td{
            border: 1px black solid;
        }


    </style>

<body>
    <p>hello world</p>

    <table>
        <thead>
            <tr>
                <th class="fw-semibold">Item Name</th>
                <th class="fw-semibold">Qty</th>
                <th class="fw-semibold">Total Qty.</th>
                <th class="fw-semibold">Type</th>
                <th class="fw-semibold">Unit Price</th>
                <th class="fw-semibold">Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($poItemData as $row)
                <tr>
                    <td>{{ $row->item }}</td>
                    <td>{{ $row->qty }}</td>
                    <td>{{ $row->qty_total }}</td>
                    <td>{{ $row->type }}</td>
                    <td>₱ {{ $row->unit_price }}</td>
                    <td>₱ {{ $row->total_amount }}</td>
                </tr>
            @endforeach

            {{-- SHOW TOTAL --}}
            <tr>
                <td colspan="5">Total:</td>
                <td>₱ {{ $poItemData->sum('total_amount') }}</td>
            </tr>
        </tbody>
    </table>


</body>
</html>