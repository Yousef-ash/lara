<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $device->device_name }} Readings
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <section class="vh-100">
                        <div class="container h-100">
                          <div class="row justify-content-center align-items-center h-100">
                            <div class="col-lg-12 col-xl-11">
                              <div class="card" style="border-radius: 25px;">
                                <div class="card-body p-md-5">
                                  <div class="row justify-content-center align-items-center">
                                    <div class="col">
                                    </div>
                                    <div class="col-12">
                                      <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">{{$device->device_name}} Readings</p>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-12">
                                      <div class="d-flex justify-content-start mb-3">
                                        <button type="button" class="btn btn-primary" style="background-color: #018673;">
                                          <a href="{{route('dashboard')}}" class="text-white text-decoration-none" href="">Back</a>
                                        </button>
                                        <button class="mx-3" onclick="printTable()">Print Table</button>

                                      </div>
                                      <input type="hidden" id="device-id" value="{{ $device->id}}">
                                      <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                        <table id="sensor-table" class="table">
                                          <thead>
                                            <tr>
                                            <th>Device Name</th>
                                              <th>Temperature</th>
                                              <th>UV</th>
                                              <th>UV Level</th>
                                              <th>Humidity</th>
                                              <th>CO</th>
                                              <th>CO2</th>
                                              <th>Dust</th>
                                              <th>Concentration</th>
                                              <th>Time</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            @foreach ($sensors as $sensor)
                                              <tr>
                                                <td>{{$sensor->device->device_name}}</td>
                                                <td>{{$sensor->temperature}}</td>
                                                <td>{{$sensor->uv}}</td>
                                                <td>
                                                    @if ($sensor->uv <=4)
                                                        Normal
                                                    @else
                                                        High
                                                    @endif
                                                </td>
                                                <td>{{ $sensor->humidity}}</td>
                                                <td>{{$sensor->co}}</td>
                                                <td>{{$sensor->co_two}}</td>
                                                <td>{{$sensor->dust}}</td>
                                                <td>
                                                    @if ($sensor->dust <=1000 )
                                                        Clean
                                                    @elseif ($sensor->dust > 1000 && $sensor->dust < 10000)
                                                        Good

                                                    @elseif ($sensor->dust > 10000 && $sensor->dust < 20000)
                                                        Acceaptable

                                                    @elseif ($sensor->dust > 20000 && $sensor->dust < 50000)
                                                        Heavy
                                                    @elseif ( $sensor->dust > 50000)
                                                        Hazard
                                                    @else
                                                        Unknown
                                                    @endif
                                                </td>
                                                <td>{{ $sensor->created_at->format('Y-m-d h:i:s')  }}</td>
                                              </tr>
                                            @endforeach
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <script>
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

    </script>
</x-app-layout>


