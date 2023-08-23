<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user'])) {
    // Redirect users to the login page
    header('Location: login.php');
    exit();
}

require('dataconnection/configuration.php'); // Connecting to the database

$searchTerm = $_GET['search'] ?? ''; // Get the search term from the query string
$categoryName = $_GET['category'] ?? ''; // Get the category name from the query string

// Fetch products based on the search term and category
$sql = "
    SELECT a.*
    FROM auctions AS a
    INNER JOIN categories AS c ON a.categoryName = c.categoryName
    WHERE (a.auction_name LIKE :searchTerm OR a.Description LIKE :searchTerm)
        AND (BINARY c.categoryName = :categoryName OR :categoryName = '')
";


$stmt = $pdo->prepare($sql);
$stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
$stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Browse Products</title>
    <link rel="stylesheet" href="ibuy.css" />
    <style>
        /* Additional styles here */
    </style>
</head>
<body>
    <header>
        <h1><span class="i">i</span><span class="b">b</span><span class="u">u</span><span class="y">y</span></h1>

        <form action="#" method="get">
            <input type="text" name="search" placeholder="Search for anything" value="<?php echo htmlspecialchars($searchTerm); ?>" />
            <input type="submit" name="submit" value="Search" />
        </form>
    </header>

    <nav>
        <!-- Dropdown menu and other navigation links here -->
    </nav>

    <img src="banners/1.jpg" alt="Banner" />

    <main>
        <h1>Search Results</h1>

        <ul class="productList">
            <?php foreach ($products as $product) { ?>
                <li>
                    <!-- Display product details here -->
                    <img src="product.png" alt="<?php echo htmlspecialchars($product['auction_name']); ?>" />
                    <article>
                        <h2><?php echo htmlspecialchars($product['auction_name']); ?></h2>
                        <h3><?php echo getCategoryName($product['categoryName'], $pdo); ?></h3>
                        
                        <?php
                        $description = $product['Description'];
                        $maxDescriptionLength = 60;
                        if (strlen($description) > $maxDescriptionLength) {
                            $shortenedDescription = substr($description, 0, $maxDescriptionLength) . '...';
                            echo '<p>' . htmlspecialchars($shortenedDescription) . '</p>';
                        } else {
                            echo '<p>' . htmlspecialchars($description) . '</p>';
                        }
                        
                        $currentBid = getCurrentBidAmount($product['auction_name'], $pdo);
                        echo '<p class="price">Current bid: £' . htmlspecialchars($currentBid) . '</p>';
                        ?>
                        
                        <a href="auction_details.php?auction_name=<?php echo urlencode($product['auction_name']); ?>" class="more auctionLink">More &gt;&gt;</a>
                    </article>
                </li>
            <?php } ?>
        </ul>

<?php
// Function to fetch category name based on categoryName
function getCategoryName($categoryName, $pdo) {
    $query = "SELECT categoryName FROM categories WHERE categoryName = :categoryName";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);
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
