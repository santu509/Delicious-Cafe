<?php

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load database connection / admin authentication
include_once('admin_login.php');


// ==========================================
// ALL FAQ
// ==========================================
function allfaq()
{
    global $connect;

    $sql = "SELECT * FROM faq";
    $run = mysqli_query($connect, $sql);

    if ($run && mysqli_num_rows($run) > 0) {
        return mysqli_fetch_all($run, MYSQLI_ASSOC);
    }

    return false;
}


// ==========================================
// FAQ ADD
// ==========================================
if (isset($_POST['save_faq'])) {
    global $connect;
    $question = $_POST['question'];
    $ans = $_POST['answer'];

    $sql = "INSERT INTO faq (question, answer)
            VALUES ('$question', '$ans')";

    $run = mysqli_query($connect, $sql);

    if ($run) {
        $_SESSION['alert_type'] = 'success';
        $_SESSION['alert_msg'] = 'FAQ added successfully.';
    } else {
        $_SESSION['alert_type'] = 'danger';
        $_SESSION['alert_msg'] = 'Failed to add FAQ.';
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}


// ==========================================
// FAQ UPDATE
// ==========================================
if (isset($_POST['update_btn'])) {
global $connect;
    $id = (int) $_POST['id'];
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    $sql = "UPDATE faq
            SET question='$question',
                answer='$answer'
            WHERE id=$id";

    $run = mysqli_query($connect, $sql);

    if ($run) {
        $_SESSION['alert_type'] = 'success';
        $_SESSION['alert_msg'] = 'FAQ updated successfully.';
    } else {
        $_SESSION['alert_type'] = 'danger';
        $_SESSION['alert_msg'] = 'Failed to update FAQ.';
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}


// ==========================================
// FAQ DELETE
// ==========================================
if (isset($_GET['btn']) && $_GET['btn'] == 'faq_delete') {
global $connect;
    $id = (int) $_GET['id'];

    $sql = "DELETE FROM faq WHERE id=$id";

    $run = mysqli_query($connect, $sql);

    if ($run) {
        $_SESSION['alert_type'] = 'success';
        $_SESSION['alert_msg'] = 'FAQ deleted successfully.';
    } else {
        $_SESSION['alert_type'] = 'danger';
        $_SESSION['alert_msg'] = 'Failed to delete FAQ.';
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}


// ==========================================
// IMPORTANT
// Dashboard comes AFTER all header() logic
// ==========================================
include_once('Dashboard.php');

?>

<?php if (isset($_SESSION['alert_msg'])): ?>

    <div id="customAlert"
        class="alert alert-<?= $_SESSION['alert_type'] ?> alert-dismissible fade show border-0 shadow-sm"
        style="display:none; position:fixed; top:20px; right:400px; z-index:9999; max-width:450px; width:90%; border-radius:12px;">

        <?= $_SESSION['alert_msg']; ?>

        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"></button>
    </div>

    <?php
    unset($_SESSION['alert_msg']);
    unset($_SESSION['alert_type']);
    ?>

<?php endif; ?>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    /* Cafe Theme Colors */
    :root {
        --cafe-primary: #5c3a21;
        /* Coffee Brown */
        --cafe-secondary: #d4b895;
        /* Latte */
        --cafe-bg: #f9f6f0;
        /* Light Beige */
        --cafe-text: #3e2723;
        /* Dark Brown */
    }

    body {
        background-color: var(--cafe-bg);
        color: var(--cafe-text);
    }

    .container-custom {
        /* width: 100%; */
        margin-top: 10px;
        margin-left: 15%;
        /* Adjust this based on your sidebar width */
        padding: 2%;
        transition: all 0.3s ease;
    }

    /* Mobile & Tablet Responsiveness */
    @media (max-width: 991px) {
        .container-custom {
            margin-left: 0;
            padding: 15px;
        }
    }

    /* Text Wrapping for long questions & answers */
    .wrap-text {
        word-wrap: break-word;
        word-break: break-word;
        white-space: pre-wrap;
        /* Keeps user line breaks but forces wrap */
        min-width: 200px;
        /* Prevents cells from becoming too narrow */
    }

    .btn-cafe {
        background-color: #043e8a;
        color: white;
        border: none;
    }

    .btn-cafe:hover {
        background-color: #042a5d;
        color: white;
    }

    .card-header {
        background-color: var(--cafe-primary) !important;
        color: white;
    }

    .table thead th {
        background-color: var(--cafe-secondary);
        color: var(--cafe-text);
    }

    .modal-header {
        background-color: var(--cafe-primary);
        color: white;
    }

    .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }

    .btn-update {
        background-color: green;
        color: #f9f6f0;
        font-weight: 600;
    }

    .btn-update:hover {
        background: #0e6201;
        ;
        color: #f9f6f0;
        font-weight: 600;
    }

    .btn_close {
        border: 2px solid red;
        color: red;
        font-weight: 600;
    }

    .btn_close:hover {
        border: 2px solid red;
        color: white;
        background: red;
        font-weight: 600;
        transition: 0.5s;
    }

    .successAlert {
        margin-left: 50%;
        position: fixed;

    }
</style>

<div class="container-custom">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <h2 class="m-0 fw-bold" style="color: #512d04; font-weight: bold;">FAQ Management</h2>
        <button type="button" class="btn btn-cafe px-3 py-2" data-bs-toggle="modal" data-bs-target="#addFaqModal">
            <i class="fa fa-plus"></i> Add New FAQ
        </button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover m-0 align-middle">
                    <thead>
                        <tr>
                            <th width="10%" class="text-center">Sl.No</th>
                            <th width="35%">Question</th>
                            <th width="40%">Answer</th>
                            <th width="15%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $Allfaq = allfaq();
                        if ($Allfaq) {
                            foreach ($Allfaq as $faq) {
                        ?>
                                <tr>
                                    <td class="text-center"><?php echo $i; ?></td>
                                    <td class="fw-semibold wrap-text"><?php echo $faq['question'] ?></td>
                                    <td class=" wrap-text"><?php echo $faq['answer'] ?></td>
                                    <td class="text-center">
                                        <div class="d-flex flex-wrap justify-content-center gap-3">
                                            <button type="button" class="btn btn-sm btn-outline-warning edit-btn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editFaqModal"
                                                data-id="<?php echo $faq['id'] ?>"
                                                data-question="<?php echo $faq['question'] ?>"
                                                data-answer="<?php echo $faq['answer'] ?>">
                                                <i class="fa-solid fa-edit"></i>
                                            </button>
                                            <a href="faq_page.php?btn=faq_delete&id=<?php echo $faq['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirmAdminDelete(event, this.href, 'this FAQ entry');"><i class="fa-solid fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                                $i = $i + 1;
                            }
                        } else {
                            ?>

                        <?php
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="addFaqModal" tabindex="-1" aria-labelledby="addFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFaqModalLabel">Add New FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Question</label>
                        <textarea class="form-control" name="question" rows="2" placeholder="Enter question here..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Answer</label>
                        <textarea class="form-control" name="answer" rows="4" placeholder="Enter answer here..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn_close" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="save_faq" class="btn btn-update">Save FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editFaqModal" tabindex="-1" aria-labelledby="editFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFaqModalLabel">Edit FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Question</label>
                        <textarea class="form-control" name="question" id="edit-question" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Answer</label>
                        <textarea class="form-control" name="answer" id="edit-answer" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn_close" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-update" name="update_btn">Update FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // success and failed message start

    document.addEventListener("DOMContentLoaded", function() {

        const alertBox = document.getElementById("customAlert");

        if (alertBox) {

            alertBox.style.display = "block";

            setTimeout(() => {

                alertBox.classList.remove("show");

                setTimeout(() => {
                    alertBox.remove();
                }, 300);

            }, 3000);
        }

    });

    // success and failed message end


    document.addEventListener("DOMContentLoaded", function() {
        const editButtons = document.querySelectorAll('.edit-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Get data attributes from the clicked button
                const id = this.getAttribute('data-id');
                const question = this.getAttribute('data-question');
                const answer = this.getAttribute('data-answer');

                // Set values in the modal inputs
                document.getElementById('edit-id').value = id;
                document.getElementById('edit-question').value = question;
                document.getElementById('edit-answer').value = answer;
            });
        });
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
</body>

</html>