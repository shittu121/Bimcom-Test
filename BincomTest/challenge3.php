<?php
session_start(); // Start session

include('dbcon.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $polling_unit_id = $_POST['polling_unit_id'];
    $party_scores = $_POST['party_scores']; // Assuming party_scores is an array

    // Insert the new results into the database
    $date_entered = date('Y-m-d'); // Current date
    foreach ($party_scores as $party => $score) {
        $party = strtoupper($party); // Convert party name to uppercase
        $sql = "INSERT INTO announced_pu_results (polling_unit_uniqueid, party_abbreviation, party_score, date_entered, entered_by_user, user_ip_address)
                VALUES ($polling_unit_id, '$party', $score, '$date_entered', 'admin', 'null')";
        $conn->query($sql);
    }

    $_SESSION['message'] = "Results stored successfully.";
    header("Location: challenge3.php");
    exit; // Prevent further execution
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Question 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
<div class="container">
    <?php
    // Display the success message if set
    if (isset($_SESSION['message'])) {
        echo "<div class='alert alert-success' role='alert'>" . $_SESSION['message'] . "</div>";
        unset($_SESSION['message']); // Remove the message after displaying
    }

    $conn->close();
    ?>
    <div class="text text-center"><h1>Store Results</h1></div>
    <form class="form my-3" method="post" action="">
        <div class="form-group">
            <label for="polling_unit_id">Polling Unit ID:</label>
            <input type="text" class="form-control" name="polling_unit_id" id="polling_unit_id" required>
        </div>
        <div class="form-group my-3">
            <label for="party_pdp">PDP Score:</label>
            <input type="text" class="form-control" name="party_scores[PDP]" id="party_pdp" required>
        </div>
        <div class="form-group">
            <label for="party_dpp">DPP Score:</label>
            <input type="text" class="form-control" name="party_scores[DPP]" id="party_dpp" required>
        </div>
        <div class="form-group my-3">
            <label for="party_acn">ACN Score:</label>
            <input type="text" class="form-control" name="party_scores[ACN]" id="party_acn" required>
        </div>
        <div class="form-group my-3">
            <label for="party_ppa">PPA Score:</label>
            <input type="text" class="form-control" name="party_scores[PPA]" id="party_ppa" required>
        </div>
        <!-- Add other parties as needed -->
        <input type="submit" class="btn btn-primary" value="Submit Results"
               onclick="this.value='Submitting...'; setTimeout(function(){this.value='Submitted';}, 1000);">
    </form>
    <h6 class='text-center'><a href='index.php'>Click Here to Go Back To Home Page.</a></h6>
    
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
