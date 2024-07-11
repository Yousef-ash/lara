<?php
namespace App\Events;

use App\Models\Sensor;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class SensorDataUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sensor;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Sensor $sensor)
    {
        $this->sensor = $sensor;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('sensor.' . $this->sensor->device_id);
    }

    public function broadcastWith()
    {
        return [
            'device_id' => $this->sensor->device_id,
            'device_name' => $this->sensor->device->device_name,
            'sensor' => $this->sensor,
        ];
    }
}

