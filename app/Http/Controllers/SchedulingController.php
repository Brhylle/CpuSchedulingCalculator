<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchedulingController extends Controller
{
    public function schedule(Request $request)
    {
        $validatedData = $request->validate([
            'processes.*.name' => 'required|string',
            'processes.*.arrival_time' => 'required|integer|min:0',
            'processes.*.burst_time' => 'required|integer|min:1',
            'processes.*.priority' => 'sometimes|required|integer|min:1',
            'algorithm' => 'required|in:fcfs,sjf,priority',
        ]);

        $processes = $validatedData['processes'];
        $algorithm = $validatedData['algorithm'];

        // Implement your scheduling algorithm logic here
        switch ($algorithm) {
            case 'fcfs':
                $result = $this->fcfs($processes);
                break;
            case 'sjf':
                $result = $this->sjf($processes);
                break;
            case 'priority':
                // Placeholder for priority scheduling algorithm
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
        usort($processes, function ($a, $b) {
            return $a['arrival_time'] <=> $b['arrival_time'];
        });

        $current_time = 0;
        $gantt_chart = [];

        foreach ($processes as $process) {
            $waiting_time = max(0, $current_time - $process['arrival_time']);
            $turnaround_time = $waiting_time + $process['burst_time'];
            $current_time += $process['burst_time'];

            // Create entry for Gantt chart
            $gantt_chart[] = [
                'process_name' => $process['name'],
                'start_time' => $current_time - $process['burst_time'],
                'end_time' => $current_time,
            ];

            // Update process details
            $process['waiting_time'] = $waiting_time;
            $process['turnaround_time'] = $turnaround_time;
        }

        // Calculate averages
        $total_waiting_time = array_sum(array_column($processes, 'waiting_time'));
        $total_turnaround_time = array_sum(array_column($processes, 'turnaround_time'));
        $average_waiting_time = $total_waiting_time / count($processes);
        $average_turnaround_time = $total_turnaround_time / count($processes);

        return [
            'gantt_chart' => $gantt_chart,
            'processes' => $processes,
            'average_waiting_time' => $average_waiting_time,
            'average_turnaround_time' => $average_turnaround_time,
        ];
    }

    private function sjf($processes)
    {
        // Shortest Job First (SJF) Scheduling Algorithm
        // Sort processes by burst time
        usort($processes, function ($a, $b) {
            return $a['burst_time'] <=> $b['burst_time'];
        });

        $current_time = 0;
        $gantt_chart = [];

        foreach ($processes as $process) {
            $waiting_time = max(0, $current_time - $process['arrival_time']);
            $turnaround_time = $waiting_time + $process['burst_time'];
            $current_time += $process['burst_time'];

            // Create entry for Gantt chart
            $gantt_chart[] = [
                'process_name' => $process['name'],
                'start_time' => $current_time - $process['burst_time'],
                'end_time' => $current_time,
            ];

            // Update process details
            $process['waiting_time'] = $waiting_time;
            $process['turnaround_time'] = $turnaround_time;
        }

        // Calculate averages
        $total_waiting_time = array_sum(array_column($processes, 'waiting_time'));
        $total_turnaround_time = array_sum(array_column($processes, 'turnaround_time'));
        $average_waiting_time = $total_waiting_time / count($processes);
        $average_turnaround_time = $total_turnaround_time / count($processes);

        return [
            'gantt_chart' => $gantt_chart,
            'processes' => $processes,
            'average_waiting_time' => $average_waiting_time,
            'average_turnaround_time' => $average_turnaround_time,
        ];
    }

    private function priority($processes)
    {
        // Priority Scheduling Algorithm
        // Sort processes by priority (higher priority value indicates higher priority)
        usort($processes, function ($a, $b) {
            return $b['priority'] <=> $a['priority'];
        });

        $current_time = 0;
        $gantt_chart = [];

        foreach ($processes as $process) {
            $waiting_time = max(0, $current_time - $process['arrival_time']);
            $turnaround_time = $waiting_time + $process['burst_time'];
            $current_time += $process['burst_time'];

            // Create entry for Gantt chart
            $gantt_chart[] = [
                'process_name' => $process['name'],
                'start_time' => $current_time - $process['burst_time'],
                'end_time' => $current_time,
            ];

            // Update process details
            $process['waiting_time'] = $waiting_time;
            $process['turnaround_time'] = $turnaround_time;
        }

        // Calculate averages
        $total_waiting_time = array_sum(array_column($processes, 'waiting_time'));
        $total_turnaround_time = array_sum(array_column($processes, 'turnaround_time'));
        $average_waiting_time = $total_waiting_time / count($processes);
        $average_turnaround_time = $total_turnaround_time / count($processes);

        return [
            'gantt_chart' => $gantt_chart,
            'processes' => $processes,
            'average_waiting_time' => $average_waiting_time,
            'average_turnaround_time' => $average_turnaround_time,
        ];
    }
}
