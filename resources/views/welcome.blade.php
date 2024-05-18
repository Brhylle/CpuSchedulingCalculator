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
            margin: 0;
            background-color: #C0BADE; /* BACKGROUND color */
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }
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
        .algorithm-select {
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
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

        #compute-button{
            width: 100%;
        }
    </style>
</head>
<body>
    <form action="{{ route('calculate') }}" method="POST">
        @csrf
        <h2 style="text-align: center;">CPU Scheduling Calculator</h2>

        <div class="algorithm-select">
            <label for="algorithm">Select Scheduling Algorithm:</label>
            <select name="algorithm" id="algorithm" required>
                <option value="fcfs">First Come First Serve (FCFS)</option>
                <option value="sjf">Shortest Job First (SJF)</option>
                <option value="priority">Priority Scheduling</option>
            </select>
        </div>

        <div id="processes">
            <div class="process">
                <label for="process_name_1">Process Name:</label>
                <input type="text" id="process_name_1" name="processes[1][name]" required>
                <label for="arrival_time_1">Arrival Time:</label>
                <input type="number" id="arrival_time_1" name="processes[1][arrival_time]" required>
                <label for="burst_time_1">Burst Time:</label>
                <input type="number" id="burst_time_1" name="processes[1][burst_time]" required>
                <label for="priority_1">Priority (if applicable):</label>
                <input type="number" id="priority_1" name="processes[1][priority]">
            </div>
            <!-- Additional processes can be added dynamically with JavaScript -->
        </div>

        <div class="buttons-container">
            {{-- this button ADDS A PROCESS EACH CLICK --}}
            <button class="process-shrinker" type="button" onclick="addProcess()">Add Process</button>
            <button class="process-shrinker" type="button" onclick="subtractProcess()">Remove Process</button>
        </div>
        

        {{-- this button PROCESSES THE INPUTTED AND VALIDATED DATA on the server-side --}}
        <button id="compute-button" type="submit">Compute</button>


    </form>

    <script>
        let processCount = 1;

        function addProcess() {
            processCount++;
            const processesDiv = document.getElementById('processes');

            const processTemplate = `
                <div class="process">
                    <label for="process_name_${processCount}">Process Name:</label>
                    <input type="text" id="process_name_${processCount}" name="processes[${processCount}][name]" required>
                    <label for="arrival_time_${processCount}">Arrival Time:</label>
                    <input type="number" id="arrival_time_${processCount}" name="processes[${processCount}][arrival_time]" required>
                    <label for="burst_time_${processCount}">Burst Time:</label>
                    <input type="number" id="burst_time_${processCount}" name="processes[${processCount}][burst_time]" required>
                    <label for="priority_${processCount}">Priority (if applicable):</label>
                    <input type="number" id="priority_${processCount}" name="processes[${processCount}][priority]">
                </div>
            `;

            processesDiv.insertAdjacentHTML('beforeend', processTemplate);
        }
    </script>
</body>
</html>