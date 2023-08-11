<?php
require_once "conn.php";
/*
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $order = $_POST['order'];
    $size = $_POST['size'];
    $addons = $_POST['addons'];
    $quantity = $_POST['quantity'];

    $sql = mysqli_query($conn, "INSERT INTO Orders (Name, `Order`, Size, Addons, Quantity, Price, Date, Status) VALUES ('$name', '$order', '$size', '$addons', '$quantity', 100, NOW(), 'Pending')");

    echo mysqli_error($conn);


    if ($sql) {
        echo "<script>alert('New record added')</script>";
        echo "<script>document.location = 'index.php';</script>";
    } else {
        $errorMessage = mysqli_error($conn);
        echo "<script>alert('Something went wrong in query: $errorMessage')</script>";
    }
}
*/

if (isset($_POST['confirm'])) {

    $hiddenNames = $_POST['hiddenNames'];
    $hiddenOrders = $_POST['hiddenOrders'];
    $hiddenSize = $_POST['hiddenSize'];
    $hiddenAddons = $_POST['hiddenAddons'];
    $hiddenQuantity = $_POST['hiddenQuantity'];

    $namesArray = json_decode($hiddenNames, true);
    $ordersArray = json_decode($hiddenOrders, true);
    $sizesArray = json_decode($hiddenSize, true);
    $addonsArray = json_decode($hiddenAddons, true);
    $quantitiesArray = json_decode($hiddenQuantity, true);

    if (!empty($namesArray)) {

        if (count($namesArray) > 1) {
            $insertValues = array();

            for ($i = 0; $i < count($namesArray); $i++) {
                $name = mysqli_real_escape_string($conn, $namesArray[$i]);
                $order = mysqli_real_escape_string($conn, $ordersArray[$i]);
                $size = mysqli_real_escape_string($conn, $sizesArray[$i]);
                $addons = mysqli_real_escape_string($conn, $addonsArray[$i]);
                $quantity = mysqli_real_escape_string($conn, $quantitiesArray[$i]);

                // Make sure to escape the values to prevent SQL injection

                $insertValues[] = "('$name', '$order', '$size', '$addons', '$quantity', 100, NOW(), 'Pending')";
            }

            $valuesString = implode(", ", $insertValues);
            $sql = mysqli_query($conn, "INSERT INTO Orders (Name, `Order`, Size, Addons, Quantity, Price, Date, Status) VALUES $valuesString");

            echo '<script>alert("Successfully added");</script>';
        } else {
            $name = mysqli_real_escape_string($conn, $namesArray[0]);
            $order = mysqli_real_escape_string($conn, $ordersArray[0]);
            $size = mysqli_real_escape_string($conn, $sizesArray[0]);
            $addons = mysqli_real_escape_string($conn, $addonsArray[0]);
            $quantity = mysqli_real_escape_string($conn, $quantitiesArray[0]);

            // Make sure to escape the values to prevent SQL injection

            $insertValues[] = "('$name', '$order', '$size', '$addons', '$quantity', 100, NOW(), 'Pending')";

            $valuesString = implode($insertValues);
            $sql = mysqli_query($conn, "INSERT INTO Orders (Name, `Order`, Size, Addons, Quantity, Price, Date, Status) VALUES $valuesString");
            echo '<script>alert("Successfully added");</script>';
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm">
                <h2>For Single Orders</h2>
                <form method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" name="name" class="form-control-lg" placeholder="Enter Name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input onclick="showOptions()" type="text" id="order" name="order" class="form-control-lg" placeholder="Enter Order" readonly required>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input onclick="showSizes()" type="text" id="size" name="size" class="form-control-lg" placeholder="Enter Size" readonly required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <input onclick="showAddons()" type="text" id="addons" name="addons" class="form-control-lg" placeholder="Enter Add-ons" required>
                            <a onclick="clearAddons();" class="btn-primary btn btn-danger" style="margin-top:10px;">Clear</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input min="1" type="hidden" name="quantity" class="form-control-lg" placeholder="Enter Quantity" required>
                        </div>

                        <div class="col-md-12 col-sm-6 quantity">
                            <span class="minus">-</span>
                            <span class="num">1</span>
                            <span class="plus">+</span>

                            <style>
                                .quantity {
                                    height: 50px;
                                    max-width: 300px;
                                    display: flex;
                                    background-color: white;
                                    border: 1px solid black;
                                    border-radius: 12px;
                                    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
                                    margin-left:14px;
                                }

                                .quantity span {
                                    width: 100%;
                                    text-align: center;
                                    font-size: 20px;
                                    font-weight: 600;
                                }

                                .quantity span.num {
                                    font-size: 25px;
                                    border-right: 2px solid rgba(0, 0, 0, 0.2);
                                    border-left: 2px solid rgba(0, 0, 0, 0.2);
                                }

                                .quantity span.plus:active{
                                    opacity: 30%;
                                    background-color: #212121;
                                }

                                .quantity span.minus:active{
                                    opacity: 30%;
                                    background-color: #212121;
                                }
                            </style>

                            <script>
                                const plus = document.querySelector(".plus");
                                const minus = document.querySelector(".minus");
                                const num = document.querySelector(".num");

                                let a = 1;
                                document.getElementsByName("quantity")[0].value = a;

                                plus.addEventListener("click", () => {
                                    a++;
                                    num.innerText = a;
                                    document.getElementsByName("quantity")[0].value = a;
                                })


                                minus.addEventListener("click", () => {
                                    if (a > 1) {
                                        a--;
                                        num.innerText = a;
                                        document.getElementsByName("quantity")[0].value = a;
                                    }

                                })
                            </script>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <!--
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            -->
                            <a href="#" class="btn btn-primary">View Orders</a>
                        </div>
                    </div>
                </form>
            </div>


            <div class="col-sm-8">

                <h2>For Multiple Orders</h2>

                <div class="table-responsive">
                    <table class="table" id="pendingOrdersDetails">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Order</th>
                                <th>Add-ons</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Controls</th>
                            </tr>
                        </thead>
                    </table>

                    <button class="btn btn-primary" onclick="AddRow()">Add</button>

                    <form method="POST">

                        <input type="hidden" name="hiddenNames" id="hiddenNames" value="" required>

                        <input type="hidden" name="hiddenOrders" id="hiddenOrders" value="" required>

                        <input type="hidden" name="hiddenSize" id="hiddenSize" value="" required>

                        <input type="hidden" name="hiddenAddons" id="hiddenAddons" value="" required>

                        <input type="hidden" name="hiddenQuantity" id="hiddenQuantity" value="" required>

                        <input type="submit" class="btn btn-primary" name="confirm" onclick="jsArrayToPhp()" value="Confirm Order" style="margin-top:15px;"></input>
                    </form>
                </div>
                <script src="pendingOrder.js">

                </script>
            </div>

        </div>
    </div>



    <!--This is the div for Order buttons-->
    <div id="container2" class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="category-title">Shakes</div>
                <?php
                $shakes = array(
                    "Milo Bits", "Cookies n' Cream", "Strawberry Jam", "Choco Mousse",
                    "Cappuccino", "Coffee Jelly", "Cheesy Mango Graham", "Cheesy Mango Cheesecake",
                    "Cheesy Cheesecake", "Strawberry Cheesecake", "Cheesy Graham", "Strawberry Cheesecake"
                );
                foreach ($shakes as $shake) {
                    echo '<button class="btn btn-primary menu-item" value="' . $shake . '" onclick="changeOrdersValue(this.value); hideOptions()">' . $shake . '</button>';
                }
                ?>
            </div>
            <div class="col-md-3">
                <div class="category-title">Milktea</div>
                <?php
                $milktea = array("Wintermelon", "Okinawa", "Dark Choco", "Red Velvet", "Matcha", "Taro");
                foreach ($milktea as $tea) {
                    echo '<button class="btn btn-primary menu-item" value="' . $tea . '" onclick="changeOrdersValue(this.value); hideOptions()">' . $tea . '</button>';
                }
                ?>
            </div>
            <div class="col-md-3">
                <div class="category-title">Fruit Tea</div>
                <?php
                $fruitTea = array("Green Apple", "Blueberry", "Kiwi", "Lychee", "Strawberry", "Passion Fruit");
                foreach ($fruitTea as $tea) {
                    echo '<button class="btn btn-primary menu-item" value="' . $tea . '" onclick="changeOrdersValue(this.value); hideOptions()">' . $tea . '</button>';
                }
                ?>
            </div>
            <div class="col-md-3">
                <div class="category-title">Fresh Fruit</div>
                <?php
                $freshFruit = array("Papaya", "Melon", "Avocado", "Mango", "Buko", "Dragon Fruit", "Mixed Fruit");
                foreach ($freshFruit as $fruit) {
                    echo '<button class="btn btn-primary menu-item" value="' . $fruit . '" onclick="changeOrdersValue(this.value); hideOptions()">' . $fruit . '</button>';
                }
                ?>
            </div>
        </div>

        <style>
            .category-title {
                font-size: 24px;
                font-weight: bold;
                margin-top: 20px;
            }

            .menu-item {
                font-size: 20px;
                margin-bottom: 10px;
                padding: 10px;
                border-radius: 10px;
                margin: 5px;
                background-color: #212121;
            }

            #container2 {
                visibility: hidden;
                position: absolute;
                top: 0;
                background-color: white;
            }
        </style>
    </div>




    <!--This is the div for Sizes-->
    <div class="col-md-3 offset-1">


        <div id="container3" class="container">

            <div class="row mb-3">
                <div class="col-md-12 d-flex justify-content-end">
                    <button onclick="hideSizes();" class="btn btn-small btn-danger">X</button>
                </div>
            </div>

            <div class="row col-md-12 flex justify-content-center mb-3">
                <div class="col-md-4">
                    <button onclick="changeSizesValue(this.value); hideSizes()" value="S" class="btn btn-primary menu-item">Small</button>
                </div>


            </div>

            <div class="row col-md-12 lex justify-content-center mb-3">
                <div class="col-md-4">
                    <button onclick="changeSizesValue(this.value); hideSizes()" value="M" class="btn btn-primary menu-item">Medium</button>
                </div>
            </div>


            <div class="row col-md-12 lex justify-content-center mb-3">
                <div class="col-md-4">
                    <button onclick="changeSizesValue(this.value); hideSizes()" value="L" class="btn btn-primary menu-item">Large</button>
                </div>
            </div>


            <style>
                .col-md-4 {
                    background-color: #212121;
                    color: white;
                    text-align: center;
                    border-radius: 10px;
                }

                .btn-small {
                    position: absolute;
                }

                #container3 {
                    background-color: gray;
                    border-radius: 10px;
                    position: absolute;
                    top: 100px;
                    visibility: hidden;
                }

                .menu-item {
                    font-size: 20px;
                    margin-bottom: 10px;
                    padding: 10px;
                    border-radius: 10px;
                    margin: 5px;
                    background-color: #212121;
                    width: 100%;
                    border: none;
                }

                .menu-item:hover {
                    background-color: #212121;
                }
            </style>

            <script>
                function showSizes() {
                    document.getElementById("container3").style.visibility = "visible";
                }

                function hideSizes() {
                    document.getElementById("container3").style.visibility = "hidden";
                }

                function changeSizesValue(val) {
                    document.getElementById("size").value = val;
                }
            </script>
        </div>
    </div>

    <!--This is the div for addons-->
    <div class="col-md-3 offset-1">
        <div id="container4" class="container">

            <div class="row mb-3">
                <div class="col-md-12 d-flex justify-content-end">
                    <button onclick="hideAddons();" class="btn btn-small btn-danger">X</button>
                </div>
            </div>

            <div class="row col-md-12 flex justify-content-center mb-3">
                <div class="col-md-4">
                    <button onclick="changeAddonsValue(this.value); hideAddons()" value="Pearl" class="btn btn-primary menu-item">Pearl</button>
                </div>


            </div>

            <div class="row col-md-12 lex justify-content-center mb-3">
                <div class="col-md-4">
                    <button onclick="changeAddonsValue(this.value); hideAddons()" value="Crystal/Nata" class="btn btn-primary menu-item">Crystal/Nata</button>
                </div>
            </div>


            <div class="row col-md-12 lex justify-content-center mb-3">
                <div class="col-md-4">
                    <button onclick="changeAddonsValue(this.value); hideAddons()" value="Oreo" class="btn btn-primary menu-item">Oreo</button>
                </div>
            </div>

            <div class="row col-md-12 lex justify-content-center mb-3">
                <div class="col-md-4">
                    <button onclick="changeAddonsValue(this.value); hideAddons()" value="Graham" class="btn btn-primary menu-item">Graham</button>
                </div>
            </div>

            <div class="row col-md-12 lex justify-content-center mb-3">
                <div class="col-md-4">
                    <button onclick="changeAddonsValue(this.value); hideAddons()" value="Cream Cheese" class="btn btn-primary menu-item">Cream Cheese</button>
                </div>
            </div>
        </div>

        <style>
            #container4 {
                background-color: gray;
                border-radius: 10px;
                position: absolute;
                top: 50px;
                visibility: hidden;
            }
        </style>

        <script>
            function showAddons() {
                document.getElementById("container4").style.visibility = "visible";
            }

            function hideAddons() {
                document.getElementById("container4").style.visibility = "hidden";
            }

            function changeAddonsValue(val) {
                var addonsVal = document.getElementById("addons").value;
                if (addonsVal === "") {
                    document.getElementById("addons").value = val;
                } else {
                    document.getElementById("addons").value += "," + val;
                }
            }

            function clearAddons() {
                document.getElementById("addons").value = "";
            }
        </script>

    </div>


</body>

</html>