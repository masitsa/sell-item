<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fetchdata extends MX_Controller
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
}
