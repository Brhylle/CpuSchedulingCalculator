<!-- resources/views/result.blade.php -->
<!DOCTYPE html>
<html lang="en" data-theme="cupcake">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPU Scheduling Calculator</title>
    @vite('resources/css/app.css')
    <style>
        :root {        
            --text: #0f0a3b;
            --background: #c999ff;
            --background-2: #f1e5ff;
            --primary: #0d087f;
            --secondary: #dedcff;
            --accent: #c88ee9;
            --accent-2: #ead4f7;
        }

        body {
            font-family: PP Neue Montreal Medium;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: var(--background);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .wrapper {
            width: 90%;
            max-width: 1200px;
            height: 90vh;
            background-color: var(--background-2);
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            padding: 20px;
        }

        h1 {
            font-family: Humane Bold;
            font-size: 5rem;
            color: var(--text);
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 24px;
            color: var(--text);
            margin-top: 20px;
            font-weight: bold;
            font-family: PP Neue Montreal Bold;
            text-align: center;
        }

        th {
            background-color: var(--primary);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: var(--background);
            border: 1px solid var(--accent);
            font-size: 28px;
        }

        th,
        td {
            border: 1px solid var(--accent);
            padding: 6px;
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: var(--secondary);
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
            background-color: var(--secondary);
            border: 1px solid var(--accent);
            position: relative;
        }

        .gantt-container .bar {
            background-color: var(--primary);
            position: relative;
            padding: 35px;
        }

        .gantt-container .bar span {
            color: var(--accent-2);
            font-size: 32px;
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
            font-size: 40px;
        }

        div.start-process-el, div.end-process-el {
            display: flex;
            position: relative;
        }

        .rounded-button {
            border-radius: 1rem;
            padding: 12px;
            font-size: medium;
            background: var(--primary);
            text-decoration: none;
        }

        .button-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 2rem;
            text-transform: uppercase;
            font-size: 4rem;
            color: white;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h1 class="font-bold m-0">CPU Scheduler Results</h1>

        {{-- DISPLAY THE GANTT CHART ELEMENTS --}}
        <h2>Gantt Chart</h2>

        <div class="gantt-container">
            @php
                $prevEndTime = 0;
                $totalDuration = 0;
            @endphp

            @foreach ($result['gantt_chart'] as $entry)
                @php
                    $entryStartTime = $entry['start_time'];
                    $entryEndTime = $entry['end_time'];
                    $processDuration = $entryEndTime - $entryStartTime;
                @endphp

                @if ($entryStartTime > $prevEndTime)
                    @php
                        $idleDuration = $entryStartTime - $prevEndTime;
                        $totalDuration += $idleDuration;
                        if ($prevEndTime != 0) {
                    @endphp
                            <div class="bar idle" style="width: {{ $idleDuration }}%;">
                                <span>idle</span>
                            </div>
                    @php
                        }
                    @endphp
                @endif

                <div class="bar" style="width: {{ $processDuration }}%;">
                    <span>{{ $entry['process_name'] }}</span>
                </div>

                @php
                    $prevEndTime = $entryEndTime;
                    $totalDuration += $processDuration;
                @endphp
            @endforeach
        </div>

        <div class="gantt-process-times">
            @php
                $index = 1;
                $shownTimes = [];
            @endphp

            @foreach ($result['gantt_chart'] as $entry)
                @php
                    $startTime = $entry['start_time'];
                    $endTime = $entry['end_time'];
                    $startTimeLength = strlen($startTime);  
                    $endTimeLength = strlen($endTime);
                    $baseMargin = 1.5;
                    $gapThreshold = 0.65;
                    $startTimeMargin = $baseMargin - (($startTimeLength - 1) * $gapThreshold);
                    $endTimeMargin = $baseMargin - (($endTimeLength - 1) * $gapThreshold);
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

        <div class="button-wrapper padding-12">
            <button id="calculate-again-btn" class="rounded-button">
                <a href="{{ route('welcome') }}" class="padding-12 text-text-100">Calculate Again</a>
            </button>
        </div>
    </div>
</body>
</html>