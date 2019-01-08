<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cars extends MX_Controller
{
    
    function __construct() {
        parent:: __construct();
 
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400'); // cache for 1 day
        }
    
        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
            exit(0);
        }
        $this->load->model("cars_model"); //CONNECT/USEMODEL
        $this->load->model("kaizalas_model");// ""
        $this->load->model("brands_model");
        
}
//function to load the brands
     function create_car(){//details entered
            //receive json post
            $json_string = file_get_contents("php://input");
           
            //convert json string  to array && encode cahngea to string
            $json_object = json_decode($json_string);
        
            //validate
            if(is_array($json_object) && (count($json_object)> 0)){
                //retieve data
                $row = $json_object[0];
                $data = array(
                    "seller_name" =>$row->sellername,
                    "date" =>$row->date,
                    "phone_number" =>$row->phonenumber,
                    "transmission" =>$row->transmission,
                    "price" =>$row->price,
                    "model" =>$row->model,
                    "brand" =>$row->brand,
                    "car_image	" =>$row->carimage
                );
                //request to submit /request to save data
               $saving =  $this->cars_model->save_cardetails($data);
               $subscribers = array($row->phonenumber);
              
               $message_fields = array(
                "model" =>$row->model,
                "brand" =>$row->brand,
                "price" =>$row->price,
                "car_image	" =>$row->carimage
               );
               $year = 2013;
               $message_description = $row->brand." ".$row->model." ".$year;

           
               if($saving == TRUE){
                   //send a confirmation
                   //
                   $messagetitle = " Post has been Accepted";
                   $status = "successful";


                   // echo "succesful";
               }else{
                   //echo "didnt work";
                   $messagetitle = "Your Post wasnt successful";
                   $status = " error";
               }
               $this->kaizalas_model->send_announcement($messagetitle, $message_description, $status, $date, $message_fields, $subscribers);
            }
            else {
                    echo " Invalid data/error occured somewhere";
            }
        
    }
}
?>