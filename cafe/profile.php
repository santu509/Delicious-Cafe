<?php
include 'header.php';
include "connection.php";
global $connect;
?>

<!-- Import Google Fonts for Cafe-themed typography -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* Cafe Color Theme & Variables */
    :root {
        --bg-page: #fdfbf7;
        --card-bg: #ffffff;
        --card-border: #ebdcc8;
        --text-title: #36221c;
        --text-accent: #c18c5d;
        --text-body: #5c524f;
        --input-border: #ebdcc8;
        --input-focus: #c18c5d;
        
        --btn-primary: #36221c;
        --btn-primary-hover: #1a851f; /* turns green on hover, like original */
        --btn-secondary: #c18c5d;
        --btn-secondary-hover: #36221c;
        
        --shadow-soft: 0 16px 40px rgba(54, 34, 28, 0.06), 0 4px 12px rgba(54, 34, 28, 0.02);
    }

    .profile-page-wrapper {
        font-family: 'Montserrat', sans-serif;
        background-color: var(--bg-page);
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        box-sizing: border-box;
    }

    /* Glassmorphic/Sleek Card Design */
    .profile-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 24px;
        box-shadow: var(--shadow-soft);
        width: 100%;
        max-width: 460px;
        padding: 50px 40px;
        text-align: center;
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .profile-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 50px rgba(54, 34, 28, 0.1);
    }

    /* Profile Subtitle */
    .profile-subtitle {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-accent);
        text-transform: uppercase;
        letter-spacing: 3px;
        margin-bottom: 6px;
        display: block;
    }

    /* Profile Title (Serif styled) */
    .profile-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 2.3rem;
        color: var(--text-title);
        margin-top: 0;
        margin-bottom: 30px;
        font-weight: 700;
    }

    /* Avatar Container */
   .profile-avatar-container {
    position: relative;
    display: flex;
    align-self: center; 
    margin-bottom: 35px;
    width: 120px;
    height: 120px;
}

    .profile-avatar-container img {
        border-radius: 50%;
        width: 120px;
        height: 120px;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 6px 18px rgba(54, 34, 28, 0.1);
        transition: all 0.3s ease;
        background-color: #fbf9f4;
        
    }

    /* Pulsing Gradient Ring around avatar */
    .profile-avatar-container::before {
        content: '';
        position: absolute;
        top: -6px;
        left: -6px;
        right: -6px;
        bottom: -6px;
        border-radius: 50%;
        background: linear-gradient(45deg, var(--text-accent), var(--text-title), #ebdcc8, var(--text-accent));
        background-size: 300% 300%;
        animation: rotateGradient 6s linear infinite;
        z-index: -1;
        opacity: 0.85;
    }

    /* Camera Icon Badge (Overlay at the bottom-right curve) */
    .camera-icon-badge {
        position: absolute;
        bottom: 2px;
        right: 2px;
        background-color: var(--text-accent);
        color: #fff;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid #fff;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(54, 34, 28, 0.2);
        transition: all 0.3s ease;
        z-index: 2;
    }

    .camera-icon-badge:hover {
        background-color: var(--text-title);
        transform: scale(1.1);
    }

    /* Form Fields */
    .profile-form {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .form-group {
        text-align: left;
        position: relative;
    }

    .field-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--text-accent);
        margin-bottom: 8px;
        display: block;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        padding-left: 4px;
        transition: color 0.3s ease;
    }

    .form-group:focus-within .field-label {
        color: var(--text-title);
    }

    .input-field-custom {
        width: 100%;
        padding: 14px 20px;
        font-size: 0.95rem;
        font-weight: 500;
        color: var(--text-title);
        background-color: #ffffff;
        border: 2px solid var(--input-border);
        border-radius: 12px;
        box-sizing: border-box;
        outline: none;
        transition: all 0.3s ease;
    }

    .input-field-custom:hover {
        border-color: var(--text-accent);
    }

    .input-field-custom:focus {
        border-color: var(--input-focus);
        box-shadow: 0 6px 15px rgba(193, 140, 93, 0.12);
        transform: translateY(-1px);
    }

    /* Password Input Container and Toggle */
    .password-input-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .password-input-container .input-field-custom {
        padding-right: 50px;
    }

    .password-toggle-btn {
        position: absolute;
        right: 15px;
        background: none;
        border: none;
        cursor: pointer;
        color: var(--text-accent);
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s ease;
    }

    .password-toggle-btn:hover {
        color: var(--text-title);
    }

    /* Buttons Style */
    .btn-group {
        display: flex;
        gap: 15px;
        margin-top: 15px;
    }

    .btn-custom {
        flex: 1;
        padding: 14px 28px;
        font-size: 0.9rem;
        font-weight: 700;
        border-radius: 50px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #fff !important;
        box-shadow: 0 4px 10px rgba(54, 34, 28, 0.08);
    }

    .btn-back {
        background-color: var(--btn-secondary);
    }

    .btn-back:hover {
        background-color: var(--btn-secondary-hover);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(193, 140, 93, 0.25);
    }

    .btn-update {
        background-color: var(--btn-primary);
    }

    .btn-update:hover {
        background-color: var(--btn-primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(26, 133, 31, 0.25);
    }

    .btn-custom:active {
        transform: translateY(0);
    }

    /* Keyframe Animations */
    @keyframes rotateGradient {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }

    /* Responsive adjustments */
    @media only screen and (max-width: 576px) {
        .profile-card {
            padding: 35px 24px;
            border-radius: 20px;
        }

        .btn-group {
            flex-direction: column-reverse;
            gap: 10px;
        }

        .btn-custom {
            width: 100%;
        }
    }
</style>

<?php
$userid = $_SESSION['id'];
$sql = "select * from customers where id='$userid'";
$run = mysqli_query($connect, $sql);
$data = [];
if (mysqli_num_rows($run)) {
    $data = mysqli_fetch_assoc($run);
}

// 100% Browser Compatible Base64 default avatar SVG in warm bronze theme (#c18c5d)
$defaultSvg = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0iI2MxOGM1ZCI+PGNpcmNsZSBjeD0iMTIiIGN5PSI4IiByPSI0Ii8+PHBhdGggZD0iTTEyIDE0Yy02LjEgMC04IDQtOCA0djJoMTZ2LTJzLTEuOS00LTgtNHoiLz48L3N2Zz4=";

// Double check and build the image path correctly
$profilePicPath = "";
if (!empty($data['profile'])) {
    $profilePicPath = "upload/" . htmlspecialchars($data['profile']);
}
?>

<div class="profile-page-wrapper">
    <div class="profile-card">
        <span class="profile-subtitle">Personal info</span>
        <h2 class="profile-title">My Profile</h2>
        
        <!-- form tag modified with enctype for file uploading -->
        <form action="" method="post" enctype="multipart/form-data" class="profile-form">
            
            <!-- Clickable Profile Avatar container -->
            <div class="profile-avatar-container">
                <!-- Profile Image -->
                <img id="avatar-preview" src="<?php echo !empty($profilePicPath) ? $profilePicPath : $defaultSvg; ?>" onerror="this.onerror=null; this.src='<?php echo $defaultSvg; ?>';" alt="Profile Picture">
                
                <!-- Camera Icon Badge at the bottom right corner of the circle (no hover overlay on image) -->
                <div class="camera-icon-badge" onclick="document.getElementById('profile_pic').click();" title="Change profile picture">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                </div>
                
                <!-- Hidden file input for picture upload -->
                <input type="file" name="profile_pic" id="profile_pic" accept="image/*" style="display: none;" onchange="previewImage(event)">
            </div>

            <div class="form-group">
                <label class="field-label" for="name">Name</label>
                <input type="text" class="input-field-custom" id="name" name="Name" placeholder="Name" value="<?php echo htmlspecialchars($data['name']); ?>" required />
            </div>

            <div class="form-group">
                <label class="field-label" for="email">Email ID</label>
                <input type="email" class="input-field-custom" id="email" name="email" placeholder="Email id" value="<?php echo htmlspecialchars($data['email_id']); ?>" required />
            </div>

            <div class="form-group">
                <label class="field-label" for="password">Password</label>
                <div class="password-input-container">
                    <input type="password" class="input-field-custom" id="password" name="Password" placeholder="Password" value="<?php echo htmlspecialchars($data['password']); ?>" required />
                    
                    <!-- SVG Toggle Button -->
                    <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility()" title="Toggle visibility">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="btn-group">
                <a href="index.php" class="btn-custom btn-back">Back To Home</a>
                <button type="submit" class="btn-custom btn-update" name="update">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Live Image Preview function
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('avatar-preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(file);
        }
    }

    // Password Show/Hide Toggle function
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const eyeIconBtn = document.querySelector('.password-toggle-btn');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIconBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                </svg>
            `;
        } else {
            passwordInput.type = 'password';
            eyeIconBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
            `;
        }
    }
