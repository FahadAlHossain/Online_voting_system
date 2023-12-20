<?php
// Disable warnings
error_reporting(E_ERROR | E_PARSE);

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
?>
<?php

// $activeElectionsForClub = getActiveElectionsForClubsss($db, $club);


// Code to determine the active clubs
$activeClubsQuery = mysqli_query($db, "SELECT DISTINCT club_name FROM elections WHERE status = 'Active'") or die(mysqli_error($db));
$activeClubs = [];

while ($row = mysqli_fetch_assoc($activeClubsQuery)) {
    $activeClubs[] = $row['club_name'];
}


$activeElectionsQuery = mysqli_query($db, "SELECT * FROM elections WHERE status = 'Active'") or die(mysqli_error($db));
$activeElections = [];

while ($row = mysqli_fetch_assoc($activeElectionsQuery)) {
    $activeElections[] = $row['election_topic'];
    $e_id = $row['id']; // hhhhhh
}



?>



<?php
if (isset($_GET['added'])) {
    ?>
    <div class="alert alert-success my-3" role="alert">
        Candidate has been added successfully.
    </div>
    <?php
} else if (isset($_GET['largeFile'])) {
    ?>
        <div class="alert alert-danger my-3" role="alert">
            Candidate image is too large, please upload a smaller file (you can upload any image up to 2MB).
        </div>
    <?php
} else if (isset($_GET['invalidFile'])) {
    ?>
            <div class="alert alert-danger my-3" role="alert">
                Invalid image type (Only .jpg, .png files are allowed).
            </div>
    <?php
} else if (isset($_GET['failed'])) {
    ?>
                <div class="alert alert-danger my-3" role="alert">
                    Image uploading failed, please try again.
                </div>
    <?php
} else if (isset($_GET['delete-id'])) {
    $candidate_id = $_GET['delete-id'];
    mysqli_query($db, "DELETE FROM candidate_details WHERE id = '" . $candidate_id . "'") or die(mysqli_error($db));
    ?>
                    <div class="alert alert-danger my-3" role="alert">
                        Candidate has been deleted successfully!
                    </div>
    <?php

}
?>





