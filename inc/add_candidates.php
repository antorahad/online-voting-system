<?php
if (isset($_POST['addCandidateBtn'])) {
    $election_id  =  mysqli_real_escape_string($db, $_POST['election_id']);

    $candidate_name = mysqli_real_escape_string($db, $_POST['candidate_name']);

    $candidate_brand  = mysqli_real_escape_string($db, $_POST['candidate_brand']);

    $inserted_by = $_SESSION['username'];

    $inserted_on = date("Y-m-d");

    //Image method//
    $targetted_folder = "../candidate_photos/";
    $candidate_photo  =  $targetted_folder . rand(111111111, 99999999999) . "_" . rand(111111111, 99999999999) . $_FILES['candidate_photo']['name'];
    $candidate_photo_tmp_name = $_FILES['candidate_photo']['tmp_name'];
    $candidate_photo_type = strtolower(pathinfo($candidate_photo, PATHINFO_EXTENSION));
    $allowed_types = array("jpg", "png", "jpeg");
    $image_size = $_FILES['candidate_photo']['size'];

    if ($image_size < 2000000) {
        if (in_array($candidate_photo_type, $allowed_types)) {
            if (move_uploaded_file($candidate_photo_tmp_name, $candidate_photo)) {
                mysqli_query($db, "INSERT INTO candidate_details(election_id, candidate_name, candidate_brand, candidate_photo, inserted_by, inserted_on) VALUES ('" . $election_id . "', '" .  $candidate_name . "', '" .  $candidate_brand . "', '" . $candidate_photo . "', '" .  $inserted_by . "', '" . $inserted_on . "')") or die(mysqli_error($db));

                echo "<script>location.assign('index.php?addCandidatePage=1&added=1')</script>";
            } else {
                echo "<script>location.assign('index.php?addCandidatePage=1&failed=1')</script>";
            }
        } else {
            echo "<script>location.assign('index.php?addCandidatePage=1&invalidFile=1')</script>";
        }
    } else {
        echo "<script>location.assign('index.php?addCandidatePage=1&largeFile=1')</script>";
    }

?>

<?php
}

if (isset($_GET['added'])) {
?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-sharp fa-solid fa-circle-check"></i> Candidate added successfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}elseif(isset($_GET['delete_id'])){
    mysqli_query($db,"DELETE FROM candidate_details WHERE id = '".$_GET['delete_id']."'") OR die(mysqli_error($db));
?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa-sharp fa-solid fa-circle-check"></i> Election has deleted successfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}elseif (isset($_GET['largeFile'])) {
?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa-sharp fa-solid fa-circle-xmark"></i> Image size is too large
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php
} elseif (isset($_GET['invalidFile'])) {
?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa-sharp fa-solid fa-circle-xmark"></i> Image type is invalid
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
} elseif (isset($_GET['failed'])) {

?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa-sharp fa-solid fa-circle-xmark"></i> Image uploading failed
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>
<section class="candidate_wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <h3 class="title mb-3">Add New Candidates</h3>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label>Election Name</label>
                        <select name="election_id" class="form-control" required>
                            <option value="">Select Election</option>
                            <?php

                            $fetchingElections = mysqli_query($db, "SELECT * FROM elections") or die(mysqli_error($db));
                            $isAnyElectionAdded = mysqli_num_rows($fetchingElections);
                            if ($isAnyElectionAdded > 0) {

                                while ($row = mysqli_fetch_assoc($fetchingElections)) {
                                    $election_id = $row['id'];
                                    $election_name = $row['election_topic'];
                                    $allowed_candidates = $row['no_of_candidates'];
                                    //checking how many candidates are added for a specific election//

                                    $fetchingCandidate = mysqli_query($db, "SELECT * FROM candidate_details WHERE election_id = '" . $election_id . "' ") or die(mysqli_error($db));
                                    $added_candidates = mysqli_num_rows($fetchingCandidate);

                                    if ($added_candidates < $allowed_candidates) {


                            ?>

                                        <option value="<?php echo $election_id; ?>"><?php echo $election_name; ?></option>

                                <?php
                                    }
                                }
                            } else {
                                ?>

                                <option value="">Please add election first</option>

                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label>Name of Candidate</label>
                        <input type="text" class="form-control" name="candidate_name" required />
                    </div>
                    <div class="mb-4">
                        <label>Candidate Image</label>
                        <input type="file" class="form-control" name="candidate_photo" required />
                    </div>
                    <div class="mb-4">
                        <label>Candidate Party</label>
                        <input type="text" class="form-control" name="candidate_brand" required />
                    </div>
                    <button type="submit" name="addCandidateBtn" class="addBtn">Add Candidate</button>
                </form>
            </div>

            <div class="col-md-8">
                <h3 class="title mb-3">Candidate Information</h3>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-info">
                            <tr class="text-center">
                                <th scope="col">S.No</th>
                                <th scope="col">Photo</th>
                                <th scope="col">Name</th>
                                <th scope="col">Party</th>
                                <th scope="col">Election</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $fetchingData = mysqli_query($db, "SELECT * FROM candidate_details") or die(mysqli_error($db));

                            $isAnyCandidateAdded = mysqli_num_rows($fetchingData);

                            if ($isAnyCandidateAdded > 0) {
                                $sno = 1;
                                while ($row = mysqli_fetch_assoc($fetchingData)) {

                                    $election_id = $row['election_id'];
                                    $fetchingElectionName = mysqli_query($db, "SELECT * FROM elections WHERE id = '" . $election_id . "' ") or die(mysqli_error($db));

                                    $execFetchingElectionNameQuery = mysqli_fetch_assoc($fetchingElectionName);

                                    $election_name =   $execFetchingElectionNameQuery['election_topic'];
                                    $candidate_photo = $row['candidate_photo'];

                                    $candidate_id = $row['id'];
                            ?>

                                    <tr class="text-center">
                                        <td><?php echo $sno++ ?></td>
                                        <td> <img src="<?php echo $candidate_photo; ?>" /></td>
                                        <td><?php echo $row['candidate_name']; ?></td>
                                        <td><?php echo $row['candidate_brand']; ?></td>
                                        <td><?php echo $election_name; ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-danger" onclick="DeleteData(<?php echo $candidate_id;?>)">Delete</button>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7" class="text-center text-info">No any Candidate is added yet.</td>
                                </tr>
                            <?php

                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    const DeleteData = (c_id) =>{
        let c = confirm("Do you really want to delete this data?");

        if(c==true){
            location.assign("index.php?addCandidatePage=1&delete_id=" + c_id);
        }
    }
</script>