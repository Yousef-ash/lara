<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SensorController;
use App\Models\Device;
use App\Models\Sensor;
use Illuminate\Support\Facades\Route;



Route::get('/dashboard', function () {
    return view('dashboard')->with('devices', Device::all());
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/', function () {
    return view('dashboard')->with('devices', Device::all());
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/create', [DeviceController::class, 'create'])->name('device.create');
    Route::get('/edit/{id}', [DeviceController::class, 'edit'])->name('device.edit');
    Route::post('/save', [DeviceController::class, 'store'])->name('device.store');
    Route::put('/update/{id}', [DeviceController::class, 'update'])->name('device.update');
    Route::delete('/delete/{id}', [DeviceController::class, 'destroy'])->name('device.destroy');
    Route::get('/sensors/{id}', [SensorController::class, 'show'])->name('sensors.index');
    
});

require __DIR__.'/auth.php';



