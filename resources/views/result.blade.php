<!-- resources/views/result.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPU Scheduling Calculator</title>
    @vite('resources/css/app.css')
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
            font-weight: bold;
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
        .gantt-container {
            display: flex;
            align-items: center;
            margin-top: 20px;
            justify-content: center;
            align-items: center;
        }
        .gantt-container div {
            flex: 0;
            padding: 4px;
            text-align: center;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            position: relative;
        }

        .gantt-container .bar {
            background-color: #4CAF50;
            position: relative;
            /* bottom: 0;
            left: 0;
            right: 0; */
            padding: 15px;
        }

        /* THIS STYLING TARGETS THE FONT INSIDE THE GANTT CHART */
        .gantt-container .bar span {
            color: #0E3D21;
            font-size: 12px;
            font-weight: bold;
            position: absolute;
            padding: 5px;
            top: 0px;
            left: 50%;
            transform: translateX(-50%);
        }

        .gantt-process-times {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-content: center;
            position: relative;
        }
        
        div.start-process-el, div.end-process-el {
            display: flex;
            position: relative;

        }
    </style>
</head>
<body>
    <h1 class="font-bold">CPU Scheduler Results</h1>

    {{-- GANTT CHART --}}
    <h2 class="text-center">Gantt Chart</h2>

    <div class="gantt-container">
        @php $index = 1; @endphp
        @foreach ($result['gantt_chart'] as $entry)
            <div >
                <div class="bar">
                    <span>{{ $entry['process_name'] }}</span>
                </div>
            </div>
        @php $index++; @endphp
        @endforeach
    </div>

    {{-- START AND END TIME OF EACH PROCESSES --}}
    <div class="gantt-process-times">
        @php
            $index = 1;
            $shownTimes = [];
        @endphp

        @foreach ($result['gantt_chart'] as $entry)
            @php
                // initialization of variables for use later...
                    $startTime = $entry['start_time'];
                    $endTime = $entry['end_time'];
                    $startTimeLength = strlen($startTime);
                    $endTimeLength = strlen($endTime);
                    $baseMargin = 1.00; // base margin
                    $adjustmentFactor = 0.25; // adjustment factor for each digit increase and so the decrease of margin (both left and right)
                    
                    $startTimeMargin = $baseMargin - (($startTimeLength - 1) * $adjustmentFactor);
                    $endTimeMargin = $baseMargin - (($endTimeLength - 1) * $adjustmentFactor);
            @endphp

            @if (!in_array($startTime, $shownTimes))
                <div class="start-process-el" style="margin-left: {{ $startTimeMargin }}rem; margin-right: {{ $startTimeMargin }}rem;">
                    {{$startTime}}
                </div>
                @php $shownTimes[] = $startTime; @endphp
            @endif

            @if ($startTime != $endTime && !in_array($endTime, $shownTimes))
                <div class="end-process-el" style="margin-left: {{ $endTimeMargin }}rem; margin-right: {{ $endTimeMargin }}rem;">
                    {{$endTime}}
                </div>
                @php $shownTimes[] = $endTime; @endphp
            @endif

        @endforeach
        @php $index++ @endphp
    </div>

    {{-- PROCESS DETAILS TABLE--}}
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

    {{-- AVERAGE WEIGHTED TIME TABLE --}}
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