<?php
    session_start();
    require'include/header.php';
    include('function/function.php');
    include('function/constante.php');
    include('configuration/dbConnection.php');
    if(!isset($_SESSION['user_id']))
    {
        redirect('../log.php');
    }
      
?>
<?php
if (isset($_POST['send']))
    {
        extract($_POST);
        $insert="INSERT INTO `affectation`( `id_engins`, `lieu_affetation`, `delai`, `date_de_sortie`, `date_de_retour`, `datee` )
        VALUES ('$number', '$lieu', '$duree', '$date_de_sortie', '$date_de_retour',NOW() )";
        $run_query=mysqli_query($connect,$insert);
?>
<?php
if ($run_query)
    {

        set_flash("enregistrer avec seccuss");
        extract($_POST);
        $insert="UPDATE `listengins` SET `Emplacement`='$lieu' WHERE `number`='$number'";
        $run_query=mysqli_query($connect,$insert);
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
    <h1 class="h2">Mont Gabaon Affectation</h1>
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

	<form method="POST" action="affectation.php" enctype="multipart/form-data">
    <div class="row mb-3 mt-3">
    <div class="col-md-3 col-sm-6">
        <label>Immmatriculation de l'engin</label>
        <select value="number"name="number" class="form-control" required>
        <?php
                include('configuration/dbConnection.php');
                $select="select * from listengins";
                $run_query=mysqli_query($connect,$select);
                while($row=mysqli_fetch_assoc($run_query))
                {
        ?>
            <option value="<?php echo $row['number'];?>"><?php echo $row['number'];?></option>
                <?php
                }
                ?>
        </select>
    </div>

    <div class="col-md-3 col-sm-6">
        <label>Lieu d'affectaction</label>
        <select name="lieu" class="form-control" required>
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
        <label>Duree de location</label>
        <input type="number" class="form-control" placeholder="Entrez la duree de la location" name="duree" >
        </div>
    <div class="col-md-3 col-sm-6">
        <label>Date de sortie</label>
        <input type="date" class="form-control" placeholder="indiquez la date de sortie de l'engin" name="date_de_sortie" required>
    </div>
    </div>
    <div class="row mb-3 mt-3">
    <div class="col-md-4 mt-3">
        <label>Date de Retour</label>
        <input type="date" class="form-control" placeholder="indiquez le jour" name="date_de_retour" required>
        </div>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit"value="send" name="send">Affecter</button>
</form>
        </br>
        <?php
        include('parial/flash.php');
        ?>
<h2>Liste des affectations d'Engins</h2>

    <div class="table-responsive "style="display:block; height:400px; overflow: auto;" >
        <table class="table table-striped table-sm table-bordered">
        <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Immmatriculation</th>
            <th>Lieu d'affectation</th>
            <th>Duree de la loaction</th>
            <th>Date de sortie</th>
            <th>Date du retour</th>
            <th>Enregistrer le</th>
            <th>Action</th>
            </tr>
        </thead>
        <!-- style="display:block; height:200px; overflow: auto;" -->

        <?php
            include('configuration/dbConnection.php');
                 $select="select * from affectation ORDER BY id DESC";
                $run_query=mysqli_query($connect,$select);
                while($row=mysqli_fetch_assoc($run_query))
                {
            ?>
        <tbody >

        <tr>
            <td><?php echo $row['id'];?></td>
            <td><?php echo $row['id_engins'];?></td>
            <td><?php echo $row['lieu_affetation'];?></td>
            <td><?php echo $row['delai'];?></td>
            <td><?php echo $row['date_de_sortie'];?></td>
            <td><?php echo $row['date_de_retour'];?></td>
            <td><?php echo $row['datee'];?></td>
            <td><a class="btn btn-primary"href="include/edit1.php?id=<?php echo $row['id'];?>">Edit</a><a class="btn btn-danger"href="include/delete1.php?id=<?php echo $row['id'];?>">Delete</a></td>
            </tr>
                <?php
                }
                ?>
        </tbody>
        <tfooter>
        <?php
                include('configuration/dbConnection.php');
                $select="select COUNT(*) AS total from affectation ";
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
