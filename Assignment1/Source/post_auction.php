<?php
require('dataconnection/configuration.php'); // Connecting to the database
?>
<!-- post_auction.php -->
<!DOCTYPE html>
<html>
	<head>
		<title>ibuy Auctions</title>
		<link rel="stylesheet" href="ibuy.css" />
	</head>
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
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

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
/* ... (your existing CSS rules) ... */

.auction-form {
    width: 60%;
    margin: auto;
    padding: 20px;
    background-color: #f5f5f5;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.auction-form label {
    display: block;
    font-size: 1.2em;
    margin-top: 10px;
}

.auction-form input[type="text"],
.auction-form input[type="date"],
.auction-form select,
.auction-form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.auction-form button[type="submit"] {
    background-color: #3665f3;
    color: white;
    font-size: 1.2em;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    float: right;
}

/* ... (your existing CSS rules) ... */

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
            <li class="dropdown">
                <a href="#" class="categoryLink">Categories</a>
                <ul class="dropdown-content">
                    <?php
                    // Fetch categories from the database
                    $categoriesQuery = "SELECT categoryName FROM categories";
                    $categoriesResult = $pdo->query($categoriesQuery);

                    // Loop through the categories and generate dropdown items
                    while ($category = $categoriesResult->fetch(PDO::FETCH_ASSOC)) {
                        echo '<li><a href="#">' . $category['categoryName'] . '</a></li>';
                    }
                    ?>
                </ul>
            </li>
            <!-- Other navigation links -->
            <li><a class="categoryLink" href="user_dashboard.php">Home</a></li>
            <li><a class="categoryLink" href="#">Latest listings</a></li>
            <li><a class="categoryLink" href="#">Search Results</a></li>
            <li><a class="categoryLink" href="\Admin\adminlogin.php">Admin</a></li>
            <li><a class="categoryLink" href="category.php">Category listings</a></li>
            <li><a class="categoryLink" href="post_auction.php">Post Auction</a></li>
            <li><a class="categoryLink" href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <img src="banners/1.jpg" alt="Banner" />
    <main>
        <h2>Post Auction</h2>
        <form method="POST" action="process_post_auction.php" class="auction-form">
            <label for="auction_name">Auction Name:</label>
            <input type="text" name="auction_name" required>

            <label for="auctioneer">Auctioneer:</label>
            <input type="text" name="auctioneer" required>

            <label for="auctionDate">Auction Date:</label>
            <input type="date" name="auctionDate" required>

            <label for="categoryID">Category:</label>
<select name="categoryID" required>
    <?php
    // Fetch categories from the database and populate the dropdown
    $sql = "SELECT * FROM categories";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();

    foreach ($categories as $category) {
        echo "<option value='{$category['categoryName']}'>{$category['categoryName']}</option>";
    }
    ?>
</select>

            <label for="Description">Description:</label>
            <textarea name="Description" rows="4" cols="50" required></textarea>

            <button type="submit">Post Auction</button>
        </form>
    </main>

    <footer>
        &copy; ibuy <?php echo date("Y"); ?> <!-- Display the current year dynamically -->
    </footer>
</body>
</html>