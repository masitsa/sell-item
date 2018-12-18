<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registration extends MX_Controller
{
    /**
     * Constructor for this controller.
     *
     * Tasks:
     *         Checks for an active advertiser login session
     *    - and -
     *         Loads models required
     */
    public function __construct()
    {
        parent::__construct();
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400'); // cache for 1 day
        }

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            }

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header("Access-Control-Allow-Headers: token, Content-Type");
                header('Content-Type: text/plain');
            }

            exit(0);
        }
    }

    public function index()
    {
        $json_string = file_get_contents("php://input");
        $json_object = json_decode($json_string);
        $response = array();

        $this->load->view('royalMediaServices/searchView', $response);
    }

    public function get_category_id($category)
    {
        $this->db->where("category", $category);
        $query = $this->db->get("categories");
        $category_id = null;
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $category_id = $row->id;
        }

        return $category_id;
    }

    public function user_exists($userId)
    {
        $this->db->where("user_id", $userId);
        $query = $this->db->get("users");

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function register_services()
    {
        $json_string = file_get_contents("php://input");
        $json_object = json_decode($json_string);
        // var_dump($json_object); die();
        $response = array();
        //fetch all users from db table users
        $users = $this->db->get('users')->result();
        $temp_phone = 'temp_phone';

        if (is_array($json_object)) {
            if (count($json_object) > 0) {
                $row = $json_object[0];
                // foreach ($json_object as $row) {
                $response_time = date("Y-m-d H:i:s");
                $userId = $row->userId;

                $lat_array = json_decode($row->body, true);
                $lat = $lat_array['answer13']['lt'];
                $lng_array = json_decode($row->body, true);
                $lng = $lng_array['answer13']['lg'];
                $dataItem = array(
                    "time_modified" => $response_time,
                    "category" => $row->category,
                    "item" => $row->item,
                    "quantity" => $row->quantity,
                    "units" => $row->units,
                    "price" => $row->price,
                    "user_id" => $userId,
                    "image" => $row->image,
                    "image2" => $row->image2,
                    "image3" => $row->image3,
                    "image4" => $row->image4,
                    "lat" => $lat,
                    "lng" => $lng,
                    "location" => $row->location,
                    "category_id" => $this->get_category_id($row->category),
                );

                //Check if user exists
                if ($this->user_exists($userId) == false) {
                    $dataUser = array(
                        "name" => $row->name,
                        "phone_number" => $row->phone,
                        "user_id" => $userId,
                        "time_modified" => $response_time,
                    );

                    $this->db->insert("users", $dataUser);
                }
                
                if ($this->db->insert("items", $dataItem)) {
                    //echo "saved";
                    $response["result"] = "true";
                    $response["message"] = "Request saved successfully";
                } else {
                    $response["result"] = "false";
                    $response["message"] = "Unable to save item";
                }
                // }
            } else {
                $response["result"] = "false";
                $response["message"] = "No results present in request object";
            }
        } else {
            $response["result"] = "false";
            $response["message"] = "Error in request object";
        }
        echo json_encode($response);
    }

    public function services_search()
    {
        $json_string = file_get_contents("php://input");
        $json_object = json_decode($json_string);
        $response = array();

        //params to search with
        $category = '';
        $item = '';
        $units = '';

        if (is_array($json_object)) {
            if (count($json_object) > 0) {
                foreach ($json_object as $row) {
                    $category = $row->category;
                    $item = $row->item;
                    $units = $row->units;
                }
            } else {
                $response["result"] = "false";
                $response["message"] = "No results present in request object";
            }
        } else {
            $response["result"] = "false";
            $response["message"] = "Error in request object";
        }

        // $category = "Cereals";
        // $item = "Bean";
        // $units = "kg";
        if ($category != '' && $item != '' && $units != '') {

            $this->db->select('*');
            $this->db->from('items');
            $this->db->join('users', 'items.user_id = users.user_id');
            $this->db->where('category', $category);
            $this->db->where('item', $item);
            $this->db->where('units', $units);
            // $this->db->where('category', 'Cereals');
            // $this->db->where('item', 'Hotel');
            // $this->db->where('units', 'grams');
            $items = $this->db->get();

            //$items = $this->db->get('items');
            echo json_encode($items->result());
        }

    }
    public function items_search()
    {
        $json_string = file_get_contents("php://input");
        // $json_string = '[{
        //     "item": "Potatoes",
        //     "location": "Nanyuki",
        //     "category": "Vegetable",
        //     "lat": "lat",
        //     "lng": "lng"
        // }]';
        $json_object = json_decode($json_string);
        $response = array();

        if (is_array($json_object)) {
            if (count($json_object) > 0) {
                $row = $json_object[0];
                $item = $row->item;
                $location = $row->location;
                $category = $row->category;
                //Remove ', Kenya' from location
                if (strpos($location, ', Kenya') != false) {
                    $location = substr($location, 0, strpos($location, ', Kenya'));
                }
                //Remove ', Road' from location
                if (strpos($location, ', Road') != false) {
                    $location = substr($location, 0, strpos($location, ', Road'));
                }
                //Remove ' Road' from location
                if (strpos($location, ' Road') != false) {
                    $location = substr($location, 0, strpos($location, ' Road'));
                }
                //Remove 'Road' from location
                if (strpos($location, 'Road') != false) {
                    $location = substr($location, 0, strpos($location, 'Road'));
                }
                //If category, item and location have been provided
                if(($item != "" || $item != NULL) && ($category != "" || $category != NULL)){
                    $this->db->select('items.*, users.name, users.phone_number');
                    $this->db->from('items, users');
                    // $this->db->order_by("category", "ASC");
                    $this->db->order_by("category", "ASC");
                    $this->db->order_by("time_modified", "DESC");
                    // $this->db->group_by("item");
                    $this->db->where("items.item = '" . $item . "' AND items.location LIKE '%" . $location . "%' AND items.category = '" . $category . "' AND items.user_id = users.user_id");
                    $items = $this->db->get();

                    $response["result"] = "true";
                    $response["message"] = $items->result();

                }
                //If only category and location have been provided
                else if($category != "" || $category != NULL){
                    $this->db->select('items.*, users.name, users.phone_number');
                    $this->db->from('items, users');
                    $this->db->order_by("category", "ASC");
                    $this->db->order_by("time_modified", "DESC");
                    // $this->db->group_by("item");
                    $this->db->where("items.category = '" . $category . "' AND items.location LIKE '%" . $location . "%' AND items.user_id = users.user_id");
                    $items = $this->db->get();

                    $response["result"] = "true";
                    $response["message"] = $items->result();
                }
                //If only location has been provided
                else if(($item == "" || $item == NULL) && ($category == "" || $category == NULL)){
                    $this->db->select('items.*, users.name, users.phone_number');
                    $this->db->from('items, users');
                    $this->db->order_by("category", "ASC");
                    $this->db->order_by("time_modified", "DESC");
                    // $this->db->group_by("item");
                    $this->db->where("items.location LIKE '%" . $location . "%' AND items.user_id = users.user_id");
                    $items = $this->db->get();
                    $response["result"] = "true";
                    $response["message"] = $items->result();
                }

            } else {
                $response["result"] = "false";
                $response["message"] = "No results present in request object";
            }
        } else {
            $response["result"] = "false";
            $response["message"] = "Error in request object";
        }
        echo json_encode($response);
    }

    public function categories()
    {
        $this->db->select('*');
        $this->db->from("categories");
        $categories = $this->db->get();
        echo json_encode($categories->result());
    }

    public function items()
    {
        $this->db->select('*');
        $this->db->from("items");
        $items = $this->db->get();
        echo json_encode($items->result());
    }

    public function category_items()
    {
        $this->db->select('*');
        $this->db->from("category_items");
        $category_items = $this->db->get();
        echo json_encode($category_items->result());
    }

    public function units()
    {
        $this->db->select('*');
        $this->db->from("units");
        $units = $this->db->get();
        echo json_encode($units->result());
    }

    public function purchase_items()
    {
        $json_string = file_get_contents("php://input");
        $json_object = json_decode($json_string);
        $response = array();

        if (is_array($json_object)) {
            if (count($json_object) > 0) {
                $row = $json_object[0];
                $data['quantity'] = $row->quantity;
                $data['item_id'] = $row->item_id;
                $data['customer_name'] = $row->customer_name;
                $data['customer_phone'] = $row->customer_phone;

                if ($this->db->insert("orders", $data)) {
                    $response["result"] = "true";
                } else {
                    $response["result"] = "false";
                    $response["message"] = "Unable to save";
                }

            } else {
                $response["result"] = "false";
                $response["message"] = "No results present in request object";
            }
        } else {
            $response["result"] = "false";
            $response["message"] = "Error in request object";
        }
        echo json_encode($response);

        // $category = "Cereals";
        // $item = "Bean";
        // $units = "kg";
        // if ($category != '') {
        //     $this->db->select('item');
        //     $this->db->from('items');
        //     $this->db->where('category', $category);
        //     $items = $this->db->get();
        //     //$items = $this->db->get('items');
        //     echo json_encode($items->result());
        // } else {
        //     echo "Category is null";
        // }
    }
}
