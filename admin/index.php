<?php
require_once '../config.php';

// Check if admin is logged in
if(!isset($_SESSION['admin_id'])) {
    redirect('login.php');
}

// Get Statistics
$total_products = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$total_categories = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$total_orders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$pending_orders = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetchColumn();

// Get Recent Orders
$recent_orders = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .admin-dashboard {
            padding: 40px;
            background: #F9FAFB;
            min-height: 100vh;
        }
        .dashboard-header {
            background: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            color: #6B7280;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .stat-card .number {
            font-size: 36px;
            font-weight: bold;
            color: var(--primary);
        }
        .recent-orders {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .recent-orders h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            text-align: right;
            border-bottom: 1px solid #E5E7EB;
        }
        th {
            background: #F3F4F6;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="admin-dashboard">
        <div class="dashboard-header">
            <h1>لوحة التحكم</h1>
            <p>مرحباً بك في لوحة التحكم الخاصة بـ <?php echo SITE_NAME; ?></p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>إجمالي المنتجات</h3>
                <div class="number"><?php echo $total_products; ?></div>
            </div>
            <div class="stat-card">
                <h3>الأقسام</h3>
                <div class="number"><?php echo $total_categories; ?></div>
            </div>
            <div class="stat-card">
                <h3>إجمالي الطلبات</h3>
                <div class="number"><?php echo $total_orders; ?></div>
            </div>
            <div class="stat-card">
                <h3>الطلبات المعلقة</h3>
                <div class="number"><?php echo $pending_orders; ?></div>
            </div>
        </div>

        <div class="recent-orders">
            <h2>آخر الطلبات</h2>
            <?php if(empty($recent_orders)): ?>
                <p>لا توجد طلبات حتى الآن</p>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th>اسم العميل</th>
                        <th>رقم الهاتف</th>
                        <th>المبلغ الإجمالي</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($recent_orders as $order): ?>
                    <tr>
                        <td>#<?php echo $order['id']; ?></td>
                        <td><?php echo escape($order['customer_name']); ?></td>
                        <td><?php echo escape($order['customer_phone']); ?></td>
                        <td><?php echo number_format($order['total'], 2); ?> <?php echo CURRENCY; ?></td>
                        <td><?php echo $order['status']; ?></td>
                        <td><?php echo date('Y-m-d H:i', strtotime($order['created_at'])); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>