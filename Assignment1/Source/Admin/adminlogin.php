<?php
session_start(); // Start the session

if (isset($_POST['submit'])) {
    if ($_POST['password'] == 'letmein') {
        $_SESSION['loggedin'] = true;
        header('Location: /Admin/admin_panel.php'); // Adjust the path to match the correct location
        exit();
    } else {
        $loginError = "Invalid password.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="/ibuy.css" />
    <link rel="stylesheet" href="/styles.css" />
    <style>
        /* Add your additional CSS styles here if needed */
        header form input[type=submit] {
            background-color: #005d96;
            color: white;
            width: 20%;
            font-size: 2em;
            padding: 0.5em;
            cursor: pointer;
            border: 0;
        }
        header form input[type="text"] {
            border: 2px solid black;
            font-size: 2em;
            padding: 0.45em;
            width: 70%;
        }
 

        
    /* Adjust the styles for the buttons */
    .button {
        display: inline-block;
        padding: 8px 25px; /* Adjust padding for the buttons */
        margin-right: 10px; /* Add margin between buttons */
        background-color: #4CAF50;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        border: none;
        min-width: 120px; /* Set the minimum width for the buttons */
        text-align: center;
        line-height: 20px; /* Center text vertically */
    }
        
        /* Hover effect for buttons */
        .button:hover {
            background-color: #45a049;
        }
/* Table style */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th,
table td {
    padding: 8px;
    border: 1px solid #ccc;
}

.description-cell {
    max-width: 300px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.actions-cell {
    width: 150px; /* Decrease the width of the actions column */
    white-space: nowrap;
}

/* Button style */
.button {
    display: inline-block;
    padding: 8px 15px; /* Adjust padding for the buttons */
    background-color: #4CAF50;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    border: none;
}

/* Hover effect for buttons */
.button:hover {
    background-color: #45a049;
}
a, a:visited {
  color: white;
}
    </style>
</head>
<body>
    <header>
        <h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>
        <form action="#">
            <input type="text" name="search" placeholder="Search for anything" />
            <input type="submit" name="submit" value="Search" />
        </form>
    </header>
    <nav>
        <ul>
            <li><a href="adminlogin.php">Admin Dashboard</a></li>
            <li><a href="adminlogin.php">Auctions</a></li>
            <li><a href="adminlogin.php">Categories</a></li>
            <li><a href="/Logout.php">Logout</a></li>
        </ul>
    </nav>
    <img src="/banners/1.jpg" alt="Banner" />
    <main class="sidebar">
        <?php
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            // ... Your logged-in content ...
        } else {
            ?>
            <h2>Log in</h2>
            <?php if (isset($loginError)) { echo "<p style='color: red;'>$loginError</p>"; } ?>
            <form action="admin_panel.php" method="post" style="padding: 40px">
                <label>Enter Password</label>
                <input type="password" name="password" />
                <input type="submit" name="submit" value="Log In" />
            </form>
            <?php
        }
        ?>
    </main>
    <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
</body>
</html>
