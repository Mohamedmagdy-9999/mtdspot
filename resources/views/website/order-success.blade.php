<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success - ShopHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div data-header></div>

    <main>
        <div class="container" style="max-width: 600px; margin: 4rem auto; text-align: center;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">✅</div>
            <h1 style="font-size: 2rem; margin-bottom: 1rem;">Order Placed Successfully!</h1>
            <p style="color: var(--text-secondary); margin-bottom: 2rem;">
                Thank you for your order. We've sent a confirmation email to your registered email address.
            </p>
            <div style="background-color: var(--bg-secondary); padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                <p style="margin-bottom: 0.5rem;"><strong>Order ID:</strong> <span id="order-id"></span></p>
                <p><strong>Estimated Delivery:</strong> 5-7 business days</p>
            </div>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="profile.html" class="btn btn--primary">View Orders</a>
                <a href="products.html" class="btn btn--outline">Continue Shopping</a>
            </div>
        </div>
    </main>

    <div data-footer></div>

    <script src="js/components.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const orderId = urlParams.get('orderId');
            if (orderId) {
                document.getElementById('order-id').textContent = orderId;
            }
        });
    </script>
</body>
</html>
