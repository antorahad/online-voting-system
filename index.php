<?php
require_once("inc/config.php");

if (isset($_POST['sign_up_btn'])) {

    $su_username = mysqli_real_escape_string($db, $_POST['su_username']);

    $su_nid_no = mysqli_real_escape_string($db, $_POST['su_nid_no']);

    $su_password = mysqli_real_escape_string($db, sha1($_POST['su_password']));

    $su_retype_password = mysqli_real_escape_string($db, sha1($_POST['su_retype_password']));

    $user_role = "Voter";

    if ($su_password == $su_retype_password) {

        //insert query//
        mysqli_query($db, "INSERT INTO users(username, nid_no, password, user_role) VALUES('" . $su_username . "', '" . $su_nid_no . "', '" . $su_password . "', '" . $user_role . "')") or die(mysqli_error($db));
?>
        <script>
            location.assign("index.php?sign-up=1&registered=1");
        </script>
    <?php
    } else {
    ?>
        <script>
            location.assign("index.php?sign-up=1&invalid=1");
        </script>
        <?php
    }
} elseif (isset($_POST['loginBtn'])) {

    $nid_no = mysqli_real_escape_string($db, $_POST['nid_no']);
    $password = mysqli_real_escape_string($db, sha1($_POST['password']));

    //select query//
    $fetchingData = mysqli_query($db, "SELECT * FROM users WHERE nid_no = '" . $nid_no . "'") or die(mysqli_error($db));

    if (mysqli_num_rows($fetchingData) > 0) {
        $data = mysqli_fetch_assoc($fetchingData);

        if ($nid_no == $data['nid_no'] and  $password == $data['password']) {

            session_start();
            $_SESSION['user_role'] = $data['user_role'];

            $_SESSION['username'] = $data['username'];

            $_SESSION['user_id'] = $data['id'];

            if ($data['user_role'] == "Admin") {
                $_SESSION['key'] = "Adminkey";
                header("location: admin/index.php?homePage=1");
            } else {
                $_SESSION['key'] = "Voterkey";
                header("location: voter/index.php");
            }
        } else {
        ?>
            <script>
                location.assign("index.php?invalid_access=1");
            </script>
        <?php
        }
    } else {
        ?>
        <script>
            location.assign("index.php?sign-up=1&not_registered=1");
        </script>
<?php
    }
}

if (isset($_GET['registered'])) {
    echo "<script>alert('Your account has been created')</script>";
} elseif (isset($_GET['invalid'])) {
    echo "<script>alert('Password did not matched')</script>";
} elseif (isset($_GET['not_registered'])) {
    echo "<script>alert('Sorry you are not registered')</script>";
} elseif (isset($_GET['invalid_access'])) {
    echo "<script>alert('Invalid NID or password')</script>";
}


$fetchingElections = mysqli_query($db, "SELECT * FROM elections") or die(mysqli_error($db));
while ($data = mysqli_fetch_assoc($fetchingElections)) {
    $starting_date = $data['starting_date'];
    $ending_date = $data['ending_date'];
    $curr_date = date("Y-m-d");
    $election_id = $data['id'];
    $status = $data['status'];

    if ($status == "Active") {

        $date1 = date_create($curr_date);
        $date2 = date_create($ending_date);
        $diff = date_diff($date1, $date2);

        if ((int) $diff->format("%R%a") < 0) {
          //update
          mysqli_query($db, "UPDATE elections SET status = 'Expired' WHERE id = '".$election_id."' ") or die(mysqli_error($db));
        }
    } elseif ($status == "Inactive") {
        $date1 = date_create($curr_date);
        $date2 = date_create($starting_date);
        $diff = date_diff($date1, $date2);

        if ((int) $diff->format("%R%a") <= 0) {
           //update
          mysqli_query($db, "UPDATE elections SET status = 'Active' WHERE id = '".$election_id."' ") or die(mysqli_error($db));
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Voting System</title>
    <!-- Fav link -->
    <link rel="shortcut icon" href="img/vote.png" type="image/x-icon">
    <!-- CSS link -->
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

</head>

<body>
    <?php
    if (isset($_GET['sign-up'])) {
    ?>
        <form method="POST" class="votingForm mt-5">
            <div class="text-center mb-3">
                <img src="img/vote.png" alt="logo" class="img-fluid">
            </div>

            <div class="text-center mb-3">
                <h3 class="formTitle">Online Voting System</h3>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                <input type="text" class="form-control" placeholder="User Name" name="su_username" required />
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                <input type="text" class="form-control" placeholder="NID Number" name="su_nid_no" required />
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                <input type="password" class="form-control" placeholder="Password" name="su_password" required />
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                <input type="password" class="form-control" placeholder="Confirm Password" name="su_retype_password" required />
            </div>

            <div class="text-center">
                <button type="submit" class="signupBtn" name="sign_up_btn">Register</button>
            </div>

            <div class="mt-3 text-center">
                Already have an account? <a href="index.php">Login Here</a>
            </div>
        </form>
    <?php
    } else {
    ?>
        <form method="POST" class="votingForm mt-5">
            <div class="text-center mb-3">
                <img src="img/vote.png" alt="logo" class="img-fluid">
            </div>

            <div class="text-center mb-3">
                <h3 class="formTitle">Online Voting System</h3>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                <input type="text" class="form-control" placeholder="NID Number" name="nid_no" required />
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                <input type="password" class="form-control" placeholder="Password" name="password" required />
            </div>

            <div class="text-center">
                <button type="submit" class="loginBtn" name="loginBtn">Login</button>
            </div>

            <div class="mt-3 text-center">
                Don't have an account? <a href="?sign-up=1">Register Here</a>
            </div>
        </form>
    <?php
    }
    ?>
    <!-- JQuery cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>