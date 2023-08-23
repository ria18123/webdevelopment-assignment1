<?php
require('../dataconnection/configuration.php'); // Including the database configuration file to establish a connection.

$message = ''; // Initialize a variable to store status messages.

// Check if the request method is POST (form submission).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = $_POST['categoryName']; // Get the submitted category name from the form.

    // SQL query to check if the category name already exists in the database.
    $sqlCheck = "SELECT COUNT(*) FROM categories WHERE categoryName = ?";
    $stmtCheck = $pdo->prepare($sqlCheck); // Prepare the query.
    $stmtCheck->execute([$categoryName]); // Execute the query with the category name as parameter.
    $categoryCount = $stmtCheck->fetchColumn(); // Fetch the count result.

    // Check if the category name already exists.
    if ($categoryCount > 0) {
        $message = 'Category already exists'; // Set a message indicating that the category already exists.
    } else {
        // SQL query to insert the new category name into the database.
        $sqlInsert = "INSERT INTO categories (categoryName) VALUES (?)";
        $stmtInsert = $pdo->prepare($sqlInsert); // Prepare the query.
        $stmtInsert->execute([$categoryName]); // Execute the query with the category name as parameter.

        $message = 'Category added successfully'; // Set a message indicating successful category addition.
    }
}
?>

<!-- The body content goes here -->
<!DOCTYPE html>
<html>
     <!-- Head section containing metadata and external resources -->
<head>
        <!-- The title of the page -->
    <title>Add Category</title>
      <!-- Link to external stylesheets -->
    <link rel="stylesheet" href="/ibuy.css" />
    <link rel="stylesheet" href="/styles.css" />
  <!-- Adding the additional CSS for this page only -->
    <style>
         /* CSS styles for the header form */       
        header form input[type=submit] {
             /* Button styling */
            background-color: #005d96;
            color: white;
            width: 20%;
            font-size: 2em;
            padding: 0.5em;
            cursor: pointer;
            border: 0;
        }
        header form input[type="text"] {
             /* Text input styling */
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
        footer {
            margin-top: 2vw;
        }
  
     /* Adjusted styles for buttons */
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

 /* Additional button style */
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
/* Additional styles for alignment  */
        .form-group {
            margin-bottom: 20px;
        }
        main form input[type="submit"] {
            /* Button styling within the main content */
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
        a, a:visited {
  color: white;
}


    
    </style>
</head>
<body>
    <!-- Header section with the website logo and search form -->
    <header>
        <h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>
        <form action="#">
            <input type="text" name="search" placeholder="Search for anything" />
            <input type="submit" name="submit" value="Search" />
        </form>
    </header>
    <!-- Navigation section with links to different pages -->
    <nav>
        <ul>
            <li><a href="admin_panel.php">Home</a></li>
            <li><a href="/">Auctions</a></li>
            <li><a href="categories.php">Categories</a></li>
        </ul>
    </nav>
    <!-- Banner image -->
    <img src="/banners/1.jpg" alt="Banner" />

    <!-- Main content section with sidebar -->
    <main class="sidebar">
        <!-- Left sidebar section with navigation links -->
        <section class="left">
            <!-- Sidebar navigation links -->
            <ul>
                <li><a href="addauction.php">Add Auction</a></li>
                <li><a href="editauction.php">Edit Auction</a></li>
                <li><a href="deleteauction.php">Delete Auction</a></li>
            </ul>
        </section>
        <!-- Right sidebar section for adding categories -->
        <section class="right">
            <h2>Add Category</h2>
            <?php if (!empty($message)) : ?>
                <div class="message"><?= $message ?></div>
            <?php endif; ?>
            <!-- Form for adding a new category -->
            <form action="add_category.php" method="POST">
                <div class="form-group">
                    <label for="categoryName">Category Name:</label>
                    <input type="text" name="categoryName" required><br>
                </div>
                <!-- Submit button for adding the category -->
                <input type="submit" value="Add Category" class="button" />
            </form>
        </section>
    </main>

    <!-- Footer section with copyright information -->
    <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
</body>
