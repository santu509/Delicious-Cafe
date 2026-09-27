<?php
// তোমার ডেটাবেস কানেকশন ফাইলটি এখানে ইনক্লুড করে নিতে পারো (যদি অন্য ফাইলে থাকে)
// include 'db_connect.php'; 

$message = "";
global $connect;
// ফর্ম সাবমিট হলে ডেটা প্রসেস করা
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['upload_file'])) {
    // $connect ব্যবহার করে ডেটা ফিল্টার করা
    $title = $connect->real_escape_string($_POST['title']);
    $category_id = (int)$_POST['category_id'];
    $description = $connect->real_escape_string($_POST['description']);
    $price = !empty($_POST['price']) ? (float)$_POST['price'] : 0.00;
    $type = $connect->real_escape_string($_POST['type']);
    $user_id = 1; // এখানে লগ-ইন করা ইউজারের ID বসবে, আপাতত 1 রাখা হলো

    // ফাইল আপলোড লজিক
    $target_dir = "uploads/";
    $file_name = basename($_FILES["upload_file"]["name"]);
    // ফাইলের নাম ইউনিক করার জন্য time() ব্যবহার করা হয়েছে
    $target_file = $target_dir . time() . "_" . $file_name; 
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // শুধুমাত্র ছবি এবং PDF অ্যালাউ করা
    $allowed_types = array("jpg", "jpeg", "png", "gif", "pdf");

    if (in_array($file_type, $allowed_types)) {
        if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file)) {
            // Prepared Statement ব্যবহার করে ডেটাবেসে ইনসার্ট
            $sql = "INSERT INTO resources (user_id, category_id, title, description, price, image, type, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, 'available')";
            
            $stmt = $connect->prepare($sql);
            $stmt->bind_param("iissdss", $user_id, $category_id, $title, $description, $price, $target_file, $type);

            if ($stmt->execute()) {
                $message = "<div class='alert alert-success'>ফাইল এবং ডেটা সফলভাবে আপলোড হয়েছে!</div>";
            } else {
                $message = "<div class='alert alert-danger'>ডেটাবেস এরর: " . $connect->error . "</div>";
            }
            $stmt->close();
        } else {
            $message = "<div class='alert alert-danger'>ফাইল আপলোড করতে সমস্যা হয়েছে।</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>শুধুমাত্র PDF এবং Image (JPG, PNG, GIF) ফাইল সাপোর্ট করে।</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Note/Resource</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Upload New Note or Resource</h4>
                </div>
                <div class="card-body">
                    <?= $message; ?>

                    <form action="" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" id="title" required placeholder="Enter resource title">
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" name="category_id" id="category_id" required>
                                <option value="">Select Category</option>
                                <?php
                                // ডাইনামিক ক্যাটাগরি ফেচ করা (তোমার categories টেবিল থেকে)
                                $cat_query = "SELECT id, category_name FROM categories ORDER BY category_name ASC";
                                $cat_result = $connect->query($cat_query);
                                if ($cat_result && $cat_result->num_rows > 0) {
                                    while($row = $cat_result->fetch_assoc()) {
                                        echo "<option value='".$row['id']."'>".$row['category_name']."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Write a short description..."></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Listing Type</label>
                                <select class="form-select" name="type" id="type" required>
                                    <option value="sell">Sell</option>
                                    <option value="exchange">Exchange</option>
                                    <option value="donate">Donate</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price (If selling)</label>
                                <input type="number" step="0.01" class="form-control" name="price" id="price" placeholder="0.00">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="upload_file" class="form-label">Upload File (PDF or Image)</label>
                            <input class="form-control" type="file" name="upload_file" id="upload_file" accept=".pdf, image/*" required>
                            <small class="text-muted">Allowed formats: JPG, PNG, GIF, PDF.</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Upload Resource</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>