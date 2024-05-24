<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use PDF;
use Swift_Message;
use Symfony\Component\Mime\Part\Attachment;

class InvoicesController extends Controller
{
    public function index()
    {
        // Authenticate the user and get the token
        $token = $this->getAuthToken();

        // Fetch invoices using the obtained token
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
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: {$token}"
            ),
        ));


        $response = curl_exec($curl);
        //dd($response);
        $json_response = json_decode($response, true);
        $invoices = $json_response['data'] ?? null;


        curl_close($curl);

        //dd($invoices);
        // Render the view with the invoices data
        return view('invoices')->with(['invoices' => $invoices]);
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

    public function invoice(Request $request, $id)
    {
        // Authenticate the user and get the token
        $token = $this->getAuthToken();
        //dd($token);
        // Fetch a single invoice by ID using the obtained token
        $curl = curl_init();

        $apiUrl = env('API_URL');

        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl . "/invoices?id={$id}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: {$token}"
            ),
        ));

        $response = curl_exec($curl);
        //dd($response);
        $json_response = json_decode($response, true);
        //dd($json_response);
        $invoice = $json_response['result'] ?? null;

        curl_close($curl);
        //dd($invoice);
        // Render the view with the invoice data
        return view('invoices.invoice')->with(['invoice' => $invoice]);

    }

    public function edit($id)
    {
        $invoice = Invoice::find($id);
        return view('invoices.edit', ['invoice' => $invoice]);
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        $invoice->customer_name = $request->customer_name;
        $invoice->amount = $request->amount;
        $invoice->date = $request->date;
        $invoice->save();

        return redirect()->route('invoices.index');
    }

    public function invoiceDownload($id)
    {
        $token = $this->getAuthToken();

        $curl = curl_init();

        $apiUrl = env('API_URL');

        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl . '/invoices?id=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: {$token}"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $invoice = json_decode($response, true);

        if ($invoice && isset($invoice['data'])) {
            $invoiceData = $invoice['data'];

            // Generate the PDF invoice
            $view = view('invoices.generatePdf', compact('invoiceData'))->render();
            // Create a new Dompdf instance and load the HTML into it
            $pdf = new \Dompdf\Dompdf();
            $pdf->loadHtml($view);

            // Set the paper size and orientation
            $pdf->setPaper('A4', 'portrait');

            // Render the PDF
            $pdf->render();
            //dd($invoiceData);
            // Return the PDF download response
            return $pdf->stream('Fatura nº' . $invoiceData['id'] . '.pdf');
        } else {
            // Handle the case when the invoice data is not available
            Session::flash('error', 'Erro ao obter valores da fatura.');
            return redirect()->back();
        }
    }

    public function sendInvoice(Request $request, $id)
    {

        // dd($id);
        $token = $this->getAuthToken();

        $curl = curl_init();

        $apiUrl = env('API_URL');

        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl . '/invoices?id=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: {$token}"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $invoice = json_decode($response, true);

        if ($invoice && isset($invoice['data'])) {
            $invoiceData = $invoice['data'];
            //dd($invoiceData);
            // Generate the PDF invoice
            $pdf = PDF::loadView('invoices.generatePdf', compact('invoiceData'));

            // Get the email address from the form
            $email = $request->input('email');

            // Send the email with the PDF attachment
            Mail::send([], [], function ($message) use ($email, $pdf) {
                $message->to($email)
                    ->subject('Fatura Fire Hazard')
                    ->attachData($pdf->output(), 'fatura.pdf', [
                        'mime' => 'application/pdf',
                    ])
                    ->text('Bom dia, esperamos que se encontre bem, serve este e-mail para o notificar da fatura referente ha intervenção efetuada por FireHazard.');
            });

            // Set the success message in the session
            Session::flash('success', 'Fatura enviada por e-mail.');

            // Redirect back to the intervention page
            return redirect()->back()->with('success', 'Fatura enviada por e-mail.');
        } else {

            // Set the error message in the session
            Session::flash('error', 'A fatura não foi enviada.');

            // Redirect back to the intervention page
            return redirect()->back()->with('error', 'A fatura não foi enviada.');
        }
    }
}
