<?php 
  session_start();
  require'include/header.php';
  include('function/function.php');
  include('function/constante.php');
  include('configuration/dbConnection.php');
  include('configuration/connection.php');
  if(!isset($_SESSION['user_id']))
  {
    redirect('../log.php');
  }
  
?>
<?php
if (isset($_POST['send']))
    {
        extract($_POST);
        if (is_already_in_use('Designation', $Designation, 'stock'))
        {
            set_flash("cet object est deja dans le system!",'danger');
        }
        else{
        $Prix_total=$Prix_unitaire * $Qte;
        $insert="INSERT INTO `stock`(`Qte`, `Unite`, `Designation`, `Reference`, `Departement`, `Prix_unitaire`, `Prix_total`)
        VALUES ( '$Qte', '$Unite', '$Designation', '$Reference', '$Departement', '$Prix_unitaire', '$Prix_total')";
        $run_query=mysqli_query($connect,$insert);
        }
?>
<?php
if ($run_query)
    {

        set_flash("enregistrer avec seccuss");
    }
    else
    {

        set_flash("erreur d enregistrement", 'danger');
    }
    }
?>
  <div class="container-fluid">
  <div class="row">
    <?php require'include/navigation_menu.php';?>
  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Mont Gabaon New Item</h1>
      <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
          <button type="button" class="btn btn-sm btn-outline-secondary">Importer</button>
          <button type="button" class="btn btn-sm btn-outline-secondary">Exporter</button>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
          <span data-feather="calendar"></span>&nbsp;Calendrier
        </button>
      </div>
    </div>

    <!-- <canvas class="my-4 w-100" id="myChart" width="900" height="300"></canvas> -->

	<h5>Veiller Ajouter un nouveau Objet dans le stock</h5>

	<form method="POST" action="Add_stock.php" enctype="multipart/form-data">
    <div class="row mb-3 mt-3">
      <div class="col-md-3 col-sm-6">
        <label>Qte</label>
        <input type="number" class="form-control" placeholder="Entrer la quantite" name="Qte" required>
      </div>

      <div class="col-md-3 col-sm-6">
        <label>Unite</label>
        <select name="Unite" class="form-control" required>
            <option value="kg">Kg</option>
            <option value="g">g</option>
            <option value="km">Km</option>
            <option value="m3">m3</option>
            <option value="m2">m2</option>
            <option value="m">m</option>
            <option value="Paire">Paire</option>
            <option value="Pices">Pieces</option>
            <option value="L">L</option>
            <option value="Kit">Kit</option>
            <option value="Carton">Carton</option>
            <option value="Rouleaux">Rouleaux</option>
            <option value="Sac">Sac</option>
            <option value="Boite">Boite</option>
        </select>
      </div>

      <div class="col-md-3 col-sm-6">
        <label>Designation</label>
        <input type="text" class="form-control" placeholder="Entrez la designation" name="Designation" >
      </div>

      <div class="col-md-3 col-sm-6">
        <label>Reference</label>
        <input type="text" class="form-control" placeholder="Entrez la reference" name="Reference" required>
      </div>
    </div>
    <div class="row mb-3 mt-3">
      <div class="col-md-4 mt-3">
        <label>Departement</label>
        <select name="Departement" class="form-control" required>
        <?php
                include('configuration/dbConnection.php');
                $select="select * from departement";
                $run_query=mysqli_query($connect,$select);
                while($row=mysqli_fetch_assoc($run_query))
                {
        ?>
            <option value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
                <?php
                }
                ?>
        </select>
      </div>
      <div class="col-md-4 mt-3">
        <label>Prix Unitaire</label>
        <input type="number" class="form-control" placeholder="Entrez le prix unitaire sans la virgule" name="Prix_unitaire" required>
      </div>
    </div>
   	<button class="btn btn-lg btn-primary btn-block" type="submit"value="send" name="send">Ajouter</button>
	</form>
  </br>
      <?php
        include('parial/flash.php');
        ?>
<h2>Liste des Items</h2>
      <div class="table-responsive "style="display:block; height:400px; overflow: auto;" >
        <table class="table table-striped table-sm table-bordered">
        <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>Qte</th>
              <th>Unite</th>
              <th>Designation</th>
              <th>Reference</th>
              <th>Departement</th>
              <th>Prix_unitaire</th>
              <th>Prix_total</th>
              <th>Action</th>
            </tr>
          </thead>
          <!-- style="display:block; height:200px; overflow: auto;" -->

            <?php
                include('configuration/dbConnection.php');
                 $select="select * from stock ORDER BY id DESC";
                $run_query=mysqli_query($connect,$select);
                while($row=mysqli_fetch_assoc($run_query))
                {
            ?>
          <tbody >

            <tr>
              <td><?php echo $row['id'];?></td>
              <td><?php echo $row['Qte'];?></td>
              <td><?php echo $row['Unite'];?></td>
              <td><?php echo $row['Designation'];?></td>
              <td><?php echo $row['Reference'];?></td>
              <td><?php echo $row['Departement'];?></td>
              <td><?php echo $row['Prix_unitaire'];?></td>
              <td><?php echo $row['Prix_total'];?></td>
              <td><a class="btn btn-primary"href="include/edit1.php?id=<?php echo $row['id'];?>">Edit</a><a class="btn btn-danger"href="include/delete1.php?id=<?php echo $row['id'];?>">Delete</a></td>
            </tr>
                <?php
                }
                ?>
          </tbody>
          <tfooter>
          <?php
                include('configuration/dbConnection.php');
                $select="select COUNT(*) AS total from stock";
                $run_query=mysqli_query($connect,$select);
                while($row=mysqli_fetch_assoc($run_query))
                {
            ?>
              <tr>
                <td>Total</td>
                <td colspan="10"></td>
              <td><?php echo $row['total'];?></td>
                </tr>
              <?php
                }
                ?>
          </tfooter>
        </table>
      </div>
      <p class="mt-5 mb-3 text-muted text-center">&copy; 2024-2025</p>
  </main>
  </div>
  </div>
<?php require'include/footer.php';?>
