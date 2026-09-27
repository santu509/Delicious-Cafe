<?php include_once('category_action.php');
global $connect;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delicious Cafe Dashboard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../asset/bootstrap-5.3.7-dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Import Google Fonts for Cafe-themed typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="icon" type="image/png" href="../asset/image/Gemini_Generated_Image_y86qlny86qlny86q-removebg-preview.png">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #fdfbf7;
        }

        .Dashboard-right {
            width: 84%;
            float: right;
            background-color: #fdfbf7;
            min-height: 100vh;
            padding: 30px 40px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        /* Title styling */
        h2 {
            font-family: 'Playfair Display', Georgia, serif;
            font-weight: 700;
            color: #36221c;
        }

        .add-btn {
            font-size: 15px;
            font-weight: 700;
            background-color: #36221c;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            transition: 0.3s;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 10px rgba(54, 34, 28, 0.08);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .add-btn:hover {
            transform: translateY(-2px);
            background-color: #c18c5d;
            box-shadow: 0 6px 15px rgba(193, 140, 93, 0.25);
        }

        /* Premium Stat Card Styling */
        .custom-stat-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px 20px;
            box-shadow: 0 10px 30px rgba(54, 34, 28, 0.04);
            border: 1px solid #ebdcc8;
            border-top: 5px solid transparent; 
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .custom-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(54, 34, 28, 0.08);
        }

        .border-accent { border-top-color: #c18c5d !important; }
        .border-green { border-top-color: #20c997 !important; }
        .border-red { border-top-color: #ef4444 !important; }
        .border-coffee { border-top-color: #36221c !important; }

        .stat-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #8a7c77;
            text-transform: uppercase;
            margin-bottom: 6px;
            letter-spacing: 1px;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: #36221c;
            margin: 0;
        }

        .stat-icon-box {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .icon-accent { background-color: #fff7e6; color: #c18c5d; }
        .icon-green { background-color: #e8f9f4; color: #20c997; }
        .icon-red { background-color: #ffeef0; color: #ef4444; }
        .icon-coffee { background-color: #ebdcc8; color: #36221c; }

        /* Row Number Selector */
        #rownumberselector {
            border: 2px solid #ebdcc8;
            border-radius: 8px;
            color: #36221c;
            font-weight: 600;
            /* padding: 8px 12px; */
            font-size: 0.9rem;
        }

        #rownumberselector:focus {
            border-color: #c18c5d;
            box-shadow: 0 4px 12px rgba(193, 140, 93, 0.1);
        }

        /* Table Card Styling */
        .category-table {
            border-radius: 16px;
            border: 1px solid #ebdcc8;
            box-shadow: 0 10px 30px rgba(54, 34, 28, 0.04);
            background-color: #ffffff;
            overflow: hidden;
        }

        .category-table h4 {
            font-family: 'Playfair Display', Georgia, serif;
            font-weight: 700;
            color: #36221c;
        }

        .table th {
            background-color: #f5e1be !important;
            color: #36221c !important;
            font-weight: 700;
            padding: 15px 12px;
            border: none;
        }

        .table td {
            padding: 14px 12px;
            border-bottom: 1px solid #ebdcc8;
            color: #5c524f;
            vertical-align: middle;
        }

        /* Pagination style adjustments */
        .pagination .page-link {
            color: #36221c;
            border: 1px solid #ebdcc8;
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        .pagination .page-link:hover {
            background-color: #ebdcc8;
            color: #36221c;
        }

        .pagination .page-item.active .page-link {
            background-color: #c18c5d !important;
            border-color: #c18c5d !important;
            color: #ffffff !important;
        }

        /* Modals style customization */
        .custom-modal {
            border-radius: 16px;
            border: none;
            box-shadow: 0 20px 50px rgba(54, 34, 28, 0.15);
            overflow: hidden;
        }

        .custom-header {
            background-color: #36221c;
            color: #fff;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
            border: none;
            padding: 18px 24px;
        }

        .custom-close {
            filter: invert(1);
        }

        .custom-input {
            background-color: #ffffff !important;
            border: 2px solid #ebdcc8 !important;
            border-radius: 10px;
            color: #36221c;
            padding: 10px 14px;
        }

        .custom-input:focus {
            border-color: #c18c5d;
            box-shadow: 0 4px 12px rgba(193, 140, 93, 0.1);
        }

        .custom-label {
            font-weight: 700;
            font-size: 12px;
            color: #8a7c77;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }

        .cancel-btn, .save-btn {
            border-radius: 50px;
            padding: 10px 24px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .cancel-btn {
            border: 2px solid #ef4444;
            color: #ef4444;
            background: transparent;
        }

        .cancel-btn:hover {
            background-color: #ef4444;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .save-btn {
            border: none;
            background-color: #20c997;
            color: #ffffff;
        }

        .save-btn:hover {
            background-color: #1cb084;
            transform: translateY(-1px);
        }

        /* Toast message */
        .custom-toast {
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1055;
            min-width: 300px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* ====================================================
           Mobile Responsive CSS Override Stylesheet 
           ==================================================== */
        
        /* Tablets & Smaller Desktops */
        @media (max-width: 991px) {
            .Dashboard-right {
                width: 100% !important;
                float: none;
                padding: 25px 20px;
            }
        }

        /* Large Mobile & Tablets */
        @media (max-width: 768px) {
            .custom-stat-card {
                padding: 18px 15px;
            }
            .stat-value {
                font-size: 1.4rem;
            }
            .stat-title {
                font-size: 0.65rem;
            }
            .stat-icon-box {
                width: 44px;
                height: 44px;
                font-size: 18px;
            }
            .custom-toast {
                width: 90%;
                min-width: auto;
            }
        }

        /* Small Mobile Devices (Phones) */
        @media (max-width: 575px) {
            .Dashboard-right {
                padding: 20px 15px;
            }
            .header-container {
                flex-direction: column;
                align-items: stretch !important;
                text-align: center;
            }
            .header-container > div {
                margin-bottom: 15px;
            }
            .add-btn {
                width: 100%;
                padding: 14px 20px;
            }
            /* Stack action buttons vertically on tiny screens to save table space */
            .action-btns-wrapper {
                flex-direction: column;
                gap: 8px;
            }
            .action-btns-wrapper .btn {
                width: 100%;
                margin: 0 !important;
            }
            /* Reduce description width requirement on small phones */
            .desc-column {
                min-width: 180px !important;
            }
        }
    </style>
</head>

<body>
    <div class="toast position-fixed custom-toast" id="confirmTost" role="alert">
        <div class="d-flex">
            <div class="toast-body w-100" id="customalert"></div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
    
    <?php include("Dashboard.php") ?>

    <div class=" pt-4 px-3 px-md-5 Dashboard-right">

        <!-- Responsive Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 header-container">
            <div>
                <h2 style="color: #512d04; font-weight: bold;">Category Management</h2>
                <p class="text-muted mb-0">Organize your artisanal menu with precision and style.</p>
            </div>

            <button class="add-btn" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="fa fa-plus me-2"></i> Add Category
            </button>
        </div>

        <!-- Responsive Grid for Stat Cards -->
        <div class="row g-3 g-md-4">
            <!-- Stat Card 1 -->
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="custom-stat-card border-accent">
                    <div class="stat-content">
                        <div>
                            <p class="stat-title">Total Categories</p>
                            <h3 class="stat-value"><?php echo TotalCategory('categories') ?></h3>
                        </div>
                        <div class="stat-icon-box icon-accent"><i class="fa-solid fa-layer-group"></i></div>
                    </div>
                </div>
            </div>

            <!-- Stat Card 2 -->
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="custom-stat-card border-green">
                    <div class="stat-content">
                        <div>
                            <p class="stat-title">Active Categories</p>
                            <h3 class="stat-value"><?php echo ActiveCategory('categories') ?></h3>
                        </div>
                        <div class="stat-icon-box icon-green"><i class="fa-solid fa-circle-check"></i></div>
                    </div>
                </div>
            </div>

            <!-- Stat Card 3 -->
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="custom-stat-card border-red">
                    <div class="stat-content">
                        <div>
                            <p class="stat-title">Inactive Categories</p>
                            <h3 class="stat-value"><?php echo InActiveCategory('categories') ?></h3>
                        </div>
                        <div class="stat-icon-box icon-red"><i class="fa-solid fa-circle-xmark"></i></div>
                    </div>
                </div>
            </div>

            <!-- Stat Card 4 -->
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="custom-stat-card border-coffee">
                    <div class="stat-content">
                        <div>
                            <p class="stat-title">Total Items</p>
                            <h3 class="stat-value"><?php echo TotalItems('products') ?></h3>
                        </div>
                        <div class="stat-icon-box icon-coffee"><i class="fa-solid fa-mug-hot"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row Selector -->
        <div class="d-flex justify-content-start justify-content-md-end mt-4 mb-2">
            <select id="rownumberselector" class="form-select w-auto shadow-sm">
                <option value="5" <?php echo (isset($_GET['rows']) && $_GET['rows'] == 5) ? 'selected' : ''; ?>>Number of Rows - 5</option>
                <option value="10" <?php echo (isset($_GET['rows']) && $_GET['rows'] == 10) ? 'selected' : ''; ?>>Number of Rows - 10</option>
                <option value="15" <?php echo (isset($_GET['rows']) && $_GET['rows'] == 15) ? 'selected' : ''; ?>>Number of Rows - 15</option>
                <option value="20" <?php echo (isset($_GET['rows']) && $_GET['rows'] == 20) ? 'selected' : ''; ?>>Number of Rows - 20</option>
            </select>
        </div>

        <!-- Category Table -->
        <div class="card category-table mb-4">
            <h4 class="ms-3 ms-md-4 mt-3 mb-2">Menu Categories</h4>
            <div class="table-responsive p-0 p-md-2 border-top">
                <table class="table table-hover text-center align-middle text-nowrap mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Sl No.</th>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Items</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $NumberOfRows = $_GET['rows'] ?? 5;
                        $limit = $NumberOfRows;
                        $PageNumber = $_GET['pageid'] ?? 1;
                        $offset = ($PageNumber - 1) * $limit;

                        $sql = "SELECT * FROM categories LIMIT $limit OFFSET $offset";
                        $run = mysqli_query($connect, $sql);
                        
                        if ($run && mysqli_num_rows($run) > 0) {
                            $category_data = mysqli_fetch_all($run, MYSQLI_ASSOC);
                            foreach ($category_data as $key => $single_data) {
                        ?>
                                <tr>
                                    <td><b><?php echo ($offset + $key + 1); ?></b></td>
                                    <td class="fw-medium text-dark"><?php echo htmlspecialchars($single_data["name"]); ?></td>
                                    
                                    <!-- Dynamic class for description width -->
                                    <td class="text-wrap text-start desc-column" style="min-width: 250px;">
                                        <?php echo htmlspecialchars($single_data["description"]); ?>
                                    </td>
                                    
                                    <td>
                                        <?php
                                        $category_id = $single_data["id"];
                                        $totalitems = TotalItemsEachCategory('products', $category_id);
                                        echo "<b class='fs-6'>$totalitems</b>";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($single_data['status']) {
                                            echo "<span class='badge bg-success px-3 py-2 rounded-pill'>Active</span>";
                                        } else {
                                            echo "<span class='badge bg-danger px-3 py-2 rounded-pill'>Inactive</span>";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <!-- Wrapped actions in a custom container for targeted mobile styling -->
                                        <div class="d-flex justify-content-center align-items-center gap-2 action-btns-wrapper">
                                            <a href="#"
                                                class="btn btn-sm btn-warning editBtn text-dark fw-bold px-2 shadow-sm"
                                                data-id="<?php echo $single_data['id']; ?>"
                                                data-name="<?php echo htmlspecialchars($single_data['name']); ?>"
                                                data-status="<?php echo $single_data['status']; ?>"
                                                data-desc="<?php echo htmlspecialchars($single_data['description']); ?>"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editCategoryModal">
                                                <i class="fa fa-edit me-1"></i>
                                            </a>

                                            <a href="category_action.php?id=<?php echo $single_data["id"]; ?>&btn=category" onclick="return confirmAdminDelete(event, this.href, 'this category')"
                                                class="btn btn-sm btn-danger px-2 fw-bold shadow-sm">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan='6' class='text-danger fw-bold py-5'>No Records Found</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php
            $sql = "SELECT COUNT(*) as total FROM categories";
            $run = mysqli_query($connect, $sql);
            $row = mysqli_fetch_assoc($run);
            $totalNumberOfRows = $row['total'];
            $totalpage = ceil($totalNumberOfRows / $limit);
            ?>

            <?php if($totalpage > 1): ?>
            <div aria-label="Page navigation" class="d-flex justify-content-center justify-content-md-end p-3 bg-white">
                <ul class="pagination mb-0 flex-wrap justify-content-center gap-1">
                    <?php if ($PageNumber > 1): ?>
                        <li class="page-item">
                            <a class="page-link shadow-sm rounded" href="category.php?pageid=<?php echo $PageNumber - 1; ?>&rows=<?php echo $limit; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $totalpage; $i++): ?>
                        <li class="page-item <?php echo ($PageNumber == $i) ? 'active' : ''; ?>">
                            <a class="page-link shadow-sm rounded" href="category.php?pageid=<?php echo $i; ?>&rows=<?php echo $limit; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($PageNumber < $totalpage): ?>
                        <li class="page-item">
                            <a class="page-link shadow-sm rounded" href="category.php?pageid=<?php echo $PageNumber + 1; ?>&rows=<?php echo $limit; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Start Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header custom-header">
                    <h5 class="modal-title fw-bold">Add Category</h5>
                    <button type="button" class="btn btn-close bg-white custom-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="category_action.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="custom-label">CATEGORY NAME</label>
                            <input type="text" class="form-control custom-input" placeholder="e.g. Artisanal Roasts" name="category_name" required>
                        </div>
                        <div class="mb-4">
                            <label class="custom-label">DESCRIPTION</label>
                            <textarea class="form-control custom-input" rows="3" placeholder="Short description..." name="category_description" required></textarea>
                        </div>
                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end mt-4">
                            <button type="button" class="cancel-btn w-100" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="save-btn w-100" name="add-btn">Add Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Add Category Modal -->

    <!-- Start Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header custom-header">
                    <h5 class="modal-title fw-bold">Edit Category</h5>
                    <button type="button" class="btn btn-close bg-white custom-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="category_action.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="c_id" id="category_id">
                        
                        <div class="mb-3">
                            <label class="custom-label">CATEGORY NAME</label>
                            <input type="text" id="category_name" class="form-control custom-input" name="category_name" required>
                        </div>

                        <div class="mb-3">
                            <label class="custom-label">STATUS</label>
                            <select name="category_status" id="category_status" class="form-select custom-input">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="custom-label">DESCRIPTION</label>
                            <textarea id="category_description" class="form-control custom-input" rows="3" name="category_description" required></textarea>
                        </div>
                        
                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-end mt-4">
                            <button type="button" class="cancel-btn w-100" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="save-btn w-100" name="edit-btn">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Edit Category Modal -->

    <script src="../asset/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Start the number of rows select for pagination
        document.getElementById('rownumberselector').addEventListener("change", function() {
            window.location.href = "category.php?rows=" + this.value + "&pageid=1";
        });

        // Edit category modal data view start
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('category_id').value = this.dataset.id;
                document.getElementById('category_name').value = this.dataset.name;
                document.getElementById('category_status').value = this.dataset.status;
                document.getElementById('category_description').value = this.dataset.desc;
            });
        });

        // Toast message logic
        let ConfirmTost = document.getElementById('confirmTost');
        let customalertbox = document.getElementById('customalert');

        let status = <?php echo json_encode($_SESSION['status'] ?? null); ?>;
        let message = <?php echo json_encode($_SESSION['msg'] ?? null); ?>;
        
        if (status === true) {
            customalertbox.innerText = message;
            customalertbox.classList.add("fs-6", "text-white", "fw-medium");
            ConfirmTost.classList.add("text-bg-success", "border-0");
        } else if (status === false) {
            customalertbox.innerText = message;
            customalertbox.classList.add("fs-6", "text-white", "fw-medium");
            ConfirmTost.classList.add("text-bg-danger", "border-0");
        } else {
            ConfirmTost.style.display = "none";
        }

        if (status !== null) {
            let toast = new bootstrap.Toast(ConfirmTost, {
                delay: 3000
            });
            toast.show();
        }
        
        <?php
        unset($_SESSION['status']);
        unset($_SESSION['msg']);
        ?>

        // Admin Custom Delete Confirmation
        function confirmAdminDelete(e, url, itemName) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }

            if (typeof Swal === 'undefined') {
                if (confirm('Are you sure you want to delete ' + (itemName || 'this item') + '?')) {
                    window.location.href = url;
                }
                return false;
            }

            Swal.fire({
                title: 'Are you sure?',
                html: '<p style="color: #6c757d; font-size: 0.95rem; margin-top: 5px; margin-bottom: 0;">Do you really want to delete <b>' + (itemName || 'this item') + '</b>?<br><span style="font-size: 0.85rem; color: #dc3545; display: inline-block; margin-top: 6px;">This action cannot be undone!</span></p>',
                icon: 'warning',
                iconColor: '#e63946',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-trash me-1"></i> Yes, Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                reverseButtons: true,
                focusCancel: true,
                backdrop: 'rgba(50, 24, 5, 0.45)',
                customClass: {
                    popup: 'rounded-4 shadow-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });

            return false;
        }
    </script>
</body>

</html>