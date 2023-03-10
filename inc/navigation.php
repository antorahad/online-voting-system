<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <h4 class="welcome-text">Welcome <?php echo $_SESSION['user_role']?></h4>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
     <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto text-center">
        <li class="nav-item">
          <a class="nav-link" href="index.php?homePage=1">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?addElectionPage=1">Add Election</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?addCandidatePage=1">Add Candidates</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-danger" href="../admin/logout.php">logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>