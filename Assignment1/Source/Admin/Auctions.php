<?php
// Include the database configuration file to establish a connection
require('../dataconnection/configuration.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the 'id' field is set in the submitted form
    if (isset($_POST['id'])) {
        // Retrieve the auction name from the submitted form data
        $auctionName = $_POST['id'];

        // Archive the auction by updating its status to "archived" in the database
        $archiveStmt = $pdo->prepare('UPDATE auctions SET status = "archived" WHERE auction_name = :auctionName');
        $archiveStmt->execute(['auctionName' => $auctionName]);

        // Display a success message
        echo '<div class="message">Auction archived successfully</div>';
    }
}
?>
<!-- The body content goes here -->
<!DOCTYPE html>
<html>
<!-- Head section containing metadata and external resources -->
<head>
        <!-- The title of the page -->
    <title>Auctions</title>
      <!-- Link to external stylesheets -->
    <link rel="stylesheet" href="/ibuy.css" />
    <link rel="stylesheet" href="/styles.css" />
    <!-- Add your additional CSS styles here if needed -->
    <style>
    /* Add your additional CSS styles here if needed */
    
    /* Styling for the search button in the header */
    header form input[type=submit] {
        background-color: #005d96;
        color: white;
        width: 20%;
        font-size: 2em;
        padding: 0.5em;
        cursor: pointer;
        border: 0;
    }
    
    /* Styling for the search input field in the header */
    header form input[type="text"] {
        border: 2px solid black;
        font-size: 2em;
        padding: 0.45em;
        width: 70%;
    }
    
    /* Style for the sidebar container */
    .sidebar {
        align-items: center;
        padding: 0;
        margin-top: 2vw;
    }
    
    /* Styling for the left section of the sidebar */
    .sidebar .left {
        width: 20%;
        background-color: #555;
        padding: 10px;
        list-style-type: none;
    }
    
    /* Styling for the right section of the sidebar */
    .sidebar .right {
        flex: 1;
        padding: 20px;
    }
    
    /* Styling for the footer */
    footer {
        margin-top: 2vw;
    }
    
    /* Styling for the table */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    
    /* Styling for table headers and cells */
    table th,
    table td {
        padding: 8px;
        border: 1px solid #ccc;
    }
    
    /* Styling for description cells with ellipsis for overflow */
    .description-cell {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    /* Styling for cells in the actions column */
    .actions-cell {
        white-space: nowrap;
    }
    
    /* Styling for buttons within the actions column */
    .actions-cell .button {
        width: auto;
        padding: 0.5em 1em;
        margin-bottom: 10px; /* Add margin between buttons */
    }
    
    /* Base styling for buttons */
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
    
    /* Styling for links and visited links */
    a, a:visited {
        color: white;
    }
</style>

</head>
<body>
    <!-- Header section with logo and search form -->
    <header>
        <h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>
        <form action="#">
            <input type="text" name="search" placeholder="Search for anything" />
            <input type="submit" name="submit" value="Search" />
        </form>
    </header>
    
    <!-- Navigation menu -->
    <nav>
        <ul>
            <li><a href="admin_panel.php">Home</a></li>
            <li><a href="Auctions.php">Auctions</a></li>
            <li><a href="categories.php">Categories</a></li>
        </ul>
    </nav>
    
    <!-- Banner image -->
    <img src="/banners/1.jpg" alt="Banner" />
    
    <!-- Main content area with sidebar -->
    <main class="sidebar">
        <!-- Left section of the sidebar -->
        <section class="left">
            <ul>
                <li><a href="Auctions.php">Auctions</a></li>
                <li><a href="categories.php">Categories</a></li>
            </ul>
        </section>
        
        <!-- Right section of the sidebar -->
        <section class="right">
            <!-- Heading for the auctions section -->
            <h2>Auctions</h2>
            
            <!-- Button to add a new auction -->
            <a class="button new" href="addauction.php">Add new auction</a>
            
            <!-- PHP code to display auctions in a table -->
            <?php
            // Display a table to show auction details
            echo '<table class="auctions">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Name</th>';
            echo '<th>Category</th>';
            echo '<th>Description</th>';
            echo '<th>Auction Date</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            echo '</thead>';
            
            // Fetch and display auction data from the database
            $stmt = $pdo->query('SELECT * FROM auctions');
            foreach ($stmt as $auction) {
                echo '<tr>';
                echo '<td>' . $auction['auction_name'] . '</td>';
                echo '<td>' . $auction['categoryID'] . '</td>'; // Display category
                echo '<td class="description-cell">' . $auction['Description'] . '</td>';
                echo '<td>' . $auction['auctionDate'] . '</td>'; // Display auction date
                
                // Actions column with buttons
                echo '<td class="actions-cell">';
                echo '<a class="button" href="viewbidders.php?name=' . urlencode($auction['auction_name']) . '">View Bidders</a>';
                echo '<a class="button" href="editauction.php?name=' . urlencode($auction['auction_name']) . '">Edit Auction</a>';
                echo '<a class="button" href="viewauction.php?name=' . urlencode($auction['auction_name']) . '">View Full Details</a>';
                echo '</td>';
                echo '</tr>';
            }
            
            echo '</table>';
            ?>
        </section>
    </main>
    
    <!-- Footer section with copyright information -->
    <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
</body>
</html>