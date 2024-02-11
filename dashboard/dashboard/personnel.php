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
        if (is_already_in_use('nom', $name, 'personnel'))
        {
            set_flash("ce nom est deja utiliser est deja utiliser!",'danger');
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
                    if($imgSize>5000000){
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
        $insert="INSERT INTO `personnel`(`nom`, `poste`, `sexe`, `numero`, `photo`, `date`)
        VALUES ( '$name', '$fonction', '$sexe', '$number', '$userpic', NOW())";
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
      <h1 class="h2">Mont Gabaon New Personnel</h1>
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

	<h5>Veiller Ajouter un personnel</h5>

	<form method="POST" action="personnel.php" enctype="multipart/form-data">
    <div class="row mb-3 mt-3">
      <div class="col-md-3 col-sm-6">
        <label>Nom Complet</label>
        <input type="text" class="form-control" placeholder="Entrer le nom complet du personnel" name="name" required>
      </div>

      <div class="col-md-3 col-sm-6">
        <label>Numero de telephone</label>
        <input type="text" class="form-control" placeholder="Entrez Numero de telephone" name="number" required>
      </div>

      <div class="col-md-3 col-sm-6">
        <label>Fonction</label>
        <input type="text" class="form-control" placeholder="Entrez la fonction" name="fonction" >
      </div>

      <div class="col-md-3 col-sm-6">
        <label>Inserez une image</label>
        <input type="file" class="form-control" placeholder="entrez l'image" name="photo" required>
      </div>
    </div>
    <div class="row mb-3 mt-3">
      <div class="col-md-4 mt-3">
        <label>Sexe</label>
        <select name="sexe" class="form-control" required>
            <option value="Masculin">Musculin</option>
            <option value="Feminin">Feminin</option>
        </select>
      </div>
</div>
		<button class="btn btn-lg btn-primary btn-block" type="submit"value="send" name="send">Ajouter</button>
	</form>
  </br>
      <?php
        include('parial/flash.php');
        ?>
<h2>Liste des personnels</h2>
      <div class="table-responsive "style="display:block; height:400px; overflow: auto;" >
        <table class="table table-striped table-sm table-bordered">
        <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>Noms</th>
              <th>Poste</th>
              <th>Sexe</th>
              <th>Numero de telephone</th>
              <th>Photo</th>
              <th>Date d'enrgistrement</th>
              <th>Action</th>
            </tr>
          </thead>
          <!-- style="display:block; height:200px; overflow: auto;" -->

            <?php
                include('configuration/dbConnection.php');
                 $select="select * from personnel ORDER BY id DESC";
                $run_query=mysqli_query($connect,$select);
                while($row=mysqli_fetch_assoc($run_query))
                {
            ?>
          <tbody >

            <tr>
              <td><?php echo $row['id'];?></td>
              <td><?php echo $row['nom'];?></td>
              <td><?php echo $row['poste'];?></td>
              <td><?php echo $row['sexe'];?></td>
              <td><?php echo $row['numero'];?></td>
              <td><img src="user_images/<?php echo $row["photo"]; ?>" width = 100 title="<?php echo $row['photo']; ?>"> </td>
              <td><?php echo $row['date'];?></td>
              <td><a class="btn btn-primary"href="include/edit1.php?id=<?php echo $row['id'];?>">Edit</a><a class="btn btn-danger"href="include/delete1.php?id=<?php echo $row['id'];?>">Delete</a></td>
            </tr>
                <?php
                }
                ?>
          </tbody>
          <tfooter>
          <?php
                include('configuration/dbConnection.php');
                $select="select COUNT(*) AS total from personnel";
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
