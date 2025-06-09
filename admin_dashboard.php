<html>
    <head>
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="samplestyle.css">
        <?php $conn=mysqli_connect("localhost", "root", "", "clubpenguinProject");
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header("Location: login.php");
            exit();
        }
        ?>

    </head>
    <body>
        <div id="side-navbar">
            <!--buttons: Account, Dashboard, Orders, Settings,          Log Out-->
            <p>Hello, Admin <?php echo $_SESSION['admin_name']; ?>!</p>
            <a href="logout.php"><button>Log Out</button></a>
        </div>
        <div id="main-container">
            <nav>
                <div id="left-nav">
                    <!--LOGO,       display- Hello Admin 'username'-->
                </div>
                <div id="right-nav">
                    <!--Log Out button-->
                </div>
            </nav>
            <main>
                <article id="left-main">
                    <section class="table-container">
                        <div class="top-part">
                            <div class="top-left-part">
                                <!--Table1: Users,     button: Action= add-->
                                <h2>Users</h2>
                                <a href="addUser_form.php"><button>Add User</button></a>
                            </div>
                            <div class="top-right-part">
                                <!--Search bar for Table1-->
                                <form method="GET" action="admin_dashboard.php">
                                    <input type="text" name="search_user" placeholder="Search user..." value="<?php echo isset($_GET['search_user']) ? htmlspecialchars($_GET['search_user']) : ''; ?>">
                                    <button type="submit">Search</button>
                                </form>
                            </div>
                        </div>
                        <div class="lower-part">
                            <!--
                            Table 1
                                Table rows,          buttons: Action= edit, delete
                            -->
                            <table border="1" width="100%" style="border-collapse: collapse; margin-top: 10px;">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th>Phone Number</th>
                                        <th>Date Created</th>
                                        <th>Latest Update</th>
                                        <th colspan="2">Actions</th>   
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $searchUser = isset($_GET['search_user']) ? mysqli_real_escape_string($conn, $_GET['search_user']) : '';
                                    if ($searchUser !== '') {
                                        $query = "SELECT * FROM User WHERE 
                                                userfName LIKE '%$searchUser%' OR 
                                                userlName LIKE '%$searchUser%' OR 
                                                userEmail LIKE '%$searchUser%' OR 
                                                userPhoneNum LIKE '%$searchUser%'";
                                    } else {
                                        $query = "SELECT * FROM User ORDER BY userID ASC";
                                    }
                                    $select_tblUsers = mysqli_query($conn, $query);
                                    if (mysqli_num_rows($select_tblUsers) > 0) {
                                        while($row = mysqli_fetch_array($select_tblUsers)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['userID']; ?></td>
                                                <td><?php echo $row['userfName']; ?></td>
                                                <td><?php echo $row['userlName']; ?></td>
                                                <td><?php echo $row['userEmail']; ?></td>
                                                <td><?php echo $row['userPassword']; ?></td>
                                                <td><?php echo $row['userPhoneNum']; ?></td>
                                                <td><?php echo $row['createdAt']; ?></td>
                                                <td><?php echo $row['updatedAt']; ?></td>
                                                <td align="center">
                                                    <a href="editUser_form.php?userID=<?php echo $row['userID']; ?>">Edit</a>
                                                </td>
                                                <td align="center">
                                                    <a href="deleteUser.php?userID=<?php echo $row['userID']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='10' align='center'>No users found.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <section class="table-container">
                        <div class="top-part">
                            <div class="top-left-part">
                                <!--Table2: Cars,     button: Action= add-->
                                <h2>Cars</h2>
                                <a href="addCar_form.php"><button>Add Car</button></a>
                            </div>
                            <div class="top-right-part">
                                <!--Search bar for Table2-->
                                <form method="GET" action="admin_dashboard.php">
                                    <input type="text" name="search_car" placeholder="Search car..." value="<?php echo isset($_GET['search_car']) ? htmlspecialchars($_GET['search_car']) : ''; ?>">
                                    <button type="submit">Search</button>
                                </form>
                            </div>
                        </div>
                        <div class="lower-part">
                            <!--
                            Table 2
                                Table rows,          buttons: Action= edit, delete
                            -->
                            <table border="1" width="80%" style="border-collapse: collapse;">
                                <tr>
                                    <th>Car ID</th>
                                    <th>Brand</th>
                                    <th>Model</th>
                                    <th>Size</th>
                                    <th>Plate Number</th>
                                    <th>Description</th>
                                    <th>Available</th>
                                    <th>Date Created</th>
                                    <th colspan="2">Actions</th>  
                                </tr>
                                    <?php  
                                    $searchCar = isset($_GET['search_car']) ? mysqli_real_escape_string($conn, $_GET['search_car']) : '';
                                    if ($searchCar !== '') {
                                        $query = "SELECT * FROM Car WHERE 
                                                carBrand LIKE '%$searchCar%' OR 
                                                carModel LIKE '%$searchCar%' OR 
                                                carPlateNum LIKE '%$searchCar%' OR 
                                                carSize LIKE '%$searchCar%'";
                                    } else {
                                        $query = "SELECT * FROM Car ORDER BY carID ASC";
                                    }
                                    $select_tblCar = mysqli_query($conn, $query);
                                    if (mysqli_num_rows($select_tblCar) > 0) {
                                        while($row = mysqli_fetch_array($select_tblCar)){
                                            ?>
                                            <tr>
                                                <td><?php echo $row['carID'];?></td>
                                                <td><?php echo $row['carBrand'];?></td>
                                                <td><?php echo $row['carModel'];?></td>
                                                <td><?php echo $row['carSize'];?></td>
                                                <td><?php echo $row['carPlateNum'];?></td>
                                                <td><?php echo $row['carDescription'];?></td>
                                                <td><?php echo $row['isAvailable'];?></td>
                                                <td><?php echo $row['createdAt'];?></td>
                                                <td align="center">
                                                        <a href="editCar_form.php?userID=<?php echo $row['carID']; ?>">Edit</a>
                                                    </td>
                                                    <td align="center">
                                                        <a href="deleteCar.php?userID=<?php echo $row['carID']; ?>" onclick="return confirm('Are you sure you want to delete this car?');">Delete</a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    }else {
                                        echo "<tr><td colspan='10' align='center'>No cars found.</td></tr>";
                                    }
                                    ?>
                            </table>
                        </div>
                    </section>

                    <section class="table-container">
                        <div class="top-part">
                            <div class="top-left-part">
                                <!--Table3: Confirmed Orders,     Orders button-->
                                <h2>Confirmed Orders</h2>
                                <a href="pendingOrders.php">Check Pending Orders</a>
                            </div>
                            <div class="top-right-part">
                                <!--Search bar for Table3-->
                                <form method="GET" action="admin_dashboard.php">
                                    <input type="text" name="search_order" placeholder="Search orders..." value="<?php echo isset($_GET['search_order']) ? htmlspecialchars($_GET['search_order']) : ''; ?>">
                                    <button type="submit">Search</button>
                                </form>
                            </div>
                        </div>
                        <div class="lower-part">
                            <!--
                            Table 3
                                Table rows,          button: Action= cancel
                            -->
                            <div class="lower-part">
                                <table border="1" width="100%" style="border-collapse: collapse; margin-top: 10px;">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>User</th>
                                            <th>Car</th>
                                            <th>Description</th>
                                            <th>Dispatch Date</th>
                                            <th>Return Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $searchOrder = isset($_GET['search_order']) ? mysqli_real_escape_string($conn, $_GET['search_order']) : '';
                                        if ($searchOrder !== '') {
                                            $query = "
                                                SELECT o.orderID, u.userfName, u.userlName, c.carBrand, c.carModel,
                                                    o.orderDescription, o.dispatchDate, o.returnDate
                                                FROM Orders o
                                                JOIN User u ON o.userID = u.userID
                                                JOIN Car c ON o.carID = c.carID
                                                WHERE o.isConfirmed = 1 AND (
                                                    u.userfName LIKE '%$searchOrder%' OR
                                                    u.userlName LIKE '%$searchOrder%' OR
                                                    c.carBrand LIKE '%$searchOrder%' OR
                                                    c.carModel LIKE '%$searchOrder%' OR
                                                    o.orderDescription LIKE '%$searchOrder%'
                                                )
                                                ORDER BY o.dispatchDate ASC
                                            ";
                                        } else {
                                            $query = "
                                                SELECT o.orderID, u.userfName, u.userlName, c.carBrand, c.carModel,
                                                    o.orderDescription, o.dispatchDate, o.returnDate
                                                FROM Orders o
                                                JOIN User u ON o.userID = u.userID
                                                JOIN Car c ON o.carID = c.carID
                                                WHERE o.isConfirmed = 1
                                                ORDER BY o.dispatchDate ASC
                                            ";
                                        }
                                        $confirmedOrdersQuery = mysqli_query($conn, $query);
                                        if (mysqli_num_rows($confirmedOrdersQuery) > 0):
                                            while ($row = mysqli_fetch_assoc($confirmedOrdersQuery)):
                                        ?>
                                            <tr>
                                                <td><?php echo $row['orderID']; ?></td>
                                                <td><?php echo $row['userfName'] . ' ' . $row['userlName']; ?></td>
                                                <td><?php echo $row['carBrand'] . ' ' . $row['carModel']; ?></td>
                                                <td><?php echo $row['orderDescription']; ?></td>
                                                <td><?php echo $row['dispatchDate']; ?></td>
                                                <td><?php echo $row['returnDate']; ?></td>
                                                <td align="center">
                                                    <a href="returnOrder.php?orderID=<?php echo $row['orderID']; ?>" onclick="return confirm('Move this order back to pending?');">
                                                        ❌ Cancel
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php
                                            endwhile;
                                        else:
                                            echo "<tr><td colspan='7' align='center'>No confirmed orders.</td></tr>";
                                        endif;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </article>
                <aside id="right-main">
                    <?php
                    // Analytics Queries
                    $userCountQuery = mysqli_query($conn, "SELECT COUNT(*) AS totalUsers FROM User");
                    $confirmedOrderQuery = mysqli_query($conn, "SELECT COUNT(*) AS confirmedOrders FROM Orders WHERE isConfirmed = 1");
                    $pendingOrderQuery = mysqli_query($conn, "SELECT COUNT(*) AS pendingOrders FROM Orders WHERE isConfirmed = 0");

                    $totalUsers = mysqli_fetch_assoc($userCountQuery)['totalUsers'];
                    $confirmedOrders = mysqli_fetch_assoc($confirmedOrderQuery)['confirmedOrders'];
                    $pendingOrders = mysqli_fetch_assoc($pendingOrderQuery)['pendingOrders'];
                    ?>

                    <div class="analytics-card">
                        <h3>👤 Total Users</h3>
                        <p><?php echo $totalUsers; ?></p>
                    </div>

                    <div class="analytics-card">
                        <h3>✅ Confirmed Orders</h3>
                        <p><?php echo $confirmedOrders; ?></p>
                    </div>

                    <div class="analytics-card">
                        <a href="pendingOrders.php"><h3>🕒 Pending Orders</h3></a>
                        <p><?php echo $pendingOrders; ?></p>
                    </div>
                </aside>
            </main>
        </div>
    </body>
</html>