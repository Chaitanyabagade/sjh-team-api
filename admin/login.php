<?php
     header('Access-Control-Allow-Origin: *');
    
        $name=$_POST['name'];
        $mobile=$_POST['mobile'];
        $pass=$_POST['pass'];
        $outp="";
     
        if($name==='chaitanya bagade' && $pass==='Chaitanya@701' && $mobile==="9307084680"){  // change this 
            http_response_code(200);
            $team='chaitanya';                             // change this allso 
            $outp.='{"mobile_no":"'.$mobile.'",';
            $outp.='"user_name":"'.$name.'",';
            $outp.='"team":"'.$team.'",';
            $outp.='"Status":"200"}';
            echo $outp;
            
        }   
        else if($name==='tushar regude' && $pass==='Tushar@303' && $mobile==="9370575370"){  // change this 
            http_response_code(200);
            $team='tushar';                             // change this allso 
            $outp.='{"mobile_no":"'.$mobile.'",';
            $outp.='"user_name":"'.$name.'",';
            $outp.='"team":"'.$team.'",';
            $outp.='"Status":"200"}';
            echo $outp;
            
        }   
        
        else if($name==='onkar zendekar' && $pass==='Onkar@999' && $mobile==="9075648109"){  // change this 
            http_response_code(200);
            $team='onkar';                             // change this allso 
            $outp.='{"mobile_no":"'.$mobile.'",';
            $outp.='"user_name":"'.$name.'",';
            $outp.='"team":"'.$team.'",';
            $outp.='"Status":"200"}';
            echo $outp;
            
        }     
        
        else{
            echo $outp;
        }
     
?>