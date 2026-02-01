-- Create Database
CREATE DATABASE IF NOT EXISTS al_haddad_mall CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE al_haddad_mall;

-- Categories Table
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    icon VARCHAR(10) NOT NULL,
    color1 VARCHAR(20) NOT NULL,
    color2 VARCHAR(20) NOT NULL,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Products Table
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT NOT NULL,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    discount INT DEFAULT 0,
    image VARCHAR(255) NOT NULL,
    featured BOOLEAN DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Orders Table
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_name VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    customer_address TEXT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Order Items Table
CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Admin Users Table
CREATE TABLE admin_users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Sample Categories
INSERT INTO categories (name, icon, color1, color2, sort_order) VALUES
('خضروات وفواكه', '🥬', '#059669', '#047857', 1),
('لحوم وأسماك', '🥩', '#DC2626', '#991B1B', 2),
('ألبان وأجبان', '🧀', '#F59E0B', '#D97706', 3),
('مخبوزات', '🍞', '#F59E0B', '#D97706', 4),
('مشروبات', '🥤', '#2563EB', '#1E40AF', 5),
('معلبات', '🥫', '#EA580C', '#C2410C', 6),
('حلويات', '🍫', '#EC4899', '#DB2777', 7),
('منظفات', '🧴', '#8B5CF6', '#7C3AED', 8);

-- Insert Sample Products
INSERT INTO products (category_id, name, description, price, discount, image, featured) VALUES
(1, 'طماطم طازجة', 'طماطم طازجة من المزارع المحلية', 5.50, 10, 'https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=400', 1),
(1, 'خيار', 'خيار طازج ومقرمش', 3.00, 0, 'https://images.unsplash.com/photo-1568584711075-3d021a7c3ca3?w=400', 1),
(2, 'لحم بقري', 'لحم بقري طازج درجة أولى', 45.00, 15, 'https://images.unsplash.com/photo-1603048297172-c92544798d5a?w=400', 1),
(3, 'جبنة بيضاء', 'جبنة بيضاء طازجة', 12.00, 0, 'https://images.unsplash.com/photo-1452195100486-9cc805987862?w=400', 1),
(4, 'خبز فرنسي', 'خبز فرنسي طازج يومياً', 4.00, 0, 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400', 1),
(5, 'عصير برتقال', 'عصير برتقال طبيعي 100%', 8.50, 20, 'https://images.unsplash.com/photo-1600271886742-f049cd451bba?w=400', 1),
(6, 'تونة معلبة', 'تونة بزيت الزيتون', 6.00, 0, 'https://images.unsplash.com/photo-1584438784894-089d6a62b8fa?w=400', 1),
(7, 'شوكولاتة', 'شوكولاتة فاخرة بالحليب', 15.00, 25, 'https://images.unsplash.com/photo-1511381939415-e44015466834?w=400', 1);

-- Insert Default Admin (username: admin, password: admin123)
INSERT INTO admin_users (username, password, email) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@alhaddadmall.com');