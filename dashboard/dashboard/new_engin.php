<?php
session_start();
  require'include/header.php';
  include('function/function.php');
  include('function/constante.php');
  include('configuration/dbConnection.php');
  include('configuration/connection.php');
?>
<?php
 if(!isset($_SESSION['user_id']))
 {
  redirect('../log.php');
 }
if (isset($_POST['send']))
    {
        extract($_POST);
        if (is_already_in_use('number', $number, 'listengins'))
        {
            set_flash("cette imatriculation est deja utiliser est deja utiliser!",'danger');
        }
        else{
        $userpic="";
        
            $target_path=$_FILES['photo']['name'];
            $tmp_dir=$_FILES['photo']['tmp_name'];
            $imgSize=$_FILES['photo']['size'];
            if(!empty($target_path))
            {
                $upload_dir='user_images/';
                $imgExt=strtolower(pathinfo($target_path,PATHINFO_EXTENSION));
                $valid_extensions=array('jpeg','jpg','png','gif');
                $userpic=rand(1000,1000000).".".$imgExt;
                if(in_array($imgExt, $valid_extensions)){
                    if($imgSize>5000000)
                    {
                        move_uploaded_file($tmp_dir,$upload_dir.$userpic);
                        set_flash("your file is  large", 'danger');
                    }else
                    {
                        set_flash("your file is too large", 'danger');
                    }
                }else
                {
                    set_flash("is only allow jpeg jpg png and gif",'danger');
                }

            }
            else
            {
                set_flash("enter the file", 'danger');
            }
            move_uploaded_file($tmp_dir,$upload_dir.$userpic);
        $insert="INSERT INTO `listengins`(`Equipment`, `Number`, `Plaque`, `Type`, `Make`, `Chassis`, `Qte`, `Annee_acquit`, `Emplacement`, `Remarque`,`photo`)
        VALUES ( '$equipment', '$number', '$plaque', '$type', '$make', '$chassis', '$qte', '$annee_acquit', '$emplacement', '$remarque','$userpic')";
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
      <h1 class="h2">Mont Gabaon New Engins</h1>
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

	<h5>Veiller Ajouter un nouveau Engin</h5>

	<form method="POST" action="new_engin.php" enctype="multipart/form-data">
    <div class="row mb-3 mt-3">
      <div class="col-md-3 col-sm-6">
        <label>Equipment</label>
        <input type="text" class="form-control" placeholder="Entrer le nom de l'equipment" name="equipment" required>
      </div>

      <div class="col-md-3 col-sm-6">
        <label>Number</label>
        <input type="text" class="form-control" placeholder="Entrez Numero d'enregistrement" name="number" required>
      </div>

      <div class="col-md-3 col-sm-6">
        <label>Plaque</label>
        <input type="text" class="form-control" placeholder="Entrez la plaque" name="plaque" >
      </div>

      <div class="col-md-3 col-sm-6">
        <label>Inserez une image</label>
        <input type="file" class="form-control" placeholder="Photo de l'engin" name="photo" required>
      </div>
    </div>
    <div class="row mb-3 mt-3">
      <div class="col-md-4 mt-3">
        <label>Type</label>
        <input type="text" class="form-control" placeholder="entrez le type del'engin" name="type" >
      </div>
      <div class="col-md-4 mt-3">
        <label>Make</label>
        <input type="text" class="form-control" placeholder="Entrez la marque de l'engin" name="make" required>
      </div>
      <div class="col-md-4 mt-3">
        <label>Chassis</label>
        <input type="text" class="form-control" placeholder="Entrez le numero du chassis" name="chassis" required>
      </div>
    </div>
    <div class="row mb-3 mt-3">
      <div class="col-md-3 col-sm-6">
        <label>Quantite</label>
        <input type="number" class="form-control" placeholder="Entrez la quantite des engins" name="qte" required>
      </div>
      <div class="col-md-3 col-sm-6">
        <label>Annee d'acquisition</label>
        <input type="text" class="form-control" placeholder="L'annee de l'acquisition" name="annee_acquit" required>
      </div>
      <div class="col-md-3 col-sm-6">
        <label>Affectation</label>
        <select name="emplacement" class="form-control" required>
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
      </div>
      <div class="col-md-3 col-sm-6">
        <label>Remarque/Etat</label>
        <textarea class="form-control" placeholder="Entrez l'etat de l'engin" rows="5" name="remarque" required></textarea>
      </div>
    </div>
		<button class="btn btn-lg btn-primary btn-block" type="submit"value="send" name="send">Ajouter</button>
	</form>
  </br>
      <?php
        include('parial/flash.php');
        ?>
<h2>Liste des Engins</h2>
      <div class="table-responsive "style="display:block; height:400px; overflow: auto;" >
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
              <td><img src="user_images/<?php echo $row["photo"]; ?>" width = 100 title="<?php echo $row['photo']; ?>"> </td>
              <td><a class="btn btn-primary"href="include/edit1.php?id=<?php echo $row['id'];?>">Edit</a><a class="btn btn-danger"href="include/delete1.php?id=<?php echo $row['id'];?>">Delete</a></td>
            </tr>
                <?php
                }
                ?>
          </tbody>
          <tfooter>
          <?php
                include('configuration/dbConnection.php');
                $select="select COUNT(*) AS total from listengins";
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
