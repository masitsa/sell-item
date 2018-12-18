<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contact extends MX_Controller
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
    // use AfricasTalking\SDK\AfricasTalking;
    public function sendsms($request)
    {
        $this->load->library('africastalking');
        $this->db->select('*');
        $this->db->from("contacts");
        $contactsObj = $this->db->get();
        $contacts = $contactsObj->result();
        $batch_size = 1000;
        $total_contacts = count($contacts);
        $total_batch = $total_contacts / $batch_size;
        $contacts = json_encode($contacts);
        $contacts = json_decode($contacts);
        // use 'sandbox' for development in the test environment
        // $username = 'sandbox';
        // // use your sandbox app API key for development in the test environment
        // $apiKey = 'ca5328cd241404e991d78a599f7ad9500925661e3cc4c3ab471b97c0598c21c2';
        // $AT = new AfricasTalking($username, $apiKey);
        // $this->africastalking->sendMessage($recipients, $message);

        // Get one of the services
        // $sms = $AT->sms();

        //    dd( $application = $AT->application());

        $message = $request;

        $mess = new Message();
        $mess->name = $message;
        $mess->save();

        $recipients = "";
        $batch_result = array();
        $final_contact_per_batch = 0;

        $phone_and_id = array();
        $phones = array();
        $response_array = array();
        $response = array();

        for ($m = 0; $m < $total_batch; $m++) {
            //next maximum contact maximum index
            $max_contact_index = $batch_size * ($m + 1);
            //if this next maximum contact index has exceeded total number of contacts assign it to total_contacts
            $max_contact_index = $max_contact_index >= $total_contacts ? $total_contacts : $max_contact_index;
            for ($k = $final_contact_per_batch; $k < $max_contact_index; $k++) {
                $recipients .= $contacts[$k]->mobilenumber . ",";
                $phone_and_id['id'] = $contacts[$k]->id;
                $phone_and_id['phone'] = $contacts[$k]->mobilenumber;
                array_push($phones, $phone_and_id);
            }

            $enqueue = true;

            try {
                // Thats it, hit send and we'll take care of the rest
                // $result = $sms->send([
                //     'to' => $recipients,
                //     'message' => $message,
                //     'enqueue' => $enqueue,
                // ]);

                $result = $this->africastalking->sendMessage($recipients, $message);
                var_dump($result);die();

                array_push($batch_result, $result);

                $array = json_encode($result);
                $js = json_decode($array, true);

                $data = $js['data'];
                $recipients = $data['SMSMessageData']['Recipients'];

                // print_r($js->data->SMSMessageData->Recipients);
                foreach ($recipients as $recipient) {
                    $status = $recipient['status'];
                    $status = ($status == 'Success' ? 1 : ($status == 'Failed' ? 2 : 3));
                    $number = $recipient['number'];
                    $costStr = $recipient['cost'];
                    $cost = substr($costStr, strpos($costStr, 'S') + 2, strlen($costStr) - strpos($costStr, 'S'));

                    $response_array['status'] = $status;
                    $response_array['cost'] = $cost;
                    array_push($response, $response_array);

                    $contact_id = 1;

                    for ($id = 0; $id < count($phones); $id++) {
                        if ($phones[$id]['phone'] == $number) {
                            $contact_id = $phones[$id]['id'];
                            break;
                        }
                    }
                    set_time_limit(0);
                    // Status::create([
                    //     'status' => $status,
                    //     'send_status_cost' => $cost,
                    //     'bal_before_send' => 100,
                    //     'message_id' => $mess->id,
                    //     'contact_id' => $contact_id,
                    // ]);
                    // print_r($phones);
                    print_r($response);
                }

                $final_contact_per_batch = $batch_size * ($m + 1);
                $recipients = "";

            } catch (Exception $e) {
                echo "Error: " . $e . getMessage();
            }
        }
    }
}
