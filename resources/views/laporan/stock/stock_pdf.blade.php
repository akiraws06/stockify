<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stock Opname</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Laporan Stock Opname</h1>
    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Category</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Current Stock</th>
                <th>Time</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transactions)
            <tr>
                <td>{{ $transactions->product_sku }}</td>
                <td>{{ $transactions->category_name }}</td>
                <td>{{ $transactions->product_name }}</td>
                <td>
                    @if ($transactions->type == 'Masuk')
                    + {{ $transactions->quantity }}
                    @else
                    - {{ $transactions->quantity }}
                    @endif
                </td>
                <td>{{ $transactions->stock_sementara }}</td>
                <td>{{ \Carbon\Carbon::parse($transactions->updated_at)->setTimezone('Asia/Jakarta')->format('Y-m-d') ?? 'Tanggal Tidak Ditemukan'}} </td>
                <td>{{ \Carbon\Carbon::parse($transactions->updated_at)->setTimezone('Asia/Jakarta')->format('H:i:s') ?? 'Waktu Tidak Ditemukan' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 

