<?php
include_once('All-Function.php');

$id = $_GET['id'];
$data = single_row_details('customers', $id);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit User</title>

    <link rel="stylesheet" href="../asset/bootstrap-5.3.7-dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f6ddbe;
            min-height: 100vh;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .btn {
            border-radius: 10px;
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
            border: 4px solid purple;
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
    </style>
</head>

<body>

    <div class="container w-50 d-flex justify-content-center align-items-center">

        <div class="col-md-6 mt-5">

            <div class="card p-4">

                <form method="POST" action="Edit-customer-action.php" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $data['id'] ?>">

                    <!-- Profile Image -->
                    <div class="text-center mb-3">

                        <div class="profile-wrapper">

                            <img src="../upload/<?php echo $data['profile']; ?>"
                                class="profile-img" id="previewImg">

                            <!-- Camera Icon -->
                            <label for="fileInput" class="camera-icon bg-info">
                                <i class="bi bi-camera-fill"></i>
                            </label>

                            <input type="file" name="profileimg" id="fileInput" hidden>

                        </div>

                        <h4 class="mt-3"><?php echo $data['name'] ?></h4>

                    </div>

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="uname">Name</label>
                        <div class="input-group">
                            <label for="uname" class="input-group-text"><i class="bi bi-person"></i></label>
                            <input type="text" id="uname" name="name" class="form-control"
                                value="<?php echo $data['name']; ?>" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="uemail">Email</label>
                        <div class="input-group">
                            <label for="uemail" class=" input-group-text"><i class="bi bi-envelope"></i></label>
                            <input type="email" id="uemail" name="email" class="form-control"
                                value="<?php echo $data['email_id']; ?>" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="upassword">Password</label>
                        <div class="input-group">
                            <label for="upassword" class="input-group-text"><i class="bi bi-lock"></i></label>
                            <input type="text" id="upassword" name="password" class="form-control"
                                value="<?php echo $data['password']; ?>" required>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="user_list.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>

                        <button type="submit" name="submit-btn" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Update
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script src="../asset/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const fileInput = document.getElementById('fileInput');
        const previewImg = document.getElementById('previewImg');

        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                previewImg.src = URL.createObjectURL(file);
            }
        });
    </script>

</body>

</html>