<?php
$election_id = $_GET['viewResult'];
?>
<section class="voter_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php
                $fetchingActiveElections = mysqli_query($db, "SELECT * FROM elections WHERE id = '" . $election_id . "'") or die(mysqli_error($db));
                $totalActiveElections = mysqli_num_rows($fetchingActiveElections);

                if ($totalActiveElections > 0) {
                    while ($data = mysqli_fetch_assoc($fetchingActiveElections)) {
                        $election_id = $data['id'];
                        $election_topic = $data['election_topic'];

                ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr class="table-warning text-center">
                                        <th colspan="5">Election Name: <?php echo $election_topic; ?></th>
                                    </tr>
                                    <tr class="table-info text-center">
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Party</th>
                                        <th>Votes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $fetchingCandidates = mysqli_query($db, "SELECT * FROM candidate_details WHERE election_id = '" . $election_id . "'") or die(mysqli_error($db));
                                    while ($candidateData = mysqli_fetch_assoc($fetchingCandidates)) {
                                        $candidate_id = $candidateData['id'];
                                        $candidate_photo = $candidateData['candidate_photo'];
                                        $candidate_name = $candidateData['candidate_name'];
                                        $candidate_party = $candidateData['candidate_brand'];

                                        //Fetching Candidate Votes
                                        $fetchingVotes = mysqli_query($db, "SELECT * FROM votings WHERE candidate_id = '" . $candidate_id . "'") or die(mysqli_error($db));

                                        $totalVotes = mysqli_num_rows($fetchingVotes);
                                    ?>
                                        <tr class="text-center">
                                            <td><img src="<?php echo $candidate_photo; ?>"></td>
                                            <td><?php echo $candidate_name; ?></td>
                                            <td><?php echo $candidate_party; ?></td>
                                            <td><?php echo  $totalVotes; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                    <?php
                    }
                } else {
                    echo "No any active election.";
                }
                    ?>
                        </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center text-info">Vote Details</h2>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr class="table-info text-center">
                                <th>S.No</th>
                                <th>Voters Name</th>
                                <th>Nid Number</th>
                                <th>Voted To</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <?php
                        $fetchingVoteDetails = mysqli_query($db, "SELECT * FROM votings WHERE election_id = '" . $election_id . "'") or die(mysqli_error($db));


                        $number_of_votes = mysqli_num_rows($fetchingVoteDetails);

                        if ($number_of_votes > 0) {
                            $sno = 1;
                            while ($data = mysqli_fetch_assoc($fetchingVoteDetails)) {

                                $voters_id = $data['voters_id'];
                                $candidate_id = $data['candidate_id'];

                                $fetchingUserName = mysqli_query($db, "SELECT * FROM users WHERE id = '" . $voters_id . "'") or die(mysqli_error($db));
                                $isDataAvailable = mysqli_num_rows($fetchingUserName);
                                $userData = mysqli_fetch_assoc($fetchingUserName);
                                if ($isDataAvailable > 0) {

                                    $username =  $userData['username'];
                                    $nid_no = $userData['nid_no'];
                                } else {
                                    echo "No data available";
                                    $nid_no = $userData['nid_no'];
                                }

                                $fetchingCandidateName = mysqli_query($db, "SELECT * FROM candidate_details WHERE id = '" . $candidate_id . "'") or die(mysqli_error($db));
                                $isDataAvailable = mysqli_num_rows($fetchingCandidateName);
                                $candidateData = mysqli_fetch_assoc($fetchingCandidateName);
                                if ($isDataAvailable > 0) {

                                    $candidate_name =  $candidateData['candidate_name'];
                                } else {
                                    $candidate_name = "No data available";
                                }
                        ?>
                                <tbody>
                                    <tr class="text-center">
                                        <td><?php echo $sno++; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td><?php echo $nid_no; ?></td>
                                        <td><?php echo $candidate_name; ?></td>
                                        <td><?php echo $data['vote_date'] ?></td>
                                    </tr>
                                </tbody>
                            <?php
                            }
                        } else {
                            ?>

                            <div class="alert alert-warning text-center" role="alert">
                               <h6>No data is available at the moment</h6>
                            </div>

                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>