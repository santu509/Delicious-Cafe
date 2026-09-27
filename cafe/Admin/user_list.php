<?php
include('All-Function.php');
session_start();
global $connect;

if (isset($_POST['user_id']) && isset($_POST['active_status'])) {
    $user_id = $_POST['user_id'];
    $status = $_POST['active_status'];

    // Update query to change the status
    $query = "UPDATE customers SET active_status = '$status' WHERE id = '$user_id'";

    $result = mysqli_query($connect, $query);


    if ($result) {
        $_SESSION['status'] = true;
        $_SESSION['msg'] = "User status updated successfully!";
    } else {
        $_SESSION['status'] = false;
        $_SESSION['msg'] = "Failed to update status.";
    }


    header("location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<?php include('Dashboard.php'); ?>

<style>
    /* Custom Card Styles matching the image */
    .custom-stat-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 24px 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        border: none;
        border-top: 5px solid transparent;
        /* For top colored border */
        transition: transform 0.2s ease-in-out;
    }

    .custom-stat-card:hover {
        transform: translateY(-3px);
    }

    /* Card Themes */
    .border-blue {
        border-top-color: #4378ff;
    }

    .border-green {
        border-top-color: #20c997;
    }

    .border-orange {
        border-top-color: #ffb822;
    }

    .stat-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stat-title {
        font-size: 13px;
        font-weight: 700;
        color: #6c757d;
        text-transform: uppercase;
        margin-bottom: 6px;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 26px;
        font-weight: 800;
        color: #1a1d20;
        margin: 0;
    }

    /* Icon Box Styles */
    .stat-icon-box {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .icon-blue {
        background-color: #edf2ff;
        color: #4378ff;
    }

    .icon-green {
        background-color: #e8f9f4;
        color: #20c997;
    }

    .icon-orange {
        background-color: #fff7e6;
        color: #ffb822;
    }

    .custom-toast {
        top: 10%;
        left: 55%;
        transform: translate(-50%, -50%);
    }

    .user-img {
        width: 50px;
        height: 50px;
    }

    .add_user_btn {
        float: right;
    }

    .add_user_modal_header {
        background-color: #512d04;
    }

    .model-custom-width {
        width: 30% !important;
    }

    /* Profile Section */
    .profile-wrapper {
        position: relative;
        width: 110px;
        margin: auto;
    }

    .profile-img {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #9505ca;
    }

    /* Camera icon bottom */
    .camera-icon {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 30px;
        height: 30px;
        background: #0d6efd;
        color: white;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 14px;
        border: 2px solid white;
        cursor: pointer;
        transition: 0.3s;
    }

    .camera-icon:hover {
        transform: scale(1.1);
    }

    .input-group:focus-within .input-group-text {
        border: 3px solid #86b7fe;
        border-color: #86b7fe;
        background-color: #cfe2ff;
    }

    .input-group:focus-within .form-control {
        border: 3px solid #86b7fe;
        border-color: #86b7fe;
        box-shadow: none;
    }

    .form-label {
        font-weight: 600;
        font-size: 16px;
    }


    .cancel-btn {
        border: 1px solid #e10505;
        padding: 1.5%;
        border-radius: 8px;
        font-weight: 600;
    }

    .cancel-btn:hover {
        border: 1px solid #e10505;
        padding: 1.5%;
        border-radius: 8px;
        background-color: #e10505;
        color: #fbfafa;
        transform: scale(1.10);
        transition: all 300ms ease;

    }

    .save-btn {
        border: none;
        padding: 1.5%;
        border-radius: 8px;
        background-color: #029121;
        color: #fbf9f9;
        font-weight: 600;
    }

    .save-btn:hover {
        background-color: #03851f;

        transform: scale(1.05);
        transition: all 300ms ease;
    }

    .pagination-botton-link {
        float: right;
    }
    .table_heading tr th{
        background-color: #673803;
        color: whitesmoke;
    }
    .table_hover tbody tr:hover{
        background-color: #99741f!important;
    }

    /* Custom styles for light status dropdowns */
    .status-select-active {
        background-color: #d1e7dd !important; 
        color: #0f5132 !important;
        border-color: #badbcc !important;
        font-weight: 600;
    }
    
    .status-select-inactive {
        background-color: #f8d7da !important;
        color: #842029 !important;
        border-color: #f5c2c7 !important;
        font-weight: 600;
    }
</style>

<?php
// Pagination Function Call

global $connect;

$status_filter = $_GET['status'] ?? '';
$name_filter = $_GET['name'] ?? '';
$limit = $_GET['limit'] ?? 5;
$currentPage = $_GET['page'] ?? 1;

$offset = ($currentPage - 1) * $limit;

$where = "WHERE 1=1";

if ($status_filter !== '') {
    $where .= " AND active_status='$status_filter'";
}

if (!empty($name_filter)) {
    $where .= " AND name LIKE '%$name_filter%'";
}

$count_query = mysqli_query(
    $connect,
    "SELECT COUNT(*) AS total FROM customers $where"
);

$totalRows = mysqli_fetch_assoc($count_query)['total'];
$totalPages = ceil($totalRows / $limit);

$query = mysqli_query(
    $connect,
    "SELECT * FROM customers $where ORDER BY id DESC LIMIT $offset,$limit"
);

$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}
?>

<div class="toast position-fixed custom-toast" id="confirmTost" role="alert">
    <div class="d-flex">
        <div class="toast-body" id="customalert"></div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
</div>

<div class=" pt-5 px-5 Dashboard-right">
    <div class="row g-4 mb-4">

        <div class="col-md-4">
            <div class="custom-stat-card border-blue">
                <div class="stat-content">
                    <div>
                        <p class="stat-title">Total Customers</p>


                        <h3 class="stat-value">
                            <?php
                            $sql = "SELECT COUNT(name) AS total FROM customers";
                            $run = mysqli_query($connect, $sql);

                            if ($run) {
                                $row = mysqli_fetch_assoc($run);
                                echo $row['total'];
                            } else {
                                echo "0";
                            }
                            ?>
                        </h3>
                    </div>
                    <div class="stat-icon-box icon-blue">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="custom-stat-card border-green">
                <div class="stat-content">
                    <div>
                        <p class="stat-title">Active Customers</p>
                        <h3 class="stat-value"><?php
                            $sql = "SELECT COUNT(name) AS total FROM customers WHERE active_status=1";
                            $run = mysqli_query($connect, $sql);

                            if ($run) {
                                $row = mysqli_fetch_assoc($run);
                                echo $row['total'];
                            } else {
                                echo "0";
                            }
                            ?></h3>
                    </div>
                    <div class="stat-icon-box icon-green">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="custom-stat-card border-orange">
                <div class="stat-content">
                    <div>
                        <p class="stat-title">Inactive Customers</p>
                        <h3 class="stat-value"><?php
                            $sql = "SELECT COUNT(name) AS total FROM customers WHERE active_status=0";
                            $run = mysqli_query($connect, $sql);

                            if ($run) {
                                $row = mysqli_fetch_assoc($run);
                                echo $row['total'];
                            } else {
                                echo "0";
                            }
                            ?></h3>
                    </div>
                    <div class="stat-icon-box icon-orange">
                        <i class="fa-solid fa-user-xmark"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <button class="btn btn-primary add_user_btn " data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="fa fa-plus"></i> Add User
    </button>

 <form method="GET" class="row mt-3 mb-4">

    <div class="col-md-4">
        <input
            type="text"
            name="name"
            class="form-control"
            placeholder="Search Customer Name..."
            value="<?php echo htmlspecialchars($name_filter); ?>">
    </div>

    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">All Status</option>

            <option value="1"
                <?php if ($status_filter === '1') echo 'selected'; ?>>
                Active
            </option>

            <option value="0"
                <?php if ($status_filter === '0') echo 'selected'; ?>>
                Inactive
            </option>
        </select>
    </div>

    <div class="col-md-2">
        <select name="limit" class="form-select">
            <option value="5" <?php if ($limit == 5) echo 'selected'; ?>>5</option>
            <option value="10" <?php if ($limit == 10) echo 'selected'; ?>>10</option>
            <option value="25" <?php if ($limit == 25) echo 'selected'; ?>>25</option>
            <option value="50" <?php if ($limit == 50) echo 'selected'; ?>>50</option>
        </select>
    </div>

    <div class="col-md-2">
        <button type="submit" class="btn btn-warning w-100">
            <i class="fa fa-search"></i> Filter
        </button>
    </div>

    <div class="col-md-1">
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>"
            class="btn btn-secondary w-100">
            <i class="fa fa-refresh"></i>
        </a>
    </div>

</form>

    <div class="table-responsive w-100 mt-3">
        <table class="table table-bordered table_hover">
            <thead class="table_heading text-center">
                <tr>
                    <th>Sl</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody class="table-secondary text-center">
                <?php
                if (!empty($data)) {
                    foreach ($data as $key => $row) {
                ?>
                        <tr>
                            <td>
                                <?php echo (($currentPage - 1) * $limit) + $key + 1; ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($row['name']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($row['email_id'] ?? 'NA'); ?>
                            </td>
                            <td>
                                <img class="rounded-circle user-img"
                                    src="<?php echo !empty($row['profile']) ? '../upload/' . $row['profile'] : '../asset/image/profile.png'; ?>">
                            </td>

                            <td>
                                <!-- Updated dropdown status layout with softer styling -->
                                <form action="" method="POST" class="m-0">
                                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                    <select name="active_status" class="form-select form-select-sm shadow-sm <?php echo ($row['active_status'] == 1) ? 'status-select-active' : 'status-select-inactive'; ?>" onchange="this.form.submit()" style="cursor: pointer;">
                                        <option value="1" class="bg-white text-success fw-bold" <?php if ($row['active_status'] == 1) echo 'selected'; ?>>Active</option>
                                        <option value="0" class="bg-white text-danger fw-bold" <?php if ($row['active_status'] == 0) echo 'selected'; ?>>Inactive</option>
                                    </select>
                                </form>
                            </td>

                            <td>
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewUserModal<?php echo $row['id']; ?>">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="viewUserModal<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content shadow-lg border-0 rounded-4">
                                    <div class="modal-header bg-warning text-dark border-0">
                                        <h5 class="modal-title fw-bold">
                                            <i class="fa fa-user me-2"></i>User Details
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center mt-3 mb-3">
                                        <img src="<?php echo !empty($row['profile']) ? '../upload/' . $row['profile'] : '../asset/image/profile.png'; ?>"
                                            class="rounded-circle mb-3 shadow" style="width: 130px; height: 130px; object-fit: cover; border: 4px solid #ffc107;">

                                        <h4 class="fw-bold mb-1"><?php echo htmlspecialchars($row['name']); ?></h4>
                                        <p class="text-muted mb-3"><i class="fa fa-envelope me-1"></i> <?php echo htmlspecialchars($row['email_id'] ?? 'NA'); ?></p>

                                        <div class="mt-2">
                                            <span class="fw-bold me-2">Status:</span>
                                            <?php if ($row['active_status'] == 1): ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">Inactive</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 justify-content-center">
                                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="6" class="text-danger fw-bold py-3">
                            No Record Found
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

   <nav class="pagination-botton-link">
    <ul class="pagination justify-content-center">

        <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
            <a class="page-link"
                href="?page=<?php echo $currentPage - 1; ?>&limit=<?php echo $limit; ?>&status=<?php echo $status_filter; ?>&name=<?php echo urlencode($name_filter); ?>">
                Previous
            </a>
        </li>

        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>

            <li class="page-item <?php echo ($currentPage == $i) ? 'active' : ''; ?>">
                <a class="page-link"
                    href="?page=<?php echo $i; ?>&limit=<?php echo $limit; ?>&status=<?php echo $status_filter; ?>&name=<?php echo urlencode($name_filter); ?>">
                    <?php echo $i; ?>
                </a>
            </li>

        <?php } ?>

        <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
            <a class="page-link"
                href="?page=<?php echo $currentPage + 1; ?>&limit=<?php echo $limit; ?>&status=<?php echo $status_filter; ?>&name=<?php echo urlencode($name_filter); ?>">
                Next
            </a>
        </li>

    </ul>
</nav>
</div>

<div class="modal fade" id="addUserModal">
    <div class="modal-dialog modal-dialog model-custom-width">
        <div class="modal-content shadow-lg border-0 rounded-4">

            <div class="modal-header model-header-bg text-light border-0 add_user_modal_header">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <span class="badge bg-warning rounded p-2"><i class="fa fa-user-plus text-primary"></i></span>
                    Add New User
                </h5>
                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="user_Action.php" method="POST" enctype="multipart/form-data">

                    <div class="text-center mb-3">
                        <div class="profile-wrapper">
                            <img src="../asset/image/profile.png" class="profile-img" id="previewImg">
                            <label for="fileInput" class="camera-icon bg-primary">
                                <i class="fa fa-camera text-white"></i>
                            </label>
                            <input type="file" name="profileimg" id="fileInput" hidden>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-user "></i></span>
                            <input type="text" name="name" class="form-control" placeholder="Enter name" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text "><i class="fa fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control " placeholder="Enter email" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <input type="password" id="password" name="password" class="form-control " placeholder="Enter password" required>
                            <span class="input-group-text bg-light" onclick="togglePassword()" style="cursor:pointer;">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4 gap-2">
                        <button type="submit" name="customer-add-btn" class="save-btn px-4 me-2">
                            Add
                        </button>
                        <button type="button" class="cancel-btn border px-4" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="../asset/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Image preview in Add User Modal
    document.getElementById('fileInput').addEventListener("change", function() {
        let imagefile = document.getElementById('fileInput').files[0];
        if (imagefile) {
            document.getElementById('previewImg').src = URL.createObjectURL(imagefile);
        }
    });

    // Toggle password visibility in Add User modal
    function togglePassword() {
        let password_field = document.querySelector('#password');
        if (password_field.type === "password") {
            password_field.type = "text";
        } else {
            password_field.type = "password";
        }
    }

    // Handle Toast Notifications based on Session variables
    let ConfirmTost = document.getElementById('confirmTost');
    let customalertbox = document.getElementById('customalert');
    let status = <?php echo json_encode($_SESSION['status'] ?? null); ?>;
    let message = <?php echo json_encode($_SESSION['msg'] ?? null); ?>;

    if (status === true) {
        customalertbox.innerText = message;
        customalertbox.classList.add("fs-5");
        ConfirmTost.classList.add("text-bg-success");
    } else if (status === false) {
        customalertbox.innerText = message;
        customalertbox.classList.add("fs-5");
        ConfirmTost.classList.add("bg-danger");
    } else {
        ConfirmTost.style.display = "none";
    }

    if (status !== null) {
        let toast = new bootstrap.Toast(ConfirmTost, {
            delay: 2000
        });
        toast.show();
    }
</script>

<?php
// Clear session messages after displaying
unset($_SESSION['status']);
unset($_SESSION['msg']);
?>
</body>

</html>