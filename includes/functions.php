<?php
/**
 * Helper functions and product CRUD operations with support for multiple images
 * and purchase/selling prices. This version removes the status (visibility) and
 * tag fields entirely; products are always visible and there is no tag input.
 */

// Escape HTML entities
function h($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

// Return 'active' CSS class if current page matches
function active($page, $current) {
    return $page === $current ? 'active' : '';
}

// Format a number as Vietnamese Dong currency
function money($n) {
    return '₫ ' . number_format((float)$n, 0, ',', '.');
}

/**
 * Fetch all products with aggregated information (KHÔNG phân trang).
 * Giữ lại để tương thích ngược nếu nơi khác còn dùng.
 */
function get_all_products() {
    $pdo = get_pdo();
    if (!$pdo) {
        return array();
    }
    $sql = "
        SELECT
            sp.ma_san_pham AS id,
            sp.ten_san_pham AS name,
            sp.mo_ta AS description,
            sp.gia_nhap AS purchase,
            sp.gia_ban AS price,
            COALESCE(SUM(ct.so_luong), 0) AS stock,
            dm.ten_danh_muc AS category,
            (
                SELECT anh.dia_chi_anh
                FROM anh_san_pham anh
                WHERE anh.ma_san_pham = sp.ma_san_pham AND anh.anh_chinh = 1
                ORDER BY anh.ma_anh ASC
                LIMIT 1
            ) AS image,
            sp.ngay_cap_nhat AS updated_at,
            COUNT(DISTINCT CONCAT(IFNULL(ct.kich_thuoc,''), '-', IFNULL(ct.mau_sac,''))) AS variants
        FROM san_pham sp
        LEFT JOIN chi_tiet_san_pham ct ON sp.ma_san_pham = ct.ma_san_pham
        LEFT JOIN danh_muc dm ON sp.ma_danh_muc = dm.ma_danh_muc
        GROUP BY sp.ma_san_pham
        ORDER BY sp.ngay_cap_nhat DESC
    ";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Đếm tổng số sản phẩm (hỗ trợ tìm kiếm theo mã hoặc tên).
 */
function get_total_products($q = '') {
    $pdo = get_pdo();
    if (!$pdo) return 0;

    $where = '';
    $params = [];
    if ($q !== '') {
        $where = 'WHERE sp.ma_san_pham LIKE ? OR sp.ten_san_pham LIKE ?';
        $kw = '%' . $q . '%';
        $params = [$kw, $kw];
    }

    $sql = "
        SELECT COUNT(*) FROM (
            SELECT sp.ma_san_pham
            FROM san_pham sp
            LEFT JOIN chi_tiet_san_pham ct ON sp.ma_san_pham = ct.ma_san_pham
            LEFT JOIN danh_muc dm ON sp.ma_danh_muc = dm.ma_danh_muc
            {$where}
            GROUP BY sp.ma_san_pham
        ) t
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return (int)$stmt->fetchColumn();
}

/**
 * Lấy danh sách sản phẩm có phân trang + tìm kiếm (SQL).
 * $limit: số sp/trang; $offset: vị trí bắt đầu; $q: từ khoá (mã hoặc tên).
 */
function get_products_paginated($limit, $offset, $q = '') {
    $pdo = get_pdo();
    if (!$pdo) return [];

    $where = '';
    $params = [];

    if ($q !== '') {
        // dùng placeholder có tên
        $where = 'WHERE sp.ma_san_pham LIKE :kw1 OR sp.ten_san_pham LIKE :kw2';
        $kw = '%' . $q . '%';
        $params[':kw1'] = $kw;
        $params[':kw2'] = $kw;
    }

    $sql = "
        SELECT
            sp.ma_san_pham AS id,
            sp.ten_san_pham AS name,
            sp.mo_ta AS description,
            sp.gia_nhap AS purchase,
            sp.gia_ban AS price,
            COALESCE(SUM(ct.so_luong), 0) AS stock,
            dm.ten_danh_muc AS category,
            (
                SELECT anh.dia_chi_anh
                FROM anh_san_pham anh
                WHERE anh.ma_san_pham = sp.ma_san_pham AND anh.anh_chinh = 1
                ORDER BY anh.ma_anh ASC
                LIMIT 1
            ) AS image,
            sp.ngay_cap_nhat AS updated_at,
            COUNT(DISTINCT CONCAT(IFNULL(ct.kich_thuoc,''), '-', IFNULL(ct.mau_sac,''))) AS variants
        FROM san_pham sp
        LEFT JOIN chi_tiet_san_pham ct ON sp.ma_san_pham = ct.ma_san_pham
        LEFT JOIN danh_muc dm ON sp.ma_danh_muc = dm.ma_danh_muc
        $where
        GROUP BY sp.ma_san_pham
        ORDER BY sp.ngay_cap_nhat DESC
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $pdo->prepare($sql);

    // bind các tham số tìm kiếm (nếu có)
    foreach ($params as $name => $value) {
        $stmt->bindValue($name, $value, PDO::PARAM_STR);
    }
    // bind limit/offset kiểu INT
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * Fetch a single product by ID.
 */
function get_product($id) {
    $pdo = get_pdo();
    if (!$pdo) {
        return null;
    }
    $sql = "
        SELECT
            sp.ma_san_pham AS id,
            sp.ten_san_pham AS name,
            sp.mo_ta AS description,
            sp.gia_nhap AS purchase,
            sp.gia_ban AS price,
            COALESCE(SUM(ct.so_luong), 0) AS stock,
            dm.ten_danh_muc AS category,
            (
                SELECT anh.dia_chi_anh
                FROM anh_san_pham anh
                WHERE anh.ma_san_pham = sp.ma_san_pham AND anh.anh_chinh = 1
                ORDER BY anh.ma_anh ASC
                LIMIT 1
            ) AS image,
            sp.ngay_cap_nhat AS updated_at
        FROM san_pham sp
        LEFT JOIN chi_tiet_san_pham ct ON sp.ma_san_pham = ct.ma_san_pham
        LEFT JOIN danh_muc dm ON sp.ma_danh_muc = dm.ma_danh_muc
        WHERE sp.ma_san_pham = ?
        GROUP BY sp.ma_san_pham
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($id));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
}

/**
 * Fetch all images for a specific product.
 */
function get_product_images($id) {
    $pdo = get_pdo();
    if (!$pdo) {
        return array();
    }
    $stmt = $pdo->prepare('SELECT ma_anh, dia_chi_anh, anh_chinh FROM anh_san_pham WHERE ma_san_pham = ? ORDER BY ma_anh ASC');
    $stmt->execute(array($id));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get the category ID from its name.
 */
function get_category_id($name) {
    $pdo = get_pdo();
    if (!$pdo) {
        return null;
    }
    $stmt = $pdo->prepare('SELECT ma_danh_muc FROM danh_muc WHERE ten_danh_muc = ?');
    $stmt->execute(array($name));
    $id = $stmt->fetchColumn();
    return $id ?: null;
}

/**
 * Save a product along with its variants and images.
 */
function save_product($product) {
    $pdo = get_pdo();
    if (!$pdo) {
        return false;
    }
    // Resolve category ID
    $categoryId = null;
    if (!empty($product['category'])) {
        $categoryId = get_category_id($product['category']);
    }
    // Determine whether to update or insert product
    $id = isset($product['id']) && $product['id'] ? $product['id'] : null;
    if ($id) {
        // Update existing product
        $stmt = $pdo->prepare('UPDATE san_pham SET ten_san_pham = ?, mo_ta = ?, gia_nhap = ?, gia_ban = ?, ma_danh_muc = ?, ngay_cap_nhat = NOW() WHERE ma_san_pham = ?');
        $result = $stmt->execute(array(
            $product['name'],
            $product['description'],
            $product['purchase'],
            $product['price'],
            $categoryId,
            $id
        ));
    } else {
        // Insert new product with auto-increment ID
        $stmt = $pdo->prepare('INSERT INTO san_pham (ten_san_pham, mo_ta, gia_nhap, gia_ban, ma_danh_muc, ngay_tao, ngay_cap_nhat) VALUES (?, ?, ?, ?, ?, NOW(), NOW())');
        $result = $stmt->execute(array(
            $product['name'],
            $product['description'],
            $product['purchase'],
            $product['price'],
            $categoryId
        ));
        $id = $result ? $pdo->lastInsertId() : null;
    }
    if (!$result || !$id) {
        return false;
    }
    // 1. Delete selected images if requested
    if (isset($product['delete_image']) && is_array($product['delete_image'])) {
        foreach ($product['delete_image'] as $imgId) {
            // Fetch file path to delete physical file
            $stmtDelPath = $pdo->prepare('SELECT dia_chi_anh FROM anh_san_pham WHERE ma_anh = ? AND ma_san_pham = ?');
            $stmtDelPath->execute(array($imgId, $id));
            $path = $stmtDelPath->fetchColumn();
            if ($path) {
                $fullPath = __DIR__ . '/../' . $path;
                if (file_exists($fullPath)) {
                    @unlink($fullPath);
                }
            }
            // Delete record from database
            $stmtDelRecord = $pdo->prepare('DELETE FROM anh_san_pham WHERE ma_anh = ? AND ma_san_pham = ?');
            $stmtDelRecord->execute(array($imgId, $id));
        }
    }
    // 2. Update main image flag if specified
    $mainImageId = isset($product['main_image']) && $product['main_image'] !== '' ? $product['main_image'] : null;
    if ($mainImageId) {
        // Set all images to non-main
        $stmtReset = $pdo->prepare('UPDATE anh_san_pham SET anh_chinh = 0 WHERE ma_san_pham = ?');
        $stmtReset->execute(array($id));
        // Set selected image as main
        $stmtSet = $pdo->prepare('UPDATE anh_san_pham SET anh_chinh = 1 WHERE ma_anh = ? AND ma_san_pham = ?');
        $stmtSet->execute(array($mainImageId, $id));
    }
    // 3. Handle new image uploads
    $newImageIds = array();
    if (isset($_FILES['image_files']) && !empty($_FILES['image_files']['name'][0])) {
        $filesCount = count($_FILES['image_files']['name']);
        for ($i = 0; $i < $filesCount; $i++) {
            if ($_FILES['image_files']['error'][$i] === UPLOAD_ERR_OK) {
                $tmpName  = $_FILES['image_files']['tmp_name'][$i];
                $basename = basename($_FILES['image_files']['name'][$i]);
                $ext      = strtolower(pathinfo($basename, PATHINFO_EXTENSION));
                $filename = uniqid() . '.' . $ext;
                $uploadDir = __DIR__ . '/../uploads/';
                if (!is_dir($uploadDir)) {
                    @mkdir($uploadDir, 0777, true);
                }
                $target = $uploadDir . $filename;
                if (move_uploaded_file($tmpName, $target)) {
                    $imagePath = 'uploads/' . $filename;
                    // Insert as non-main by default; we'll ensure one main later
                    $stmtInsImg = $pdo->prepare('INSERT INTO anh_san_pham (ma_san_pham, dia_chi_anh, anh_chinh) VALUES (?, ?, 0)');
                    $stmtInsImg->execute(array($id, $imagePath));
                    $newImageIds[] = $pdo->lastInsertId();
                }
            }
        }
    }
    // 4. Ensure there is a main image. If none flagged as main, pick one.
    $stmtCheck = $pdo->prepare('SELECT COUNT(*) FROM anh_san_pham WHERE ma_san_pham = ? AND anh_chinh = 1');
    $stmtCheck->execute(array($id));
    $hasMain = (int)$stmtCheck->fetchColumn() > 0;
    if (!$hasMain) {
        $mainIdToSet = null;
        if (!empty($newImageIds)) {
            $mainIdToSet = $newImageIds[0];
        } else {
            // pick the first available image
            $stmtFirst = $pdo->prepare('SELECT ma_anh FROM anh_san_pham WHERE ma_san_pham = ? ORDER BY ma_anh ASC LIMIT 1');
            $stmtFirst->execute(array($id));
            $mainIdToSet = $stmtFirst->fetchColumn();
        }
        if ($mainIdToSet) {
            $stmtSetMain = $pdo->prepare('UPDATE anh_san_pham SET anh_chinh = 1 WHERE ma_anh = ? AND ma_san_pham = ?');
            $stmtSetMain->execute(array($mainIdToSet, $id));
        }
    }
    // 5. Handle variants (sizes, colors, quantities)
    if (isset($product['variant_size']) && is_array($product['variant_size'])) {
        // Remove old variants
        $stmtDel = $pdo->prepare('DELETE FROM chi_tiet_san_pham WHERE ma_san_pham = ?');
        $stmtDel->execute(array($id));
        $sizes  = $product['variant_size'];
        $colors = $product['variant_color'] ?? array();
        $qtys   = $product['variant_qty']   ?? array();
        $count  = max(count($sizes), count($colors), count($qtys));
        for ($i = 0; $i < $count; $i++) {
            $size  = isset($sizes[$i])  ? trim($sizes[$i])  : '';
            $color = isset($colors[$i]) ? trim($colors[$i]) : '';
            $qty   = isset($qtys[$i])   ? (int)$qtys[$i]    : 0;
            if ($size !== '' && $color !== '' && $qty > 0) {
                $stmtIns = $pdo->prepare('INSERT INTO chi_tiet_san_pham (ma_san_pham, kich_thuoc, mau_sac, so_luong) VALUES (?, ?, ?, ?)');
                $stmtIns->execute(array($id, $size, $color, $qty));
            }
        }
    }
    return true;
}

/**
 * Delete a product and all its related data (images and variants).
 */
function delete_product($id) {
    $pdo = get_pdo();
    if (!$pdo) {
        return false;
    }
    // Remove images physically and from database
    $stmtImgs = $pdo->prepare('SELECT ma_anh, dia_chi_anh FROM anh_san_pham WHERE ma_san_pham = ?');
    $stmtImgs->execute(array($id));
    $images = $stmtImgs->fetchAll(PDO::FETCH_ASSOC);
    foreach ($images as $img) {
        $fullPath = __DIR__ . '/../' . $img['dia_chi_anh'];
        if (file_exists($fullPath)) {
            @unlink($fullPath);
        }
    }
    $stmtDelImgs = $pdo->prepare('DELETE FROM anh_san_pham WHERE ma_san_pham = ?');
    $stmtDelImgs->execute(array($id));
    // Remove variants
    $stmtDelVar = $pdo->prepare('DELETE FROM chi_tiet_san_pham WHERE ma_san_pham = ?');
    $stmtDelVar->execute(array($id));
    // Remove product
    $stmtDelProd = $pdo->prepare('DELETE FROM san_pham WHERE ma_san_pham = ?');
    return $stmtDelProd->execute(array($id));
}


/**
 * ====== FILTER HELPERS FOR PRODUCT LIST ======
 */

function dm_get_categories() {
    $pdo = get_pdo();
    if (!$pdo) return [];
    $sql = "SELECT ma_danh_muc, ten_danh_muc FROM danh_muc ORDER BY ten_danh_muc ASC";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function dm_get_sizes() {
    $pdo = get_pdo();
    if (!$pdo) return [];
    $sql = "SELECT DISTINCT kich_thuoc FROM chi_tiet_san_pham WHERE kich_thuoc IS NOT NULL AND kich_thuoc <> '' ORDER BY kich_thuoc";
    $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return array_values(array_filter(array_map(function($r){ return $r['kich_thuoc']; }, $rows)));
}

function dm_get_colors() {
    $pdo = get_pdo();
    if (!$pdo) return [];
    $sql = "SELECT DISTINCT mau_sac FROM chi_tiet_san_pham WHERE mau_sac IS NOT NULL AND mau_sac <> '' ORDER BY mau_sac";
    $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return array_values(array_filter(array_map(function($r){ return $r['mau_sac']; }, $rows)));
}

function dm_count_products_filtered($q = '', $category = null, $size = '', $color = '') {
    $pdo = get_pdo();
    if (!$pdo) return 0;

    $where = [];
    $params = [];

    if ($q !== '') {
        $where[] = "(sp.ma_san_pham LIKE :kw OR sp.ten_san_pham LIKE :kw)";
        $params[':kw'] = '%' . $q . '%';
    }
    if (!empty($category)) {
        $where[] = "sp.ma_danh_muc = :cat";
        $params[':cat'] = (int)$category;
    }
    if ($size !== '') {
        $where[] = "EXISTS (SELECT 1 FROM chi_tiet_san_pham ct WHERE ct.ma_san_pham = sp.ma_san_pham AND ct.kich_thuoc = :size)";
        $params[':size'] = $size;
    }
    if ($color !== '') {
        $where[] = "EXISTS (SELECT 1 FROM chi_tiet_san_pham ct2 WHERE ct2.ma_san_pham = sp.ma_san_pham AND ct2.mau_sac = :color)";
        $params[':color'] = $color;
    }

    $sql = "SELECT COUNT(*) AS total
            FROM san_pham sp
            " . (count($where) ? " WHERE " . implode(" AND ", $where) : "");

    $stmt = $pdo->prepare($sql);
    foreach ($params as $k=>$v) {
        if ($k === ':cat') $stmt->bindValue($k, (int)$v, PDO::PARAM_INT);
        else $stmt->bindValue($k, $v, PDO::PARAM_STR);
    }
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}

function dm_get_products_filtered($limit, $offset, $q = '', $category = null, $size = '', $color = '') {
    $pdo = get_pdo();
    if (!$pdo) return [];

    $where = [];
    $params = [
        ':limit' => (int)$limit,
        ':offset' => (int)$offset,
    ];

    if ($q !== '') {
        $where[] = "(sp.ma_san_pham LIKE :kw OR sp.ten_san_pham LIKE :kw)";
        $params[':kw'] = '%' . $q . '%';
    }
    if (!empty($category)) {
        $where[] = "sp.ma_danh_muc = :cat";
        $params[':cat'] = (int)$category;
    }
    if ($size !== '') {
        $where[] = "EXISTS (SELECT 1 FROM chi_tiet_san_pham ct WHERE ct.ma_san_pham = sp.ma_san_pham AND ct.kich_thuoc = :size)";
        $params[':size'] = $size;
    }
    if ($color !== '') {
        $where[] = "EXISTS (SELECT 1 FROM chi_tiet_san_pham ct2 WHERE ct2.ma_san_pham = sp.ma_san_pham AND ct2.mau_sac = :color)";
        $params[':color'] = $color;
    }

    $sql = "
        SELECT
            sp.ma_san_pham AS id,
            sp.ten_san_pham AS name,
            sp.mo_ta AS description,
            sp.gia_nhap AS purchase,
            sp.gia_ban AS price,
            COALESCE(SUM(ct.so_luong), 0) AS stock,
            dm.ten_danh_muc AS category,
            (
                SELECT anh.dia_chi_anh
                FROM anh_san_pham anh
                WHERE anh.ma_san_pham = sp.ma_san_pham AND anh.anh_chinh = 1
                ORDER BY anh.ma_anh ASC
                LIMIT 1
            ) AS image,
            sp.ngay_cap_nhat AS updated_at,
            COUNT(DISTINCT CONCAT(IFNULL(ct.kich_thuoc,''), '-', IFNULL(ct.mau_sac,''))) AS variants
        FROM san_pham sp
        LEFT JOIN danh_muc dm ON dm.ma_danh_muc = sp.ma_danh_muc
        LEFT JOIN chi_tiet_san_pham ct ON ct.ma_san_pham = sp.ma_san_pham
        " . (count($where) ? " WHERE " . implode(" AND ", $where) : "") . "
        GROUP BY sp.ma_san_pham
        ORDER BY sp.ngay_cap_nhat DESC
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $pdo->prepare($sql);
    foreach ($params as $k=>$v) {
        if ($k === ':limit' || $k === ':offset') {
            $stmt->bindValue($k, (int)$v, PDO::PARAM_INT);
        } elseif ($k === ':cat') {
            $stmt->bindValue($k, (int)$v, PDO::PARAM_INT);
        } else {
            $stmt->bindValue($k, $v, PDO::PARAM_STR);
        }
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
