<?php
require_once('connections/config.php');  
$msg='';
if(isset($_POST["Invia"])){

  if($_POST["username"]==login_user&&$_POST["password"]=login_pass){
 session_start();    
$_SESSION['Created'] = time(); 
header("Location: index.php");
   
  } else {
      $msg='Utente e Password e sbagliato';
  }
}else{
    $msg='Prego enter utente e password e poi clica su pulsante';
}  
?>
<!DOCTYPE html>
<html class="bootstrap-admin-vertical-centered">
    <head>
        <title>Login page</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap -->
        <link rel="stylesheet" media="screen" href="css/bootstrap.min.css">
        <link rel="stylesheet" media="screen" href="css/bootstrap-theme.min.css">

        <!-- Bootstrap Admin Theme -->
        <link rel="stylesheet" media="screen" href="css/bootstrap-admin-theme.css">

        <!-- Custom styles -->
        <style type="text/css">
            .alert{
                margin: 0 auto 20px;
            }
        </style>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
           <script type="text/javascript" src="js/html5shiv.js"></script>
           <script type="text/javascript" src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bootstrap-admin-without-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-info">
                        <a class="close" data-dismiss="alert" href="#" id="close2">&times;</a>
                        <text id="msg"><?php echo $msg; ?></text>
                    </div>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="bootstrap-admin-login-form" id="login">
                        <h1>Login</h1>
                        <div class="form-group">
                            <input class="form-control" type="text" name="username" placeholder="Utente" id="utente" required="">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" name="password" placeholder="Password" id="pass" required="">
                        </div>
                        <!--<div class="form-group">
                            <label>
                                <input type="checkbox" name="remember_me">
                                Remember me
                            </label>
                        </div>-->
                        <button class="btn btn-lg btn-primary" type="submit" name="Invia">Invia</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!--<script src="js/bootstrap.min.js" type="text/javascript"></script>-->
       <script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
        <script type="text/javascript">
       /*     $("#login").submit(function(event){
    // cancels the form submission
    event.preventDefault();
    submitLogin();
     });
     function submitLogin(){
        var username= $("#utente").val();
        var password= $("#pass").val();
        $.ajax({
        type: "POST",
        url: "processlogin.php",
        data: "username=" + username+ "&password=" + password ,
        success : function(text){
            if(text==='error'){
              $('#msg').text('utente e password e sbagliato'); 
              $('#close2').addClass('alert-danger');
            }else{
                window.location = "index.php";
            }
        }})
         
     }*/
            $(function() {
                // Setting focus
                $('input[name="username"]').focus();

                // Setting width of the alert box
                var alert = $('.alert');
                var formWidth = $('.bootstrap-admin-login-form').innerWidth();
                var alertPadding = parseInt($('.alert').css('padding'));

                if (isNaN(alertPadding)) {
                    alertPadding = parseInt($(alert).css('padding-left'));
                }

                $('.alert').width(formWidth - 2 * alertPadding);
            });
        </script>
    </body>
</html>
