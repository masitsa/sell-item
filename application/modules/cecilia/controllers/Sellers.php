<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sellers extends MX_Controller
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
        $this->load->model("sellers_model"); //CONNECT/USEMODEL
        $this->load->model("kaizalas_model");// ""
}
//function to load the brands
     function create_seller(){//details entered
            //receive json post
            $json_string = file_get_contents("php://input");
            // $json_string = '[
            //     {
            //       "sellername": "Cecilia",
            //       "date": "1545233460000",
            //       "phonenumber": "0875214",
            //       "transmission": "Vjvvb",
            //       "price": "Bjjj",
            //       "model": "Hhvv",
            //       "brand": "8666",
            //       "carimage": "https://cdn.inc-000.kms.osi.office.net/att/1d36e0c05e0d1e692c8020feeec517e8db2af3330e830b5ae1f972c36109dab2.jpg?sv=2015-12-11&sr=b&sig=bI0QQjXvAOhoJHMMTvstf2TReDBECG08vieW86b0g9o%3D&st=2018-12-19T14:32:02Z&se=2292-10-03T15:32:02Z&sp=r"
            //     }
            //   ]';
            //convert json string  to array
            $json_object = json_decode($json_string);
        
            //validate
            if(is_array($json_object) && (count($json_object)> 0)){
                //retieve data
                $row = $json_object[0];
                $data = array(
                    "seller_name" =>$row->sellername,
<<<<<<< HEAD
                    "Date" =>$row->date,
                    "phone_number" =>$row->phonenumber,
                    "Transmission" =>$row->transmission,
                    "Price" =>$row->price,
                    "Model" =>$row->model,
                    "Brand" =>$row->brand,
=======
                    "date" =>$row->date,
                    "phone_number" =>$row->phonenumber,
                    "transmission" =>$row->transmission,
                    "price" =>$row->price,
                    "model" =>$row->model,
                    "brand" =>$row->brand,
>>>>>>> 9c726054db27fcb368352eaebc2f7f9523b68088
                    "car_image	" =>$row->carimage
                );
                //request to submit /request to save data
               $saving =  $this->sellers_model->save_sellerdetails($data);
               $subscribers = array($row->phonenumber);
               
               if($saving == TRUE){
                   //send a confirmation
                   //
                   $messagetitle = "successful";
                   $mesage_description = "thanks for ".$row->sellername;

                   // echo "succesful";
               }else{
                   //echo "didnt work";
                   $messagetitle = "not successful";
                   $mesage_description = " Sorry ".$row->sellername ."tryagain";
               }
               $this->kaizalas_model-> send_announcement($messagetitle, $mesage_description, $subscribers);
            }
            else {
                    echo " Invalid data/error occured somewhere";
            }
        
    }
}
?>