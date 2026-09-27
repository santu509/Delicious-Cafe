<?php
// Include your admin dashboard header/sidebar
include_once('Dashboard.php');
global $connect;

// --- HANDLE STATUS UPDATE ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = mysqli_real_escape_string($connect, $_POST['order_status']);

    $update_query = "UPDATE orders SET order_status = '$new_status' WHERE id = $order_id";
    if (mysqli_query($connect, $update_query)) {
        $success_msg = "Order #ORD-$order_id status updated to $new_status.";
    } else {
        $error_msg = "Error updating status: " . mysqli_error($connect);
    }
}

// --- HANDLE FILTERS & PAGINATION ---
$where_clauses = [];
$filter_status = isset($_POST['filter_status']) ? $_POST['filter_status'] : 'all';
$filter_payment = isset($_POST['filter_payment']) ? $_POST['filter_payment'] : 'all';
$filter_date = isset($_POST['filter_date']) ? $_POST['filter_date'] : 'all';

// Pagination Variables
$limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 10; // Default 10 rows
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$offset = ($page - 1) * $limit;

// Status Filter Logic
if ($filter_status !== 'all') {
    $safe_status = mysqli_real_escape_string($connect, $filter_status);
    $where_clauses[] = "o.order_status = '$safe_status'";
}

// Payment Filter Logic
if ($filter_payment !== 'all') {
    $safe_payment = mysqli_real_escape_string($connect, $filter_payment);
    $where_clauses[] = "o.payment_method = '$safe_payment'";
}

// Date Filter Logic
if ($filter_date === 'today') {
    $where_clauses[] = "DATE(o.created_at) = CURDATE()";
} elseif ($filter_date === 'yesterday') {
    $where_clauses[] = "DATE(o.created_at) = CURDATE() - INTERVAL 1 DAY";
} elseif ($filter_date === 'this_week') {
    $where_clauses[] = "YEARWEEK(o.created_at, 1) = YEARWEEK(CURDATE(), 1)";
} elseif ($filter_date === 'this_month') {
    $where_clauses[] = "MONTH(o.created_at) = MONTH(CURDATE()) AND YEAR(o.created_at) = YEAR(CURDATE())";
}

// Build the final WHERE string for the Table
$where_sql = "";
if (count($where_clauses) > 0) {
    $where_sql = "WHERE " . implode(" AND ", $where_clauses);
}

// Get Total Records for Pagination
$count_query = "SELECT COUNT(o.id) as total FROM orders o LEFT JOIN products p ON o.product_id = p.id $where_sql";
$count_result = mysqli_query($connect, $count_query);
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $limit);

// --- FETCH DYNAMIC STATS ---
$order_count_query = "SELECT COUNT(id) as total_orders FROM orders";
$order_count_result = mysqli_query($connect, $order_count_query);
$total_orders = $order_count_result ? mysqli_fetch_assoc($order_count_result)['total_orders'] : 0;

$sales_query = "SELECT SUM(total_price) as total_sales FROM orders WHERE order_status != 'Cancelled'";
$sales_result = mysqli_query($connect, $sales_query);
$total_sales = $sales_result ? mysqli_fetch_assoc($sales_result)['total_sales'] : 0;
$total_sales = $total_sales ? $total_sales : 0;

$cash_query = "SELECT SUM(total_price) as total_cash FROM orders WHERE payment_method = 'Cash' AND order_status != 'Cancelled'";
$cash_result = mysqli_query($connect, $cash_query);
$total_cash = $cash_result ? mysqli_fetch_assoc($cash_result)['total_cash'] : 0;
$total_cash = $total_cash ? $total_cash : 0;

$online_query = "SELECT SUM(total_price) as total_online FROM orders WHERE payment_method = 'Net Banking' AND order_status != 'Cancelled'";
$online_result = mysqli_query($connect, $online_query);
$total_online = $online_result ? mysqli_fetch_assoc($online_result)['total_online'] : 0;
$total_online = $total_online ? $total_online : 0;
?>

