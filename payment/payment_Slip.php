<?php
// Database configuration
$db_host = 'localhost';
$db_user = 'username';
$db_pass = 'password';
$db_name = 'your_database';

// Connect to database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Include PHPMailer and TCPDF
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';
// require 'tcpdf/tcpdf.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to fetch order data from database
function getOrderData($order_id, $conn) {
    $order = [];
    
    // Get order details
    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
        
        // Get order items
        $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->bind_param("s", $order_id);
        $stmt->execute();
        $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $order['items'] = $items;
        
        // Get company info
        $stmt = $conn->prepare("SELECT * FROM company_info LIMIT 1");
        $stmt->execute();
        $company = $stmt->get_result()->fetch_assoc();
        $order = array_merge($order, $company);
    }
    
    return $order;
}


// Function to send email with payment slip
function sendPaymentEmail($order) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.example.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your_email@example.com';
        $mail->Password   = 'your_password';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        
        // Recipients
        $mail->setFrom($order['company_email'], $order['company_name']);
        $mail->addAddress($order['customer_email'], $order['customer_name']);
        
        // Generate email content
        $subtotal = 0;
        foreach ($order['items'] as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $tax = $subtotal * ($order['tax_rate'] / 100);
        $grand_total = $subtotal + $tax;
        
        $emailContent = "
        Dear {$order['customer_name']},
        
        Please find below the payment details for your order #{$order['order_id']}:
        
        Order Date: " . date('M j, Y', strtotime($order['order_date'])) . "
        Due Date: " . date('M j, Y', strtotime($order['due_date'])) . "
        
        ITEMS:
        ";
        
        foreach ($order['items'] as $item) {
            $amount = $item['price'] * $item['quantity'];
            $emailContent .= "
            - {$item['product_name']} (Qty: {$item['quantity']}) @ Rs. " . number_format($item['price'], 2) . " = Rs. " . number_format($amount, 2);
        }
        
        $emailContent .= "
        
        Subtotal: Rs. " . number_format($subtotal, 2) . "
        Tax ({$order['tax_rate']}%): Rs. " . number_format($tax, 2) . "
        Grand Total: Rs. " . number_format($grand_total, 2) . "
        
        PAYMENT INSTRUCTIONS:
        Please transfer the amount to:
        Bank: {$order['bank_name']}
        Account Name: {$order['account_name']}
        Account No: {$order['account_number']}
        Branch: {$order['branch']}
        
        Please include your Order #{$order['order_id']} in the payment reference.
        
        Thank you for your business!
        {$order['company_name']}
        ";
        
        // Generate PDF
        $pdfContent = generatePaymentSlipPDF($order);
        
        // Email content
        $mail->isHTML(false);
        $mail->Subject = 'Payment Slip for Order #' . $order['order_id'];
        $mail->Body    = $emailContent;
        
        // Attach PDF
        $mail->addStringAttachment($pdfContent, 'Payment_Slip_' . $order['order_id'] . '.pdf');
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email sending failed: " . $mail->ErrorInfo);
        return false;
    }
}

// Process request
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $order = getOrderData($order_id, $conn);
    
    if (!empty($order)) {
        // Display order data
        echo "<h1>Order #{$order['order_id']}</h1>";
        echo "<p>Customer: {$order['customer_name']}</p>";
        echo "<p>Email: {$order['customer_email']}</p>";
        echo "<p>Date: " . date('M j, Y', strtotime($order['order_date'])) . "</p>";
        
        // Send email button
        echo '<form method="post" style="margin:20px 0;">
                <input type="hidden" name="order_id" value="' . $order_id . '">
                <button type="submit" name="send_email">Send Payment Slip via Email</button>
              </form>';
        
        if (isset($_POST['send_email'])) {
            if (sendPaymentEmail($order)) {
                echo "<p style='color:green;'>Payment slip has been sent to {$order['customer_email']}</p>";
            } else {
                echo "<p style='color:red;'>Failed to send payment slip. Please try again.</p>";
            }
        }
    } else {
        echo "<p>Order not found.</p>";
    }
} else {
    echo "<p>No order specified.</p>";
}

$conn->close();
?>