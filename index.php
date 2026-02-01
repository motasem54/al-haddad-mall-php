<?php
require_once 'config.php';

// Get Categories
$categories_query = $pdo->query("SELECT * FROM categories ORDER BY sort_order");
$categories = $categories_query->fetchAll();

// Get Featured Products
$products_query = $pdo->query("SELECT * FROM products WHERE featured = 1 AND status = 'active' LIMIT 8");
$products = $products_query->fetchAll();

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <h1 class="hero-title">مرحباً بك في الحداد مول</h1>
        <p class="hero-subtitle">تسوق أفضل المنتجات بأسعار منافسة وجودة عالية</p>
        <a href="products.php" class="btn btn-gold btn-lg">تصفح المنتجات الآن</a>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section">
    <div class="container">
        <h2 class="section-title">أقسام المتجر</h2>
        <div class="categories-grid">
            <?php foreach($categories as $category): ?>
            <div class="category-card">
                <div class="category-icon" style="background: linear-gradient(135deg, <?php echo escape($category['color1']); ?>, <?php echo escape($category['color2']); ?>);">
                    <span class="icon"><?php echo $category['icon']; ?></span>
                </div>
                <h3 class="category-name"><?php echo escape($category['name']); ?></h3>
                <a href="products.php?category=<?php echo $category['id']; ?>" class="category-link">تصفح المنتجات</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="products-section">
    <div class="container">
        <h2 class="section-title">المنتجات المميزة</h2>
        <div class="products-grid">
            <?php foreach($products as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <img src="<?php echo escape($product['image']); ?>" alt="<?php echo escape($product['name']); ?>">
                    <?php if($product['discount'] > 0): ?>
                    <span class="discount-badge">-<?php echo $product['discount']; ?>%</span>
                    <?php endif; ?>
                </div>
                <div class="product-info">
                    <h3 class="product-name"><?php echo escape($product['name']); ?></h3>
                    <div class="product-price">
                        <?php if($product['discount'] > 0): ?>
                            <span class="old-price"><?php echo number_format($product['price'], 2); ?> <?php echo CURRENCY; ?></span>
                            <span class="new-price"><?php echo number_format($product['price'] * (1 - $product['discount']/100), 2); ?> <?php echo CURRENCY; ?></span>
                        <?php else: ?>
                            <span class="new-price"><?php echo number_format($product['price'], 2); ?> <?php echo CURRENCY; ?></span>
                        <?php endif; ?>
                    </div>
                    <button onclick="addToCart(<?php echo $product['id']; ?>)" class="btn btn-primary btn-block">أضف للسلة</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>