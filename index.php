<?php
session_start();
$config = json_decode(file_get_contents('data/config.json'), true);
$stats = json_decode(file_get_contents('data/stats.json'), true);
$stats['visits'] = ($stats['visits'] ?? 0) + 1;
file_put_contents('data/stats.json', json_encode($stats));
$thankYou = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $thankYou = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otar Digital Diary</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <h1>Otar Digital Diary</h1>
    <nav>
        <a href="#demo">Demo</a>
        <a href="#pricing">Pricing</a>
        <a href="#buy">Buy Now</a>
        <a href="admin.php">Admin</a>
    </nav>
</header>
<main>
    <section id="demo">
        <h2>Demo</h2>
        <p>Try out our digital diary before you buy!</p>
        <a href="demo.html" class="btn">View Demo</a>
    </section>
    <section id="pricing">
        <h2>Pricing Plans</h2>
        <div class="pricing-grid">
            <div class="plan">
                <h3>Basic Plan</h3>
                <p class="price">₹129</p>
                <ul><li>Basic diary functionality</li><li>5 custom pages</li></ul>
            </div>
            <div class="plan featured">
                <h3>Advanced Plan</h3>
                <p class="price">₹249</p>
                <ul><li>All Basic features</li><li>20 custom pages</li><li>Password protection</li></ul>
            </div>
            <div class="plan">
                <h3>Premium Plan</h3>
                <p class="price">₹399</p>
                <ul><li>All Advanced features</li><li>Unlimited pages</li><li>Cloud backup</li><li>Priority support</li></ul>
            </div>
        </div>
    </section>
    <section id="buy">
        <h2>Buy Now</h2>
        <?php if ($thankYou): ?>
            <div class="thank-you">
                <h3>Thank You for Your Purchase!</h3>
                <p>Please send your payment of ₹<?php echo $_POST['plan_price']; ?> to:</p>
                <p><strong>UPI ID:</strong> <?php echo $config['upi_id']; ?></p>
                <p><strong>Email Screenshot to:</strong> <?php echo $config['email']; ?></p>
                <p>We'll send your digital diary within 24 hours of payment confirmation.</p>
            </div>
        <?php else: ?>
            <form action="process.php" method="POST">
                <div class="form-group"><label for="name">Full Name:</label><input type="text" id="name" name="name" required></div>
                <div class="form-group"><label for="email">Email:</label><input type="email" id="email" name="email" required></div>
                <div class="form-group">
                    <label for="plan">Select Plan:</label>
                    <select id="plan" name="plan" required>
                        <option value="">-- Select a Plan --</option>
                        <option value="Basic" data-price="129">Basic Plan - ₹129</option>
                        <option value="Advanced" data-price="249">Advanced Plan - ₹249</option>
                        <option value="Premium" data-price="399">Premium Plan - ₹399</option>
                    </select>
                    <input type="hidden" id="plan_price" name="plan_price" value="">
                </div>
                <div class="form-group"><label for="customization">Customization Requests:</label><textarea id="customization" name="customization"></textarea></div>
                <button type="submit" class="btn">Proceed to Payment</button>
            </form>
        <?php endif; ?>
    </section>
    <section id="payment-info">
        <h2>Payment Instructions</h2>
        <p>After submitting your order, please send the payment to:</p>
        <p><strong>UPI ID:</strong> <?php echo $config['upi_id']; ?></p>
        <p>Then email the payment screenshot to: <?php echo $config['email']; ?></p>
    </section>
</main>
<footer>
    <p>&copy; <?php echo date('Y'); ?> Otar Digital Diary. All rights reserved.</p>
</footer>
<script>
    document.getElementById('plan').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        document.getElementById('plan_price').value = price;
    });
</script>
</body>
</html>
