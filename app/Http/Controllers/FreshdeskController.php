<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FreshdeskController extends Controller
{
    
    
    static function getTickets(){
        $apikey = env('FRESHDESK_API_KEY');
        $password = env('FRESHDESK_PASSWORD');
        $domain = env('FRESHDESK_DOMAIN');

        $url = "https://".$domain.".freshdesk.com/api/v2/tickets?per_page=100";
        $ch = curl_init($url);

        $header[] = "Content-type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $apikey.":".$password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($server_output, 0, $header_size);
        $response = substr($server_output, $header_size);
        $tickets = json_decode($response);
        dd($tickets);
    }

    public static function getUserByEmail($email){
        $apikey = env('FRESHDESK_API_KEY');
        $password = env('FRESHDESK_PASSWORD');
        $domain = env('FRESHDESK_DOMAIN');

        $url = "https://".$domain.".freshdesk.com/api/v2/contacts?email=".$email;
        $ch = curl_init($url);

        $header[] = "Content-type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $apikey.":".$password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($server_output, 0, $header_size);
        $response = substr($server_output, $header_size);
        $contacts = json_decode($response);
        return $contacts[0];
    }

    public static function getTicketsByUser($id){
        $apikey = env('FRESHDESK_API_KEY');
        $password = env('FRESHDESK_PASSWORD');
        $domain = env('FRESHDESK_DOMAIN');

        $url = "https://".$domain.".freshdesk.com/api/v2/tickets?requester_id=".$id."&per_page=100";
        $ch = curl_init($url);

        $header[] = "Content-type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $apikey.":".$password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($server_output, 0, $header_size);
        $response = substr($server_output, $header_size);
        $tickets = json_decode($response);
        return $tickets;
    }

    public static function getTicketStatus($status){
        $apikey = env('FRESHDESK_API_KEY');
        $password = env('FRESHDESK_PASSWORD');
        $domain = env('FRESHDESK_DOMAIN');

        $url = "https://".$domain.".freshdesk.com/api/v2/ticket_fields";
        $ch = curl_init($url);

        $header[] = "Content-type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $apikey.":".$password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($server_output, 0, $header_size);
        $response = substr($server_output, $header_size);
        $ticket = json_decode($response);
        return $ticket[4]->choices->$status[1];
        
    }

    public static function getConversationOfTicket($id){
        $apikey = env('FRESHDESK_API_KEY');
        $password = env('FRESHDESK_PASSWORD');
        $domain = env('FRESHDESK_DOMAIN');

        $url = "https://".$domain.".freshdesk.com/api/v2/tickets/".$id."/conversations ";
        $ch = curl_init($url);

        $header[] = "Content-type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $apikey.":".$password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($server_output, 0, $header_size);
        $response = substr($server_output, $header_size);
        $conversation = json_decode($response);
        return $conversation;
    }

    public static function getTicketById($id){
        $apikey = env('FRESHDESK_API_KEY');
        $password = env('FRESHDESK_PASSWORD');
        $domain = env('FRESHDESK_DOMAIN');

        $url = "https://".$domain.".freshdesk.com/api/v2/tickets/".$id;
        $ch = curl_init($url);

        $header[] = "Content-type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $apikey.":".$password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($server_output, 0, $header_size);
        $response = substr($server_output, $header_size);
        $ticket = json_decode($response);
        return $ticket;
    }

    public static function getTicketType(){
        $apikey = env('FRESHDESK_API_KEY');
        $password = env('FRESHDESK_PASSWORD');
        $domain = env('FRESHDESK_DOMAIN');

        $url = "https://".$domain.".freshdesk.com/api/v2/ticket_fields";
        $ch = curl_init($url);

        $header[] = "Content-type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $apikey.":".$password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($server_output, 0, $header_size);
        $response = substr($server_output, $header_size);
        $ticket = json_decode($response);
        return $ticket[2]->choices;
    }

    public static function getTicketStatusField(){
        $apikey = env('FRESHDESK_API_KEY');
        $password = env('FRESHDESK_PASSWORD');
        $domain = env('FRESHDESK_DOMAIN');

        $url = "https://".$domain.".freshdesk.com/api/v2/ticket_fields";
        $ch = curl_init($url);

        $header[] = "Content-type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $apikey.":".$password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($server_output, 0, $header_size);
        $response = substr($server_output, $header_size);
        $ticket = json_decode($response);
        return $ticket[4]->choices;
    }

    public static function makeTicket($summary, $subject, $type, $requester_id){
        $apikey = env('FRESHDESK_API_KEY');
        $password = env('FRESHDESK_PASSWORD');
        $domain = env('FRESHDESK_DOMAIN');
        $url = "https://".$domain.".freshdesk.com/api/v2/tickets";
        
            $ticket_data = json_encode(array(
                "description" => $summary,
                "subject" => $subject,
                "priority" => 1,
                "status" => 2,
                "type" => $type,
                "requester_id" => $requester_id,
            ));
        

        $ch = curl_init($url);

        $header[] = "Content-type: application/json";
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $apikey.":".$password);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($server_output, 0, $header_size);
        $response = substr($server_output, $header_size);

        if($info['http_code'] == 201) {
            return true;
        } else {
            return false;
          }
    }

    public static function createReply($ticket_id, $body, $requester_id){
        $apikey = env('FRESHDESK_API_KEY');
        $password = env('FRESHDESK_PASSWORD');
        $domain = env('FRESHDESK_DOMAIN');
        $url = "https://".$domain.".freshdesk.com/api/v2/tickets/".$ticket_id."/reply ";
        
        $ticket_data = json_encode(array(
            "body" => $body,
            "user_id" => intval($requester_id),
        ));
        
        $ch = curl_init($url);

        $header[] = "Content-type: application/json";
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $apikey.":Test12345");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($server_output, 0, $header_size);
        $response = substr($server_output, $header_size);
        dd($response);
        if($info['http_code'] == 201) {
            return true;
        } else {
            return false;
          }
    }

    public static function makeTicketWithAttachment($summary, $subject, $type, $requester_id, $attachment){
        $apikey = env('FRESHDESK_API_KEY');
        $password = env('FRESHDESK_PASSWORD');
        $domain = env('FRESHDESK_DOMAIN');

        $ticket_payload = json_encode(array(
        "subject" => $subject,
        "description" => $summary,
        "type" => $type,
        "requester_id" => $requester_id,
        "priority" => 1,
        "status" => 2,
        "attachments" =>  array(curl_file_create($attachment))
        ));


        $url = "https://$domain.freshdesk.com/api/v2/tickets";

        $ch = curl_init($url);

        $header[] = "Content-type: application/json";
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERPWD, $apikey.":".$password);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($server_output, 0, $header_size);
        $response = substr($server_output, $header_size);
        dd($response);

        if($info['http_code'] == 201) {
        echo "Ticket created successfully, the response is given below \n";
        echo "Response Headers are \n";
        echo $headers."\n";
        echo "Response Body \n";
        echo "$response \n";
        } else {
        if($info['http_code'] == 404) {
            echo "Error, Please check the end point \n";
        } else {
            echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
            echo "Headers are ".$headers;
            echo "Response are ".$response;
        }
        }

        curl_close($ch);
    }

    public static function updateTicketStatus($ticket_id, $status){
        
        $apikey = env('FRESHDESK_API_KEY');
        $password = env('FRESHDESK_PASSWORD');
        $domain = env('FRESHDESK_DOMAIN');
        $url = "https://".$domain.".freshdesk.com/api/v2/tickets/".$ticket_id;
        
        $ticket_data = json_encode(array(
            "status" => intval($status)
        ));
        
        $ch = curl_init($url);

        $header[] = "Content-type: application/json";
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $apikey.":".$password);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($server_output, 0, $header_size);
        $response = substr($server_output, $header_size);
        if($info['http_code'] === 200) {
            return true;
        } else {
            return false;
          }
    }
}