<div class="row my-3">
    <div class="col-4">
        <h3>Add New Candidates</h3>
        <form method="POST" enctype="multipart/form-data">

            <div class="form-group">
            <label for="activeClub">Select Club:</label>
                <select class="form-control" name="club_name" id="club_name" required>
                    <option value="" disabled selected>Select Club</option>
                    <?php
                    foreach ($activeClubs as $club) {
                        echo "<option value=\"$club\">$club</option>";
                    }
                    ?>
                </select>
                <?php
        // if (isset($_POST['club_name'])) {
        //     $selectedClub = mysqli_real_escape_string($db, $_POST['club_name']);
        //     $activeElectionsForClub = getActiveElectionsForClub($db, $club);

        //     foreach ($activeElectionsForClub as $election) {
        //         echo "<option value=\"{$election['id']}\">{$election['election_topic']}</option>";
        //     }
        // }
        ?>
            </div>

            <div class="form-group">
            <label for="activeClub">Select Election TOPIC:</label>
                <select class="form-control" name="election_topic" id="election_topic" required>
                    <option value="" disabled selected>Select Election</option>
                    <?php
                    foreach ($activeElections as $club) {
                        echo "<option value=\"$club\">$club</option>";
                    }
                    ?>
                </select>
                <?php
        ?>
            </div>

            <div class="form-group">
                <input type="text" name="candidate_name" placeholder="Candidate Name" class="form-control" required />
            </div>
            <div class="form-group">
                <input type="file" name="candidate_photo" class="form-control" required />
            </div>
            <div class="form-group">
                <input type="text" name="candidate_details" placeholder="Candidate Details" class="form-control"
                    required />
            </div>
            <input type="submit" value="Add Candidate" name="addCandidateBtn" class="btn btn-primary" />
        </form>
    </div>

    <div class="col-8">
        <h3>Candidate Details</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Name</th>
                    <th scope="col">Details</th>
                    <th scope="col">Election</th>
                    <th scope="col">Club</th>
                    <th scope="col">Action </th>

                </tr>
            </thead>
            <tbody>
                <?php
                $fetchingData = mysqli_query($db, "SELECT * FROM candidate_details") or die(mysqli_error($db));
                $isAnyCandidateAdded = mysqli_num_rows($fetchingData);
                

                if ($isAnyCandidateAdded > 0) {
                    $sno = 1;
                    while ($row = mysqli_fetch_assoc($fetchingData)) {
                        $candidate_id = $row['id'];
                        $election_id = $row['election_id'];
                        $fetchingElectionName = mysqli_query($db, "SELECT * FROM elections WHERE id = '" . $election_id . "'") or die(mysqli_error($db));
                        $execFetchingElectionNameQuery = mysqli_fetch_assoc($fetchingElectionName);
                        $election_name = $execFetchingElectionNameQuery['election_topic'];

                        $candidate_photo = $row['candidate_photo'];

                        ?>
                        <tr>
                            <td>
                                <?php echo $sno++; ?>
                            </td>
                            <td> <img src="<?php echo $candidate_photo; ?>" class="candidate_photo" /> </td>
                            <td>
                                <?php echo $row['candidate_name']; ?>
                            </td>
                            <td>
                                <?php echo $row['candidate_details']; ?>
                            </td>
                            <td>
                                <?php echo $election_name; ?>
                            </td>
                            <td>
                                <?php echo $row['club_name']; ?>
                            </td>
                            <td>
                                <a href="edit_candidates.php?candidate_id=<?php echo $row['candidate_id']; ?>"
                                    class="btn btn-sm btn-warning"> Edit </a>

                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger"
                                    onclick="deleteCandidate(<?php echo $candidate_id; ?>)">Delete</button>
                            </td>

                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7"> No any candidate is added yet. </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    const deleteCandidate = (candidateId) => {
        let c = confirm("Are you really want to delete it?");

        if (c == true) {
            location.assign("index.php?addCandidatePage=1&delete-id=" + candidateId);
        }
    }
</script>




<?php

if (isset($_POST['addCandidateBtn'])) {
    $election_id = mysqli_real_escape_string($db, $_POST['election_id']);
    $candidate_name = mysqli_real_escape_string($db, $_POST['candidate_name']);
    $candidate_details = mysqli_real_escape_string($db, $_POST['candidate_details']);
    $inserted_by = $_SESSION['username'];
    $inserted_on = date("Y-m-d");
    $club_name = mysqli_real_escape_string($db, $_POST["club_name"]);
    $election_topic = mysqli_real_escape_string($db, $_POST["election_topic"]);

    // Photograph Logic Starts
    $targetted_folder = "../assets/images/candidate_photos/";
    $candidate_photo = $targetted_folder . rand(111111111, 99999999999) . "_" . rand(111111111, 99999999999) . $_FILES['candidate_photo']['name'];
    $candidate_photo_tmp_name = $_FILES['candidate_photo']['tmp_name'];
    $candidate_photo_type = strtolower(pathinfo($candidate_photo, PATHINFO_EXTENSION));
    $allowed_types = array("jpg", "png", "jpeg");
    $image_size = $_FILES['candidate_photo']['size'];

    if ($image_size < 2000000) // 2 MB
    {
        if (in_array($candidate_photo_type, $allowed_types)) {
            if (move_uploaded_file($candidate_photo_tmp_name, $candidate_photo)) {
                // inserting into db
                mysqli_query($db, "INSERT INTO candidate_details(election_id, candidate_name, candidate_details, candidate_photo, inserted_by, inserted_on,club_name) VALUES('" . $e_id . "', '" . $candidate_name . "', '" . $candidate_details . "', '" . $candidate_photo . "', '" . $inserted_by . "', '" . $inserted_on . "','".$club_name."')") or die(mysqli_error($db));

                echo "<script> location.assign('index.php?addCandidatePage=1&added=1'); </script>";


            } else {
                echo "<script> location.assign('index.php?addCandidatePage=1&failed=1'); </script>";
            }
        } else {
            echo "<script> location.assign('index.php?addCandidatePage=1&invalidFile=1'); </script>";
        }
    } else {
        echo "<script> location.assign('index.php?addCandidatePage=1&largeFile=1'); </script>";
    }

    // Photograph Logic Ends






?>
<?php

}






?>