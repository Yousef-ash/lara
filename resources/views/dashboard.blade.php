<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Devices') }}
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
                                      <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Devices</p>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-12">
                                      <div class="d-flex justify-content-start mb-3">
                                        <button type="button" class="btn btn-primary" style="background-color: #018673;">
                                          <a href="{{route('device.create')}}" class="text-white text-decoration-none" href="">Add Device</a>
                                        </button>
                                      </div>
                                      <div class="table-responsive">
                                        <table class="table">
                                          <thead>
                                            <tr>
                                              <th>Device Name</th>
                                              <th>Location</th>
                                              <th>Owner</th>
                                              <th>Controll</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            @foreach ($devices as $device)
                                              <tr>
                                                <td >
                                                    {{$device->device_name}}
                                                </td>
                                                <td>{{$device->location}}</td>
                                                <td>{{$device->user->name}}</td>
                                                <td>
                                                  <a class="btn btn-primary mb-1" href="{{route('sensors.index', ['id' => $device->id])}}" role="button" style="background-color: #21a38f;">Readings</a>
                                                  <a class="btn btn-primary mb-1" href="{{route('device.edit', ['id' => $device->id])}}" role="button" style="background-color: #21a38f;">Edit</a>
                                                  <form class="d-inline" action="{{route('device.destroy', ['id' => $device->id])}}" method="post">
                                                    @method('Delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                  </form>
                                                </td>
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

</x-app-layout>
