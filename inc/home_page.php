<section class="home_wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h3 class="title mb-3">Elections</h3>
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
                                <th scope="col">Insert By</th>
                                <th scope="col">Insert Date</th>
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
                                        <td><?php echo $row['inserted_by']; ?></td>
                                        <td><?php echo $row['inserted_on']; ?></td>
                                        <td>
                                            <a href="index.php?viewResult=<?php echo $election_id; ?>" class="btn btn-sm btn-success">View Result</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="9" class="text-center text-info">No any election is added yet.</td>
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
