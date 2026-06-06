<?php $__env->startSection('title', 'My Orders'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h3 class="mb-4">My Orders</h3>

    <?php if($orders->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Order Status</th>
                        <th>Payment Status</th>
                        <th>Delivery Status</th>
                        <th>Delivery Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr id="order-<?php echo e($order->id); ?>">
                            <td>#<?php echo e($order->id); ?></td>
                            <td><?php echo e($order->order_date->format('d M, Y H:i')); ?></td>
                            <td>Rs. <?php echo e(number_format($order->total, 2)); ?></td>

                            
                            <td>
                                <?php
                                    $orderStatusClass = 'bg-secondary';
                                    if ($order->order_status == 'Pending') $orderStatusClass = 'bg-warning';
                                    elseif ($order->order_status == 'Confirmed') $orderStatusClass = 'bg-success';
                                    elseif ($order->order_status == 'Cancelled') $orderStatusClass = 'bg-danger';
                                ?>
                                <span class="badge <?php echo e($orderStatusClass); ?>">
                                    <?php echo e($order->order_status); ?>

                                </span>
                            </td>

                            
                            <td>
                                <?php
                                    $paymentStatusClass = 'bg-secondary';
                                    if ($order->payment_status == 'Pending') $paymentStatusClass = 'bg-warning';
                                    elseif ($order->payment_status == 'Paid') $paymentStatusClass = 'bg-success';
                                    elseif ($order->payment_status == 'Failed') $paymentStatusClass = 'bg-danger';
                                ?>
                                <span class="badge <?php echo e($paymentStatusClass); ?>">
                                    <?php echo e($order->payment_status); ?>

                                </span>
                            </td>

                            
                            <td>
                                <?php
                                    $deliveryStatusClass = 'bg-secondary';
                                    if ($order->delivery_status == 'Pending') $deliveryStatusClass = 'bg-warning';
                                    elseif ($order->delivery_status == 'Delivered') $deliveryStatusClass = 'bg-success';
                                    elseif ($order->delivery_status == 'Shipped') $deliveryStatusClass = 'bg-info';
                                    elseif ($order->delivery_status == 'Cancelled') $deliveryStatusClass = 'bg-danger';
                                ?>
                                <span class="badge <?php echo e($deliveryStatusClass); ?>">
                                    <?php echo e($order->delivery_status); ?>

                                </span>
                            </td>

                            <td>
                                <?php echo e($order->delivery_date?->format('d M, Y H:i') ?? 'Not Delivered Yet'); ?>

                            </td>

                            <td class="d-flex flex-column gap-2">
                                <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn btn-sm btn-info text-white">View Details</a>
                                <a href="<?php echo e(route('items.invoice', $order->id)); ?>" class="btn btn-sm btn-primary">View Invoice</a>

                                <?php if($order->order_status == 'Pending'): ?>
                                    <button class="btn btn-sm btn-danger cancel-order" data-id="<?php echo e($order->id); ?>">Cancel</button>
                                <?php endif; ?>
                            </td>
                        </tr>

                        
                        <tr class="order-items-row">
                            <td colspan="8">
                                <strong>Items:</strong>
                                <ul class="list-unstyled mb-2">
                                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <?php echo e($item->item->title); ?> (x<?php echo e($item->quantity); ?>) - Rs. <?php echo e(number_format($item->price, 2)); ?>

                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>

                                
                                <strong>Payment History:</strong>
                                <?php if($order->payments->count() > 0): ?>
                                    <table class="table table-sm table-bordered mt-2">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Gateway</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Transaction ID</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $order->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $paymentClass = 'bg-secondary';
                                                    if ($payment->status == 'Pending') $paymentClass = 'bg-warning';
                                                    elseif ($payment->status == 'Paid') $paymentClass = 'bg-success';
                                                    elseif ($payment->status == 'Failed') $paymentClass = 'bg-danger';
                                                    elseif ($payment->status == 'Refunded') $paymentClass = 'bg-secondary';
                                                ?>
                                                <tr>
                                                    <td><?php echo e(strtoupper($payment->gateway)); ?></td>
                                                    <td>Rs. <?php echo e(number_format($payment->amount, 2)); ?></td>
                                                    <td><span class="badge <?php echo e($paymentClass); ?>"><?php echo e($payment->status); ?></span></td>
                                                    <td><?php echo e($payment->transaction_id ?? 'N/A'); ?></td>
                                                    <td><?php echo e($payment->created_at->format('d M, Y H:i')); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p class="text-muted mb-0">No payment records found.</p>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center">You have no orders yet. <a href="<?php echo e(route('home')); ?>">Start Shopping</a></p>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.cancel-order');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.dataset.id;
            if(confirm('Are you sure you want to cancel this order?')) {
                fetch(`/my-orders/${orderId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({})
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success){
                        alert(data.success);
                        const badge = document.querySelector(`#order-${orderId} td:nth-child(4) span`);
                        badge.textContent = 'Cancelled';
                        badge.className = 'badge bg-danger';
                        const deliveryBadge = document.querySelector(`#order-${orderId} td:nth-child(6) span`);
                        deliveryBadge.textContent = 'Cancelled';
                        deliveryBadge.className = 'badge bg-danger';
                        const deliveryDateCell = document.querySelector(`#order-${orderId} td:nth-child(7)`);
                        const now = new Date();
                        deliveryDateCell.textContent = now.toLocaleString();
                        this.remove();
                    } else {
                        alert(data.error);
                    }
                })
                .catch(err => console.error(err));
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Genz_Shop\resources\views/web/user/orders.blade.php ENDPATH**/ ?>