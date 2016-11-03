<?php

include("/adodb5/adodb.inc.php");
 require_once('connections/dbConnect.class.php'); 

class Sabreinfo {  
   public $_db,$limit,$page,$links,$query,$total,$numpages;
   
   // $query      = "SELECT City.Name, City.CountryCode, Country.Code, Country.Name AS Country, Country.Continent, Country.Region FROM City, Country WHERE City.CountryCode = Country.Code";
           
        function __construct() {  
            $this->limit =25;
            $this->numpages=0;
            $this->page=1;
            $this->links=  7;
          
            // connecting to database  
            $db = new dbConnect();
            $this->_db=$db->getConnection();
        /* @var $rs type */
           
          //  $this->total =$rs->RecordCount();
        } 
        
        public function getData($rating="",$country="",$limit,$offset) {
            //echo $rating.';'.$country.';';
            $sql="";
            if($rating==""&&$country==""){
                $sql.="SELECT *
        FROM (
           SELECT si.[name],si.[rating],si.[state] ,si.[country],si.[id_sabre],'https://maps.googleapis.com/maps/api/geocode/json?address='+REPLACE(SUBSTRING(sa.textdata,9,CHARINDEX('<br>',sa.textdata)-10),' ','+')+'&bounds='+si.latitudine+','+si.longitudine+'&sensor=false' as Indirizzo , ROW_NUMBER() OVER (ORDER BY si.[id_sabre]) AS x,sa.textdata as atributes,sd.textdata as decription
           from sabre_info si inner join sabre_attributi sa on si.id_sabre=sa.id_sabre inner join sabre_desc sd on si.id_sabre=sd.id_sabre
        ) AS y
        WHERE y.x BETWEEN ".$offset." AND ".($offset+$limit)." ORDER BY y.x ;";
                //$sql.="SELECT Top 100  [name],[rating],[state] ,[country],[id_sabre]   FROM [sabre_info];";
            }
            if($rating!=""&&$country==""){
                   $sql.="SELECT *
        FROM (
           SELECT si.[name],si.[rating],si.[state] ,si.[country],si.[id_sabre],'https://maps.googleapis.com/maps/api/geocode/json?address='+REPLACE(SUBSTRING(sa.textdata,9,CHARINDEX('<br>',sa.textdata)-10),' ','+')+'&bounds='+si.latitudine+','+si.longitudine+'&sensor=false' as Indirizzo, ROW_NUMBER() OVER (ORDER BY si.[id_sabre]) AS x,sa.textdata as atributes,sd.textdata as decription
           from sabre_info si inner join sabre_attributi sa on si.id_sabre=sa.id_sabre inner join sabre_desc sd on si.id_sabre=sd.id_sabre WHERE si.[rating] LIKE '%".$rating."%'
        ) AS y
        WHERE y.x BETWEEN ".$offset." AND ".($offset+$limit)." ORDER BY y.x ;";
              //  $sql.="SELECT Top 20  [name],[rating],[state] ,[country],[id_sabre]   FROM [sabre_info] WHERE [rating] LIKE '%".$rating."%';";
            }
             if($country!=""&&$rating==""){
                      $sql.="SELECT *
        FROM (
           SELECT si.[name],si.[rating],si.[state] ,si.[country],si.[id_sabre],'https://maps.googleapis.com/maps/api/geocode/json?address='+REPLACE(SUBSTRING(sa.textdata,9,CHARINDEX('<br>',sa.textdata)-10),' ','+')+'&bounds='+si.latitudine+','+si.longitudine+'&sensor=false' as Indirizzo, ROW_NUMBER() OVER (ORDER BY si.[id_sabre]) AS x,sa.textdata as atributes,sd.textdata as decription
           from sabre_info si inner join sabre_attributi sa on si.id_sabre=sa.id_sabre inner join sabre_desc sd on si.id_sabre=sd.id_sabre WHERE si.[state] ='".$country."'
        ) AS y
        WHERE y.x BETWEEN ".$offset." AND ".($offset+$limit)." ORDER BY y.x ;";
               //$sql.="SELECT Top 20  [name],[rating],[state] ,[country],[id_sabre]   FROM [sabre_info] WHERE [country] ='".$country."';";
            }
            if($rating!=""&&$country!=""){
                      $sql.="SELECT *
        FROM (
           SELECT si.[name],si.[rating],si.[state] ,si.[country],si.[id_sabre],'https://maps.googleapis.com/maps/api/geocode/json?address='+REPLACE(SUBSTRING(sa.textdata,9,CHARINDEX('<br>',sa.textdata)-10),' ','+')+'&bounds='+si.latitudine+','+si.longitudine+'&sensor=false' as Indirizzo, ROW_NUMBER() OVER (ORDER BY si.[id_sabre]) AS x,sa.textdata as atributes,sd.textdata as decription
           from sabre_info si inner join sabre_attributi sa on si.id_sabre=sa.id_sabre inner join sabre_desc sd on si.id_sabre=sd.id_sabre WHERE si.[rating] LIKE '%".$rating."%' and si.[state] ='".$country."'
        ) AS y
        WHERE y.x BETWEEN ".$offset." AND ".($offset+$limit)." ORDER BY y.x ;";
                //$sql.="SELECT Top 20  [name],[rating],[state] ,[country],[id_sabre]   FROM [sabre_info] WHERE [rating] LIKE '%".$rating."%' and [country] ='".$country."';";
               // $sql.=" SELECT Top 20  [name],[rating],[state] ,[country],[id_sabre]   FROM [sabre_info] WHERE [rating] LIKE '%".$rating."%' and [country] ='.$country.';";
            }
            //echo $sql;
            $this->_db->SetFetchMode(ADODB_FETCH_BOTH);
      $rs = $this->_db->Execute($sql);
      return $rs;
        }
        
