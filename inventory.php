<?php
// Database connection
$conn = mysqli_connect("192.168.88.194", "jda", "", "deped_ams");

// Query to select data from the database
$sql = "SELECT * FROM asset";

// Check if search term is provided in the GET request
if (isset($_GET['search'])) {
    // Add search condition to the query
    $search_term = mysqli_real_escape_string($conn, $_GET['search']);
    $sql = " WHERE asset.description LIKE '%$search_term%'";
}

$result = mysqli_query($conn, $sql);

// Check if any data is returned by the query
if (mysqli_num_rows($result) > 0) {
    // Start table markup
    echo "<form method='get' action=''>";
    echo "<div class='form-group'>";
    echo "<label for='search'>Search:</label>";
    echo "<input type='text' class='form-control' name='search' id='search' placeholder='Enter description'>";
    echo "</div>";
    echo "<button type='submit' class='btn btn-primary'>Submit</button>";
    echo "</form>";
    echo "<br>";
    echo "<table class='table table-striped'>";
    echo "<thead><tr><th>ID</th><th>Description</th><th>Property No</th><th>Stock No</th><th>Unit Measure</th><th>Unit Value</th><th>Quantity on Property Card</th><th>Quantity on Physical Count</th><th>Shortage Quantity</th><th>Shortage Value</th><th>Remarks</th><th>Date</th><th>User</th><th>Sub Category</th></tr></thead>";
    echo "<tbody>";
    // Loop through each row in the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Output table row
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td>" . $row['property_no'] . "</td>";
        echo "<td>" . $row['stock_no'] . "</td>";
        echo "<td>" . $row['stock_no'] . "</td>";
        echo "<td>" . $row['unit_val'] . "</td>";
        echo "<td>" . $row['qty_property_card'] . "</td>";
        echo "<td>" . $row['qty_physical_count'] . "</td>";
        echo "<td>" . $row['shortage_qty'] . "</td>";
        echo "<td>" . $row['shortage_value'] . "</td>";
        echo "<td>" . $row['stock_no'] . "</td>";
        echo "<td>" . $row['date'] . "</td>";
        echo "<td>" . $row['stock_no'] . "</td>";
        echo "<td>" . $row['stock_no'] . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
} else {
    echo "No data found.";
}

// Close database connection
mysqli_close($conn);
?>