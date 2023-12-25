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
  $query = "SELECT * FROM buku b, anggota a, rating_buku r WHERE a.noktp =  r.noktp AND b.idbuku = r.idbuku AND a.noktp = '$ktp' AND b.idbuku = '$bookId'";
  $result = $db->query($query);

  $querynamabuku = "SELECT judul FROM buku WHERE idbuku = '$bookId'";
  $resultnamabuku = $db->query($querynamabuku);
  $row = $resultnamabuku->fetch_object();
?>


<div class="row w-1000 mx-auto mt-5">
    <div class="col">
        <div class="card">
        <?php  echo '<div class="card-header">Rating Buku : '. $row->judul . '</div>'; ?>
            <div class="card-body">
              <?php if($result->num_rows == 0){ ?>
                <form method="POST" action="">
                  <div class="form-group">
                    <label for="rating">Rating:</label>
                    <select class="form-control" id="rating" name="rating">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                  $rating = $_POST['rating'];
                  $ktp = $_SESSION['ktp'];
                  $date = date('Y-m-d H:i:s');
                  $query2 = "INSERT INTO rating_buku (noktp, idbuku, skor_rating, tgl_rating) VALUES ('$ktp', '$bookId', '$rating', '$date')";
                  $result2 = $db->query($query2);
                  if (!$result2) {
                    die("Could not query the database: <br>".$db->error.'<br>Query:'.$query2);
                  } else {
                    header('Location: detail_book.php?id='.$bookId);
                    exit;
                  }
                }
              ?>
              <?php } else {
                $row = $result->fetch_object();
                echo '<label>Anda sudah memberikan rating untuk buku ini:</label>';
                echo '<div class="alert alert-info" role="alert">';
                echo 'Rating: '.$row->skor_rating;
                echo '</div>';
              } ?>
            </div>
        </div>
    </div>

<?php
    include("footer.php");
?>