<?php
// Start the session
session_start();

// Include the database connection code from configuration.php
require('dataconnection/configuration.php');

// Function to get category name
function getCategoryName($categoryID, $pdo) {
    $query = "SELECT categoryName FROM categories WHERE categoryName = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$categoryID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        return $result['categoryName'];
    } else {
        return 'Unknown Category'; // Return a default value if category is not found
    }
}

// Function to get current bid amount
function getCurrentBidAmount($auctionName, $pdo) {
    $query = "SELECT MAX(bidAmount) AS currentBid FROM bids WHERE auction_name = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$auctionName]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['currentBid'] !== null) {
        return number_format($result['currentBid'], 2);
    } else {
        return 'No bids yet';
    }
}

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: login.php'); // Change this to your login page
    exit();
}

// Use the logged-in user's email to fetch their auctions
$user_email = $_SESSION['user']['Email'];

$user_auctions_sql = "SELECT * FROM auctions WHERE auctioneer = ?";
$user_auctions_stmt = $pdo->prepare($user_auctions_sql);
$user_auctions_stmt->execute([$user_email]);

$user_auctions = $user_auctions_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>ibuy Auctions</title>
    <link rel="stylesheet" href="ibuy.css" />
    <style>
        /* Basic styles for dropdown menu */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            max-width: 250px; /* Adjust the width as needed */
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        /* Rest of your existing CSS styles */
        .dropdown:hover .dropdown-content {
            display: block;
        }
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
        /* Additional styling for dropdown menu */
        .dropdown-content li {
            padding: 8px;
        }
        /* Add this style definition to your existing CSS */
        .action-button {
            background-color: #e43137;
            color: white;
            font-size: 1em;
            padding: 0.5em 1em;
            border: none;
            cursor: pointer;
            margin-top: 5px;
        }

        .action-button:hover {
            background-color: #c1242b;
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
        <!-- Dropdown for categories -->
        <li><a class="categoryLink" href="user_dashboard.php">Home</a></li>
        <li class="dropdown">
            <a href="#" class="categoryLink">Categories</a>
            <ul class="dropdown-content">
                <?php
                // Fetch categories from the database
                $categoriesQuery = "SELECT categoryName FROM categories";
                $categoriesResult = $pdo->query($categoriesQuery);
                $categoriesCount = 0; // Initialize a counter

                // Loop through the categories and generate dropdown items
                while ($category = $categoriesResult->fetch(PDO::FETCH_ASSOC)) {
                    // Show only a certain number of categories
                    if ($categoriesCount < 5) {
                        echo '<li><a href="category_auctions.php?category=' . $category['categoryName'] . '">' . $category['categoryName'] . '</a></li>';
                        $categoriesCount++;
                    } else {
                        break; // Stop looping after a certain number of categories
                    }
                }

                // Add a "More" option that redirects to a separate page with all categories
                echo '<li><a href="all_categories.php">More</a></li>';
                ?>
            </ul>
        </li>

            <!-- Other navigation links -->
            <li><a class="categoryLink" href="user_auctions.php">Your Auctions</a></li>
            <li><a class="categoryLink" href="post_auction.php">Post Auction</a></li>
            <li><a class="categoryLink" href="\Admin\adminlogin.php">Admin</a></li>
            <li><a class="categoryLink" href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <img src="banners/1.jpg" alt="Banner" />

    <main>
        <h1>Your Auctions</h1>
        <?php if (empty($user_auctions)) { ?>
            <p>No auctions found for this user.</p>
        <?php } else { ?>
            <ul>
                <?php foreach ($user_auctions as $auction) { ?>
                    <li>
                        <article class="product">
                            <img src="product.png" alt="<?php echo $auction['auction_name']; ?>">
                            <section class="details">
                                <h2><?php echo htmlspecialchars($auction['auction_name']); ?></h2>
                                <h3><?php echo getCategoryName($auction['categoryName'], $pdo); ?></h3>
                                <p class="price">Current bid: £<?php echo htmlspecialchars(getCurrentBidAmount($auction['auction_name'], $pdo)); ?></p>
                                <p class="remaining-time">Auction on: <?php echo date($auction['auctionDate']); ?></p>
                                <p class="remaining-time">Ends on: <?php echo date('Y-m-d H:i:s', strtotime($auction['auction_end_time'])); ?></p>
                            </section>
                            <section class="description">
                                <p><?php echo htmlspecialchars($auction['Description']); ?></p>
                            </section>
                        </article>
                       
                        <button class="action-button" onclick="location.href='edit_auction.php?auction_name=<?php echo $auction['auction_name']; ?>'">Edit</button>


                        <button class="action-button" onclick="location.href='delete_auction.php?id=<?php echo $auction['auction_name']; ?>'">Delete</button>
                        <!-- Display bid form -->
                        
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
        <!-- Add more content as needed -->
        <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
    </main>

</body>
</html>
