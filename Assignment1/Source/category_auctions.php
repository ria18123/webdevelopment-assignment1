<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user'])) {
    // Redirect users to the login page
    header('Location: login.php');
    exit();
}

require('dataconnection/configuration.php'); // Connecting to the database

// Retrieve the category name from the URL parameter
$categoryName = $_GET['category'];

// Fetch auctions of the selected category
$sql = "SELECT * FROM auctions WHERE categoryName = :categoryName ORDER BY auctionDate DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);
$stmt->execute();
$auctions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>ibuy Auctions</title>
		<link rel="stylesheet" href="ibuy.css" />
	</head>
    <style>
        /* Basic styles for dropdown menu */
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
    </style>
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
        <h1><?php echo $categoryName; ?> Auctions</h1>

        <ul class="productList">
            <?php
            foreach ($auctions as $auction) {
                echo '<li>';
                echo '<img src="product.png" alt="' . $auction['auction_name'] . '">';
                echo '<article>';
                echo '<h2>' . $auction['auction_name'] . '</h2>';
                echo '<h3>' . getCategoryName($auction['categoryName'], $pdo) . '</h3>';
                
                // Shorten the description if it's too long
                $description = $auction['Description'];
                $maxDescriptionLength = 60; // Set your desired maximum description length
                if (strlen($description) > $maxDescriptionLength) {
                    $shortenedDescription = substr($description, 0, $maxDescriptionLength) . '...';
                    echo '<p>' . $shortenedDescription . '</p>';
                } else {
                    echo '<p>' . $description . '</p>';
                }
            
                // Use the getCurrentBidAmount function to display the current bid
                $currentBid = getCurrentBidAmount($auction['auction_name'], $pdo);
                echo '<p class="price">Current bid: £' . $currentBid . '</p>';
            
                echo '<a href="auction_details.php?auction_name=' . $auction['auction_name'] . '" class="more auctionLink">More &gt;&gt;</a>';
                echo '</article>';
                echo '</li>';
            }
            
            // Function to fetch category name based on categoryID
            function getCategoryName($categoryID, $pdo) {
                $query = "SELECT categoryName FROM categories WHERE categoryName = :categoryID";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':categoryID', $categoryID, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result['categoryName'];
            }
            
            // Function to fetch the current bid amount for an auction
            function getCurrentBidAmount($auctionName, $pdo) {
                $query = "SELECT MAX(bidAmount) AS currentBid FROM bids WHERE auction_name = :auctionName";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':auctionName', $auctionName, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result['currentBid']) {
                    return $result['currentBid'];
                } else {
                    return 'No bids yet';
                }
            }
            ?>
        </ul>

        <footer>
            &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
        </footer>
		</main>
</body>
</html>
