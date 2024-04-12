<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Question 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class='bg-light'>

  <div class="container my-3 g-4">
  <?php

include('dbcon.php');

// Create a form or dropdown menu to select the polling unit
echo "<form method='get' action='' class='text-center'>
        <label for='polling_unit_uniqueid'>Select Polling Unit:</label>
        <select name='polling_unit_uniqueid' id='polling_unit_uniqueid'>";
$sql = "SELECT * FROM polling_unit";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    echo "<option value='{$row['uniqueid']}' class='text-center'>{$row['polling_unit_name']}</option>";
}
echo "</select>
        <input type='submit' value='Show Results'>
      </form>";
echo "<h6 class='text-center'><a href='index.php'>Click Here to Go Back To Home Page.</a></h6>";   


// Check if polling_unit_uniqueid is set in the URL
if (isset($_GET['polling_unit_uniqueid'])) {
    $polling_unit_uniqueid = $_GET['polling_unit_uniqueid'];

    // Fetch the results for the selected polling unit
    $sql = "SELECT * FROM announced_pu_results WHERE polling_unit_uniqueid = $polling_unit_uniqueid";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display the results in a table
        ?>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Party</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['party_abbreviation']; ?></td>
                        <td><?php echo $row['party_score']; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
    } else {
        echo "No results found for the selected polling unit.";
    }
    
}



$conn->close();
?>
  </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
