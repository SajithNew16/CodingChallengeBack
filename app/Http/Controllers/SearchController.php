<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Http\Request;
use Storage;

class SearchController extends Controller
{
    /**
     * load First Instrustion
     */
    public function index()
    {
        $response = [
            'success' => true,
            'data' => Config::get('constants.EXIT_OR_CONTINUE'),
            'message' => 'successfully loaded',
        ];

        return response()->json($response, 200);

    }

    /**
     * return Searchable User fields
     */
    public function userFields()
    {
        $response = [
            'success' => true,
            'data' => Config::get('constants.SEARCHABLE_USER_FIELDS_ARR'),
            'message' => 'successfully loaded',
        ];

        return response()->json($response, 200);

    }

    public function displayOrganizationName($user)
    {
        $json = Storage::disk('local')->get('organizations.json');
        $json = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($json));
        $arr = json_decode($json, true);
        for ($i = 0; $i < sizeof($arr); $i++) {
            // print_r($user);die;
            if ($arr[$i]['_id'] == $user['organization_id']) {
                return $arr[$i]['name'];
            }
        }
    }

    public function displayTicketsSubjectsForUsers($user)
    {
        $json = Storage::disk('local')->get('tickets.json');
        $json = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($json));
        $arr = json_decode($json, true);
        $tickets = [];
        $k = 0;
        for ($i = 0; $i < sizeof($arr); $i++) {
            if ($arr[$i]['submitter_id'] == $user['_id']) {
                $tickets[$k] = $arr[$i]['subject'];
                $k++;
            }
        }
        return $tickets;
    }

    /**
     * search users and return result
     */
    public function filteredUsers(Request $request)
    {
        $json = Storage::disk('local')->get('users.json');
        $json = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($json));
        $arr = json_decode($json, true);
        $searchTerm = $request->input('searchTerm');
        $searchValue = $request->input('searchValue');

        $users = [];
        $organizationArr = [];
        $ticketArr = [];

        for ($i = 0; $i < sizeof($arr); $i++) {
            if ($arr[$i][$searchTerm] == $searchValue) {
                //return $arr
                $users = $arr[$i];
                //diplay organization name
                $organizationArr['organization_name'] = $this->displayOrganizationName($arr[$i]);

                //diplay ticket subjects
                $ticketArr['tickets'] = $this->displayTicketsSubjectsForUsers($arr[$i]);

                break;
            }

        }

        $data['users'] = $users;
        $data['organization_name'] = $organizationArr;
        $data['tickets'] = $ticketArr;
        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'successfully loaded',
        ];

        return response()->json($response, 200);

    }

}