<style>
    /* --- GENERAL DASHBOARD LAYOUT --- */
    .orders-wrapper {
        margin-left: 16%;
        padding: 30px;
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
        background-color: #f8fafc;
        box-sizing: border-box; /* Ensure padding doesn't cause overflow */
    }

    .page-title {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 28px;
        font-family: 'Playfair Display', serif;
        font-size: 1.85rem;
    }

    /* --- PREMIUM STYLISH STATS GRID --- */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 35px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.02);
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
    }

    .card-orders::before { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
    .card-sales::before { background: linear-gradient(90deg, #10b981, #34d399); }
    .card-cash::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .card-online::before { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }

    .stat-info {
        display: flex;
        flex-direction: column;
        z-index: 2;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .card-orders .stat-icon { background: #eff6ff; color: #2563eb; }
    .card-sales .stat-icon { background: #ecfdf5; color: #059669; }
    .card-cash .stat-icon { background: #fffbeb; color: #d97706; }
    .card-online .stat-icon { background: #f5f3ff; color: #7c3aed; }

    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
    }

    /* --- ALERTS --- */
    .custom-alert {
        border-radius: 12px;
        font-size: 16px;
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
    }

    /* --- FILTER BAR STYLES --- */
    .filter-bar {
        background: #ffffff;
        padding: 18px 24px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.02);
        margin-bottom: 24px;
        border: 1px solid #e2e8f0;
        display: flex;
        gap: 20px;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-group label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-select {
        padding: 9px 14px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 0.9rem;
        color: #334155;
        outline: none;
        min-width: 150px;
        background-color: #f8fafc;
        cursor: pointer;
        transition: 0.2s;
    }

    .filter-select:focus {
        border-color: #623501;
        box-shadow: 0 0 0 2px rgba(98, 53, 1, 0.1);
    }

    .btn-filter, .btn-reset {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 9px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: 0.2s;
        height: 41px;
        text-decoration: none;
    }

    .btn-filter {
        background-color: #623501;
        color: white;
        border: none;
    }

    .btn-filter:hover { background-color: #4a2801; }

    .btn-reset {
        background-color: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
    }

    .btn-reset:hover {
        background-color: #e2e8f0;
        color: #1e293b;
    }

    /* --- PREMIUM TABLE STYLES --- */
    .admin-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch; /* Smooth scroll on iOS */
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
        min-width: 900px; /* Forces table width on small screens to scroll nicely */
    }

    .admin-table thead {
        background-color: #623501;
    }

    .admin-table th {
        padding: 14px 18px;
        text-align: left;
        font-size: 0.85rem;
        text-transform: uppercase;
        color: #ffffff;
        font-weight: 600;
        letter-spacing: 0.75px;
        white-space: nowrap;
    }

    .admin-table td {
        padding: 18px 20px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        font-size: 0.95rem;
        color: #334155;
    }

    .admin-table tbody tr:hover {
        background-color: #fef7ef;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
        text-align: center;
        min-width: 90px;
    }

    .status-Pending { background-color: #fef3c7; color: #d97706; }
    .status-Processing { background-color: #e0f2fe; color: #0284c7; }
    .status-Completed { background-color: #d1fae5; color: #059669; }
    .status-Cancelled { background-color: #fee2e2; color: #dc2626; }

    .pay-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
        text-transform: uppercase;
        display: inline-block;
    }

    .pay-upi { background-color: #f3e8ff; color: #6b21a8; }
    .pay-cash { background-color: #e0f2fe; color: #0369a1; }

    .txn-text {
        display: block;
        font-size: 0.70rem;
        color: #030303;
        margin-top: 4px;
        font-family: monospace;
    }

    .status-select {
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 0.85rem;
        font-weight: 500;
        outline: none;
        background: #fff;
        color: #334155;
        cursor: pointer;
        transition: border-color 0.2s;
        width: 100%;
        min-width: 120px;
    }

    .status-select:focus {
        border-color: #8b5a2b;
    }

    /* --- PAGINATION STYLES --- */
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 24px;
        background: #fff;
        border-top: 1px solid #e2e8f0;
        flex-wrap: wrap;
        gap: 15px;
    }

    .pagination-info {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 500;
    }

    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 6px;
    }

    .page-btn {
        padding: 6px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        background: #fff;
        color: #334155;
        cursor: pointer;
        transition: 0.2s;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .page-btn:hover:not(:disabled) {
        background: #f8fafc;
        border-color: #94a3b8;
    }

    .page-btn.active {
        background: #623501;
        color: #fff;
        border-color: #623501;
        cursor: default;
    }

    .page-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* ==================================================
       MOBILE RESPONSIVE QUERIES (MEDIA QUERIES) 
       ================================================== */
    
    /* For tablets and smaller */
    @media (max-width: 992px) {
        .orders-wrapper {
            margin-left: 0; /* Assuming sidebar collapses or moves to top on mobile */
            padding: 20px 15px;
        }
    }

    /* For mobile phones */
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .stats-grid {
            grid-template-columns: 1fr; /* Stack stat cards vertically */
            gap: 15px;
        }

        .filter-bar {
            flex-direction: column; /* Stack filters vertically */
            align-items: stretch;
            padding: 15px;
        }

        .filter-group {
            width: 100%;
        }

        .filter-select, .btn-filter, .btn-reset {
            width: 100%; /* Make inputs and buttons full width */
        }
        
        .btn-filter i, .btn-reset i {
            margin-right: 8px; /* Proper spacing for icons */
        }

        .custom-alert {
            /* Center alerts nicely at top for small screens */
            right: 50%;
            transform: translateX(50%);
            width: 90%;
            min-width: auto;
            justify-content: space-between;
        }

        .pagination-wrapper {
            flex-direction: column;
            text-align: center;
        }

        .pagination {
            justify-content: center;
            flex-wrap: wrap;
        }
    }
</style>

<div class="orders-wrapper">
    <div class="container-fluid">
        <h2 class="page-title" style="color: #512d04; font-weight: bold;"> Order Management</h2>

        <?php if (isset($success_msg)): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 custom-alert" id="successAlert" role="alert">
                <span><i class="fas fa-check-circle me-2"></i> <?php echo $success_msg; ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($error_msg)): ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 custom-alert" role="alert">
                <span><i class="fas fa-exclamation-triangle me-2"></i> <?php echo $error_msg; ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="stats-grid">
            <div class="stat-card card-orders">
                <div class="stat-info">
                    <span class="stat-label">Total Orders</span>
                    <span class="stat-value"><?php echo number_format($total_orders); ?></span>
                </div>
                <div class="stat-icon"><i class="fas fa-shopping-bag"></i></div>
            </div>

            <div class="stat-card card-sales">
                <div class="stat-info">
                    <span class="stat-label">Total Sales</span>
                    <span class="stat-value">₹<?php echo number_format($total_sales, 2); ?></span>
                </div>
                <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
            </div>

            <div class="stat-card card-cash">
                <div class="stat-info">
                    <span class="stat-label">Cash Payments</span>
                    <span class="stat-value">₹<?php echo number_format($total_cash, 2); ?></span>
                </div>
                <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
            </div>

            <div class="stat-card card-online">
                <div class="stat-info">
                    <span class="stat-label">Net Banking</span>
                    <span class="stat-value">₹<?php echo number_format($total_online, 2); ?></span>
                </div>
                <div class="stat-icon"><i class="fas fa-qrcode"></i></div>
            </div>
        </div>

        <form method="POST" action="" id="filterForm" class="filter-bar">

            <input type="hidden" name="page" id="page_no" value="<?php echo $page; ?>">

            <div class="filter-group">
                <label>Show Rows</label>
                <select name="limit" class="filter-select" onchange="document.getElementById('page_no').value=1; this.form.submit();">
                    <option value="5" <?php echo $limit == 5 ? 'selected' : ''; ?>>5</option>
                    <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>10</option>
                    <option value="25" <?php echo $limit == 25 ? 'selected' : ''; ?>>25</option>
                    <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>50</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Date Range</label>
                <select name="filter_date" class="filter-select">
                    <option value="all" <?php echo $filter_date == 'all' ? 'selected' : ''; ?>>All Time</option>
                    <option value="today" <?php echo $filter_date == 'today' ? 'selected' : ''; ?>>Today</option>
                    <option value="yesterday" <?php echo $filter_date == 'yesterday' ? 'selected' : ''; ?>>Yesterday</option>
                    <option value="this_week" <?php echo $filter_date == 'this_week' ? 'selected' : ''; ?>>This Week</option>
                    <option value="this_month" <?php echo $filter_date == 'this_month' ? 'selected' : ''; ?>>This Month</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Order Status</label>
                <select name="filter_status" class="filter-select">
                    <option value="all" <?php echo $filter_status == 'all' ? 'selected' : ''; ?>>All Statuses</option>
                    <option value="Pending" <?php echo $filter_status == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="Processing" <?php echo $filter_status == 'Processing' ? 'selected' : ''; ?>>Processing</option>
                    <option value="Completed" <?php echo $filter_status == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                    <option value="Cancelled" <?php echo $filter_status == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Payment</label>
                <select name="filter_payment" class="filter-select">
                    <option value="all" <?php echo $filter_payment == 'all' ? 'selected' : ''; ?>>All Methods</option>
                    <option value="Cash" <?php echo $filter_payment == 'Cash' ? 'selected' : ''; ?>>Cash Only</option>
                    <option value="Net Banking" <?php echo $filter_payment == 'Net Banking' ? 'selected' : ''; ?>>Net Banking</option>
                </select>
            </div>

            <button type="button" class="btn-filter" onclick="document.getElementById('page_no').value=1; document.getElementById('filterForm').submit();">
                <i class="fas fa-filter"></i> Apply
            </button>

            <a href="javascript:window.location.href=window.location.pathname;" class="btn-reset">
                <i class="fas fa-undo"></i> Reset
            </a>
        </form>

        <div class="admin-card">
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="text-align: center">Sl.No</th>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Product Info</th>
                            <th>Payment</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Apply LIMIT and OFFSET for Pagination
                        $query = "SELECT o.*, p.name as product_name 
                                  FROM orders o 
                                  LEFT JOIN products p ON o.product_id = p.id 
                                  $where_sql 
                                  ORDER BY o.created_at DESC 
                                  LIMIT $limit OFFSET $offset";

                        $result = mysqli_query($connect, $query);

                        if (mysqli_num_rows($result) > 0) {
                            $serial_no = $offset + 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $date = date('d M, Y h:i A', strtotime($row['created_at']));
                                $pay_class = ($row['payment_method'] == 'Net Banking') ? 'pay-upi' : 'pay-cash';
                                $status_class = "status-" . $row['order_status'];
                                $product_display = !empty($row['product_name']) ? $row['product_name'] : "Product ID: " . $row['product_id'];
                                $payment_display_text = ($row['payment_method'] == 'Net Banking') ? 'Net Banking' : 'Cash';

                                echo "<tr>";
                                echo "<td style='text-align: center;'><strong>{$serial_no}</strong></td>";
                                echo "<td><strong style='color: #623501;'>#ORD-{$row['id']}</strong></td>";
                                echo "<td style='font-size: 0.9rem;'><small>{$date}</small></td>";
                                echo "<td><strong>" . htmlspecialchars($row['customer_name']) . "</strong></td>";

                                echo "<td>
                                        <span style='font-weight: 600; color: #1e293b;'>" . htmlspecialchars($product_display) . "</span><br>
                                        <small>Qty: {$row['quantity']} × ₹{$row['price']}</small>
                                      </td>";

                                echo "<td>
                                        <span class='pay-badge {$pay_class}'>{$payment_display_text}</span>";
                                if (!empty($row['transaction_id'])) {
                                    echo "<span class='txn-text'>ID: {$row['transaction_id']}</span>";
                                }
                                echo "</td>";

                                echo "<td><strong style='color: #0f172a;'>₹" . number_format($row['total_price'], 2) . "</strong></td>";
                                echo "<td><span class='status-badge {$status_class}'>{$row['order_status']}</span></td>";

                                // Action Form Dropdown
                                echo "<td>
                                        <form method='POST' class='action-form mb-0'>
                                            <input type='hidden' name='order_id' value='{$row['id']}'>
                                            <select name='order_status' class='status-select' onchange='this.form.submit()'>
                                                <option value='Pending' " . ($row['order_status'] == 'Pending' ? 'selected' : '') . ">Pending</option>
                                                <option value='Processing' " . ($row['order_status'] == 'Processing' ? 'selected' : '') . ">Processing</option>
                                                <option value='Completed' " . ($row['order_status'] == 'Completed' ? 'selected' : '') . ">Completed</option>
                                                <option value='Cancelled' " . ($row['order_status'] == 'Cancelled' ? 'selected' : '') . ">Cancelled</option>
                                            </select>
                                            <input type='hidden' name='update_status' value='1'>
                                        </form>
                                      </td>";
                                echo "</tr>";
                                $serial_no++;
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center py-5 text-muted'>No orders found matching your filter criteria.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?php if ($total_pages > 0): ?>
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Showing <?php echo $offset + 1; ?> to <?php echo min($offset + $limit, $total_records); ?> of <?php echo $total_records; ?> entries
                    </div>
                    <ul class="pagination">
                        <li>
                            <button class="page-btn" <?php echo ($page <= 1) ? 'disabled' : ''; ?>
                                onclick="changePage(<?php echo $page - 1; ?>)"><i class="fas fa-chevron-left"></i></button>
                        </li>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li>
                                <button class="page-btn <?php echo ($page == $i) ? 'active' : ''; ?>"
                                    onclick="changePage(<?php echo $i; ?>)"><?php echo $i; ?></button>
                            </li>
                        <?php endfor; ?>

                        <li>
                            <button class="page-btn" <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>
                                onclick="changePage(<?php echo $page + 1; ?>)"><i class="fas fa-chevron-right"></i></button>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<script>
    // JS Function to change page and submit the filter form
    function changePage(pageNum) {
        document.getElementById('page_no').value = pageNum;
        document.getElementById('filterForm').submit();
    }

    // success message hide and show
    setTimeout(() => {
        document.getElementById('successAlert')?.remove();
    }, 1500);
</script>