<?php
// Start a new session or resume the existing session
session_start();

// Check if the login form was submitted
if (isset($_POST['submit'])) {
    // Check if the provided password matches the expected value
    if ($_POST['password'] == 'letmein') {
        // Set the 'loggedin' session variable to true
        $_SESSION['loggedin'] = true;
        // Redirect the user to the admin panel page
        header('Location: /Admin/admin_panel.php'); // Adjust the path to match the correct location
        exit(); // Terminate further script execution
    } else {
        // If the password is incorrect, set an error message
        $loginError = "Invalid password.";
    }
}
?>
<!-- The body content goes here -->
<!DOCTYPE html>
<html>
<!-- Head section containing metadata and external resources -->
<head>
        <!-- The title of the page -->
    <title>Admin login</title>
      <!-- Link to external stylesheets -->
    <link rel="stylesheet" href="/ibuy.css" />
    <link rel="stylesheet" href="/styles.css" />
    <!-- Add your additional CSS styles here if needed -->
    <style>
    /* Additional CSS styles for the header form submit button */
    header form input[type=submit] {
        background-color: #005d96;
        color: white;
        width: 20%;
        font-size: 2em;
        padding: 0.5em;
        cursor: pointer;
        border: 0;
    }

    /* Additional CSS styles for the header form text input */
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

    /* Styles for table header cells and table data cells */
    table th,
    table td {
        padding: 8px;
        border: 1px solid #ccc;
    }

    /* Styles for truncating long text in a table cell */
    .description-cell {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Styles for actions cell in a table */
    .actions-cell {
        width: 150px; /* Decrease the width of the actions column */
        white-space: nowrap;
    }

    /* Button style for buttons in this section */
    .button {
        display: inline-block;
        padding: 8px 15px; /* Adjust padding for the buttons */
        background-color: #4CAF50;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        border: none;
    }

    /* Hover effect for buttons in this section */
    .button:hover {
        background-color: #45a049;
    }

    /* Styles for links and visited links */
    a, a:visited {
        color: white;
    }
</style>
</head>
<body>
    <!-- Header section with website logo and search form -->
    <header>
        <h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>
        <!-- Search form -->
        <form action="#">
            <input type="text" name="search" placeholder="Search for anything" />
            <input type="submit" name="submit" value="Search" />
        </form>
    </header>
    <!-- Navigation menu -->
    <nav>
        <ul>
            <!-- List of navigation links -->
            <li><a href="adminlogin.php">Admin Dashboard</a></li>
            <li><a href="adminlogin.php">Categories</a></li>
            <li><a href="adminlogin.php">Auctions</a></li>
            <li><a href="/Logout.php">Logout</a></li>
        </ul>
    </nav>
    <!-- Banner image -->
    <img src="/banners/1.jpg" alt="Banner" />
    <!-- Main content section with sidebar -->
    <main class="sidebar">
        <?php
        // Check if the user is logged in
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            // ... Your logged-in content ...
        } else {
            ?>
            <!-- Display login form if not logged in -->
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
    <!-- Footer section with copyright information -->
    <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
</body>
</html>
