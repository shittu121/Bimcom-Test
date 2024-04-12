<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Question 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class="bg-light">

  <div class="container">
  <?php

include('dbcon.php');


// Create a form or dropdown menu to select the local government
echo "<form method='get' action='' class='text-center mt-3'>
        <label for='lga_id'>Select Local Government:</label>
        <select name='lga_id' id='lga_id'>";
$sql = "SELECT * FROM lga";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    echo "<option value='{$row['uniqueid']}'>{$row['lga_name']}</option>";
}
echo "</select>
        <input type='submit' value='Show Summed Total'>
      </form>";
echo "<h6 class='text-center'><a href='index.php'>Click Here to Go Back To Home Page.</a></h6>";

// Check if lga_id is set in the URL
if (isset($_GET['lga_id'])) {
    $lga_id = $_GET['lga_id'];

    // Fetch the results for all polling units under the selected local government
    $sql = "SELECT party_abbreviation, SUM(party_score) AS total_score
            FROM announced_pu_results
            WHERE polling_unit_uniqueid IN (
                SELECT uniqueid FROM polling_unit WHERE lga_id = $lga_id
            )
            GROUP BY party_abbreviation";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display the results in a table
        ?>
        <table class="table table-bordered my-4">
            <thead>
                <tr>
                    <th>Party</th>
                    <th>Total Score</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grand_total = 0; // Initialize grand total
                while ($row = $result->fetch_assoc()) {
                    $grand_total += $row['total_score']; // Calculate grand total
                    ?>
                    <tr>
                        <td><?php echo $row['party_abbreviation']; ?></td>
                        <td><?php echo $row['total_score']; ?></td>
                    </tr>
                    <?php
                }
                // Display grand total row
                ?>
                <tr>
                    <td><strong>Grand Total</strong></td>
                    <td><?php echo $grand_total; ?></td>
                </tr>
            </tbody>
        </table>
        <?php
    } else {
        echo "No results found for the selected local government.";
    }
    
}



$conn->close();
?>
  </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>

