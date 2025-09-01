<?php

namespace App\Events;

use App\Models\Orders;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public function __construct(Orders $order)
    {
        $this->order = $order;
    }

    public function broadcastOn(): Channel
    {
        // Public channel for all admins
        return new Channel('orders');
    }

    public function broadcastAs(): string
    {
        return 'OrderStatusUpdated';
    }

    // public function broadcastWith(): array
    // {
    //     return [
    //         'message' => 'Order status updated',
    //         'id' => $this->order->id,
    //         'user_id' => $this->order->user_id,
    //         'product_id' => $this->order->product_id,
    //         'status' => $this->order->status,
    //         'updated_at' => $this->order->updated_at,
    //     ];
    // }
}