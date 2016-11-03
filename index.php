<?php
require_once('DataModel/Sabreinfo.class.php'); 
$limit =20;
$numpages=0;
$page=1;
$link=  7;
$result;
$getnum;
$total=0;
session_start(); 
$sabreinfo=new Sabreinfo();
$sabreinfo->islogged($_SESSION['Created']);
$_SESSION["selcountry"]="";
$_SESSION["selrate"]="";
$_SESSION["tablevalues"]=null;
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }
$offset=($page-1)*$limit;
//if(isset($_POST["cerca"])){
  

   
    if(isset($_GET["selcountry"])&&isset($_GET["selrate"])){
       $_SESSION["selcountry"]=$_GET["selcountry"];
    $_SESSION["selrate"]=$_GET["selrate"];
   
    $result=$sabreinfo->getData($_SESSION["selrate"],$_SESSION["selcountry"],$limit,$offset); 
   
    $getnum=$sabreinfo->getDatanum($_SESSION["selrate"],$_SESSION["selcountry"]);
     $_SESSION["tablevalues"]=$getnum;
    }else{
        $result=$sabreinfo->getData("","",$limit,$offset);    
        
        $getnum=$sabreinfo->getDatanum("","");
        $_SESSION["tablevalues"]=$getnum;
    }
//}  
    $_SESSION["selrate"]=  str_replace(" ","+", $_SESSION["selrate"]);
