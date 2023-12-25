<?php
include('./header.php');
  session_start();
  if (!isset($_SESSION['username'])) {
      header('Location: loginp.php');
      exit;
  }

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_POST['submit'])) {
        $status = $_POST['status'];

        require_once('db_login.php');

        $update_query = "UPDATE anggota SET status = '$status' WHERE noktp = '$id'";
        $update_result = $db->query($update_query);

        if (!$update_result) {
            die("Could not update the status: <br />" . $db->error);
        } else {
            $msg = "Status updated successfully.";
        }

        $db->close();
    }
} else {
    echo "No member ID provided.";
}
?>

<div class="card mt-5">
    <div class="card-header">Add Status
    <a href="logout.php" class="btn btn-danger float-right">Logout</a>
    </div>
    <div class="card-body">
        <form method="post">
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" name="status" id="status">
                    <option value="1">Approved</option>
                    <option value="0">Not Approved</option>
                </select>
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <a href="verifikasi.php" class="btn btn-secondary">Cancel</a>
        </form>
        <br>
        <div>
        <?php if (isset($msg)): ?>
               <div class="alert alert-success alert-dismissible">
                   <strong>Success!</strong> <?= $msg ?>
               </div>
           <?php endif; ?>
        </div>
    </div>
</div>

<?php include('./footer.php'); ?>
