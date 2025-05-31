<!DOCTYPE html>
<html>
<head>
    <title>Time Logs PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Time Logs Report</h2>
    <p>Date: {{ now()->format('Y-m-d H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Project</th>
                <th>Client</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Hours</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($timeLogs as $log)
                <tr>
                    <td>{{ $log->project->title ?? '-' }}</td>
                    <td>{{ $log->project->client->name ?? '-' }}</td>
                    <td>{{ $log->start_time }}</td>
                    <td>{{ $log->end_time ?? '-' }}</td>
                    <td>{{ $log->hours }}</td>
                    <td>{{ $log->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
