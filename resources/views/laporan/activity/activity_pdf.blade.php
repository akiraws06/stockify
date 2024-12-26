<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Aktivitas Pengguna</title>
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
    <h1>Laporan Aktivitas Pengguna</h1>
    <table>
        <thead>
            <tr>
                <th>Nama Pengguna</th>
                <th>Aktivitas</th>
                <th>Time</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
                <tr>
                    <td>{{ $activity->user->name }}</td>
                    <td>{{ $activity->activity }}</td>
                    <td>{{ $activity->created_at->format('H:i:s') }}</td>
                    <td>{{ $activity->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>