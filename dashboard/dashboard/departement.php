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
if (isset($_POST['add']))
    {
        extract($_POST);
        $insert="INSERT INTO `departement`(`name`, `datee`)
        VALUES ( '$name',NOW() )";
        $run_query=mysqli_query($connect,$insert);
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
        <h1 class="h2">Mont Gabaon Nom du departement</h1>
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
	<h5>Veiller Ajouter un departement</h5>
	<form method="POST" action="departement.php" enctype="multipart/form-data">
        <div class="row mb-3 mt-3">
            <div class="col-md-3 col-sm-6">
            <label>Nom du departement</label>
            <input type="text" class="form-control" placeholder="Entrez le nom du departement" name="name" required>
    </div>
    </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit"value="add" name="add">Affecter</button>
    </form>
    </br>

    <?php
        include('parial/flash.php');
    ?>

<h2>Liste des Lieux</h2>

    <div class="table-responsive "style="display:block; height:400px; overflow: auto;" >
        <table class="table table-striped table-sm table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom du departement</th>
                    <th>Date d'enregistrement</th>
                    <th>Action</th>
                </tr>
            </thead>
<!-- style="display:block; height:200px; overflow: auto;" -->

            <?php
                include('configuration/dbConnection.php');
                 $select="select * from departement ORDER BY id DESC";
                $run_query=mysqli_query($connect,$select);
                while($row=mysqli_fetch_assoc($run_query))
                {
            ?>
            <tbody >
            <tr>
                <td><?php echo $row['id'];?></td>
                <td><?php echo $row['name'];?></td>
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
                $select="select COUNT(*) AS total from departement ";
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