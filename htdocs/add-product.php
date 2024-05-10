<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product page</title>
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
    <div class="container-custom mt-5">
        <div class="d-block d-md-flex flex-row justify-content-between align-items-center py-30">
            <div class="col-12 col-md-3">
                <h1>Product Add</h1>
            </div>

            <div class="col-12 col-md-4">
                <div class="d-flex justify-content-end">
                    <button id="save" type="button" class="btn btn-primary me-5">Save</button>
                    <a href="/" class="btn btn-primary">Cancel</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <hr class="border-2 border-black my-0">
            </div>

            <div class="mt-4 col-6 col-lg-4">
                <form id="product_form" action="/" method="post">
                    <div class="row mb-3">
                        <div class="col-12 col-lg-4 fs-4">SKU:</div>
                        <input id="sku" class="col-12 col-lg-8" type="text" name="sku" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-lg-4 fs-4">Name:</div>
                        <input id="name" class="col-12 col-lg-8" type="text" name="name" required>
                    </div>

                    <div class="row mb-5">
                        <div class="col-12 col-lg-4 fs-4">Price ($):</div>
                        <input id="price" class="col-12 col-lg-8" type="number" name="price" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-lg-6 fs-4">Type Switcher:</div>
                        <select id="productType" class="col-12 col-lg-6" name="switcher" required>
                            <option value="" disabled selected>Select Type</option>
                            <option value="dvd">DVD</option>
                            <option value="furniture">Furniture</option>
                            <option value="book">Book</option>
                        </select>
                    </div>

                    <div id="DVD" class="row mb-3 d-none">
                        <div class="col-12 col-lg-4 fs-4">Size (MB):</div>
                        <input id="size" class="col-12 col-lg-8" type="number" name="size">
                        <div class="mt-2">“Please, provide size”</div>
                    </div>

                    <div id="Furniture" class="d-none">
                        <div class="row mb-3">
                            <div class="col-12 col-lg-4 fs-4">Height (MB):</div>
                            <input id="height" class="col-12 col-lg-8" type="number" name="height">
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 col-lg-4 fs-4">Width (MB):</div>
                            <input id="width" class="col-12 col-lg-8" type="number" name="width">
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 col-lg-4 fs-4">Length (MB):</div>
                            <input id="length" class="col-12 col-lg-8" type="number" name="length">
                        </div>
                        <div class="mt-2">“Please, provide dimensions”</div>
                    </div>

                    <div id="Book" class="row d-none">
                        <div class="col-12 col-lg-4 fs-4">Weight (KG):</div>
                        <input id="weight" class="col-12 col-lg-8" type="number" name="weight">
                        <div class="mt-2">“Please, provide weight”</div>
                    </div>

                    <input id="submit_button" class="d-none" type="submit">
                </form>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script>
        $(function() {
            $("#productType").on("change", function() {
                var selectedValue = $(this).val();
                $("#DVD, #Furniture, #Book").find("input").prop("required", false);

                $("#DVD").toggleClass("d-none", selectedValue !== "dvd");
                $("#Furniture").toggleClass("d-none", selectedValue !== "furniture");
                $("#Book").toggleClass("d-none", selectedValue !== "book");
                
                if (selectedValue === "dvd") {
                    $("#DVD").find("input").prop("required", true);
                } else if (selectedValue === "book") {
                    $("#Book").find("input").prop("required", true);
                } else if (selectedValue === "furniture") {
                    $("#Furniture").find("input").prop("required", true);
                }
            });

            $("#save").on("click", function() {
                // Check if form is valid
                if (document.getElementById("product_form").checkValidity()) {
                    // Perform AJAX request to check if SKU is unique
                    var sku = $("#sku").val();
                    $.ajax({
                        url: "db.php",
                        type: "POST",
                        data: {sku: sku},
                        success: function(response) {
                            if (response === "exist") {
                                alert("SKU already exists. Please provide a unique SKU.");
                            } else {
                                $("#submit_button").click();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error checking SKU:", error);
                        }
                    });
                } else {
                    // If form is not valid, show error message
                    alert("Please submit required data.");
                }
            });
        });
    </script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