if($getnum){
$total= $getnum->RecordCount();}
//var_dump($_SESSION["tablevalues"]);
if(isset($_GET["download"])){
    $sabreinfo->SaveExcel($_SESSION["tablevalues"]);
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Report</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
                <style type="text/css">
                   /* body{
                       background-color: #eee!important;
                    }*/
                   .bootstrap-admin-navbar-under-small {
               top: 0px!important; 
               }
             
                </style>
                <link href="css/bootstrap-admin-theme.css" rel="stylesheet" type="text/css"/>
                <link href="css/newstyle.css" rel="stylesheet" type="text/css"/>
			<link href="css/styles.css" rel="stylesheet"/>
                <link href="css/bootstrap.min.css" rel="stylesheet"/>
                <link href="css/bootstrap-admin-theme-small.css" rel="stylesheet" type="text/css"/>
                <script src="js/jquery.js" type="text/javascript"></script>
                <script src="js/bootstrap.min.js" type="text/javascript"></script>
                <script src="js/moment-with-locales.js" type="text/javascript"></script>
                 <script src="js/bootstrap-datetimepicker.js" type="text/javascript"></script>
    </head>
    <body style="overflow-y: scroll;" >
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
     
        <!--<nav class="navbar  navbar-collapse"  role="navigation" >
            <div class="collapse navbar-collapse  " >
  


              <ul class="nav navbar-nav navbar-right text-center" >
                    
                  <li> <input type="button" value="Home"   class="btn btn-primary btn-block"  onclick="location.href = 'index.php'"  /></li>
                </ul>
            </div>
            <h1 class="text-muted"> Database Sabre al 12/11/2014</h1>
    </nav>-->
        
	<!--<h2 class="text-muted">View Dati</h2>-->
	<div class="container">
      <!--  <hr/>-->
      <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="text-muted bootstrap-admin-box-title">Database Sabre al 12/11/2014</div>
                                </div>
          <div class="bootstrap-admin-panel-content" style="
    padding-bottom: 21px;
">
        <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="reportForm" class="form-inline">
         <div class="form-group">
      <label for="sel1">Seleziona Rating </label>
      <select class="form-control" id="sel1" name="selrate">
          <option value="">Seleziona Rating</option>
          <option value="An Intimate Resort">An Intimate Resort</option>
        <option value=" Bay Head">Bay Head</option>
        <option value="1 CROWN">1 CROWN</option>
        <option value="2 CROWN">2 CROWN</option>
        <option value="3 CROWN">3 CROWN</option>
        <option value="4 CROWN">4 CROWN</option>
        <option value="5 CROWN">5 CROWN</option>
      </select>
      </div>
  <div class="form-group">
       <label for="sel2">Seleziona Stato </label>
      <select class="form-control" id="sel2" name="selcountry">
     <option value="">Seleziona Stato</option>
 <?php 
 $sabreinfo->islogged($_SESSION['Created']);
       $sabreinfo=new Sabreinfo();
       $rs=$sabreinfo->GetCountry();
       if ($rs) {
    while ($arr = $rs->FetchRow()) {

        echo "<option value=" . $arr[0] . ">" . $arr[0] . "</option> ";
    }
}
?>
      </select></div>
      
            <div class="form-group">
                <input type="submit" class="btn btn-default" name="cerca" value="Cerca" />
                </div> 
            <div class="form-group" style="float:right">
                <input type="submit" class="btn btn-primary" name="download" value="Scarica" />
                </div>
        </form>
        <br>
            <div class=" form-group">
                <table class="table table-striped table-condensed table-bordered table-rounded">
                        <thead>
                                <tr>
                                <th width="10%">Name</th>
                                <th width="10%">Rating</th>
                                <th width="10%">State</th>
                                <th width="10%">Country*</th>
                                <th width="10%">City*</th>
                                <th width="10%">Indirizzo*</th>
                                <th width="5%">Numero Piano</th>
                                <th width="5%">Numero di Camere</th>
                                <th width="5%">Servizi nelle vicinanza</th>
                                <th width="5%">Attivita</th>
                                <th width="5%">Sito Web</th>
                                <th width="5%">Mail</th>
                                <th width="10%">Details</th>
                               
                        </tr>
                        
                        </thead>
                    <tbody>   

     
     <?php 
  //   $i=0;
//var_dump($result);
     $total_records = $result->RecordCount();
     while($arr = $result->FetchRow()){ 
        // $i++;
         $atributti=  explode("<br>", $arr["atributes"]);
         $description=  explode("<br>", $arr["decription"]);
         $json =  json_decode(file_get_contents($arr["Indirizzo"]),true);
         echo "<tr>";            
         echo "<td width=\"10%\">".$arr ["name"]."</td>";
         echo "<td width=\"10%\">".$arr["rating"]."</td>";
         echo "<td width=\"10%\">".$arr ["state"]."</td>";
         if(count($json["results"])>0 ){
             if(count($json["results"][0]["address_components"])>5){
         echo "<td width=\"10%\">(".$arr ["country"].") ".$json["results"][0]["address_components"][5]["long_name"]."</td>"; 
             echo "<td width=\"10%\">".$json["results"][0]["address_components"][3]["long_name"]."</td>";}else{
                  echo "<td width=\"10%\">".$arr ["country"]."</td>";
          echo "<td width=\"10%\"></td>";
             }
         echo "<td width=\"10%\">".$json["results"][0]["formatted_address"]."</td>";}  else {
          echo "<td width=\"10%\">".$arr ["country"]."</td>"; 
          echo "<td width=\"10%\"></td>";
          echo "<td width=\"10%\"></td>";
}
         
         $nrpiani=$nrcamere=$attivita=$servizi=$sito=$mail="";
         foreach ($atributti as $desctizione){
                    $values=  explode(":", $desctizione);
                    if(str_replace(" ", "",$values[0])=="NBRFLOOR"){
                            $nrpiani=$values[1];
                        }else if(str_replace(" ", "",$values[0])=="NBRROOM"){
                            $nrcamere=$values[1];
                        }else if(str_replace(" ", "",$values[0])=="NEIGHB"){
                            $servizi=$values[1];
                        }else if(str_replace(" ", "",$values[0])=="URL"){
                        $sito=$values[1];
                    }
                       //echo'<tr><td>'.$sabreinfo->translate(str_replace(" ", "",$values[0])).'</td><td>'.$values[1].'</td></tr>';
                                  }
         foreach ($description as $d){
                    $val=  explode(":", $d);
                    if(str_replace(" ", "",$val[0])=="ATTRACT"){
                        $attivita=$val[1];
                    }
                    
                   // echo $sito.';';
         }
            echo "<td width=\"5%\">".$nrpiani."</td>"; 
            echo "<td width=\"5%\">".$nrcamere."</td>"; 
            echo "<td width=\"5%\">".$servizi."</td>"; 
            echo "<td width=\"5%\">".$attivita."</td>"; 
            echo "<td width=\"5%\">".$sito."</td>"; 
            echo "<td width=\"5%\"></td>"; 
            echo "<td width=\"10%\"><a href='details.php?id=".$arr ["id_sabre"]."&name=".$arr ["name"]."'>Details</a></td>";
         echo "</tr>"; 
     }?>
                    </tbody>       
                </table>
                   <?php  
           $sabreinfo->islogged($_SESSION['Created']);     
$total_pages = ceil($total / $limit);  
 $last       = ceil( $total /$limit );
 $paginationCtrls= "<ul class='pagination' style='float: right;'>";
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }
if($last != 1){
    if ($page > 1) {
        $previous = $page - 1;
        $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF']. '?selrate='.$_SESSION["selrate"].'&selcountry='.$_SESSION["selcountry"].'&page='.$previous.'">Previous</a> </li> ';
        
        for($i = $page-9; $i < $page; $i++){
            if($i > 0){
                 
                $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?selrate='.$_SESSION["selrate"].'&selcountry='.$_SESSION["selcountry"].'&page='.$i.'">'.$i.'</a> </li> ';
            }
        }
    }
    //$paginationCtrls .= ''.$page.'';
   // ?selrate=4+CROWN&selcountry=US 
// $_SESSION["selcountry"]="";
//$_SESSION["selrate"]="";
   
    for($i = $page+1; $i <= $last; $i++){
        
        $paginationCtrls .= '<li><a href="'.$_SERVER['PHP_SELF'].'?selrate='.$_SESSION["selrate"].'&selcountry='.$_SESSION["selcountry"].'&page='.$i.'">'.$i.'</a> </li>';
        if($i >= $page+9){
            break;
        }
    }
  
    if ($page != $last) {
        $next = $page + 1;
        $paginationCtrls .= ' <li> <a href="'.$_SERVER['PHP_SELF'].'?selrate='.$_SESSION["selrate"].'&selcountry='.$_SESSION["selcountry"].'&page='.$next.'">Next</a> </li>';
    }
} echo $paginationCtrls . "</ul>";
 
 
/*$pagLink = "<ul class='pagination'>";  
for ($i=1; $i<=$total_pages; $i++) {  
             $pagLink .= "<li><a href='index.php?page=".$i."'>".$i."</a></li>";  
}
echo $pagLink . "</ul>";*/ ?>
               <br> 

            </div></div>
     
      </div>
      <p style="color:blue">*-Google Map </p>
        </div>
    </body>
</html>
