<?php

namespace App\Events;

use App\Models\Orders;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class OrderCreated implements ShouldBroadcastNow
{
    use SerializesModels;

    public $order;

    public function __construct(Ordersor $order)
    {
        $this->order = $order;
    }

    // Broadcast on public channel "orders"
    public function broadcastOn()
    {
        return new Channel('orders');
    }

    public function broadcastAs()
    {
        return 'order.created';
    }

    public function broadcastWith()
    {
        return [
            'message' => 'Order crated',
            'id' => $this->order->id,
            'user_id' => $this->order->user_id,
            'product_id' => $this->order->product_id,
            'created_at' => $this->order->created_at,
        ];
    }
}