</script>

<?php
if (isset($_POST['update'])) {
    $update_username = trim($_POST['Name']);
    $update_password = trim($_POST['Password']);
    $update_email = trim($_POST['email']);
    
    $profile_updated = false;
    $new_profile_name = $data['profile']; // keep current filename if not changed

    // File upload validation & processing
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_pic']['tmp_name'];
        $fileName = $_FILES['profile_pic']['name'];
        $fileSize = $_FILES['profile_pic']['size'];
        $fileType = $_FILES['profile_pic']['type'];
        
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        // Allowed formats
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
        
        if (in_array($fileExtension, $allowedExtensions)) {
            // Generate clean unique filename to prevent overwriting
            $new_profile_name = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $fileName);
            $uploadFileDir = 'upload/';
            
            // Create upload folder if not exists
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }
            
            $dest_path = $uploadFileDir . $new_profile_name;
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $profile_updated = true;
            }
        } else {
            showCafeAlert('Invalid File Format', 'Only JPG, JPEG, PNG, and GIF image files are allowed.', 'error', 'profile.php');
        }
    }

    // Determine if any database field has actually changed
    $any_change = ($update_username !== $data['name'] || 
                   $update_email !== $data['email_id'] || 
                   $update_password !== $data['password'] || 
                   $profile_updated);

    if ($any_change) {
        // SQL query updated to include the profile field
        $sqlquery = "update customers set name='$update_username', password='$update_password', email_id='$update_email', profile='$new_profile_name' where id='$userid'";
        $run = mysqli_query($connect, $sqlquery);
        
        if ($run) {
            // Update session data
            $_SESSION['username'] = $update_username;
            $_SESSION['eid'] = $update_email;
            if ($profile_updated) {
                $_SESSION['photo'] = $new_profile_name;
            }
            showCafeAlert('Profile Updated!', 'Your profile information has been successfully updated.', 'success', 'profile.php');
        } else {
            showCafeAlert('Update Error', 'Could not update profile in the database. Please try again.', 'error', 'profile.php');
        }
    } else {
        showCafeAlert('No Changes Detected', 'You haven\'t made any changes to your profile.', 'info', 'profile.php');
    }
}
?>

<?php
include 'footer.php';
?>