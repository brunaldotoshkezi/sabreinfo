<?php
require_once('DataModel/Sabreinfo.class.php'); 
$name="";
$id=0;
session_start();
if(isset($_GET["name"])){
    $name=$_GET["name"];
}
if(isset($_GET["id"])){
    $id=$_GET["id"];
}
$fileesiste=array('ADVRES','CARRENTL','GEOLVL','NAME','PRIINDX','RT','USFIRE');
$sabreinfo=new Sabreinfo();

$sabreresult=$sabreinfo->Getattribus_and_description($id);

$sabreinfo->islogged($_SESSION['Created']);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Details</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
                <style type="text/css">
                
                    .bs-example {
    margin-right: 0;
    margin-left: 0;
    background-color: #fff;
    border-color: #ddd;
    border-width: 1px;
    border-radius: 4px 4px 0 0;
    -webkit-box-shadow: none;
    box-shadow: none;}
                    #map {
        height: 100%;
      }
                    
                </style>
                <link href="../ContattiCliente/css/styles.css" rel="stylesheet" type="text/css"/>
                <link href="css/bootstrap-admin-theme.css" rel="stylesheet" type="text/css"/>
		<link href="css/styles.css" rel="stylesheet">
                <link href="css/newstyle.css" rel="stylesheet" type="text/css"/>
                <link href="css/bootstrap.min.css" rel="stylesheet">
                <!--<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
                <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />		
                <script src="js/jquery.js" type="text/javascript"></script>
                <script src="js/bootstrap.min.js" type="text/javascript"></script>
                <script src="js/moment-with-locales.js" type="text/javascript"></script>
                <script src="js/bootstrap-datetimepicker.js" type="text/javascript"></script>-->
        
    </head>
    <body style="overflow-y: scroll;">
          <nav class="navbar navbar-default navbar-fixed-top bootstrap-admin-navbar bootstrap-admin-navbar-under-small" role="navigation">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".main-navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                          </button>
                            <a class="navbar-brand" href="index.php">Admin Panel</a>
                        </div>
                           <div class="collapse navbar-collapse main-navbar-collapse">
                            <ul class="nav navbar-nav navuser">
                             <div class="dropdown">
                                   <button class="btn btn-default user dropdown-toggle" type="button" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> xenihs <i class="caret"></i></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="logout.php">Logout</a></li>
                                    </ul>
                                     </div>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div><!-- /.container -->
        </nav>
        <div class="container">
            <h3 class="text-muted"><?php echo $name;?></h3>
	<hr/>
               <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="text-muted bootstrap-admin-box-title">Detail</div>
                                </div>
          <div class="bootstrap-admin-panel-content" style="
    padding-bottom: 40px;
">
            <form class="form-horizontal">
                 <?php 
        $total_records = $sabreresult->RecordCount();
        $lat="";
        $log="";
        $citta="";
        $address="";
        if($total_records>0){
             while($arr = $sabreresult->FetchRow()){
                 //echo '<div class="bs-example">';
                 //echo '<div class="form-group"><label  class="col-sm-2 control-label">Name</label><div class="col-sm-10"> <p class="form-control-static">'.$arr[0].'</p></div> </div>';
                 echo '  <table class="table table-striped table-condensed table-bordered table-rounded">';
                 echo '<tbody>';
                 echo'<tr><td>Stelle</td><td>'.$arr[1].'</td></tr>';
                 echo'<tr><td>Stato</td><td>'.$arr[2].'</td></tr>';
                 echo'<tr><td>Paese</td><td>'.$arr[3].'</td></tr>';
                  $atributti=  explode("<br>", $arr[4]);
                //var_dump($atributti);
                  
                foreach ($atributti as $desctizione){
                    $values=  explode(":", $desctizione);
                    //var_dump($values);
                    if(!in_array(str_replace(" ", "",$values[0]), $fileesiste)){
                        if(str_replace(" ", "",$values[0])=="ADDR1"){
                            $address=$values[1];
                        }else if(str_replace(" ", "",$values[0])=="CITY"){
                           $citta=$values[1]; 
                        }else if(str_replace(" ", "",$values[0])=="GEOLAT"){
                            $lat=$values[1];
                        }else if(str_replace(" ", "",$values[0])=="GEOLNG"){
                            $log=$values[1];
                        }
                       echo'<tr><td>'.$sabreinfo->translate(str_replace(" ", "",$values[0])).'</td><td>'.$values[1].'</td></tr>';
                   // echo '<div class="form-group"><label  class="col-sm-2 control-label">'.$sabreinfo->translate(str_replace(" ", "",$values[0])).'</label><div class="col-sm-10"> <p class="form-control-static">'.$values[1].'</p></div> </div>';
                }} 
                  $desc=  explode("<br>", $arr[5]);
                //var_dump($desc);
                foreach ($desc as $d){
                    $val=  explode(":", $d);
                    //echo $val[0];
                    if(count($val)>0){
                    echo'<tr><td>'.$sabreinfo->translate(str_replace(" ", "",$val[0])).'</td><td>'.$val[1].'</td></tr>';}
                    //echo '<div class="form-group"><label  class="col-sm-2 control-label">'.$sabreinfo->translate(str_replace(" ", "",$val[0])).'</label><div class="col-sm-10"> <p class="form-control-static">'.$val[1].'</p></div> </div>';
                }
               // echo "<tr><td colspan='2'><div id=\"map\" style=\"width:100%;height:500px;\"></div></td></tr>";
                 echo '</tbody>';
                 echo '</table>';
                 //echo $address.";".$citta.";".$lat.";".$log.";";
               
             }
        }?>
                
           </form>
              <br>
                
  
        <a href="index.php" class="btn btn-default" style="float: right">Indietro</a>
          </div></div>
         <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="text-muted bootstrap-admin-box-title">il Locazione</div>
                                </div>
          <div class="bootstrap-admin-panel-content" >
              <div id="map" style="width:100%;height:500px;"></div></div></div>
        </div>
        </form>
        <br>
        <br>

  

            
<script>
        
function initMap() {
    var vlat="<?php echo $lat; ?>";
    var vlog="<?php echo $log; ?>";
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 15,
    center: {lat: vlat, lng: vlog}
  });
  var geocoder = new google.maps.Geocoder();

  /*document.getElementById('submit').addEventListener('click', function() {*/
    geocodeAddress(geocoder, map);
  /*});*/
}

function geocodeAddress(geocoder, resultsMap) {
    var address='<?php echo $address.",".$citta; ?>'
  //var address = '100 E SECOND STREET,TULSA';
  geocoder.geocode({'address': address}, function(results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      resultsMap.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
        map: resultsMap,
        position: results[0].geometry.location
      });
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

    </script>

    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCorjNxSe9DVlWztKQqXAI1Om6S0_5u_LY&signed_in=true&callback=initMap"
        async defer></script>
    </body>
</html>