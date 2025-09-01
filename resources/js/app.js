import './bootstrap';
import Echo from "laravel-echo";

window.Echo.channel('orders')
    .listen('.OrderStatusUpdated', (event) => {
        alert(`Order #${event.order.id} status updated to ${event.order.status}`);
        // Or update DOM dynamically instead of alert
});

window.Echo.channel('orders')
.listen('.OrderStatusUpdated', (event) => {
    alert(`📦 Order #${event.order.id} status is now: ${event.order.status}`);
});