function printTable() {
    var deviceName = "{{ $sensor->device->device_name }}"; // Retrieve device name from Blade template

var divToPrint = document.getElementById('sensor-table');
var newWin = window.open('', 'Print-Window');
newWin.document.open();
newWin.document.write(
`<html>
<head>
<title>${deviceName} Readings</title>
<style>
    /* CSS styles for print */
    body {
        font-family: 'Calibri', 'Arial', sans-serif;
        font-size: 10pt;
        background-color: #fff; /* Set background color to white */
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #ccc; /* Light grey border */
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f0f0f0; /* Light grey background */
        font-weight: bold;
    }
    /* Avoid breaking table rows across pages */
    tr {
        page-break-inside: avoid;
    }
</style>
</head>
<body onload="window.print()">
<div>
    <table id="sensor-table" class="table table-bordered table-striped">
       ` +divToPrint.outerHTML+`
    </table>
</div>
</body>
</html>`);
newWin.document.close();
setTimeout(function () { newWin.close(); }, 10);
}
