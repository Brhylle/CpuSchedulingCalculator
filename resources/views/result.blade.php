<!-- resources/views/result.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
            background-color: #C0BADE; /* BACKGROUND color */
        }
        h1 {
            font-size: 24px;
            color: #333;
        }
        h2 {
            font-size: 20px;
            color: #444;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: #fff;
            border: 1px solid #ccc;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .gantt {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }
        .gantt div {
            flex: 1;
            padding: 5px;
            text-align: center;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            position: relative;
        }
        .gantt .bar {
            background-color: #4CAF50;
            height: 20px;
            position: relative;
            bottom: 0;
            left: 0;
            right: 0;
        }
        .gantt .bar span {
            color: white;
            font-size: 12px;
            position: absolute;
            top: 2px;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
</head>
<body>
    <h1>CPU Scheduler Results</h1>

    <h2>Gantt Chart</h2>
<div class="gantt">
    @php $index = 1; @endphp
    @foreach ($result['gantt_chart'] as $entry)
        <div style="width: {{ ($entry['end_time'] - $entry['start_time']) * 20 }}px;">
            <div class="bar" style="width: 100%;">
                <span>{{ $entry['process_name'] }}</span>
            </div>
            <span>{{ $entry['start_time'] }}</span>
            {{-- <span>{{ $index }}</span> --}}
        </div>
        @php $index++; @endphp
    @endforeach
</div>

    <h2>Process Details</h2>
    <table>
        <thead>
            <tr>
                <th>Process Name</th>
                <th>Arrival Time</th>
                <th>Burst Time</th>
                <th>Priority</th>
                <th>Waiting Time</th>
                <th>Turnaround Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($result['processes'] as $process)
                <tr>
                    <td>{{ $process['name'] }}</td>
                    <td>{{ $process['arrival_time'] }}</td>
                    <td>{{ $process['burst_time'] }}</td>
                    <td>{{ $process['priority'] ?? '-' }}</td>
                    <td>{{ $process['waiting_time'] }}</td>
                    <td>{{ $process['turnaround_time'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Average Times</h2>
    <table>
        <thead>
            <tr>
                <th>Average Waiting Time</th>
                <th>Average Turnaround Time</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $result['average_waiting_time'] }}</td>
                <td>{{ $result['average_turnaround_time'] }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>