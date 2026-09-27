<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("connection.php");
include_once("Ui-All-Function.php");

if (isset($_SESSION['id'])) {
    $favorite_all_items = all_favorite_item();
    if (!empty($favorite_all_items)) {
        foreach ($favorite_all_items as $items) {
            $single_menu = single_row_details('products', $items['product_id']);
            if ($single_menu) {
?>
                <div class="card cafe-fav-card mb-3 shadow-sm" data-product-id="<?php echo (int)$single_menu['id']; ?>">
                    <div class="row g-0 align-items-center h-100 w-75">
                        <div class="col-4 h-100">
                            <img src="upload/<?php echo htmlspecialchars($single_menu['image']); ?>" style="height: 15vh; width:100%;" alt="<?php echo htmlspecialchars($single_menu['name']); ?>">
                        </div>
                        <div class="col-8">
                            <div class="card-body py-2 px-3">
                                <h6 class="card-title fw-bold mb-1 text-dark">Item : <?php echo htmlspecialchars($single_menu['name']); ?></h6>
                                <p class="card-text fw-bold text-cafe-price mb-2">Rs : <?php echo htmlspecialchars($single_menu['price']); ?></p>
                                <div class="d-flex gap-2 align-items-center">
                                    <!-- Order Button -->
                                    <a href="order_page.php?id=<?php echo (int)$single_menu['id']; ?>&btn=order" class="fm-action-btn fm-order-btn font-sans">
                                        <i class="fa-solid fa-cart-shopping"></i> Order
                                    </a>

                                    <!-- Remove Button -->
                                    <a href="Ui-All-Function.php?pid=<?php echo (int)$single_menu['id']; ?>&btn=remove" class="fm-action-btn fm-remove-btn fav-remove-btn font-sans" data-product-id="<?php echo (int)$single_menu['id']; ?>" title="Remove from Favorites">
                                        <i class="fa-solid fa-trash-can"></i> Remove
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php
            }
        }
    } else {
?>
        <div class="card cafe-fav-card mb-3 shadow-sm empty-fav-msg">
            <div class="row g-0 align-items-center h-100">
                <h3 class="text-center p-2">No items Added</h3>
            </div>
        </div>
<?php
    }
} else {
?>
    <div class="card cafe-fav-card mb-3 shadow-sm empty-fav-msg">
        <div class="row g-0 align-items-center h-100">
            <h3 class="text-center p-2">No items Added</h3>
        </div>
    </div>
<?php
}
?>
