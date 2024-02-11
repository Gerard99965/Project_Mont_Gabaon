<?php
session_start();
  include('dashboard/dashboard/function/function.php');
  include('dashboard/dashboard/function/constante.php');
  include('dashboard/dashboard/configuration/dbConnection.php');
  include('dashboard/dashboard/configuration/connection.php');
?>
<?php
    if(isset($_POST['log']))
    {
      extract($_POST);
      if(not_empty(['email'],['password']))
      {
        $errors=[];
        $connect=$bdd->prepare("SELECT `id`,`user_name`,`email`,`password`  FROM `user_table` where  (`email`=:email) and `password`=:password ");
        $connect->execute(array(
            'email'=>$email,
            'password'=>sha1($password)));
    $userHasBeenFound = $connect->rowCount();  
            if($userHasBeenFound)
             {
              $user=$connect->fetch(PDO::FETCH_OBJ);
              
               $_SESSION['user_id']=$user->id;
               $_SESSION['user_name']=$user->user_name;
               set_flash("conneted successefull",'success');
               redirect('dashboard/dashboard/new_engin.php?id='.$user->id);
               
    
            } 
            else {
                set_flash('identifiant/password incorrect', 'danger');
                save_input_data();
            }
            
            $connect->closeCursor();
      }
    }
    if(isset($_POST['create']))
    {
      if(not_empty(['user_name'],['password'],['email']))
      {
        extract($_POST);
        if (is_already_in_use('email', $email, 'user_table'))
        {
            set_flash("cet email est deja utiliser est deja utiliser!",'danger');
        }
        else
        {
          $passwordtrue=sha1($password);
          $insert="INSERT INTO `user_table`(`user_name`, `email`, `password`, `date`)
          VALUES ('$user_name','$email','$passwordtrue',NOW())";
          $run_query=mysqli_query($connect,$insert);
          if($run_query)
          {
            set_flash("enregistrer avec seccuss");
            header('location: log.php');
          }
          else
          {
            set_flash("erreur d enregistrement", 'danger');
          }
        }

      }      
    }
   
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- BOX ICONS -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"
    />

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/styles.css" />

    <title>Mont Gabaon Login</title>
  </head>
  <body>
    <div class="login">
      <div class="login__content">
        <div class="login__img">
          <img src="assets/img/img-login.svg" alt="img-login.svg" />
        </div>
        <div class="login__forms">
          <!-- sign in -->
          <form method="POST"action="log.php" class="login__register" id="login-in">
            <h1 class="login__title">Sign</h1>
            <?php
        include('dashboard/dashboard/parial/flash.php');
        ?>
        <?php
                       include('dashboard/dashboard/parial/error.php');
                        ?>
            <div class="login__box">
              <i class="bx bx-user login__icon"></i>
              <input type="text" placeholder="email" name="email" class="login__input" />
            </div>
            <div class="login__box">
              <i class="bx bx-lock login__icon"></i>
              <input
                type="password"
                placeholder="Password"
                class="login__input"
                name="password"
              />
            </div>
            <a href="#" class="login__forgot">Forgot password?</a>
            <button class="login__button" type="submit" name="log">Sign In</button>
            <div>
              <span class="login__account">Don't have an Account?</span>
              <!-- <span class="login__signin" id="sign-up">Sign Up</span> -->
            </div>
          </form>

          <!-- sign up  -->
          <form action="log.php"  method="POST" class="login__create none" id="login-up">
            <h1 class="login__title">Create Account</h1>
            <div class="login__box">
              <i class="bx bx-user login__icon"></i>
              <input type="text" placeholder="Username" name="user_name" class="login__input" required/>
            </div>
            <div class="login__box">
              <i class="bx bx-lock login__icon"></i>
              <input type="text" placeholder="Email"name="email" class="login__input" required />
            </div>
            <div class="login__box">
              <i class="bx bx-at login__icon"></i>
              <input
                type="password"
                placeholder="Password"
                class="login__input"
                name="password"
                required
              />
            </div>
            <button class="login__button" type="submit" name="create">Sign Up</button>
            <div>
              <span class="login__account">Already have an Account?</span>
              <span class="login__signup" id="sign-in">Sign In</span>
            </div>
            <div class="login__social">
              <a href="#" class="login__social-icon"
                ><i class="bx bxl-facebook"></i
              ></a>
              <a href="#" class="login__social-icon"
                ><i class="bx bxl-twitter"></i
              ></a>
              <a href="#" class="login__social-icon"
                ><i class="bx bxl-google"></i
              ></a>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="assets/js/main.js"></script>
  </body>
</html>
