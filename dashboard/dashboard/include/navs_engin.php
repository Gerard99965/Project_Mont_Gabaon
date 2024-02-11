<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">M.G dashboard</a>

    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <form method="POST"action="List_engin.php" enctype="multipart/form-data" class="input-group col-md-6">
    <!-- //<div class="input-group col-lg-12"> -->
    <select aria-label="Search" name='emplacement' class="form-control form-control-light" required>
        <?php
                include('configuration/dbConnection.php');
                $select="select * from lieu_affectation";
                $run_query=mysqli_query($connect,$select);
                while($row=mysqli_fetch_assoc($run_query))
                {
        ?>
            <option value="<?php echo $row['lieu'];?>"><?php echo $row['lieu'];?></option>
                <?php
                }
                ?>
        </select>
      <!--<input class="form-control form-control-light" type="search" placeholder="Recherche ..." aria-label="Search" name='emplacement'>-->
      <div class="input-group-prepend">
        <button class="btn btn-primary" type="submit" name="search">Recherche</button>
      </div>
    <!-- </div> -->
    </form>
    <!-- <input class="form-control form-control-dark w-50" type="search" placeholder="Recherche ..." aria-label="Search"> -->
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <a class="nav-link text-white" href="include/logout.php"><strong>Deconnexion</strong></a>
      </li>
    </ul>
  </nav>