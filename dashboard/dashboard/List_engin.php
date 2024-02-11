<?php
  session_start();
  require'include/header_list_engin.php';
  include('function/function.php');
  include('function/constante.php');
  include('configuration/dbConnection.php');
  include('configuration/connection.php');
  if(!isset($_SESSION['user_id']))
 {
  redirect('../log.php');
 }

?>
  <div class="container-fluid">
  <div class="row">
    <?php require'include/navigation_menu.php';?>
  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <!-- <h1 class="h2">Mont Gabaon Ajouter Dans Stock</h1> -->
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
    <h2>Liste des Engins</h2>
      <div class="table-responsive " >
        <table class="table table-striped table-sm table-bordered">
        <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>Equipment</th>
              <th>Number</th>
              <th>Plaque</th>
              <th>Type</th>
              <th>Make</th>
              <th>Chassis</th>
              <th>Quantite</th>
              <th>Annee Acquit</th>
              <th>Position</th>
              <th>Remarque/Etat</th>
              <th>Photo</th>
              <th>Action</th>
            </tr>
          </thead>
          <!-- style="display:block; height:200px; overflow: auto;" -->
            <?php
              if(isset($_POST['search'])){
            ?>
            <?php
                 extract($_POST);
                include('configuration/dbConnection.php');
                 $select="select * from listengins where Emplacement='$emplacement' ORDER BY id DESC";
                $run_query=mysqli_query($connect,$select);
                while($row=mysqli_fetch_assoc($run_query))
                {
            ?>
          <tbody >

            <tr>
              <td><?php echo $row['id'];?></td>
              <td><?php echo $row['Equipment'];?></td>
              <td><?php echo $row['number'];?></td>
              <td><?php echo $row['Plaque'];?></td>
              <td><?php echo $row['Type'];?></td>
              <td><?php echo $row['Make'];?></td>
              <td><?php echo $row['Chassis'];?></td>
              <td><?php echo $row['Qte'];?></td>
              <td><?php echo $row['Annee_acquit'];?></td>
              <td><?php echo $row['Emplacement'];?></td>
              <td><?php echo $row['Remarque'];?></td>
              <td><img src="img/<?php echo $row["photo"]; ?>" width = 200 title="<?php echo $row['photo']; ?>"> </td>
              <td><a class="btn btn-primary"href="include/edit1.php?id=<?php echo $row['id'];?>">Edit</a><a class="btn btn-danger"href="include/delete1.php?id=<?php echo $row['id'];?>">Delete</a></td>
            </tr>
                <?php
                }
                ?>
          </tbody>
          <tfooter>
          <?php
                include('configuration/dbConnection.php');
                $select="select COUNT(*) AS total from listengins where Emplacement='$emplacement' ";
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
                }}
                else
                {
                ?>
                 <?php
                 extract($_POST);
                include('configuration/dbConnection.php');
                 $select="select * from listengins ORDER BY id DESC";
                $run_query=mysqli_query($connect,$select);
                while($row=mysqli_fetch_assoc($run_query))
                {
            ?>
          <tbody >

            <tr>
              <td><?php echo $row['id'];?></td>
              <td><?php echo $row['Equipment'];?></td>
              <td><?php echo $row['number'];?></td>
              <td><?php echo $row['Plaque'];?></td>
              <td><?php echo $row['Type'];?></td>
              <td><?php echo $row['Make'];?></td>
              <td><?php echo $row['Chassis'];?></td>
              <td><?php echo $row['Qte'];?></td>
              <td><?php echo $row['Annee_acquit'];?></td>
              <td><?php echo $row['Emplacement'];?></td>
              <td><?php echo $row['Remarque'];?></td>
              <td><img src="user_images/<?php echo $row["photo"]; ?>" width = 100 title="<?php echo $row['photo']; ?>"></td>
              <td><a class="btn btn-primary"href="include/edit1.php?id=<?php echo $row['id'];?>">Edit</a><a class="btn btn-danger"href="include/delete1.php?id=<?php echo $row['id'];?>">Delete</a></td>
            </tr>
                <?php
                }
                ?>
          </tbody>
          <tfooter>
          <?php
                include('configuration/dbConnection.php');
                $select="select COUNT(*) AS total from listengins ";
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