<?php

if(isset($_POST["username"])&& isset($_POST["password"])){
  if($_POST["username"]=="user"&&$_POST["password"]="pass"){
      echo 'success';
   
  } else {
      echo 'error';    
  }
}  else {
echo 'error';    
}
