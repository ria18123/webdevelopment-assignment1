<?php
require('../dataconnection/configuration.php'); // Include the database configuration file to establish a connection

// Get the category name from the URL query parameter, if present
$categoryName = isset($_GET['category']) ? $_GET['category'] : '';

// Check if the form is submitted using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newCategoryName = $_POST['newCategoryName']; // Get the new category name from the form

    // Update the category name in the categories table
    $sql = "UPDATE categories SET categoryName = ? WHERE categoryName = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$newCategoryName, $categoryName]);

    // Redirect back to the categories page after updating
    header('Location: categories.php');
    exit();
}
?>


<!-- The body content goes here -->
<!DOCTYPE html>
<html>
<!-- Head section containing metadata and external resources -->
<head>
        <!-- The title of the page -->
    <title>Edit Category</title>
      <!-- Link to external stylesheets -->
    <link rel="stylesheet" href="/ibuy.css" />
    <link rel="stylesheet" href="/styles.css" />
    <!-- Add your additional CSS styles here if needed -->
    <style>
    /* Additional CSS styles */
    
    /* Style for the submit button in the header form */
    header form input[type=submit] {
        background-color: #005d96;
        color: white;
        width: 20%;
        font-size: 2em;
        padding: 0.5em;
        cursor: pointer;
        border: 0;
    }

    /* Style for the text input in the header form */
    header form input[type="text"] {
        border: 2px solid black;
        font-size: 2em;
        padding: 0.45em;
        width: 70%;
    }

    /* Sidebar style */
    .sidebar {
        align-items: center;
        padding: 0;
        margin-top: 2vw;
    }
    .sidebar .left {
        width: 20%;
        background-color: #555;
        padding: 10px;
        list-style-type: none;
    }
    .sidebar .right {
        flex: 1;
        padding: 20px;
    }

    /* Footer style */
    footer {
        margin-top: 2vw;
    }

    /* Adjust button styles */
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
        background-color: #5aa0c2;
    }

    /* Additional styles for alignment */
    .form-group {
        margin-bottom: 20px;
    }
    main form input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        flex-grow: 0;
        margin-left: auto;
        font-size: 1.2em;
        padding: 0.2em;
        cursor: pointer;
        border: 0;
        height: 47px;
        margin-top: 23px;
        margin-right: 455px;
    }
    main form input {
        flex-grow: 1;
        width: 20vw;
        margin-bottom: 1em;
        margin-right: 2vw;
        margin-left: 2vw;
        height: 30px;
    }
    /* Visited link color */
    a, a:visited {
        color: white;
    }
</style>

</head>
<body>
    <!-- Header section -->
    <header>
        <h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>
        <!-- Search form -->
        <form action="#">
            <input type="text" name="search" placeholder="Search for anything" />
            <input type="submit" name="submit" value="Search" />
        </form>
    </header>

    <!-- Navigation section -->
    <nav>
        <ul>
            <li><a href="admin_panel.php">Home</a></li>
            <li><a href="/">Auctions</a></li>
            <li><a href="categories.php">Categories</a></li>
        </ul>
    </nav>

    <!-- Banner image -->
    <img src="/banners/1.jpg" alt="Banner" />

    <!-- Main content section with sidebar layout -->
    <main class="sidebar">
        <!-- Left sidebar section -->
        <section class="left">
            <ul>
                <li><a href="Auctions.php">Auctions</a></li>
                <li><a href="categories.php">Categories</a></li>
            </ul>
        </section>
        
        <!-- Right content section -->
        <section class="right">
            <!-- Edit Category heading -->
            <h2>Edit Category: <?php echo $categoryName; ?></h2>
            <!-- Edit Category form -->
            <form method="POST">
                <label for="newCategoryName">New Category Name:</label>
                <input type="text" name="newCategoryName" value="<?php echo $categoryName; ?>" required><br>
                <input type="submit" value="Update Category" class="button" />
            </form>
        </section>

        <!-- Footer section -->
        <footer>
            &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
        </footer>
    </main>
</body>
</html>
