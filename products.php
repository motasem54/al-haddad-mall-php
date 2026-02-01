<?php
require_once 'config.php';

$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build Query
$query = "SELECT p.*, c.name as category_name FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id 
          WHERE p.status = 'active'";

if($category_id > 0) {
    $query .= " AND p.category_id = :category_id";
}

if(!empty($search)) {
    $query .= " AND p.name LIKE :search";
}

$query .= " ORDER BY p.created_at DESC";

$stmt = $pdo->prepare($query);

if($category_id > 0) {
    $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
}

if(!empty($search)) {
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
}

$stmt->execute();
$products = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="page-header">
    <div class="container">
        <h1>المنتجات</h1>
        <?php if(!empty($search)): ?>
        <p>نتائج البحث عن: "<?php echo escape($search); ?>"</p>
        <?php endif; ?>
    </div>
</div>

<section class="products-page">
    <div class="container">
        <?php if(empty($products)): ?>
        <div class="empty-state">
            <p>لا توجد منتجات حالياً</p>
        </div>
        <?php else: ?>
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
                    <span class="product-category"><?php echo escape($product['category_name']); ?></span>
                    <h3 class="product-name"><?php echo escape($product['name']); ?></h3>
                    <p class="product-description"><?php echo escape($product['description']); ?></p>
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
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>