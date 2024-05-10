<!doctype html>
<html lang="en">
  <head>
    <title>Front-page</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
  </head>
  <body>
    <?php include 'db.php'; ?>
    <div class="container-custom mt-5">
      <div class="d-block d-md-flex flex-row justify-content-between align-items-center py-30">
        <div class="col-12 col-md-3">
          <h1>Product List</h1>
        </div>

        <div class="col-12 col-md-4">
          <div class="d-flex justify-content-end">
            <a href="/add-product" class="btn btn-primary text-uppercase me-1 me-md-5">ADD</a>
            <button id="delete-product-btn" type="button" class="btn btn-danger text-uppercase">MASS DELETE</button>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <hr class="border-2 border-black my-0">
        </div><?php

        // Delete items
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mass_delete'])) {
            if (!empty($_POST['delete'])) {
                $delete_skus = $_POST['delete'];
                
                // Construct the SQL query to delete selected items
                $sql = "DELETE FROM items_db WHERE SKU IN ('" . implode("','", $delete_skus) . "')";
            
                // Execute the SQL query
                if ($conn->query($sql) === TRUE) {
                    echo "<div class='alert alert-success' role='alert'>Selected items deleted successfully!</div>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Error deleting items: " . $conn->error . "</div>";
                }
            } else {
                echo "<div class='alert alert-warning' role='alert'>No items selected for deletion!</div>";
            }
        }

        // New connection
        $conn = new mysqli("sql108.infinityfree.com", "if0_36515157", "ZUHCV6AK3Kqugq", "if0_36515157_mrmomo_db");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert items
        if (isset($_POST['sku']) && isset($_POST['name']) && isset($_POST['price']) && isset($_POST['switcher'])) {
            $sku = $conn->real_escape_string($_POST['sku']);
            $name = $conn->real_escape_string($_POST['name']);
            $price = $conn->real_escape_string($_POST['price']);
            $switcher = $conn->real_escape_string($_POST['switcher']);
            $size = $conn->real_escape_string($_POST['size']);
            $height = $conn->real_escape_string($_POST['height']);
            $width = $conn->real_escape_string($_POST['width']);
            $length = $conn->real_escape_string($_POST['length']);
            $weight = $conn->real_escape_string($_POST['weight']);

            $sql = "INSERT INTO items_db (SKU, Name, Price, Switcher, Size, Height, Width, Length, Weight) VALUES ('$sku', '$name', '$price', '$switcher', '$size', '$height', '$width', '$length', '$weight')";
            
            if ($conn->query($sql) === TRUE) {
            }
        }

        // Retrieve data from the database
        $sql = "SELECT * FROM items_db";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          ?><form method="post">
          <div class="row pt-5"><?php
              // Output data of each row
              while($row = $result->fetch_assoc()) {
                  ?><div class="col-12 col-md-6 col-xxl-3">
                      <div class="border border-3 border-dark p-3 mb-4">
                          <input type="checkbox" class="d-block delete-checkbox mb-2" name="delete[]" value="<?php echo $row["SKU"]; ?>">
                          <div class="p-5 text-center fs-4"><?php
                              echo $row["SKU"]. "<br>";
                              echo $row["Name"]. "<br>";
                              echo $row["Price"]. ".00 $" . "<br>";
      
                              // Check the value of Switcher
                              $switcher = $row["Switcher"];
                              if ($switcher == "dvd") {
                                  echo "Size: " . $row["Size"]. " MB";
                              } elseif ($switcher == "furniture") {
                                  echo "Dimension: " . $row["Height"]."x".$row["Width"]."x".$row["Length"];
                              } elseif ($switcher == "book") {
                                  echo "Weight: " . $row["Weight"]. " KG";
                              }
                              ?></div>
                      </div>
                  </div><?php
              }
            ?></div>
          <input id="submit_button" type="submit" name="mass_delete" class="d-none">
      </form>
      <?php
        } else {
        }

        // Close connection
        $conn->close();
        ?>
      </div>

    </div>

    <!-- Optional JavaScript -->
    <script>
        $(function() {      
            $("#delete-product-btn").on("click", function() {
                $("#submit_button").click();
            });
        });
    </script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  </body>
</html>