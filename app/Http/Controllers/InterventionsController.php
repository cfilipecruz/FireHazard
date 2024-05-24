<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Fluid_type;
use App\Models\Intervention;
use App\Models\User;
use Dompdf\Dompdf;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class interventionsController extends Controller
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
                'Cookie: PHPSESSID=aea61f17cd422b13ec95376f037cc4b5'
            ),
        ));

        $response = curl_exec($curl);
        //dd($response);
        $json_response = json_decode($response, true);
        $clients = $json_response['data'] ?? null;

        curl_close($curl);

        $users = User::all();
        $interventions = Intervention::orderByDesc('id')->paginate(5);
        $cars = Car::all();
        $fluid_types = Fluid_type::all();

        return view('interventions')->with(['interventions' => $interventions,
            'users' => $users,
            'cars' => $cars,
            'clients' => $clients,
            'fluid_types' => $fluid_types,
        ]);
    }

    private function getAuthToken()
    {

        $curl = curl_init();

        $apiUrl = env('API_URL');

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
        $token = $json_response['_token'];
        curl_close($curl);


        return $token;
    }

    public function intervention($id)
    {
        $intervention = Intervention::find($id);
        $cars = Car::all();
        $fluid_types = Fluid_type::all();

        return view('interventions.intervention')->with(['intervention' => $intervention,
            'cars' => $cars,
            'fluid_types' => $fluid_types,
        ]);
    }

    public function create(Request $request)
    {
        //dd($request);
        $intervention = new Intervention();

        $intervention->place = $request->place;
        $intervention->car_id = $request->car_id;
        $intervention->client_id = $request->client_id;
        $intervention->user_id = Auth::id();
        $intervention->internalNumber = $request->internalNumber;
        $intervention->serialNumber = $request->serialNumber;
        $intervention->fluid_type_id = $request->fluid_type_id;
        $intervention->capacity = $request->capacity;
        $intervention->pressure = $request->pressure;
        $intervention->factoryName = $request->factoryName;
        $intervention->factoryDate = $request->factoryDate;
        $intervention->ceMarking = $request->ceMarking;
        $intervention->localization = $request->localization;
        $intervention->lastCharged = $request->lastCharged;
        $intervention->lastHydraulicTest = $request->lastHydraulicTest;
        $intervention->maintenanceMNT = $request->maintenanceMNT;
        $intervention->chargeMNTAD = $request->chargeMNTAD;
        $intervention->type = $request->type;
        $intervention->co2Weight = $request->co2Weight;
        $intervention->hydraulicProve = $request->hydraulicProve;
        $intervention->securityStamp = $request->securityStamp;
        $intervention->oRing = $request->oRing;
        $intervention->peg = $request->peg;
        $intervention->manometer = $request->manometer;
        $intervention->diffuser = $request->diffuser;
        $intervention->plasticBase = $request->plasticBase;
        $intervention->label = $request->label;
        $intervention->sparkles = $request->sparkles;
        $intervention->approved = $request->approved;
        $intervention->new = $request->new;
        $intervention->outofservice = $request->outofservice;
        $intervention->rejectedMotive = $request->rejectedMotive;

        $intervention->observations = $request->observations;

        $intervention->save();

        return redirect()->back();
    }

    public function interventionUpdate(Request $request, $id)
    {
        $intervention = Intervention::find($id);

        $intervention->place = $request->place;
        $intervention->car_id = $request->car_id;
        $intervention->user_id = Auth::id();
        $intervention->internalNumber = $request->internalNumber;
        $intervention->serialNumber = $request->serialNumber;
        $intervention->fluid_type_id = $request->fluid_type_id;
        $intervention->capacity = $request->capacity;
        $intervention->pressure = $request->pressure;
        $intervention->factoryName = $request->factoryName;
        $intervention->factoryDate = $request->factoryDate;
        $intervention->ceMarking = $request->ceMarking;
        $intervention->localization = $request->localization;
        $intervention->lastCharged = $request->lastCharged;
        $intervention->lastHydraulicTest = $request->lastHydraulicTest;
        $intervention->maintenanceMNT = $request->maintenanceMNT;
        $intervention->chargeMNTAD = $request->chargeMNTAD;
        $intervention->type = $request->type;
        $intervention->co2Weight = $request->co2Weight;
        $intervention->hydraulicProve = $request->hydraulicProve;
        $intervention->securityStamp = $request->securityStamp;
        $intervention->oRing = $request->oRing;
        $intervention->peg = $request->peg;
        $intervention->manometer = $request->manometer;
        $intervention->diffuser = $request->diffuser;
        $intervention->plasticBase = $request->plasticBase;
        $intervention->label = $request->label;
        $intervention->sparkles = $request->sparkles;
        $intervention->approved = $request->approved;
        $intervention->new = $request->new;
        $intervention->outofservice = $request->outofservice;
        $intervention->rejectedMotive = $request->rejectedMotive;
        // $intervention->invoice_id = $request->invoice_id;
        $intervention->observations = $request->observations;

        $intervention->update();

        return redirect()->back();
    }

    //Create Invoice with intervention information
    public function createInvoice(Request $request, $id)
    {
        $token = $this->getAuthToken();

        $invoiceData = $request->only([
            'client',
            'number',
            'reference',
            'discount',
            'observations',
        ]);

        // Set default values for fields not included in the request
        $invoiceData['date'] = date('d/m/Y');
        $invoiceData['coin'] = '1';

        // Check if 'discount' field is null and set it to '0' if true
        if (is_null($invoiceData['discount'])) {
            $invoiceData['discount'] = '0';
        }

        if (is_null($invoiceData['observations'])) {
            $invoiceData['observations'] = 'Não foram registadas nenhumas observações';
        }

        // Add the remaining fields
        $invoiceData['serie'] = '27';
        $invoiceData['expiration'] = date('d/m/Y', strtotime('+1 year'));
        $invoiceData['dueDate'] = '0';
        $invoiceData['finalize'] = '1';
        $invoiceData['payment'] = '0';
        $invoiceData['lines'] = json_encode([
            [
                'id' => '113',
                'description' => 'Tinteiro Compatível Epson T1631 Preto',
                'quantity' => '1',
                'price' => '1.22',
                'discount' => '0',
                'tax' => 1,
                'exemption' => '0',
                'retention' => 0
            ]
        ]);
        $invoiceData['doc_origin'] = '9';

        $curl = curl_init();

        $apiUrl = env('API_URL');

        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl . '/invoices',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($invoiceData),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                "Authorization: {$token}",
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        // Handle the response
        $response_data = json_decode($response, true);
        //dd($response_data);
        if (isset($response_data['fatura'])) {
            $invoice_id = $response_data['fatura'];
            $intervention = Intervention::find($id);
            $intervention->invoice_id = $invoice_id;
            $intervention->update();
        } else {
            dd('teste');
        }

        return redirect()->back();
    }

    public function interventionDelete($id)
    {
        $intervention = Intervention::find($id);

        $intervention->delete();

        $interventions = Intervention::orderByDesc('id')->get();
        $cars = Car::all();
        $fluid_types = Fluid_type::all();

        return redirect()->action([InterventionsController::class, 'index']);

    }

    public function generatePdf($id)
    {
        // Increase execution time and memory limit
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '256M');

        $intervention = Intervention::findOrFail($id);

        // Load the view from the 'interventions' folder and render it to a string
        $view = view('interventions.generatePdf', compact('intervention'))->render();

        // Create a new Dompdf instance and load the HTML into it
        $pdf = new Dompdf();
        $pdf->loadHtml($view);

        // Set the paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Render the PDF
        $pdf->render();

        // Send the PDF as a stream to the browser for download
        return $pdf->stream('intervenção nª' . $intervention->id . '.pdf');
    }

    public function interventionFilter(Request $request)
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
        // Get the filter values from the request
        $user = $request->input('user');
        $id_invoice = $request->input('id_invoice');
        $client = $request->input('client_id');
        $approved = $request->input('approved');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        //dd($start_date);

        // Determine if filters are applied
        $filtersApplied = ($user || $id_invoice || $client || $approved !== null || ($start_date && $end_date));

        $users = User::all();
        $cars = Car::all();
        $fluid_types = Fluid_type::all();

        // Query the interventions based on the filters
        $interventions = Intervention::query()
            ->when($user, function ($query, $user) {
                return $query->where('user_id', $user);
            })
            ->when($client, function ($query, $client) {
                return $query->where('client_id', $client);
            })
            ->when($id_invoice, function ($query, $id_invoice) {
                return $query->where('invoice_id', $id_invoice);
            })
            ->when($approved !== null, function ($query) use ($approved) {
                return $query->where('approved', $approved);
            })
            ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                return $query->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->orderByDesc('id')
            ->paginate(5);

        //dd($interventions);
        // Return the filtered interventions to the view
        return view('interventions', [
            'users' => $users,
            'interventions' => $interventions,
            'cars' => $cars,
            'clients' => $clients,
            'fluid_types' => $fluid_types,
            'filtersApplied' => $filtersApplied,
            'filters' => [
                'user' => $user,
                'id_invoice' => $id_invoice,
                'client_id' => $client,
                'approved' => $approved,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ],
        ]);
    }

}
