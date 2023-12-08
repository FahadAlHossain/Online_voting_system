<?php
// edit_candidate.php

require_once("config.php");

if(isset($_GET['candidate_id'])) {
    $candidate_id = mysqli_real_escape_string($db, $_GET['candidate_id']);

    // Fetch candidate data from the database based on $candidate_id
    $fetchingCandidateData = mysqli_query($db, "SELECT * FROM candidate_details WHERE id = '$candidate_id'");
    $candidateData = mysqli_fetch_assoc($fetchingCandidateData);

    if ($candidateData) {
        // Display a form for editing candidate data
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Candidate</title>
            <!-- Add your CSS and other head elements here -->
        </head>
        <body>
            <h3>Edit Candidate</h3>
            <form method="POST" action="update_candidate.php">
                <input type="hidden" name="candidate_id" value="<?php echo $candidate_id; ?>">
                <!-- Add input fields for editing candidate data -->
                <div class="form-group">
                    <label for="edit_candidate_name">Candidate Name:</label>
                    <input type="text" name="edit_candidate_name" value="<?php echo $candidateData['candidate_name']; ?>" class="form-control" required />
                </div>
                <!-- Add other input fields as needed -->

                <input type="submit" value="Update Candidate" name="updateCandidateBtn" class="btn btn-success" />
            </form>
        </body>
        </html>
        <?php
    } else {
        // Candidate not found, handle accordingly
        echo "Candidate not found.";
    }

} else {
    // Candidate ID not provided, handle accordingly
    echo "Candidate ID not provided.";
}
?>
