<?php
if (isset($_POST['addElectionBtn'])) {
    $election_topic  =  mysqli_real_escape_string($db, $_POST['election_topic']);

    $number_of_candidates = mysqli_real_escape_string($db, $_POST['number_of_candidates']);

    $starting_date  = mysqli_real_escape_string($db, $_POST['starting_date']);

    $ending_date = mysqli_real_escape_string($db, $_POST['ending_date']);

    $inserted_by = $_SESSION['username'];

    $inserted_on = date("Y-m-d");

    $date1 = date_create($inserted_on);
    $date2 = date_create($starting_date);
    $diff = date_diff($date1, $date2);

    if ((int)$diff->format("%R%a") > 0) {
        $_status = "Inactive";
    } else {
        $_status = "Active";
    }

    //Inset query//
    mysqli_query($db, "INSERT INTO elections(election_topic, no_of_candidates, starting_date, ending_date, status,inserted_by, inserted_on) VALUES ('" . $election_topic . "', '" . $number_of_candidates . "', '" . $starting_date . "', '" . $ending_date . "', '" . $_status . "', '" .  $inserted_by . "', '" . $inserted_on . "')") or die(mysqli_error($db));

?>
    <script>
        location.assign("index.php?addElectionPage=1&added=1");
    </script>
<?php
}

if (isset($_GET['added'])) {
?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa-sharp fa-solid fa-circle-check"></i> Election added successfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}elseif(isset($_GET['delete_id'])){
    mysqli_query($db,"DELETE FROM elections WHERE id = '".$_GET['delete_id']."'") OR die(mysqli_error($db));
?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa-sharp fa-solid fa-circle-check"></i> Election has deleted successfully
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>
<section class="election_wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <h3 class="title mb-3">Add New Election</h3>
                <form method="POST">
                    <div class="mb-4">
                        <label>Election Topic</label>
                        <input type="text" class="form-control" name="election_topic" required />
                    </div>
                    <div class="mb-4">
                        <label>Number of Candidates</label>
                        <input type="number" class="form-control" name="number_of_candidates" required />
                    </div>
                    <div class="mb-4">
                        <label>Election Starting Date</label>
                        <input type="date" class="form-control" name="starting_date" required />
                    </div>
                    <div class="mb-4">
                        <label>Election Ending Date</label>
                        <input type="date" class="form-control" name="ending_date" required />
                    </div>
                    <button type="submit" name="addElectionBtn" class="addBtn">Add Election</button>
                </form>
            </div>
            <div class="col-md-8">
                <h3 class="title mb-3">Upcoming & Ongoing Election</h3>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-info">
                            <tr class="text-center">
                                <th scope="col">S.No</th>
                                <th scope="col">Election Name</th>
                                <th scope="col">No of Candidates</th>
                                <th scope="col">Starting Date</th>
                                <th scope="col">Ending Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $fetchingData = mysqli_query($db, "SELECT * FROM elections") or die(mysqli_error($db));

                            $isAnyElectionAdded = mysqli_num_rows($fetchingData);

                            if ($isAnyElectionAdded > 0) {
                                $sno = 1;
                                while ($row = mysqli_fetch_assoc($fetchingData)) {

                                    $election_id = $row['id'];
                            ?>
                                    <tr class="text-center">
                                        <td><?php echo $sno++ ?></td>
                                        <td><?php echo $row['election_topic']; ?></td>
                                        <td><?php echo $row['no_of_candidates']; ?></td>
                                        <td><?php echo $row['starting_date']; ?></td>
                                        <td><?php echo $row['ending_date']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-danger" onclick="DeleteData(<?php echo $election_id;?>)">Delete</button>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7" class="text-center text-info">No any election is added yet.</td>
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
    const DeleteData = (e_id) =>{
        let c = confirm("Do you really want to delete this data?");

        if(c==true){
            location.assign("index.php?addElectionPage=1&delete_id=" + e_id);
        }
    }
</script>