         public function getDatanum($rating="",$country="") {
            //echo $rating.';'.$country.';';
            $sql="";
            if($rating==""&&$country==""){
         
                $sql.=" SELECT si.[name],si.[rating],si.[state] ,si.[country],si.[id_sabre],
                        sa.textdata as atributes,sd.textdata as decription,si.latitudine,si.longitudine 
                        from sabre_info si inner join sabre_attributi sa on si.id_sabre=sa.id_sabre inner join sabre_desc sd on si.id_sabre=sd.id_sabre ";
            }
            if($rating!=""&&$country==""){
                $sql.="  SELECT si.[name],si.[rating],si.[state] ,si.[country],si.[id_sabre],
                        sa.textdata as atributes,sd.textdata as decription,si.latitudine,si.longitudine
                        from sabre_info si inner join sabre_attributi sa on si.id_sabre=sa.id_sabre inner join sabre_desc sd on si.id_sabre=sd.id_sabre WHERE si.[rating] LIKE '%".$rating."%';";
            }
             if($country!=""&&$rating==""){
               $sql.="  SELECT si.[name],si.[rating],si.[state] ,si.[country],si.[id_sabre],
                        sa.textdata as atributes,sd.textdata as decription,si.latitudine,si.longitudine
                        from sabre_info si inner join sabre_attributi sa on si.id_sabre=sa.id_sabre inner join sabre_desc sd on si.id_sabre=sd.id_sabre WHERE si.[state] ='".$country."';";
            }
            if($rating!=""&&$country!=""){
                $sql.=" SELECT si.[name],si.[rating],si.[state] ,si.[country],si.[id_sabre],
                        sa.textdata as atributes,sd.textdata as decription,si.latitudine,si.longitudine
                        from sabre_info si inner join sabre_attributi sa on si.id_sabre=sa.id_sabre inner join sabre_desc sd on si.id_sabre=sd.id_sabre WHERE si.[rating] LIKE '%".$rating."%' and si.[state] ='".$country."';";
            }
            
            $this->_db->SetFetchMode(ADODB_FETCH_BOTH);
      $rs = $this->_db->Execute($sql);
      return $rs;
        }
           
       public function GetRates(){
        $sql="SELECT Distinct [rating] FROM sabre_info ;";
             
            $rs = $this->_db->Execute($sql);
             return $rs;
           
       }
       
        public function GetCountry(){
            $null="''";
        $sql=" SELECT Distinct [state] FROM sabre_info   WHERE [state]!=$null ORDER BY [state] ";
        //echo $sql;     
            $rs = $this->_db->Execute($sql);
             return $rs;
           
       }
       
       public function Getattribus_and_description($id) {
           $sql=" SELECT  c.name,c.rating,c.state,c.country, a.textdata,b.textdata
                  FROM sabre_attributi a inner join sabre_desc b on a.id_sabre=b.id_sabre inner join sabre_info c on a.id_sabre=c.id_sabre
                  WHERE a.id_sabre=$id ;"; 
            $rs = $this->_db->Execute($sql);
             return $rs;
       }
       
