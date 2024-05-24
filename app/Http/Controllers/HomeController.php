<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Fluid_type;
use App\Models\Intervention;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $token = $this->getAuthToken();

        $curl = curl_init();

        $apiUrl = env('API_URL');

        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl . '/clients',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: {$token}",
            ),
        ));

        $response = curl_exec($curl);
        //dd($response);
        $json_response = json_decode($response, true);
        $clients = $json_response['data'] ?? null;

        curl_close($curl);

        $cars = Car::all();
        $users = User::all();
        $interventions = Intervention::all();
        $fluid_types = Fluid_Type::all();

        // Calculate the number of interventions per funcionario
        $interventionsPerUser = Intervention::select('user_id', DB::raw('count(*) as total_interventions'))
            ->groupBy('user_id')
            ->pluck('total_interventions', 'user_id');

        $interventionsPerCar = Intervention::select('car_id', DB::raw('count(*) as total_interventions'))
            ->groupBy('car_id')
            ->pluck('total_interventions', 'car_id');

// Get car license plates
        $carLicensePlates = Car::whereIn('id', $interventionsPerCar->keys())->pluck('licensePlate', 'id');

// Map car license plates to interventions per car data
        $interventionsPerCar = $interventionsPerCar->mapWithKeys(function ($value, $key) use ($carLicensePlates) {
            $licensePlate = $carLicensePlates[$key] ?? 'Loja';
            return [$licensePlate => $value];
        });

        //dd($interventionsPerCar);
        //dd($interventions);
        return view('home')->with(['users' => $users,
            'interventions' => $interventions,
            'cars' => $cars,
            'interventionsPerUser' => $interventionsPerUser,
            'interventionsPerCar' => $interventionsPerCar,
            'clients' => $clients,
            'fluid_types' => $fluid_types,
        ]);
    }

    private function getAuthToken()
    {

        $curl = curl_init();

        $apiUrl = env('API_URL');
        // dd($apiUrl);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl . '/authentication',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'username=ipvcweb4&password=ipvcweb4',
        ));

        $response = curl_exec($curl);
        $json_response = json_decode($response, true);
        if ($json_response === null) {
            // Handle invalid API credentials
            dd('Credenciais GesFaturação Inválidas');
        }
        $token = $json_response['_token'] ?? null;


        curl_close($curl);


        return $token;
    }
}
