<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Categories extends MX_Controller
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
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            }

            exit(0);
        }
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
        if ($category != '') {
            $this->db->select('item');
            $this->db->from('items');
            $this->db->where('category', $category);
            $items = $this->db->get();
            //$items = $this->db->get('items');
            echo json_encode($items->result());
        } else {
            echo "Category is null";
        }
    }
}
