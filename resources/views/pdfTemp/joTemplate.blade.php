<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
.content-table{
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 0.9em;
}

.content-table thead tr {
    background-color: #6ecc49;
    text-align: left;
    color: white;
    font-weight: bold;
}
.content-table th,
.content-table td {
    padding: 12px 15px;
}
.content-table tbody tr {
    border-bottom: 1px solid #dddddd;
}
.content-table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
}

.content-table tbody tr:last-of-type() {
    border-bottom: 2px solid #6ecc49;
}
</style>

<body>
    <table class="content-table">
        <thead>
            <tr>
                <th>NO.</th>
                <th>DATE</th>
                <th>NAME OF CLIENT</th>
                <th>NAME OF DECEASED</th>
                <th>ADDRESS</th>
                <th>SERVICE OFFERED</th>
                <th>AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            @if($joData->isEmpty())
                <tr>
                    <td colspan="7">No Data.</td>
                </tr>
            @else
                @foreach($joData as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->jo_start_date ? $row->jo_start_date : $row->jo_burial_date }}</td>
                        <td>{{ $row->client_name }}</td>
                        <td>{{ $row->joToJod->dec_name ?? 'N/A' }}</td>
                        <td>{{ $row->client_address }}</td>
                        <td>{{ $row->jod_id ? 'Coffin And Embalming' : 'Service' }}</td>
                        <td>PHP {{ number_format($row->jo_total, 2) }}</td>
                    </tr>
                @endforeach
            @endif
            <tr>
                <td colspan="6">Total</td>
                <td colspan="1">PHP {{  number_format($joData->sum('jo_total'), 2) }}</td>
            
        </tbody>
    </table>
</body>
</html>