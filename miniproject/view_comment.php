<?php
  session_start();
  if (!isset($_SESSION['ktp'])) {
      header('Location: login.php');
      exit;
  }
  require_once('db_login.php');
  $ktp = $_SESSION['ktp'];
  $bookId = $_GET['id'];
?>

<?php include("header.php"); ?>

<?php
  $querynamabuku = "SELECT judul FROM buku WHERE idbuku = '$bookId'";
  $resultnamabuku = $db->query($querynamabuku);
  $row = $resultnamabuku->fetch_object();
?>


<div class="row w-1000 mx-auto mt-5">
    <div class="col">
        <div class="card">
        <?php  echo '<div class="card-header">Comment Buku : '. $row->judul . '</div>'; ?>
            <div class="card-body">
                <form method="POST" action="">
                  <div class="form-group">
                    <label for="comment">Comment:</label>
                    <input class="form-control" id="comment" name="comment">
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                  $comment = $_POST['comment'];
                  $ktp = $_SESSION['ktp'];
                  $query2 = "INSERT INTO kometar_buku (idbuku, noktp, komentar) VALUES ('$bookId', '$ktp', '$comment')";
                  $result2 = $db->query($query2);
                  if (!$result2) {
                    die("Could not query the database: <br>".$db->error.'<br>Query:'.$query2);
                  } else {
                    header('Location: detail_book.php?id='.$bookId);
                    exit;
                  }
                }
              ?>
            </div>
        </div>
    </div>

<?php
    include("footer.php");
?>