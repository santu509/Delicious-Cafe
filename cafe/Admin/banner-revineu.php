<?php
include('Dashboard.php');

global $connect;

if (!$connect) {
    include '../connection.php';
}

if (isset($_POST['update_live_status'])) {

    $tables = intval($_POST['active_tables']);
    $staff = intval($_POST['staff_on_duty']);
    $offer = intval($_POST['online_offer']);
    $no_decoration_fees = intval($_POST['no_decoration_fees']);
    $decoration_fees = intval($_POST['decoration_fees']);
    $store_status = mysqli_real_escape_string($connect, trim($_POST['cafe_store_status']));

    // Validate input values
    if ($tables < 0 || $staff < 0) {
        echo "<script>
                alert('Value cannot be negative!');
                window.location.href='banner-revineu.php';
              </script>";
        exit;
    }

    // Get current banner image from database
    $old_data = mysqli_fetch_assoc(
        mysqli_query($connect, "SELECT banner_video FROM cafe_status_settings WHERE id = 1")
    );

    $old_video = $old_data['banner_video'];

    // Check if a new image is uploaded
    if (!empty($_FILES['banner_video']['name'])) {

        $video = time() . "_" . $_FILES['banner_video']['name'];
        $video_temp_name = $_FILES['banner_video']['tmp_name'];
        $store_location = "../upload/" . $video;

        // Delete old banner image if it exists
        if (!empty($old_video) && file_exists("../upload/" . $old_video)) {
            unlink("../upload/" . $old_video);
        }

        // Upload new image
        move_uploaded_file($video_temp_name, $store_location);

        // Update database with new image
        $update_query = "
            UPDATE cafe_status_settings 
            SET 
                active_tables = '$tables',
                staff_on_duty = '$staff',
                cafe_store_status = '$store_status',
                banner_video = '$video',
                offer='$offer',
                no_decoration_fees='$no_decoration_fees',
                decoration_fees='$decoration_fees'
            WHERE id = 1
        ";
    } else {

        // Update database without changing image
        $update_query = "
            UPDATE cafe_status_settings 
            SET 
                active_tables = '$tables',
                staff_on_duty = '$staff',
                cafe_store_status = '$store_status',
                offer='$offer',
                no_decoration_fees='$no_decoration_fees',
                decoration_fees='$decoration_fees'
            WHERE id = 1
        ";
    }

    if (mysqli_query($connect, $update_query)) {
        echo "<script>
                alert('Dashboard Status Updated Successfully!');
                window.location.href='banner-revineu.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Error updating status!');
              </script>";
    }
}

if (isset($_POST['update_timetable'])) {
    foreach ($_POST['timetable'] as $id => $data) {
        $open_time = !empty($data['open']) ? "'" . mysqli_real_escape_string($connect, $data['open']) . "'" : "NULL";
        $close_time = !empty($data['close']) ? "'" . mysqli_real_escape_string($connect, $data['close']) . "'" : "NULL";
        $is_closed = isset($data['is_closed']) ? 1 : 0;

        $update_time_query = "UPDATE cafe_timetable SET open_time = $open_time, close_time = $close_time, is_closed = $is_closed WHERE id = " . intval($id);
        mysqli_query($connect, $update_time_query);
    }
    echo "<script>alert('Weekly Timetable Updated Successfully!'); window.location.href='banner-revineu.php';</script>";
    exit;
}

$settings_query = "SELECT * FROM cafe_status_settings WHERE id = 1";
$settings_result = mysqli_query($connect, $settings_query);
$settings_data = mysqli_fetch_assoc($settings_result);

$active_tables = isset($settings_data['active_tables']) ? $settings_data['active_tables'] : 0;
$staff_on_duty = isset($settings_data['staff_on_duty']) ? $settings_data['staff_on_duty'] : 0;
$manual_store_status = isset($settings_data['cafe_store_status']) ? trim($settings_data['cafe_store_status']) : 'On';
$offer = isset($settings_data['offer']) ? $settings_data['offer'] : 0;
$no_decoration_fees = isset($settings_data['no_decoration_fees']) ? $settings_data['no_decoration_fees'] : 0;
$decoration_fees = isset($settings_data['decoration_fees']) ? $settings_data['decoration_fees'] : 0;
date_default_timezone_set('Asia/Kolkata');
$current_day = date('l');
$current_time = date('H:i:s');

