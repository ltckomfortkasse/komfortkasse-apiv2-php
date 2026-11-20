<?php

// Komfortkasse API v2 example
// sends an example order to Komfortkasse: POST /order/{orderNumber}

include_once __DIR__ . '/komfortkasse_api.php';
include_once __DIR__ . '/komfortkasse_buildorder.php';

$orderNumber = newOrderNumber();
list($status, $result) = komfortkasseApi('POST', '/order/' . rawurlencode($orderNumber), getOrder());
if ($status == 200) {
    rememberOrderNumber($orderNumber);
}

?>
<html>
<body>
<p>Order <?php echo htmlspecialchars($orderNumber); ?> sent, HTTP status <?php echo (int) $status; ?>:</p>
<pre><?php echo htmlspecialchars(is_array($result) ? json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $result); ?></pre>
</body>
</html>
