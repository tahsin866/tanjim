<?php

namespace App\Http\Controllers;

 use Illuminate\Support\Facades\DB;
 use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class SslCommerzPaymentController extends Controller
{

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index(Request $request)
    {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'success',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , 'hosted': Direct redirect to gateway / 'checkout': Show payment options)
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            // Direct redirect URL returned, redirect user
            return redirect($payment_options);
        } else {
            // Array of payment options returned
            return view('payment-gateway', compact('payment_options', 'post_data'));
        }

    }

public function payViaAjax(Request $request)
{
    Log::info('payViaAjax method called', ['request_data' => $request->all()]);
    
    try {
        // রেজিস্ট্রেশন validation রুলস
        $rules = [
            'fullNameBangla' => 'required|string|max:255',
            'fullNameEnglish' => 'required|string|max:255',
            'fatherName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phoneNumber' => 'required|string|digits:11|unique:users,phoneNumber',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'alternatePhoneNumber' => 'nullable|string|max:15',
            'dateOfBirth' => 'required|date',
            'bloodGroup' => 'nullable|string|max:255',
            'address' => 'required|string',
            'division' => 'required|integer',
            'district' => 'required|integer',
            'thana' => 'required|integer',
            'classmate1' => 'required|string|max:255',
            'classmate2' => 'required|string|max:255',
            'classmate3' => 'required|string|max:255',
            'dept_takmil' => 'boolean',
            'dept_ifta' => 'boolean',
            'dept_hifz' => 'boolean',
            'dept_qirat' => 'boolean',
            'dept_adab' => 'boolean',
            'dept_other' => 'boolean',
            'dept_takmil_year_english' => 'nullable|string|max:255',
            'dept_takmil_year_hijri' => 'nullable|string|max:255',
            'dept_ifta_year_english' => 'nullable|string|max:255',
            'dept_ifta_year_hijri' => 'nullable|string|max:255',
            'dept_hifz_year_english' => 'nullable|string|max:255',
            'dept_hifz_year_hijri' => 'nullable|string|max:255',
            'dept_qirat_year_english' => 'nullable|string|max:255',
            'dept_qirat_year_hijri' => 'nullable|string|max:255',
            'dept_adab_year_english' => 'nullable|string|max:255',
            'dept_adab_year_hijri' => 'nullable|string|max:255',
            'dept_other_class' => 'nullable|string|max:255',
            'examType' => 'required|string|max:255',
            'workplace' => 'nullable|string|max:255',
            'idType' => 'required|string|in:birth,voter,passport',
            'birthCertificate' => 'nullable|string|size:17|numeric',
            'voterId' => [
                'nullable',
                'string',
                'numeric',
                function ($attribute, $value, $fail) {
                    if ($value && (strlen($value) != 10 && strlen($value) != 17)) {
                        $fail('ভোটার আইডি অবশ্যই ১০ অথবা ১৭ সংখ্যার হতে হবে।');
                    }
                },
            ],
            'passport_id' => 'nullable|string|max:100',
        ];

        // Conditional validation
        if ($request->examType && $request->examType !== 'জানা নেই') {
            $rules['rollNumber'] = 'required|string|max:255';
        } else {
            $rules['rollNumber'] = 'nullable|string|max:255';
        }

        if ($request->idType === 'passport') {
            $rules['passport_id'] = 'required|string|max:100';
        }

        $validatedData = $request->validate($rules);

        // User তৈরি করি
        $user = User::create([
            'fullNameBangla' => $validatedData['fullNameBangla'],
            'fullNameEnglish' => $validatedData['fullNameEnglish'],
            'fatherName' => $validatedData['fatherName'],
            'email' => $validatedData['email'],
            'phoneNumber' => $validatedData['phoneNumber'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // User information তৈরি করি
        $this->createUserInformation($request, $user, $validatedData);

        // Payment ডাটা তৈরি
        $amount = $request->amount ?? 500; // Default পেমেন্ট এমাউন্ট
        $currency = 'BDT';
        $tran_id = uniqid();

        // Orders টেবিলে ইনসার্ট
        DB::table('orders')->insert([
            'user_id' => $user->id,
            'amount' => $amount,
            'status' => 'Pending',
            'transaction_id' => $tran_id,
            'currency' => $currency
        ]);

        // User register ইভেন্ট ফায়ার
        event(new Registered($user));
        Auth::login($user);

        // Payment post ডাটা তৈরি করি
        $post_data = array();
        $post_data['total_amount'] = $amount;
        $post_data['currency'] = $currency;
        $post_data['tran_id'] = $tran_id;

        // Customer information
        $post_data['cus_name'] = $user->fullNameEnglish;
        $post_data['cus_email'] = $user->email;
        $post_data['cus_add1'] = $validatedData['address'] ?? 'N/A';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $user->phoneNumber;
        $post_data['cus_fax'] = "";

        // Shipment information
        $post_data['ship_name'] = $user->fullNameEnglish;
        $post_data['ship_add1'] = $validatedData['address'] ?? 'N/A';
        $post_data['ship_add2'] = "";
        $post_data['ship_city'] = "";
        $post_data['ship_state'] = "";
        $post_data['ship_postcode'] = "";
        $post_data['ship_phone'] = $user->phoneNumber;
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Registration Fee";
        $post_data['product_category'] = "Service";
        $post_data['product_profile'] = "general";

$post_data['success_url'] = config('sslcommerz.success_url');
$post_data['fail_url'] = config('sslcommerz.failed_url');
$post_data['cancel_url'] = config('sslcommerz.cancel_url');
$post_data['ipn_url'] = config('sslcommerz.ipn_url');

        // Optional parameters
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        // SSLCommerz payment gateway এ রিডাইরেক্ট
        $sslc = new SslCommerzNotification();
        $payment_options = $sslc->makePayment($post_data, 'checkout');

        // AJAX response হিসেবে JSON return করুন, redirect নয়
        if (is_string($payment_options)) {
            $decoded = json_decode($payment_options, true);
            if (isset($decoded['status']) && ($decoded['status'] === 'SUCCESS' || $decoded['status'] === 'success')) {
                return response()->json([
                    'success' => true,
                    'redirect_url' => $decoded['data'],
                    'message' => 'Payment gateway এ redirect করা হচ্ছে...'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $decoded['message'] ?? 'পেমেন্ট গেটওয়ে এরর।'
                ], 400);
            }
        } else {
            // If array returned
            if (isset($payment_options['GatewayPageURL'])) {
                return response()->json([
                    'success' => true,
                    'redirect_url' => $payment_options['GatewayPageURL'],
                    'message' => 'Payment gateway এ redirect করা হচ্ছে...'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'পেমেন্ট গেটওয়ে URL পাওয়া যায়নি।'
                ], 400);
            }
        }

    } catch (\Exception $e) {
        Log::error('Payment error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        return response()->json([
            'success' => false, 
            'message' => $e->getMessage()
        ], 500);
    }
}



    private function createUserInformation(Request $request, User $user, array $validatedData)
    {
        $informationData = [
            'user_id' => $user->id,
            'alternatePhoneNumber' => $validatedData['alternatePhoneNumber'] ?? null,
            'dateOfBirth' => $validatedData['dateOfBirth'] ?? null,
            'bloodGroup' => $validatedData['bloodGroup'] ?? null,
            'address' => $validatedData['address'] ?? null,
            'division_id' => $validatedData['division'] ?? null,
            'district_id' => $validatedData['district'] ?? null,
            'thana_id' => $validatedData['thana'] ?? null,
            'classmate1' => $validatedData['classmate1'] ?? null,
            'classmate2' => $validatedData['classmate2'] ?? null,
            'classmate3' => $validatedData['classmate3'] ?? null,
            'dept_takmil' => !empty($validatedData['dept_takmil']) ? 1 : 0,
            'dept_ifta' => !empty($validatedData['dept_ifta']) ? 1 : 0,
            'dept_hifz' => !empty($validatedData['dept_hifz']) ? 1 : 0,
            'dept_qirat' => !empty($validatedData['dept_qirat']) ? 1 : 0,
            'dept_adab' => !empty($validatedData['dept_adab']) ? 1 : 0,
            'dept_other' => !empty($validatedData['dept_other']) ? 1 : 0,
            'dept_takmil_year_english' => $validatedData['dept_takmil_year_english'] ?? null,
            'dept_takmil_year_hijri' => $validatedData['dept_takmil_year_hijri'] ?? null,
            'dept_ifta_year_english' => $validatedData['dept_ifta_year_english'] ?? null,
            'dept_ifta_year_hijri' => $validatedData['dept_ifta_year_hijri'] ?? null,
            'dept_hifz_year_english' => $validatedData['dept_hifz_year_english'] ?? null,
            'dept_hifz_year_hijri' => $validatedData['dept_hifz_year_hijri'] ?? null,
            'dept_qirat_year_english' => $validatedData['dept_qirat_year_english'] ?? null,
            'dept_qirat_year_hijri' => $validatedData['dept_qirat_year_hijri'] ?? null,
            'dept_adab_year_english' => $validatedData['dept_adab_year_english'] ?? null,
            'dept_adab_year_hijri' => $validatedData['dept_adab_year_hijri'] ?? null,
            'dept_other_class' => $validatedData['dept_other_class'] ?? null,
            'examType' => $validatedData['examType'] ?? null,
            'rollNumber' => $validatedData['rollNumber'] ?? null,
            'workplace' => $validatedData['workplace'] ?? null,
            'idType' => $validatedData['idType'] ?? null,
            'birthCertificate' => $validatedData['birthCertificate'] ?? null,
            'voterId' => $validatedData['voterId'] ?? null,
            'passport_id' => $validatedData['passport_id'] ?? null
        ];

        if ($request->hasFile('birthCertificatePhoto')) {
            $informationData['birthCertificatePhoto'] = $request->file('birthCertificatePhoto')->store('user-documents', 'public');
        }

        if ($request->hasFile('voterIdPhoto')) {
            $informationData['voterIdPhoto'] = $request->file('voterIdPhoto')->store('user-documents', 'public');
        }

        if ($request->hasFile('passport_photo')) {
            $informationData['passport_photo'] = $request->file('passport_photo')->store('user-documents', 'public');
        }

        if ($request->hasFile('photo')) {
            $informationData['photo'] = $request->file('photo')->store('user-photos', 'public');
        }

        UserInformation::create($informationData);
    }

  public function success(Request $request)
{
    $tran_id = $request->input('tran_id');
    
    if ($tran_id) {
        // Update order status to complete
        DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->update(['status' => 'Complete']);
        
        // Get order details to find user
        $order = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->first();
            
        if ($order && $order->user_id) {
            $user = User::find($order->user_id);
            if ($user && !Auth::check()) {
                Auth::login($user);
            }
        }
        
        Log::info('Payment successful', ['transaction_id' => $tran_id]);
    }
    
    return redirect('/')->with('success', 'পেমেন্ট সফল হয়েছে! রেজিস্ট্রেশন সম্পন্ন হয়েছে।');
}

public function fail(Request $request)
{
    $tran_id = $request->input('tran_id');
    
    if ($tran_id) {
        // Update order status to failed
        DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->update(['status' => 'Failed']);
            
        // Get order details and delete user if exists
        $order = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->first();
            
        if ($order && $order->user_id) {
            // Delete user and related data
            $user = User::find($order->user_id);
            if ($user) {
                UserInformation::where('user_id', $user->id)->delete();
                $user->delete();
            }
        }
        
        Log::info('Payment failed', ['transaction_id' => $tran_id]);
    }
    
    return redirect()->route('register')->with('error', 'পেমেন্ট ব্যর্থ হয়েছে! অনুগ্রহ করে আবার চেষ্টা করুন।');
}

  public function cancel(Request $request)
{
    $tran_id = $request->input('tran_id');
    
    if ($tran_id) {
        // Update order status to cancelled
        DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->update(['status' => 'Cancelled']);
            
        // Get order details and delete user if exists
        $order = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->first();
            
        if ($order && $order->user_id) {
            // Delete user and related data
            $user = User::find($order->user_id);
            if ($user) {
                UserInformation::where('user_id', $user->id)->delete();
                $user->delete();
            }
        }
        
        Log::info('Payment cancelled', ['transaction_id' => $tran_id]);
    }
    
    return redirect()->route('register')->with('warning', 'পেমেন্ট বাতিল করা হয়েছে!');
}

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }

}
