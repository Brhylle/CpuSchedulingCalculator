<!DOCTYPE html>
<html lang="en" class="main-theme">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPU Scheduling Calculator</title>
    @vite('resources/css/app.css')

    <style>
        .process input[type="text"],
        .process input[type="number"],
        .process select {
            width: 100px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .hidden {
            display: none;
        }
        button {
            display: block;
            margin: 5px 0px 5px 0px;
            padding: 10px;
            color: white;
            border: none;
            border-radius: 7.5px;
            cursor: pointer;
            background-color: #6D41A1;
            
        }

        button:hover {
            background-color: #290e49;
            text-transform: uppercase;
            border:#220149;
        }

        .buttons-container {
            display: flex;
            flex-direction: row;
        }

        .process-shrinker {
            flex: 1;
        }

        #compute-button {
            flex: 1;
            align-self: center; /* Center the button horizontally */
            width: 100%; /* Set width to 100% */
        }

        /* Add custom style for container */
        .process-container {
            max-height: 35vh; /* Set maximum height */
            overflow-y: auto; /* Enable vertical scrolling */
        }

        .utils-form-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
        }


        .utils-form {
            font-family: "PP Neue Montreal Medium";
            background-color: #462A68; /* BACKGROUND color */
            padding: 1.25rem;
            border-radius: 0.313rem; 
           box-shadow: 0 0 0.625rem rgba(0,0,0,0.1);
           max-width: 37.5rem; /* 600px */
           margin: 4rem;
        }

        .main-theme {
            font-family: 'PP Neue Montreal Medium';
            width: 100vw;
            height: 100vh;
            color: #e9e3f1;
            background-color: #C0BADE;
            line-height: 1.6;
        }   


        .utils-title {
            text-align: center;
            font-size: 3.5rem;
            font-family: 'Humane Bold';
            line-height: 75%;

            margin-bottom: 1.25rem;
        }

        .utils-subtitle {
                        text-transform: capitalize;
           font-weight: 700; 
        }

        .utils-important {

        padding: 0.325rem;
    border-radius: 1.1rem;
    margin: 0.300rem;
    font-size: 1rem;
    font-family: 'PP Neue Montreal Medium';
    font-style: italic;
    text-align: center;
    background: #5914ad;
    color: #e9e3f1;
    font-weight: 700;
    }

    .utils-form-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .utils-process-form {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        border-radius: 5px;
        background: #ddc4fd;
        color: #290e49;
        padding: 10px;
        margin: 10px;
        box-shadow: 0 0 0.625rem rgba(0,0,0,0.1);
    }

    .button-wrapper {
        display: flex;
        justify-content: center;
        margin: 2rem;
        align-items: center;
        text-transform: uppercase;
        font-family: 'PP Neue Montreal Bold';
        font-size: 4rem;
        border: 12px solid #220149;
        border-radius: 10px;
    }

    .utils-option {
        padding: 0.325rem;
        border-radius: 1.1rem;
        margin: 0.300rem;
        font-size: 1rem;
        font-family: 'PP Neue Montreal Medium';
        font-style: italic;
        text-align: center;
        background: #5914ad;
        color: #e9e3f1;
        font-weight: 700;
    }

    .utils-algorithm-select {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        border-radius: 5px;
        background: #ddc4fd;
        color: #290e49;
        padding: 10px;
        margin: 10px;
        box-shadow: 0 0 0.625rem rgba(0,0,0,0.1);
    }

    .utils-form-label {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    
    </style>

</head>
<body>
    <div class="utils-form-wrapper">
        <form class="utils-form" action="{{ route('calculate') }}" method="POST" onsubmit="if(!validateAndCompute()) return false;">

            @csrf
            <h2 class="utils-title">CPU Scheduling Calculator</h2>

            <div class="utils-algorithm-select">
                <label for="algorithm" class="utils-subtitle">Select Scheduling Algorithm:</label>
                <select class="utils-important" name="algorithm" id="algorithm" required>
                    <option class="utils-option" value="fcfs">First Come First Serve (FCFS)</option>
                    <option class="utils-option" value="sjf">Shortest Job First (SJF)</option>
                    <option class="utils-option" value="priority">Priority Scheduling (Preemptive)</option>
                </select>
            </div>

            <!-- Wrap the processes section in a container for a vertical scrolling ehe -->
            <div class="process-container">
                <div id="processes">
                    <div class="utils-process-form">
                        <label class="utils-form-label" for="process_name_1">Process Name:</label>
                        <input type="text" id="process_name_1" name="processes[1][name]" value="P1" readonly>
                        <label class="utils-form-label" for="arrival_time_1">Arrival Time:</label>
                        <input type="number" id="arrival_time_1" name="processes[1][arrival_time]" required>
                        <label class="utils-form-label" for="burst_time_1">Burst Time:</label>
                        <input type="number" id="burst_time_1" name="processes[1][burst_time]" required>
                        <div class="priorityField hidden">
                            <div class="util-priority-input">
                                <label class="utils-form-label" for="priority_1" @required(true)>Priority: <br></label>
                                <input type="number" id="priority_1" name="processes[1][priority]">
                            </div>
                        </div>
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
            <div class="utils-process-form">
                <label class="utils-form-label" for="process_name_${processCount}">Process Name:</label>
                <input type="text" id="process_name_${processCount}" name="processes[${processCount}][name]" value="P${processCount}" readonly>
                <label class="utils-form-label" for="arrival_time_${processCount}">Arrival Time:</label>
                <input type="number" id="arrival_time_${processCount}" name="processes[${processCount}][arrival_time]" required>
                <label class="utils-form-label" for="burst_time_${processCount}">Burst Time:</label>
                <input type="number" id="burst_time_${processCount}" name="processes[${processCount}][burst_time]" required>
                <div class="priorityField ${selectedAlgorithm === 'priority' ? '' : 'hidden'}">
                    <div class="util-priority-input">
                        <label class="utils-form-label" for="priority_${processCount}" @required(true)>Priority:</label>
                        <input type="number" id="priority_${processCount}" name="processes[${processCount}][priority]">
                    </div>
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
        clearFirstProcessPriority(); // Clear priority field in the first process
    }

    function clearFirstProcessPriority() {
        const firstProcessPriority = document.querySelector('#priority_1');
        if (firstProcessPriority) {
            firstProcessPriority.value = ''; // Clear the value of the priority field
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        resetAlgorithm();

        document.getElementById('algorithm').addEventListener('change', function () {
            updatePriorityFields();
        })
    });

    function updatePriorityFields() {
    const selectedAlgorithm = document.getElementById('algorithm').value;
    const priorityFields = document.querySelectorAll('.priorityField');

    priorityFields.forEach(field => {
        const input = field.querySelector('input');
        if (selectedAlgorithm === 'priority') {
            field.classList.remove('hidden');
            field.classList.add('flex');
        } else {
            field.classList.remove('flex');
            field.classList.add('hidden');
            input.value = ''; // Reset the priority field
        }
    });
}


</script>

</body>
</html>
