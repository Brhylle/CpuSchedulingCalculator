<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPU Scheduler Results</title>
    
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
            position: absolute;
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