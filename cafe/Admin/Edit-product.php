<?php
include_once('All-Function.php');

$id = $_GET['id'];
$single_product = single_row_details('products', $id);
$all_category = allDetails('categories');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../asset/bootstrap-5.3.7-dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background: #f5f0eb;
        }

        .main-container {
            min-height: 100vh;
        }

        .card-custom {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .card-header-custom {
            background: #6b3a06;
            padding: 18px 20px;
            color: #fff;
        }

        .card-body-custom {
            background: #f4efe9;
        }

        .input-field {
            border-radius: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            transition: 0.3s;
        }

        .input-field:focus {
            border-color: #6b3a06;
            box-shadow: 0 0 0 0.15rem rgba(107, 58, 6, 0.25);
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #fff;
            border-radius: 5px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            z-index: 10;
        }

        .close-btn:hover {
            background: #f40418;
            transform: scale(1.1);
        }

        .close-btn i {
            font-size: 16px;
            color: #333;
        }

        .preview-box {
            width: 150px;
            height: 120px;
            border: 1px dashed #ccc;
            border-radius: 12px;
            background: #fff;
        }

        /* MOBILE */
        @media (max-width: 768px) {

            .container {
                padding: 15px;
            }

            .card-body-custom {
                padding: 18px;
            }

            .row>.col {
                width: 100%;
                margin-bottom: 10px;
            }

            .btn-group-responsive {
                flex-direction: column;
                gap: 10px;
            }

            .btn-group-responsive a,
            .btn-group-responsive button {
                width: 100%;
            }

            .preview-box {
                width: 120px;
                height: 100px;
            }

            #edit-preview {
                max-width: 100%;
                height: auto;
            }
        }
    </style>
</head>

<body>

    <div class="container d-flex align-items-center justify-content-center main-container">

        <div class="col-md-5">

            <div class="card border-0 card-custom">

                <!-- CLOSE -->
                <a href="product-list.php" class="close-btn">
                    <i class="bi bi-x-lg"></i>
                </a>

                <!-- HEADER -->
                <div class="card-header card-header-custom">
                    <h5 class="mb-0 fw-semibold">☕ Edit Item</h5>
                </div>

                <!-- BODY -->
                <div class="card-body card-body-custom">

                    <form action="product-edit-action.php" method="POST" enctype="multipart/form-data">
                        <!-- pid -->
                        <input type="hidden" name="id" value="<?php echo $single_product['id']; ?>">
                        <!-- NAME -->
                        <label class="form-label small fw-bold">PRODUCT NAME</label>
                        <input type="text" name="name"
                            class="form-control mb-3 input-field"
                            value="<?= $single_product['name']; ?>">

                        <!-- DESCRIPTION -->
                        <label class="form-label small fw-bold">DESCRIPTION</label>
                        <textarea name="description"
                            class="form-control mb-3 input-field"
                            rows="2"><?= $single_product['description']; ?></textarea>

                        <!-- CATEGORY + STATUS -->
                        <div class="row">
                            <div class="col">
                                <label class="form-label small fw-bold">CATEGORY</label>
                                <select name="category" class="form-select input-field">
                                    <?php foreach ($all_category as $category) { ?>
                                        <option value="<?php echo $category['id'] ?>"
                                            <?php echo ($category['id'] == $single_product['category_id']) ? 'selected' : '' ?>>
                                            <?php echo $category['name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col">
                                <label class="form-label small fw-bold">AVAILABILITY</label>
                                <select name="status" class="form-select input-field">
                                    <option value="1" <?= ($single_product['is_available'] == 1) ? 'selected' : '' ?>>Available</option>
                                    <option value="0" <?= ($single_product['is_available'] == 0) ? 'selected' : '' ?>>Not Available</option>
                                </select>
                            </div>
                        </div>

                        <!-- IMAGE + PRICE -->
                        <div class="row mt-3">
                            <div class="col">
                                <label class="form-label small fw-bold">PRODUCT IMAGE</label>
                                <input type="file" name="image" id="new-product-image"
                                    class="form-control input-field">
                            </div>

                            <div class="col">
                                <label class="form-label small fw-bold">PRICE (₹)</label>
                                <input type="number" name="price"
                                    class="form-control input-field"
                                    value="<?= $single_product['price']; ?>">
                            </div>
                        </div>

                        <!-- PREVIEW -->
                        <div class="mt-3 text-center">
                            <label class="form-label small fw-bold">PREVIEW OF IMAGE</label>

                            <div class="d-flex justify-content-center align-items-center mx-auto preview-box">
                                <img id="edit-preview"
                                    src="../upload/<?= $single_product['image']; ?>"
                                    class="rounded" style="max-height: 100%;">
                            </div>
                        </div>

                        <!-- BUTTONS -->
                        <div class="mt-4 d-flex justify-content-between btn-group-responsive">
                            <a href="product-list.php"
                                class="btn btn-outline-danger rounded-pill px-4">
                                Cancel
                            </a>

                            <button type="submit"
                                class="btn btn-success rounded-pill px-4">
                                Update Item
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <!-- IMAGE PREVIEW -->
    <script>
        document.getElementById('new-product-image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                document.getElementById('edit-preview').src = URL.createObjectURL(file);
            }
        });
    </script>

</body>

</html>