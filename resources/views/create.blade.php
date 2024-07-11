<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Device') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <section class="vh-100">
                        <div class="container h-100">
                            <div class="row d-flex justify-content-center align-items-center h-100">
                                <div class="col-lg-12 col-xl-11">
                                    <div class="card text-black" style="border-radius: 25px;">
                                        <div class="card-body p-md-5">
                                            <div class="row justify-content-center">
                                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                                    <button class="btn" style="background-color: #192D34"><a
                                                            class="text-white text-decoration-none"
                                                            href="{{ route('dashboard') }}">Back</a></button>

                                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Create
                                                        Device</p>

                                                    <form class="mx-1 mx-md-4" method="POST"
                                                        action="{{ route('device.store') }}">
                                                        @csrf

                                                        <div class="d-flex flex-row align-items-center mb-4">

                                                            <div class="form-outline flex-fill mb-0">
                                                                <label class="form-label" for="name">Device
                                                                    Name</label>
                                                                <input type="text" required id="name"
                                                                    name="name" class="form-control" />
                                                            </div>
                                                        </div>
                                                        @if ($errors->has('name'))
                                                            <span
                                                                class="text-danger">{{ $errors->first('name') }}</span>
                                                        @endif
                                                        <div class="d-flex flex-row align-items-center mb-4">

                                                            <div class="form-outline flex-fill mb-0">
                                                                <label class="form-label"
                                                                    for="location">Location</label>
                                                                <input type="text" required id="location"
                                                                    name="location" class="form-control" />
                                                            </div>
                                                        </div>
                                                        @if ($errors->has('location'))
                                                            <span
                                                                class="text-danger">{{ $errors->first('location') }}</span>
                                                        @endif

                                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                                            <button type="submit" class="btn btn-primary btn-lg"
                                                                style="background-color: #018673;">Create</button>
                                                        </div>
                                                    </form>

                                                </div>
                                                <div
                                                    class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
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