       public function translate($param) {
          $tradure=""; 
           switch ($param) {
    case "ADDR1":
      $tradure="Indirrizo";
        break;
    case "CITY":
       $tradure="Citta";
        break;
     case "FAMILYRM":
       $tradure="Family Room";
        break;
     case "GEOLAT":
       $tradure="Latitude";
        break;
     case "GEOLNG":
       $tradure="Longtitude";
        break;
     case "NBRFLOOR":
       $tradure="Numero Piano";
        break;
     case "NBRROOM":
       $tradure="Numero di Camere";
        break;
     case "NEIGHB":
       $tradure="Servizi nelle vicinanza";
        break;
     case "PARKING":
       $tradure="Parchegio";
        break;
     case "PHONE":
       $tradure="Numero di telefono";
        break;
    case "POSTCD":
       $tradure="Cap";
        break;
    case "TAX1":
       $tradure="Tasse";
        break;
    case "URL":
       $tradure="Sito web";
        break;
    case "ATTRACT":
       $tradure="Attivita";
        break;
    case "AWARD":
       $tradure="Premio";
        break;
    case "CANCEL":
       $tradure="Cancelazione";
        break;
    case "CORPLOC":
       $tradure="Lacazione di Azienda";
        break;
     case "CHKIN":
       $tradure="CheckIn";
        break;
    case "CHKOUT":
       $tradure="CheckOut";
        break;
     case "FAX":
       $tradure="Fax";
        break;
    default:
        $tradure=$param;
} return $tradure;
       }
       
       public function islogged($time) {
            if  (time() - $time > 1800) {
        session_unset();     
        session_destroy();   
        header("Location: login.php");
        }
       }
       
       public function SaveExcel($result) {
           //var_dump($result);
		$out="";
		set_time_limit(2500);
		$filename = "reports".date('m_d').".csv";
		
		$out.="Name;Rating;State;Country*;City*;Indirizzo*;Numero Piano;Numero di Camere;Servizi nelle vicinanza;Attivita;Sito Web;Mail\r\n";

		while($arr = $result->FetchRow()){
                        $atributti=  explode("<br>", $arr["atributes"]);
                        $description=  explode("<br>", $arr["decription"]);
                         $nrpiani=$nrcamere=$attivita=$servizi=$sito=$mail=$address="";
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
                                       }else if(str_replace(" ", "",$values[0])=="ADDR1"){
                                           $address=$values[1];
                                       }
                       //echo'<tr><td>'.$sabreinfo->translate(str_replace(" ", "",$values[0])).'</td><td>'.$values[1].'</td></tr>';
                                  }
                        foreach ($description as $d){
                                   $val=  explode(":", $d);
                                   if(str_replace(" ", "",$val[0])=="ATTRACT"){
                                       $attivita=$val[1];
                                   }


                        }
                        $indirizzo='https://maps.googleapis.com/maps/api/geocode/json?address='.str_replace(" ", "+",trim($address)).'&bounds='.$arr ["latitudine"].','.$arr ["longitudine"].'&sensor=false';
                       //echo $indirizzo.';';
                         $json =  json_decode(file_get_contents($indirizzo),true);    
                
			$out.="\"".$arr ["name"]
			."\";\"".$arr["rating"]
			."\";\"".$arr ["state"];
                       if(count($json["results"])>0 ){
                        if(count($json["results"][0]["address_components"])>5){
                        $out.="\"".$arr ["country"].") ".$json["results"][0]["address_components"][5]["long_name"] 
                        ."\";\"".$json["results"][0]["address_components"][3]["long_name"];}
                        else{
                        $out.$arr ["country"]
                        ."\";\"\";";
                        }
                        $out.="\"".$json["results"][0]["formatted_address"];}  
                        else {
                       $out.="\"".$arr ["country"] 
                        ."\";\""."\";\"";
                       }
          
         
			$out."\";\"".$nrpiani
			
			."\";\"".$nrcamere
			."\";\"".$servizi
			."\";\"".$attivita
			."\";\"".$sito
			."\";\"".$mail."\"\r\n";
			
		}
		echo $out;
		/*header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		echo $out;
		$file = fopen('php://output','w');
		exit;*/
	} 
       
        }

       


