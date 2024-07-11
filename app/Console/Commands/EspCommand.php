<?php

namespace App\Console\Commands;

use App\Events\SensorDataUpdated;
use App\Models\Sensor;
use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;

class EspCommand extends Command
{

    protected $signature = 'mqtt:espCommand';
    protected $description = 'Get data from ESP32';

    protected $device_id = null;
    protected $ldr = null;
    protected $temperature = null;
    protected $uv = null;
    protected $humidity = null;
    protected $co = null;
    protected $co_two = null;
    protected $dust = null;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mqtt = MQTT::connection();

        $mqtt->subscribe('Esp32/device', function ($topic, $message) {
            $this->device_id = $message;
            $this->saveSensorData();
        });

        $mqtt->subscribe('Esp32/ldr', function ($topic, $message) {
            $this->ldr = $message;
            $this->saveSensorData();
        });

        $mqtt->subscribe('Esp32/temperature', function ($topic, $message) {
            $this->temperature = $message;
            $this->saveSensorData();
        });
        $mqtt->subscribe('Esp32/UV', function ($topic, $message) {
            $this->uv = $message;
            echo $message;
            $this->saveSensorData();
        });

        $mqtt->subscribe('Esp32/humidity', function ($topic, $message) {
            $this->humidity = $message;
            $this->saveSensorData();
        });

        $mqtt->subscribe('Esp32/dust', function ($topic, $message) {
            $this->dust = $message;
            $this->saveSensorData();
        });

        $mqtt->subscribe('Esp32/co2', function ($topic, $message) {
            $this->co_two = $message;
            $this->saveSensorData();
        });
        $mqtt->subscribe('Esp32/co', function ($topic, $message) {
            $this->co = $message;
            $this->saveSensorData();
        });

        $mqtt->loop(true);
    }

    protected function saveSensorData()
    {
        if ($this->device_id != null && $this->ldr != null && $this->uv != null &&  $this->temperature !== null && $this->humidity !== null && $this->co !== null && $this->co_two !== null && $this->dust !== null) {
            $sensor = new Sensor();
            $sensor->device_id = $this->device_id;
            $sensor->device_id = $this->ldr;
            $sensor->temperature = $this->temperature;
            $sensor->uv = $this->uv;
            $sensor->humidity = $this->humidity;
            $sensor->co = $this->co;
            $sensor->co_two = $this->co_two;
            $sensor->dust = $this->dust;
            $sensor->save();
            SensorDataUpdated::dispatch($sensor);
            $this->device_id = null;
            $this->ldr = null;
            $this->temperature = null;
            $this->humidity = null;
            $this->uv = null ;
            $this->co = null;
            $this->co_two = null;
            $this->dust = null;
        }
    }
}