$timetable_query = "SELECT * FROM cafe_timetable WHERE day_name = '$current_day'";
$timetable_result = mysqli_query($connect, $timetable_query);
$today_schedule = mysqli_fetch_assoc($timetable_result);

$final_cafe_status = "Off";

if ($manual_store_status === 'On') {
    if ($today_schedule && intval($today_schedule['is_closed']) === 0) {
        $open = $today_schedule['open_time'];
        $close = $today_schedule['close_time'];

        if ($current_time >= $open && $current_time <= $close) {
            $final_cafe_status = "On";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Delicious Cafe Dashboard</title>
    <link rel="stylesheet" href="banner-revineu.css">
</head>
<body>

<div class="Dashboard-right">
    
    <!-- Banner Section -->
    <div class="banner-part px-3 px-md-4 py-4">
        <div class="banner-part-text">
            <h5 class="fs-3 fw-bold mb-2">Welcome Back Admin</h5>
            <p class="mb-0 text-light">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio atque eos exercitationem accusamus, fugit qui unde iure enim voluptates non.</p>
        </div>
        <div class="banner-part-stats mt-3 mt-lg-0 d-flex gap-2 flex-wrap justify-content-start justify-content-lg-end">
            <div class="banner-stat-box text-center flex-fill flex-md-grow-0">
                <h6 class="text-light mb-1 fs-6">Active Table</h6>
                <h5 class="text-white fw-bold mb-0"><?php echo $active_tables; ?></h5>
            </div>
            <div class="banner-stat-box text-center flex-fill flex-md-grow-0">
                <h6 class="text-light mb-1 fs-6">Staff On Duty</h6>
                <h5 class="text-white fw-bold mb-0"><?php echo $staff_on_duty; ?></h5>
            </div>
            <div class="banner-stat-box text-center flex-fill flex-md-grow-0">
                <h6 class="text-light mb-2 fs-6">Cafe Open/Close</h6>
                <?php if ($final_cafe_status === "On"): ?>
                    <button class="btn btn-primary btn-sm px-4 fw-bold w-100">On</button>
                <?php else: ?>
                    <button class="btn btn-danger btn-sm px-4 fw-bold w-100">Off</button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="container-fluid px-3 px-md-4 mt-4">
        <div class="row g-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="custom-stat-card border-blue">
                    <div class="stat-content">
                        <div>
                            <p class="stat-title">Total Customers</p>
                            <h3 class="stat-value">
                                <?php
                                $sql = "SELECT COUNT(name) AS total FROM customers";
                                $run = mysqli_query($connect, $sql);
                                echo ($run) ? mysqli_fetch_assoc($run)['total'] : "0";
                                ?>
                            </h3>
                        </div>
                        <div class="stat-icon-box icon-blue"><i class="fa-solid fa-users"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="custom-stat-card border-green">
                    <div class="stat-content">
                        <div>
                            <p class="stat-title">Total Sale</p>
                            <h3 class="stat-value">
                                <?php
                                $sales_query = "SELECT SUM(total_price) as total_sales FROM orders WHERE order_status != 'Cancelled'";
                                $sales_result = mysqli_query($connect, $sales_query);
                                $total_sales = $sales_result ? mysqli_fetch_assoc($sales_result)['total_sales'] : 0;
                                echo $total_sales ? $total_sales : 0;
                                ?>
                            </h3>
                        </div>
                        <div class="stat-icon-box icon-green"><i class="fas fa-chart-line"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="custom-stat-card border-orange">
                    <div class="stat-content">
                        <div>
                            <p class="stat-title">Total Category</p>
                            <h3 class="stat-value">
                                <?php
                                $sql = "SELECT COUNT(name) AS total FROM categories";
                                $run = mysqli_query($connect, $sql);
                                echo ($run) ? mysqli_fetch_assoc($run)['total'] : "0";
                                ?>
                            </h3>
                        </div>
                        <div class="stat-icon-box icon-orange"><i class="fa-solid fa-list"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="custom-stat-card border-purple">
                    <div class="stat-content">
                        <div>
                            <p class="stat-title">Total Product</p>
                            <h3 class="stat-value">
                                <?php
                                $sql = "SELECT COUNT(name) AS total FROM products";
                                $run = mysqli_query($connect, $sql);
                                echo ($run) ? mysqli_fetch_assoc($run)['total'] : "0";
                                ?>
                            </h3>
                        </div>
                        <div class="stat-icon-box icon-purple"><i class="fa fa-coffee"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Forms Section -->
    <div class="container-fluid px-3 px-md-4 mt-4 mb-5">
        <div class="row g-4">
            
            <!-- Live Controls -->
            <div class="col-12 col-xl-4">
                <div class="card shadow p-3 p-md-4 text-white h-100" style="border-radius: 12px; background: #f5e1be; border: none;">
                    <h4 class="card-title mb-4 text-primary fs-5 fs-md-4"><i class="fa fa-cogs me-2"></i>Live Controls</h4>
                    <form method="POST" action="" enctype="multipart/form-data" class="d-flex flex-column h-100">
                        <div class="mb-3">
                            <label class="form-label text-black fw-bold">Active Tables Count</label>
                            <input type="number" name="active_tables" class="form-control text-black border-0" value="<?php echo $active_tables; ?>" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-black fw-bold">Staff On Duty Count</label>
                            <input type="number" name="staff_on_duty" class="form-control text-black border-0" value="<?php echo $staff_on_duty; ?>" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-black fw-bold">Cafe Main Switch</label>
                            <select name="cafe_store_status" class="form-select text-black border-0">
                                <option value="On" <?php echo ($manual_store_status === 'On') ? 'selected' : ''; ?>>On (Follow Timetable)</option>
                                <option value="Off" <?php echo ($manual_store_status === 'Off') ? 'selected' : ''; ?>>Off (Force Closed)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-black fw-bold">UI Banner Video Change</label>
                            <input type="file" name="banner_video" class="form-control text-black border-0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-black fw-bold">Online Offer (%)</label>
                            <input type="number" name="online_offer" class="form-control text-black border-0" value="<?php echo $offer; ?>" min="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-black fw-bold">NO Decoration Fees</label>
                            <input type="number" name="no_decoration_fees" class="form-control text-black border-0" value="<?php echo $no_decoration_fees; ?>" min="0">
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-black fw-bold">Decoration Fees</label>
                            <input type="number" name="decoration_fees" class="form-control text-black border-0" value="<?php echo $decoration_fees; ?>" min="0">
                        </div>
                        <div class="mt-auto">
                            <button type="submit" name="update_live_status" class="btn btn-warning w-100 py-2 fw-bold text-dark">Update Live Status</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Weekly Timetable -->
            <div class="col-12 col-xl-8">
                <div class="card shadow p-3 p-md-4 h-100" style="border-radius: 12px; background: #f0e0c3; border: none;">
                    <h4 class="card-title mb-4 text-primary fs-5 fs-md-4"><i class="fa fa-calendar-alt me-2"></i>Weekly Timetable Maintain</h4>
                    <form method="POST" action="" class="d-flex flex-column h-100">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 bg-white shadow-sm" style="border-radius: 8px; overflow: hidden; min-width: 500px;">
                                <thead class="table-warning">
                                    <tr>
                                        <th class="ps-3">Day Name</th>
                                        <th>Open Time</th>
                                        <th>Close Time</th>
                                        <th class="text-center">Weekly Off?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $all_days_result = mysqli_query($connect, "SELECT * FROM cafe_timetable ORDER BY id ASC");
                                    if ($all_days_result && mysqli_num_rows($all_days_result) > 0) {
                                        while ($day = mysqli_fetch_assoc($all_days_result)):
                                    ?>
                                            <tr>
                                                <td class="fw-bold text-secondary ps-3"><?php echo htmlspecialchars($day['day_name']); ?></td>
                                                <td>
                                                    <input type="time" name="timetable[<?php echo $day['id']; ?>][open]" class="form-control form-control-sm" value="<?php echo $day['open_time']; ?>">
                                                </td>
                                                <td>
                                                    <input type="time" name="timetable[<?php echo $day['id']; ?>][close]" class="form-control form-control-sm" value="<?php echo $day['close_time']; ?>">
                                                </td>
                                                <td class="text-center">
                                                    <input type="checkbox" name="timetable[<?php echo $day['id']; ?>][is_closed]" value="1" class="form-check-input border-secondary" style="width: 1.2rem; height: 1.2rem;" <?php echo intval($day['is_closed']) === 1 ? 'checked' : ''; ?>>
                                                </td>
                                            </tr>
                                    <?php
                                        endwhile;
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center text-danger'>No data found!</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end mt-4 mt-auto pt-3">
                            <button type="submit" name="update_timetable" class="btn btn-primary px-4 py-2 fw-bold w-sm-100">Save Weekly Timetable</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>