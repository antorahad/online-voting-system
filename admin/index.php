<?php
require_once("../inc/header.php");
require_once("../inc/navigation.php");

if(isset($_GET['homePage'])){
    require_once("../inc/home_page.php");
 }
elseif(isset($_GET['addElectionPage'])){
   require_once("../inc/add_elections.php");
}
elseif(isset($_GET['addCandidatePage'])){
    require_once("../inc/add_candidates.php");
}
elseif(isset($_GET['viewResult'])){
    require_once("../inc/view_result.php");
}

require_once("../inc/footer.php");
?>