<?php
require_once 'config.php';

// Handle Cart Actions
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['action'])) {
        switch($_POST['action']) {
            case 'add':
                $product_id = (int)$_POST['product_id'];
                if(!isset($_SESSION['cart'][$product_id])) {
                    $_SESSION['cart'][$product_id] = 0;
                }
                $_SESSION['cart'][$product_id]++;
                echo json_encode(['success' => true, 'count' => getCartCount()]);
                exit;
            
            case 'update':
                $product_id = (int)$_POST['product_id'];
                $quantity = (int)$_POST['quantity'];
                if($quantity > 0) {
                    $_SESSION['cart'][$product_id] = $quantity;
                } else {
                    unset($_SESSION['cart'][$product_id]);
                }
                redirect('cart.php');
                break;
            
            case 'remove':
                $product_id = (int)$_POST['product_id'];
                unset($_SESSION['cart'][$product_id]);
                redirect('cart.php');
                break;
        }
    }
}

// Get Cart Items
$cart_items = [];
$total = 0;

if(!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll();
    
    foreach($products as $product) {
        $quantity = $_SESSION['cart'][$product['id']];
        $price = $product['discount'] > 0 
            ? $product['price'] * (1 - $product['discount']/100)
            : $product['price'];
        
        $cart_items[] = [
            'product' => $product,
            'quantity' => $quantity,
            'price' => $price,
            'subtotal' => $price * $quantity
        ];
        
        $total += $price * $quantity;
    }
}

include 'includes/header.php';
?>

<div class="page-header">
    <div class="container">
        <h1>سلة التسوق</h1>
    </div>
</div>

<section class="cart-page">
    <div class="container">
        <?php if(empty($cart_items)): ?>
        <div class="empty-cart">
            <h2>السلة فارغة</h2>
            <p>لم تقم بإضافة أي منتجات بعد</p>
            <a href="products.php" class="btn btn-primary">تصفح المنتجات</a>
        </div>
        <?php else: ?>
        <div class="cart-content">
            <div class="cart-items">
                <?php foreach($cart_items as $item): ?>
                <div class="cart-item">
                    <img src="<?php echo escape($item['product']['image']); ?>" alt="<?php echo escape($item['product']['name']); ?>">
                    <div class="item-details">
                        <h3><?php echo escape($item['product']['name']); ?></h3>
                        <p class="item-price"><?php echo number_format($item['price'], 2); ?> <?php echo CURRENCY; ?></p>
                    </div>
                    <div class="item-quantity">
                        <form method="POST">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="product_id" value="<?php echo $item['product']['id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="0" onchange="this.form.submit()">
                        </form>
                    </div>
                    <div class="item-total">
                        <p><?php echo number_format($item['subtotal'], 2); ?> <?php echo CURRENCY; ?></p>
                    </div>
                    <form method="POST" class="item-remove">
                        <input type="hidden" name="action" value="remove">
                        <input type="hidden" name="product_id" value="<?php echo $item['product']['id']; ?>">
                        <button type="submit" class="btn-remove">×</button>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="cart-summary">
                <h2>ملخص الطلب</h2>
                <div class="summary-row">
                    <span>المجموع الفرعي:</span>
                    <span><?php echo number_format($total, 2); ?> <?php echo CURRENCY; ?></span>
                </div>
                <div class="summary-row">
                    <span>رسوم التوصيل:</span>
                    <span>مجاناً</span>
                </div>
                <div class="summary-row total">
                    <span>الإجمالي:</span>
                    <span><?php echo number_format($total, 2); ?> <?php echo CURRENCY; ?></span>
                </div>
                <button class="btn btn-gold btn-block btn-lg">إتمام الطلب</button>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>