<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Services\RegistrationServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

class RegistrationController extends Controller
{

    public $registrationServices;

    public function __construct(RegistrationServices $registrationServices)
    {
        $this->registrationServices = $registrationServices;
    }

    public function get_view_international()
    {
        return view('pages.registration-international');
    }

    public function get_view_vietnamese()
    {
        return view('pages.registration-vietnamese');
    }


    public function registration_international_submit(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => 'required|string',
                'other_title' => 'nullable|string',
                'fullname' => 'required|string|max:255',
                'position' => 'nullable|string|max:255',
                'organization' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'other_dietary_requirement' => 'nullable|string|max:255',
                'country' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'required|email',
                'dietary_requirement' => 'required|string',
                'conference_type' => 'required|string',
                'paper_title' => 'nullable|string',
                'payment_method' => 'required|string',
                'register_type' => 'required|string',
            ]);
            $data['register_type'] = 'international';
            // Giả sử $this->registration là model hoặc service
            $registration = $this->registrationServices->create($data);
            if ($registration->payment_method == 'online') {
                $this->registrationServices->sendMail($registration);
                $paymentUrl = $this->registrationServices->makeOnepayUrl($registration->toArray());
                return response()->json([
                    'status' => 'redirect',
                    'url' => $paymentUrl,
                ]);
            }
            if ($registration->payment_method == 'wire') {
                $this->registrationServices->sendMailWireTransfer($registration);
                $queryString = http_build_query($registration->toArray());
                $returnUrl = config('app.url') . '/registration/wire-transfer-response?' . $queryString;
                return response()->json([
                    'status' => 'redirect',
                    'url' => $returnUrl,
                ]);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            Log::error('Registration failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }

    public function registration_vietnamese_submit(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => 'required|string',
                'other_title' => 'nullable|string',
                'fullname' => 'required|string|max:255',
                'position' => 'nullable|string|max:255',
                'organization' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'other_dietary_requirement' => 'nullable|string|max:255',
                'country' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'required|email',
                'dietary_requirement' => 'required|string',
                'conference_type' => 'required|string',
                'paper_title' => 'nullable|string',
                'payment_method' => 'required|string',
                'register_type' => 'required|string',
            ]);
            $data['register_type'] = 'vietnamese';
            $registration = $this->registrationServices->create($data);
            if ($registration->payment_method == 'online') {
                $this->registrationServices->sendMail($registration);
                $paymentUrl = $this->registrationServices->makeOnepayUrl($registration->toArray());
                return response()->json([
                    'status' => 'redirect',
                    'url' => $paymentUrl,
                ]);
            }
            if ($registration->payment_method == 'wire') {
                $this->registrationServices->sendMailWireTransfer($registration);
                $queryString = http_build_query($registration->toArray());
                $returnUrl = config('app.url') . '/registration/wire-transfer-response?' . $queryString;
                return response()->json([
                    'status' => 'redirect',
                    'url' => $returnUrl,
                ]);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            Log::error('Registration failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }

    public function payment_response(Request $request)
    {
        $data = $request->all();
        $amount = $formatted =  number_format($data['vpc_Amount'] / 100, 2, '.', ',');
        if ($data['register_type'] == 'vietnamese') {
            $amount = (int) $data['vpc_Amount'] / 100;
            $amount = number_format($amount, 2, '.', '');
        }
        $vpc_TxnResponseCode = $data['vpc_TxnResponseCode'] ?? 'null';
        $id = $data['id'] ?? null;

        $lastSent = session()->get('mail_sent_' . $id);
        $now = now();
        $diff = $now->diffInSeconds($lastSent);
        $canSendMail = true;
        if ($lastSent) {
            $diff = $now->diffInSeconds($lastSent);
            if ($diff < 120) {
                $canSendMail = false;
            }
        }

        $registration = Registration::where('id', $id)->first();

        switch ($vpc_TxnResponseCode) {
            case '0':
                $registration->payment_status = 'success';
                $registration->total_fee = $amount;
                $registration->save();
                if ($canSendMail) {
                    $this->registrationServices->sendMail($registration);
                    session()->put('mail_sent_' . $id, $now);
                }
                return view('pages.registration-response.success', compact('data'));
            case '99':
                $registration->payment_status = 'cancelled';
                $registration->total_fee = $amount;
                $registration->save();
                if ($canSendMail) {
                    $this->registrationServices->sendMail($registration);
                    session()->put('mail_sent_' . $id, $now);
                }
                return view('pages.registration-response.cancelled', compact('data'));
            default:
                $registration->payment_status = 'failed';
                $registration->total_fee = $amount;
                $registration->save();
                if ($canSendMail) {
                    $this->registrationServices->sendMail($registration);
                    session()->put('mail_sent_' . $id, $now);
                }
                return view('pages.registration-response.failed', compact('data'));
        }
    }

    public function wire_transfer_response(Request $request)
    {
        $registration = $request->all();
        $registration['display_conference'] = json_decode($registration['display_conference']);
        return view('pages.registration-response.wire-transfer', compact('registration'));
    }
}
