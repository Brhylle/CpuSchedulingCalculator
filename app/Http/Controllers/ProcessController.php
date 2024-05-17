<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function calculate(Request $request)
    {
        $validatedData = $request->validate([
            'processes' => 'required|array',
            'processes.*.name' => 'required|string',
            'processes.*.burst_time' => 'required|integer|min:1',
            'processes.*.arrival_time' => 'required|integer|min:0',
            'processes.*.priority' => 'nullable|required_if:algorithm,priority|integer|min:1',
            'algorithm' => 'required|string|in:fcfs,sjf,priority',
        ]);

        $processes = collect($validatedData['processes']);
        $algorithm = $validatedData['algorithm'];

        switch ($algorithm) {
            case 'fcfs':
                $result = $this->fcfs($processes);
                break;
            case 'sjf':
                $result = $this->sjf($processes);
                break;
            case 'priority':
                $result = $this->priority($processes);
                break;
            default:
                return back()->withInput()->withErrors(['algorithm' => 'Invalid algorithm selected.']);
        }

        return view('result', compact('result'));
    }

    private function fcfs($processes)
    {
        // First Come First Serve (FCFS) Scheduling Algorithm
        // Sort processes by arrival time
        $processes = $processes->sortBy('arrival_time')->values();
        $currentTime = 0;
        $ganttChart = [];
        $totalWaitingTime = 0;
        $totalTurnaroundTime = 0;

        $processes = $processes->map(function ($process) use (&$currentTime, &$ganttChart, &$totalWaitingTime, &$totalTurnaroundTime) {
            $startTime = max($currentTime, $process['arrival_time']);
            $endTime = $startTime + $process['burst_time'];
            $waitingTime = $startTime - $process['arrival_time'];
            $turnaroundTime = $endTime - $process['arrival_time'];

            $process['waiting_time'] = $waitingTime;
            $process['turnaround_time'] = $turnaroundTime;

            $ganttChart[] = [
                'process_name' => $process['name'],
                'start_time' => $startTime,
                'end_time' => $endTime,
            ];

            $totalWaitingTime += $waitingTime;
            $totalTurnaroundTime += $turnaroundTime;
            $currentTime = $endTime;

            return $process;
        });

        $averageWaitingTime = $totalWaitingTime / $processes->count();
        $averageTurnaroundTime = $totalTurnaroundTime / $processes->count();

        return [
            'gantt_chart' => $ganttChart,
            'processes' => $processes->values()->toArray(),
            'average_waiting_time' => $averageWaitingTime,
            'average_turnaround_time' => $averageTurnaroundTime,
        ];
    }

    private function sjf($processes)
    {
        // Shortest Job First (SJF) Scheduling Algorithm
        $currentTime = 0;
        $ganttChart = [];
        $totalWaitingTime = 0;
        $totalTurnaroundTime = 0;
        $remainingProcesses = $processes->sortBy('arrival_time')->values();
        $completedProcesses = collect();

        while ($remainingProcesses->isNotEmpty()) {
            $availableProcesses = $remainingProcesses->filter(function ($process) use ($currentTime) {
                return $process['arrival_time'] <= $currentTime;
            });

            if ($availableProcesses->isEmpty()) {
                $currentTime++;
                continue;
            }

            $shortestProcess = $availableProcesses->sortBy('burst_time')->first();
            $startTime = $currentTime;
            $endTime = $startTime + $shortestProcess['burst_time'];
            $waitingTime = $startTime - $shortestProcess['arrival_time'];
            $turnaroundTime = $endTime - $shortestProcess['arrival_time'];

            $shortestProcess['waiting_time'] = $waitingTime;
            $shortestProcess['turnaround_time'] = $turnaroundTime;

            $ganttChart[] = [
                'process_name' => $shortestProcess['name'],
                'start_time' => $startTime,
                'end_time' => $endTime,
            ];

            $totalWaitingTime += $waitingTime;
            $totalTurnaroundTime += $turnaroundTime;
            $currentTime = $endTime;

            $completedProcesses->push($shortestProcess);
            $remainingProcesses = $remainingProcesses->reject(function ($process) use ($shortestProcess) {
                return $process['name'] == $shortestProcess['name'];
            })->values();
        }

        $averageWaitingTime = $totalWaitingTime / $completedProcesses->count();
        $averageTurnaroundTime = $totalTurnaroundTime / $completedProcesses->count();

        return [
            'gantt_chart' => $ganttChart,
            'processes' => $completedProcesses->values()->toArray(),
            'average_waiting_time' => $averageWaitingTime,
            'average_turnaround_time' => $averageTurnaroundTime,
        ];
    }

    private function priority($processes)
    {
        // Priority Scheduling Algorithm
        $currentTime = 0;
        $ganttChart = [];
        $totalWaitingTime = 0;
        $totalTurnaroundTime = 0;
        $remainingProcesses = $processes->sortBy('arrival_time')->values();
        $completedProcesses = collect();

        while ($remainingProcesses->isNotEmpty()) {
            $availableProcesses = $remainingProcesses->filter(function ($process) use ($currentTime) {
                return $process['arrival_time'] <= $currentTime;
            });

            if ($availableProcesses->isEmpty()) {
                $currentTime++;
                continue;
            }

            $highestPriorityProcess = $availableProcesses->sortByDesc('priority')->first();
            $startTime = $currentTime;
            $endTime = $startTime + $highestPriorityProcess['burst_time'];
            $waitingTime = $startTime - $highestPriorityProcess['arrival_time'];
            $turnaroundTime = $endTime - $highestPriorityProcess['arrival_time'];

            $highestPriorityProcess['waiting_time'] = $waitingTime;
            $highestPriorityProcess['turnaround_time'] = $turnaroundTime;

            $ganttChart[] = [
                'process_name' => $highestPriorityProcess['name'],
                'start_time' => $startTime,
                'end_time' => $endTime,
            ];

            $totalWaitingTime += $waitingTime;
            $totalTurnaroundTime += $turnaroundTime;
            $currentTime = $endTime;

            $completedProcesses->push($highestPriorityProcess);
            $remainingProcesses = $remainingProcesses->reject(function ($process) use ($highestPriorityProcess) {
                return $process['name'] == $highestPriorityProcess['name'];
            })->values();
        }

        $averageWaitingTime = $totalWaitingTime / $completedProcesses->count();
        $averageTurnaroundTime = $totalTurnaroundTime / $completedProcesses->count();

        return [
            'gantt_chart' => $ganttChart,
            'processes' => $completedProcesses->values()->toArray(),
            'average_waiting_time' => $averageWaitingTime,
            'average_turnaround_time' => $averageTurnaroundTime,
        ];
    }
}
