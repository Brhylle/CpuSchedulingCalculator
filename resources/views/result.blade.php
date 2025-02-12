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
            --background-color: #C999FF;
            --background-color-2: #24034a;
            --theader-color: #bf87ff43;
            --text-1: #463069;
            --text-2: #0A0415;
            --accent-1: #D480E5;
        }
        body {
            font-family: PP Neue Montreal Medium;
            line-height: 1.6;
            margin: 20px;
            background-color: var(--background-color);
        }
        h1 {
            font-family: Humane Bold;
            font-size: 14rem;
            color: var(--text-1);
            text-align: center;
        }
        h2 {
            font-size: 64px;
            color: rgb(var(--text-2));
            margin-top: 20px;
            font-weight: bold;
            font-family: PP Neue Montreal Bold;
        }

        th {
            background-color: var(--theader-color)
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: var(--background-color-2);
            border: 1px solid var(--text-2);
            font-size: 28px; /* Decreased font size */
        }

        th,
        td {
            border: 1px solid var(--accent-800);
            padding: 6px; /* Decreased padding */
            text-align: left;
        }
        tbody tr:nth-child(even) {
            background-color: var(--background-50);
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
            background-color: var(--secondary-950);
            border: 1px solid var(--accent-50);
            position: relative;
        }

        .gantt-container .bar {
            background-color: var(--primary-500);
            position: relative;
            padding: 35px;
        }

        /* THIS STYLING TARGETS THE FONT INSIDE THE GANTT CHART */
        .gantt-container .bar span {
            color: var(--text-100);
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
    </style>
</head>
<body>
    <h1 class="font-bold m-0">CPU Scheduler Results</h1>

    {{-- DISPLAY THE GANTT CHART ELEMENTS --}}
    <h2 class="text-center">Gantt Chart</h2>

    {{-- GLUES AND HOLDS ALL OF THE ELEMENTS OF THE GANTT TOGETHER --}}
    {{-- GLUES AND HOLDS ALL OF THE ELEMENTS OF THE GANTT TOGETHER --}}

    <div class="gantt-container">
    @php
        $prevEndTime = 0;
        $totalDuration = 0;
    @endphp

    {{-- Iterate through each process and handle idle time --}}
    @foreach ($result['gantt_chart'] as $entry)
        @php
            $entryStartTime = $entry['start_time'];
            $entryEndTime = $entry['end_time'];
            $processDuration = $entryEndTime - $entryStartTime;
        @endphp

        {{-- Add idle segment if there's a gap --}}
        @if ($entryStartTime > $prevEndTime)
            @php
                // Calculate idle duration
                $idleDuration = $entryStartTime - $prevEndTime;
                $totalDuration += $idleDuration;
                
                // Render idle time entry only if the previous end time is not zero
                if ($prevEndTime != 0) {
            @endphp
                    {{-- Render idle time entry --}}
                    <div class="bar idle" style="width: {{ $idleDuration }}%;">
                        <span>idle</span>
                    </div>
            @php
                }
            @endphp
        @endif

        {{-- Render current process --}}
        <div class="bar" style="width: {{ $processDuration }}%;">
            <span>{{ $entry['process_name'] }}</span>
        </div>

        {{-- Update previous end time --}}
        @php
            $prevEndTime = $entryEndTime;
            $totalDuration += $processDuration;
        @endphp
    @endforeach
</div>

    {{-- DISPLAY THE START AND END TIME OF EACH PROCESSES AT THE START/END OF EACH BOXES--}}
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
                    $baseMargin = 1.5; // base margin
                    $gapThreshold = 0.65; // adjustment factor for each digit increase and so the decrease of margin (both left and right)
                    
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
                {{-- HEADERS FOR THE TABLE ITSELF --}}
                <th>Process Name</th>
                <th>Arrival Time</th>
                <th>Burst Time</th>
                <th>Priority</th>
                <th>Waiting Time</th>
                <th>Turnaround Time</th>
            </tr>
        </thead>
        <tbody>
            {{-- ITERATES THROUGHOUT ALL THE FILLED UP PROCESSES THROUGH AN ARRAY --}}
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

    {{-- TABLE DEFINITION FOR THE AVERAGES --}}
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
        <button id="calculate-again-btn 
        " class="rounded-xl padding-12 bg-accent-700"><a href="{{ route('welcome') }}" class="padding-12 text-text-100">Calculate Again</a>
        </button>
    </div>

</body>
</html>
