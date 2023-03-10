<?php
require_once("../voter/inc/header.php");
require_once("../voter/inc/navigation.php");
?>
<section class="voter_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php
                $fetchingActiveElections = mysqli_query($db, "SELECT * FROM elections WHERE status = 'Active'") or die(mysqli_error($db));
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
                                    <th>Action</th>
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
                                        <td>
                                            <?php
                                            $checkIfVoteCasted = mysqli_query($db, "SELECT * FROM votings WHERE voters_id = '" . $_SESSION['user_id'] . "' AND election_id = '".$election_id."'") or die(mysqli_error($db));

                                            $isVoteCasted = mysqli_num_rows($checkIfVoteCasted);

                                            if ($isVoteCasted > 0) 
                                            {
                                                $voteCastedData = mysqli_fetch_assoc($checkIfVoteCasted);
                                                $voteCastedToCandidate = $voteCastedData['candidate_id'];


                                                if($voteCastedToCandidate == $candidate_id)
                                                {
                                            ?>        
                                                    <img src="../img/voote.png" style="width: 100px; height: 80px; border-radius: 0px">
                                            <?php        
                                                }
                                            } else {
                                            ?>
                                                <button class="btn btn-md btn-success" onclick="CastVote(<?php echo $election_id; ?>, <?php echo $candidate_id; ?>, <?php echo $_SESSION['user_id']; ?>)">Vote</button>
                                            <?php
                                            }
                                            ?>
                                        </td>
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
</section>

<script>
    const CastVote = (election_id, customer_id, voters_id) => {
        $.ajax({
            type: "POST",
            url: "inc/ajaxCalls.php",
            data: "e_id=" + election_id + "&c_id=" + customer_id + "&v_id=" + voters_id,
            success: function(response) {
                if (response == "Success") {
                    location.assign("index.php?voteCasted=1");
                } else {
                    location.assign("index.php?voteNotCasted=1");
                }
            }
        });
    }
</script>

<?php
require_once("../voter/inc/footer.php");
?>