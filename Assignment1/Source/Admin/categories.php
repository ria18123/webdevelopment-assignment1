<?php
// Include the database configuration file to establish a connection
require('../dataconnection/configuration.php');

// Retrieve all categories from the categories table
$sql = "SELECT * FROM categories";
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll();
?>
<!-- The body content goes here -->
<!DOCTYPE html>
<html>
<!-- Head section containing metadata and external resources -->
<head>
        <!-- The title of the page -->
    <title>Admin category panel</title>
      <!-- Link to external stylesheets -->
    <link rel="stylesheet" href="/ibuy.css" />
    <link rel="stylesheet" href="/styles.css" />
    <!-- Add your additional CSS styles here if needed -->
    <style>
    /* Additional CSS styles can be added here if needed */
    
    /* Styles for the search submit button in the header */
    header form input[type=submit] {
        background-color: #005d96;
        color: white;
        width: 20%;
        font-size: 2em;
        padding: 0.5em;
        cursor: pointer;
        border: 0;
    }
    
    /* Styles for the search input in the header */
    header form input[type="text"] {
        border: 2px solid black;
        font-size: 2em;
        padding: 0.45em;
        width: 70%;
    }
    
    /* Style for the sidebar */
    .sidebar {
        align-items: center;
        padding: 0;
        margin-top: 2vw;
    }
    
    /* Styles for the left section of the sidebar */
    .sidebar .left {
        width: 20%;
        background-color: #555;
        padding: 10px;
        list-style-type: none;
    }
    
    /* Styles for the right section of the sidebar */
    .sidebar .right {
        flex: 1;
        padding: 20px;
    }
    
    /* Styles for the footer section */
    footer {
        margin-top: 2vw;
    }
    
    /* Table styles */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    
    /* Styles for table header cells and data cells */
    table th,
    table td {
        padding: 8px;
        border: 1px solid #ccc;
    }
    
    /* Styles for cells with descriptions */
    .description-cell {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    /* Styles for cells in the actions column */
    .actions-cell {
        white-space: nowrap;
    }
    
    /* Styles for buttons within the actions column */
    .actions-cell .button {
        width: auto;
        padding: 0.5em 1em;
        margin-bottom: 10px; /* Add margin between buttons */
    }
    
    /* Button styles */
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
    
    /* Styles for visited links */
    a, a:visited {
        color: white;
    }
</style>

</head>
<body>
    <!-- Header section -->
    <header>
        <!-- Logo with decorative letters -->
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
            <!-- Links to various sections -->
            <li><a href="admin_panel.php">Home</a></li>
            <li><a href="Auctions.php">Auctions</a></li>
            <li><a href="categories.php">Categories</a></li>
        </ul>
    </nav>
    
    <!-- Banner image -->
    <img src="/banners/1.jpg" alt="Banner" />
    
    <!-- Main content with sidebar layout -->
    <main class="sidebar">
        <!-- Left section of the sidebar -->
        <section class="left">
            <ul>
                <!-- Links to Auctions and Categories sections -->
                <li><a href="Auctions.php">Auctions</a></li>
                <li><a href="categories.php">Categories</a></li>
            </ul>
        </section>
        
        <!-- Right section of the sidebar -->
        <section class="right">
            <!-- Heading for Categories section -->
            <h2>Categories</h2>
            
            <!-- Button to add a new category -->
            <a class="button new" href="add_category.php">Add new category</a>
            
            <!-- Table displaying categories -->
            <table class="auctions">
                <thead>
                    <!-- Table header row -->
                    <tr>
                        <th>Category Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through categories array using PHP -->
                    <?php foreach ($categories as $category) : ?>
                        <tr>
                            <!-- Display category name -->
                            <td><?php echo $category['categoryName']; ?></td>
                            <td class="actions-cell">
                                <!-- Edit Category button with link to edit_category_form.php -->
                                <a class="button" href="edit_category_form.php?name=<?php echo urlencode($category['categoryName']); ?>">Edit Category</a>
                                <!-- Delete Category button with link to delete_category.php -->
                                <a class="button" href="delete_category.php?name=<?php echo urlencode($category['categoryName']); ?>">Delete Category</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
    
    <!-- Footer section -->
    <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
</body>
</html>