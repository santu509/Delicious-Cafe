<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once('All-Function.php');
include_once('product_list_action.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delicious Cafe Dashboard</title>

    <link rel="stylesheet" href="../asset/bootstrap-5.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
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
            overflow-x: hidden;
            /* Warm cafe background */
            background-color: #fcf9f4; 
        }

        /* ========================
           NEW EXACT IMAGE CARD STYLES
           ======================== */
        .top-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            background-color: #fff;
            padding: 10px 5px;
        }
        
        /* Top Borders matching the image */
        .border-top-blue { border-top: 4px solid #3b82f6; }
        .border-top-green { border-top: 4px solid #10b981; }
        .border-top-orange { border-top: 4px solid #f59e0b; }

        /* Icon Boxes matching the image */
        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }
        
        .bg-blue-soft { background-color: #eff6ff; color: #3b82f6; }
        .bg-green-soft { background-color: #ecfdf5; color: #10b981; }
        .bg-orange-soft { background-color: #fef3c7; color: #f59e0b; }

        /* Typography matching the image */
        .card-title-text {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .card-value-text {
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
            line-height: 1;
        }

        /* ========================
           CAFE THEME STYLES (Table, Buttons, Modal)
           ======================== */
        .card-table-wrapper {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            border: none;
            background-color: #fff;
        }

        /* Cafe theme dark brown table header */
        .table thead {
            background-color: #512d04; 
            color: #f6ddbe;
        }

        .table tbody tr:hover {
            background-color: #fdf3e6; /* Soft warm hover */
            transition: 0.3s;
        }

        .product-img {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #eedfbf;
        }

        .btn-custom {
            border-radius: 20px;
            padding: 5px 12px;
        }

        /* Cafe themed Add Button */
        .cafe-add-btn {
            background-color: #f2a546;
            color: black;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 8px 15px;
            transition: 0.3s;
        }
        
        .cafe-add-btn:hover {
            background-color: #a55d04;
            color: white;
        }

        .badge {
            padding: 6px 10px;
            font-size: 13px;
        }

        h3.title { font-weight: bold; color: #512d04; }
        
        /* Modal styling */
        .model-header-bg { background-color: #512d04; }
        #additem-modal { color: black; }
        
        label.form-label {
            color: #512d04;
            font-weight: 600;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        textarea.input-field, select.input-field, input.input-field {
            background-color: #fdf8f5;
            border: 1px solid #e2d1c3;
        }
        
        textarea.input-field:focus, select.input-field:focus, input.input-field:focus {
            background-color: #fff;
            border-color: #f2a546;
            box-shadow: 0 0 0 0.25rem rgba(242, 165, 70, 0.25);
        }

        .cancel-btn {
            border: 1px solid #e10505;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            background: transparent;
            color: #e10505;
            transition: all 300ms ease;
        }

        .cancel-btn:hover {
            background-color: #e10505;
            color: #fbfafa;
        }

        .save-btn {
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            background-color: #08a329;
            color: #fbf9f9;
            font-weight: 600;
        }

        .save-btn:hover { background-color: #03731b; }

        #image-pre {
            width: 50px;
            height: 50px;
            background-color: #dfdcdc;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .fa-question { font-size: 20px; }
        
        .custom-toast {
            top: 10%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1060;
        }

        .CategoriwiseView {
            background-color: #eedfbf;
            font-weight: 600;
            border: 1px solid #dcae65;
            color: #512d04;
        }

        /* Pagination custom color */
        .pagination .page-item.active .page-link {
            background-color: #f2a546;
            border-color: #f2a546;
            color: black;
            font-weight: bold;
        }
        .pagination .page-link {
            color: #512d04;
        }

        @media (max-width: 768px) {
            .product-img { width: 40px; height: 40px; }
            .btn-custom { padding: 4px 8px; font-size: 12px; }
            .action-bar { flex-direction: column; align-items: stretch !important; gap: 10px; }
            .action-controls { flex-direction: column; width: 100% !important; }
            .action-controls select, .action-controls button { width: 100%; }
        }
    </style>
</head>

<body>

    <?php include('Dashboard.php'); ?>

    <div class="toast position-fixed custom-toast" id="confirmTost" role="alert">
        <div class="d-flex">
            <div class="toast-body" id="customalert"></div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>

    <div class="Dashboard-right">
        <div class="container-fluid pt-4 px-2 px-md-4 px-lg-5">
            
            <div class="mb-4">
                <h2 style="color: #512d04; font-weight: bold;">Menu Management</h2>
                <p class="text-muted mb-0">Organize your artisanal menu with precision and style.</p>
            </div>
            
            <div class="row g-3 mb-4">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card top-card border-top-blue h-100 ">
                        <div class="card-body d-flex justify-content-between align-items-center ">
                            <div>
                                <div class="card-title-text">Total Items</div>
                                <div class="card-value-text"><?php echo TotalItems('products') ?></div>
                            </div>
                            <div class="icon-box bg-blue-soft">
                                <i class="fa-solid fa-bag-shopping"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card top-card border-top-green h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="card-title-text">Available Items</div>
                                <div class="card-value-text"><?php echo AvailableItems('products') ?></div>
                            </div>
                            <div class="icon-box bg-green-soft">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-12">
                    <div class="card top-card border-top-orange h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <div class="card-title-text">Not Available Items</div>
                                <div class="card-value-text"><?php echo NotAvailableItems('products') ?></div>
                            </div>
                            <div class="icon-box bg-orange-soft">
                                <i class="fa-solid fa-money-bill-wave"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-table-wrapper p-3 p-md-4 mb-5">
                <div class="d-flex justify-content-between align-items-center mb-3 action-bar">
                    <h3 class="title m-0">Coffee Items</h3>
                    
                    <div class="d-flex align-items-center gap-2 action-controls w-auto">
                        <select class="rounded p-2 form-select CategoriwiseView text-center" id="selected">
                            <option disabled selected>Category View</option>
                            <option value="All">All Category</option>
                            <?php
                            $cid = $_GET['category'] ?? 'All';
                            $allCategory = Allcategory('categories');
                            foreach ($allCategory as $SingleCategory) {
                            ?>
                                <option value="<?php echo $SingleCategory['id'] ?>" <?php echo $SingleCategory['id'] == $cid ? 'Selected' : ''; ?>><?php echo $SingleCategory['name'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        
                        <button class="cafe-add-btn text-nowrap" data-bs-toggle="modal" data-bs-target="#additem-modal">
                            <i class="fa fa-plus"></i> Add Item
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <span class="small fw-bold text-muted">Show</span>
                        <select id="rowsPerPage" class="form-select form-select-sm w-auto cursor-pointer" style="border-color: #eedfbf;">
                            <option value="5" selected>5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                        <span class="small fw-bold text-muted">Entries</span>
                    </div>
                </div>

                <div class="table-responsive border rounded" style="border-color: #eedfbf !important;">
                    <table class="table table-bordered table-hover text-center align-middle mb-0" id="productTable">
                        <thead>
                            <tr>
                                <th>Sl. No</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $AllTableData = Allproduct($cid);
                            if (!empty($AllTableData)) {
                                foreach ($AllTableData as $key => $data) {
                            ?>
                                    <tr class="table-row-data">
                                        <td style="color: #512d04;"><b><?php echo $key + 1; ?></b></td>
                                        <td class="fw-bold text-dark"><?php echo $data['name']; ?></td>
                                        <td class="text-truncate text-muted" style="max-width: 150px;" title="<?php echo $data['description']; ?>">
                                            <?php echo $data['description']; ?>
                                        </td>
                                        <td><span class="text-success fw-bold">₹<?php echo $data['price']; ?></span></td>
                                        <td>
                                            <img src="../upload/<?php echo $data['image']; ?>" class="product-img" alt="Product">
                                        </td>
                                        <td>
                                            <?php
                                            if ($data['is_available']) {
                                                echo "<span class='badge bg-success'>Available</span>";
                                            } else {
                                                echo "<span class='badge bg-danger'>Not Available</span>";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <a href="Edit-product.php?id=<?php echo $data['id']; ?>" class="btn btn-sm btn-warning btn-custom text-dark">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="delete_action.php?id=<?php echo $data['id'] ?>&btn=product"
                                                    onclick="return confirmAdminDelete(event, this.href, 'this product');"
                                                    class="btn btn-sm btn-danger btn-custom">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr class='no-records'><td colspan='7' class='text-danger fw-bold py-3'>No Records Found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex flex-wrap justify-content-between align-items-center mt-3">
                    <div id="showingInfo" class="small text-muted fw-bold mb-2 mb-md-0"></div>
                    <ul class="pagination pagination-sm m-0" id="paginationControls"></ul>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="additem-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 shadow">

                <form action="product-add-action.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header model-header-bg text-light border-0">
                        <h5 class="modal-title d-flex align-items-center gap-2" style="color: #f6ddbe;">
                            <span class="badge rounded p-2" style="background-color: #f2a546; color: black;">☕</span> Add New Item
                        </h5>
                        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body px-4 py-3">
                        <div class="mb-3">
                            <label class="form-label small text-uppercase">Product Name</label>
                            <input type="text" name="name" class="form-control input-field" placeholder="Product name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-uppercase">Description</label>
                            <textarea name="description" rows="2" class="form-control input-field" placeholder="Short description…" required></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-md-6 mb-3 mb-md-0">
                                <?php
                                global $connect;
                                $sql = "select * from categories";
                                $run = mysqli_query($connect, $sql);
                                if (mysqli_num_rows($run)) {
                                    $option = mysqli_fetch_all($run, MYSQLI_ASSOC);
                                } else {
                                    $option = [['id' => '', 'name' => 'No Category Available']];
                                }
                                ?>
                                <label class="form-label small text-uppercase">Category</label>
                                <select name="category" class="form-select input-field" required>
                                    <?php foreach ($option as $data) { ?>
                                        <option value="<?php echo $data['id']; ?>"><?php echo $data['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label small text-uppercase">Availability</label>
                                <select name="is_available" class="form-select input-field" required>
                                    <option value="1">Available</option>
                                    <option value="0">Not Available</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-md-6 mb-3 mb-md-0">
                                <label class="form-label small text-uppercase">Product Image</label>
                                <input type="file" name="image" id="product-image" class="form-control mb-2" required>
                                <div class="d-flex align-items-center gap-2">
                                    <label class="form-label small m-0 text-uppercase">Preview:</label>
                                    <img src="" id="product-image-preview" alt="" class="img-fluid rounded" style="max-height: 50px;">
                                    <div id="image-pre"><i class="fa fa-question text-muted"></i></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label small text-uppercase">Price (₹)</label>
                                <input type="number" name="price" class="form-control input-field" step="0.01" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="cancel-btn" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="add-btn" value="add_product" class="save-btn">Save Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../asset/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Category Filter
        document.getElementById('selected').addEventListener("change", function() {
            window.location.href = "product-list.php?category=" + this.value;
        });

        // Image Preview
        const product_picture = document.getElementById('product-image');
        const picture_preview = document.getElementById('product-image-preview');
        const product_picture_div = document.getElementById('image-pre');
        if (product_picture) {
            product_picture.addEventListener("change", function() {
                const image = this.files[0];
                if (image) {
                    product_picture_div.style.display = "none";
                    picture_preview.src = URL.createObjectURL(image);
                }
            });
        }

        // Toast Messages
        let ConfirmTost = document.getElementById('confirmTost');
        let customalertbox = document.getElementById('customalert');
        let status = <?php echo json_encode($_SESSION['status'] ?? null); ?>;
        let message = <?php echo json_encode($_SESSION['msg'] ?? null); ?>;
        
        if (status === true) {
            customalertbox.innerText = message;
            customalertbox.classList.add("fs-6");
            ConfirmTost.classList.add("text-bg-success");
        } else if (status === false) {
            customalertbox.innerText = message;
            customalertbox.classList.add("fs-6");
            ConfirmTost.classList.add("text-bg-danger");
        } else {
            ConfirmTost.style.display = "none";
        }
        if (status !== null) {
            let toast = new bootstrap.Toast(ConfirmTost, { delay: 2000 });
            toast.show();
        }

        // ==========================================
        // CUSTOM PAGINATION LOGIC
        // ==========================================
        document.addEventListener('DOMContentLoaded', function () {
            const rows = Array.from(document.querySelectorAll('#productTable tbody tr.table-row-data'));
            if (rows.length === 0) return; 
            
            const rowsPerPageSelect = document.getElementById('rowsPerPage');
            const paginationControls = document.getElementById('paginationControls');
            const showingInfo = document.getElementById('showingInfo');
            
            let currentPage = 1;
            let rowsPerPage = parseInt(rowsPerPageSelect.value);

            function displayTableRows() {
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;

                rows.forEach((row, index) => {
                    if (index >= start && index < end) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                let endRecord = end > rows.length ? rows.length : end;
                showingInfo.innerHTML = `Showing ${start + 1} to ${endRecord} of ${rows.length} entries`;
            }

            function setupPaginationControls() {
                paginationControls.innerHTML = '';
                const pageCount = Math.ceil(rows.length / rowsPerPage);
                if (pageCount <= 1) return; 

                // Previous Button
                let prevLi = document.createElement('li');
                prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
                prevLi.innerHTML = `<a class="page-link shadow-none" href="javascript:void(0)">Previous</a>`;
                prevLi.addEventListener('click', () => { if (currentPage > 1) changePage(currentPage - 1); });
                paginationControls.appendChild(prevLi);

                // Numbered Buttons
                for (let i = 1; i <= pageCount; i++) {
                    let li = document.createElement('li');
                    li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                    li.innerHTML = `<a class="page-link shadow-none" href="javascript:void(0)">${i}</a>`;
                    li.addEventListener('click', () => changePage(i));
                    paginationControls.appendChild(li);
                }

                // Next Button
                let nextLi = document.createElement('li');
                nextLi.className = `page-item ${currentPage === pageCount ? 'disabled' : ''}`;
                nextLi.innerHTML = `<a class="page-link shadow-none" href="javascript:void(0)">Next</a>`;
                nextLi.addEventListener('click', () => { if (currentPage < pageCount) changePage(currentPage + 1); });
                paginationControls.appendChild(nextLi);
            }

            function changePage(page) {
                currentPage = page;
                displayTableRows();
                setupPaginationControls();
            }

            rowsPerPageSelect.addEventListener('change', function () {
                rowsPerPage = parseInt(this.value);
                currentPage = 1;
                displayTableRows();
                setupPaginationControls();
            });

            displayTableRows();
            setupPaginationControls();
        });

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

    <?php
    unset($_SESSION['status']);
    unset($_SESSION['msg']);
    ?>
</body>

</html>