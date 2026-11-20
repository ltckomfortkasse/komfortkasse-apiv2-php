<?php

// Komfortkasse API v2 example
// reads the example orders from Komfortkasse: GET /order/{orderNumber} for every number in order_numbers.txt

include_once __DIR__ . '/komfortkasse_api.php';

$file = __DIR__ . '/order_numbers.txt';
$orderNumbers = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : array();

?>
<html>
<body>
<?php if (!$orderNumbers) { ?>
<p>No example orders yet, open komfortkasse_send.php first.</p>
<?php } else { ?>
<table border="1" cellpadding="4">
<tr><th>Order number</th><th>HTTP status</th><th>Payment status</th><th>Amount paid</th></tr>
<?php
    foreach ($orderNumbers as $orderNumber) {
        list($status, $order) = komfortkasseApi('GET', '/order/' . rawurlencode($orderNumber));
        $paymentStatus = is_array($order) && isset($order['paymentStatus']) ? $order['paymentStatus'] : (is_array($order) ? '' : $order);
        $amountPaid = is_array($order) && isset($order['amountPaid']) ? $order['amountPaid'] : '';
        echo '<tr><td>' . htmlspecialchars($orderNumber) . '</td><td>' . (int) $status . '</td><td>' . htmlspecialchars((string) $paymentStatus) . '</td><td>' . htmlspecialchars((string) $amountPaid) . "</td></tr>\n";
    }
?>
</table>
<?php } ?>
</body>
</html>
