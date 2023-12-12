<?php
// delete_candidate.php

require_once("config.php");

if(isset($_POST['candidate_id'])) {
    $candidate_id = mysqli_real_escape_string($db, $_POST['candidate_id']);

    // Perform the deletion in the database based on $candidate_id
    mysqli_query($db, "DELETE FROM candidate_details WHERE id = '$candidate_id'");

    // Redirect back to the page where the user came from
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();

} else {
    // Candidate ID not provided, handle accordingly
    echo "Candidate ID not provided.";
}
?>
