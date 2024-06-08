<!DOCTYPE html>
<html lang="en" class="main-theme font-humane-bold">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPU Scheduling Calculator</title>
    @vite('resources/css/app.css')

    <style>
        .process {
            margin-bottom: 10px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            background-color: #fff;
        }
        .process label {
            display: block;
            margin-bottom: 5px;
        }
        .process input[type="text"],
        .process input[type="number"],
        .process select {
            width: 100px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        button {
            display: block;
            margin-top: 10px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .buttons-container {
            display: flex;
            flex-direction: row;
        }

        .process-shrinker {
            flex: 1;
        }

        #compute-button {
            width: 100%;
        }
    </style>

</head>
<body>
    <div class="utils-form-wrapper">
        <form class="utils-form" action="{{ route('calculate') }}" method="POST" onsubmit="if(!validateAndCompute()) return false;">
            @csrf
            <h2 class="utils-title">CPU Scheduling Calculator</h2>

            <div class="utils-algorithm-select">
                <label for="algorithm">Select Scheduling Algorithm:</label>
                <select name="algorithm" id="algorithm" required>
                    <option value="fcfs">First Come First Serve (FCFS)</option>
                    <option value="sjf">Shortest Job First (SJF)</option>
                    <option value="priority">Priority Scheduling (Preemptive)</option>
                </select>
            </div>

            <div id="processes">
                <div class="process">
                    <label for="process_name_1">Process Name:</label>
                    <input type="text" id="process_name_1" name="processes[1][name]" value="P1" readonly>
                    <label for="arrival_time_1">Arrival Time:</label>
                    <input type="number" id="arrival_time_1" name="processes[1][arrival_time]" required>
                    <label for="burst_time_1">Burst Time:</label>
                    <input type="number" id="burst_time_1" name="processes[1][burst_time]" required>
                    <div class="priorityField hidden">
                        <label for="priority_1">Priority (if applicable):</label>
                        <input type="number" id="priority_1" name="processes[1][priority]">
                    </div>
                </div>
            </div>

            <div class="buttons-container">
                <button class="process-shrinker" type="button" onclick="addProcess()">Add Process</button>
                <button class="process-shrinker" type="button" onclick="subtractProcess()">Remove Process</button>
            </div>

            <button id="compute-button" type="submit">Compute</button>
        </form>
    </div>

    <script>
        let processCount = 1;

        function addProcess() {
            processCount++;
            const processesDiv = document.getElementById('processes');
            const selectedAlgorithm = document.getElementById('algorithm').value;

            const processTemplate = `
                <div class="process">
                    <label for="process_name_${processCount}">Process Name:</label>
                    <input type="text" id="process_name_${processCount}" name="processes[${processCount}][name]" value="P${processCount}" readonly>
                    <label for="arrival_time_${processCount}">Arrival Time:</label>
                    <input type="number" id="arrival_time_${processCount}" name="processes[${processCount}][arrival_time]" required>
                    <label for="burst_time_${processCount}">Burst Time:</label>
                    <input type="number" id="burst_time_${processCount}" name="processes[${processCount}][burst_time]" required>
                    <div class="priorityField ${selectedAlgorithm === 'priority' ? '' : 'hidden'}">
                        <label for="priority_${processCount}">Priority (if applicable):</label>
                        <input type="number" id="priority_${processCount}" name="processes[${processCount}][priority]">
                    </div>
                </div>
            `;

            processesDiv.insertAdjacentHTML('beforeend', processTemplate);
        }

        function subtractProcess() {
            if (processCount > 1) {
                const processesDiv = document.getElementById('processes');
                processesDiv.removeChild(processesDiv.lastElementChild);
                processCount--;
            } else {
                alert('You cannot remove a process when there is only one process.');
            }
        }

        function validateAndCompute() {
            if (processCount <= 1) {
                alert('Computing a single process is NONSENSE!');
                return false;
            }
            return true;
        }

        function resetAlgorithm() {
            document.getElementById('algorithm').value = 'fcfs';
        }

        document.addEventListener('DOMContentLoaded', function() {
            resetAlgorithm();
        });

        document.getElementById('algorithm').addEventListener('change', function() {
            const selectedAlgorithm = this.value;
            const priorityFields = document.querySelectorAll('.priorityField');

            priorityFields.forEach(field => {
                const input = field.querySelector('input');
                if (selectedAlgorithm === 'priority') {
                    field.classList.remove('hidden');
                } else {
                    field.classList.add('hidden');
                    input.value = ''; // Reset the value of the priority field
                }
            });
        });
    </script>
</body>
</html>
