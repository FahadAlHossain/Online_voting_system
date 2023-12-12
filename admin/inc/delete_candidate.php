<?php
require_once("config.php");

if (isset($_POST['candidate_id'])) {
    $candidateId = $_POST['candidate_id'];

    // Perform deletion query
    $result = mysqli_query($db, "DELETE FROM candidate_details WHERE id = '".$candidateId."'") or die(mysqli_error($db));

    if ($result) {
        echo 'Success';
    } else {
        echo 'error';
    }
} else {
    echo 'invalid parameters';
}
?>
