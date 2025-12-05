<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Export Purchase Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
    <style>
        table, th, td{
            border: 1px black solid;
        }


    </style>

<body>

    <h5 style="text-align: center;">PURCHASE ORDER</h5>
    <br><br>

    <p>TO: <strong>Mr./Mrs {{ $poData->poToSup->fname }} {{ $poData->poToSup->mname }} {{ $poData->poToSup->lname }}</strong></p>
    <p>{{ $poData->poToSup->company_address }}</p>
    <br>

    <p>{{ \Carbon\Carbon::now()->format('F d, Y') }}</p>
    <br>


    <p>Please furnish us the following items described below:</p>
        
    <table style="width: 100%">
        <thead>
            <tr>
                <th class="fw-semibold">Item Name</th>
                <th class="fw-semibold">Qty.</th>
                <th class="fw-semibold">Qty. pre Set/Box</th>
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
                    <td>{{ $row->qty_set }}</td>
                    <td>{{ $row->qty_total }}</td>
                    <td>{{ $row->type }}</td>
                    <td>₱ {{ $row->unit_price }}</td>
                    <td>₱ {{ $row->total_amount }}</td>
                </tr>
            @endforeach

            {{-- SHOW TOTAL --}}
            <tr>
                <td colspan="6">Total:</td>
                <td>₱ {{ $poItemData->sum('total_amount') }}</td>
            </tr>
        </tbody>
    </table>

    <p>Please deliver the purchase order on or before {{ \Carbon\Carbon::now()->format('F d, Y') }} this purchase order is
        valid until midnight of {{ \Carbon\Carbon::now()->addDays(1)->format('F d, Y') }}.
    </p>
    <br><br>

    <table style="width: 100%; border: 1px solid white; border-collapse: collapse;">
        <tbody>
            <tr>
                <td width="50%" style="text-align: center; border: none;"></td>
                <td width="50%" style="text-align: center; border: none;">{{ $poData->poToEmp->emp_fname }} {{ $poData->poToEmp->emp_mname }} {{ $poData->poToEmp->emp_lname }}</td>
            </tr>
            <tr>
                <td width="50%" style="text-align: center; border: none;"></td>
                <td width="50%" style="text-align: center; border: none;">Proprietor</td>
            </tr>
        </tbody>


    </table>


</body>
</html>