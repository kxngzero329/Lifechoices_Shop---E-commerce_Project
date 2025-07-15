<?php
include 'db.php';
session_start();

// Get all items
$sql = "SELECT * FROM items";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include 'nav2.php'; ?>
  <div class="container mt-5">
    <h2 class="mb-4 text-center display-4">Our Products</h2>
    <p class="lead text-center">We offer a wide range of products to help you grow, focus, and thrive</p>
    <hr class="my-5">
    <div class="row">
      <?php while ($row = $result->fetch_assoc()) { ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <img src="<?= $row['item_url'] ?>" class="card-img-top" alt="<?= $row['item_name'] ?>" style="height: 250px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title"><?= $row['item_name'] ?></h5>
            <p class="card-text"><?= $row['item_description'] ?></p>
            <p><strong>Price:</strong> R<?= $row['item_price'] ?>.00</p>
              <a href="login.php"><button class="btn btn-outline-secondary">Login to purchase</button></a>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</body>
</html>