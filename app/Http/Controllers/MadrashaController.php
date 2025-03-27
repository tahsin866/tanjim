<?php

namespace App\Http\Controllers;
use App\Models\madrasha;
use Inertia\Inertia;
use App\Models\Madrasa;
use App\Models\Division;
use App\Models\District;
use App\Models\Thana;
use Illuminate\Http\Request;
use App\Exports\MadrasaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;


class MadrashaController extends Controller
{
    //
    // public function getMadrashaList(Request $request)
    // {
    //     $perPage = $request->input('per_page', 10);
    //     $page = $request->input('page', 1);

    //     $applications = Madrasha::query()
    //         ->select(/* your fields */)
    //         ->paginate($perPage);

    //     // Calculate proper from-to values
    //     $applications->from = ($page - 1) * $perPage + 1;
    //     $applications->to = min($page * $perPage, $applications->total());


    //     $applications = madrasha::select(
    //         'id',
    //         'MName as name',
    //         'ElhaqNo as Elhaq_no',
    //         'MType',
    //         'markaz_serial',
    //         'Mobile as mobile_no',
    //         'DID',
    //         // 'district',
    //         // 'Thana_uni as thana'
    //     )->paginate($perPage);

    //     $applications->getCollection()->transform(function ($app) {
    //         $app->MType = $app->MType == 0 ? 'ছাত্রী' : 'ছাত্র';
    //         return $app;
    //     });

    //     return response()->json($applications);
    // }








    public function getMadrashaList(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        $applications = Madrasha::with(['division', 'district', 'thana'])
            ->select(
                'id',
                'MName as name',
                'ElhaqNo as Elhaq_no',
                'MType',
                'markaz_serial',
                'Mobile as mobile_no',
                'DID',
                'DISID',
                'TID'
            )
            ->paginate($perPage);

        // Calculate proper from-to values
        $applications->from = ($page - 1) * $perPage + 1;
        $applications->to = min($page * $perPage, $applications->total());

        $applications->getCollection()->transform(function ($app) {
            $app->MType = $app->MType == 0 ? 'ছাত্রী' : 'ছাত্র';
            $app->division_name = $app->division ? $app->division->Division : null;
            $app->district_name = $app->district ? $app->district->District : null;
            $app->thana_name = $app->thana ? $app->thana->Thana : null;

            // রিলেশনশিপ অবজেক্টগুলো অপসারণ করে শুধু নামগুলো রাখা
            unset($app->division);
            unset($app->district);
            unset($app->thana);

            return $app;
        });

        return response()->json($applications);
    }



// markaz data fatch


public function getMarkazList(Request $request)
{
    $perPage = $request->input('per_page', 10);
    $page = $request->input('page', 1);

    $applications = madrasha::with(['division', 'district', 'thana'])
        ->select(
            'id',
            'MName as name',
            'ElhaqNo as Elhaq_no',
            'MType',
            'markaz_serial',
            'Mobile as mobile_no',
            'DID',
            'DISID',
            'TID'
        )
        ->whereNotNull('markaz_serial') // শুধু যেখানে markaz_serial আছে
        ->where('markaz_serial', '!=', '') // খালি স্ট্রিং বাদ দেওয়া (যদি প্রয়োজন হয়)
        ->paginate($perPage);

    // Calculate proper from-to values
    $applications->from = ($page - 1) * $perPage + 1;
    $applications->to = min($page * $perPage, $applications->total());

    $applications->getCollection()->transform(function ($app) {
        $app->MType = $app->MType == 0 ? 'ছাত্রী' : 'ছাত্র';
        $app->division_name = $app->division ? $app->division->Division : null;
        $app->district_name = $app->district ? $app->district->District : null;
        $app->thana_name = $app->thana ? $app->thana->Thana : null;

        // রিলেশনশিপ অবজেক্টগুলো অপসারণ করে শুধু নামগুলো রাখা
        unset($app->division);
        unset($app->district);
        unset($app->thana);

        return $app;
    });

    return response()->json($applications);
}



// এডমিনের মারকায ফিল্টার


public function filterMadrashas(Request $request)
{
    $query = Madrasha::query();

    // Always apply the markaz_serial condition first
    $query->whereNotNull('markaz_serial')
          ->where('markaz_serial', '!=', '');

    // মাদরাসার নাম/ইলহাক নম্বর ফিল্টার
    if ($request->filled('madrasahName')) {
        $searchTerm = $request->madrasahName;
        $query->where(function ($q) use ($searchTerm) {
            $q->where('MName', 'like', '%' . $searchTerm . '%')
              ->orWhere('ElhaqNo', 'like', '%' . $searchTerm . '%');
        });
    }

    // মাদরাসার ধরন ফিল্টার
    if ($request->filled('type')) {
        if ($request->type === 'ছাত্র') {
            $query->where('MType', 1);
        } elseif ($request->type === 'ছাত্রী') {
            $query->where('MType', 0);
        }
    }

    // মাদরাসার স্তর ফিল্টার
    if ($request->filled('level')) {
        switch ($request->level) {
            case 'takmil':
                $query->where('Stage', 1);
                break;
            case 'fazilat':
                $query->where('Stage', 2);
                break;
            case 'sanabiya_uliya':
                $query->where('Stage', 3);
                break;
            case 'sanabiya':
                $query->where('Stage', 4);
                break;
            case 'mutawassita':
                $query->where('Stage', 5);
                break;
            case 'ibtedaiya':
                $query->where('Stage', 6);
                break;
            case 'hifzul_quran':
                $query->where('Stage', 7);
                break;
            case 'ilmul_qiraat':
                $query->where('Stage', 8);
                break;
        }
    }

    // মারকাযের ধরন ফিল্টার
    if ($request->filled('status')) {
        if ($request->status === 'darsiyat') {
            $query->where('CenterD', 1);
        } elseif ($request->status === 'hifzul_quran') {
            $query->where('CenterH', 1);
        } elseif ($request->status === 'ilmul_qiraat') {
            $query->where('CenterK', 1);
        } elseif ($request->status === 'all') {
            $query->where(function ($q) {
                $q->where('CenterD', 1)
                  ->orWhere('CenterH', 1)
                  ->orWhere('CenterK', 1);
            });
        }
    }

    // বিভাগ ফিল্টার
    if ($request->filled('division')) {
        $query->where('DID', $request->division);
    }

    // জেলা ফিল্টার
    if ($request->filled('district')) {
        $query->where('DISID', $request->district);
    }

    // থানা ফিল্টার
    if ($request->filled('thana')) {
        $query->where('TID', $request->thana);
    }

    // ডেটা লোড
    $madrashas = $query->with(['division', 'district', 'thana'])->get();

    // ফরম্যাটিং
    $madrashas = $madrashas->map(function ($madrasha) {
        $madrasha->type = $madrasha->MType == 0 ? 'ছাত্রী' : 'ছাত্র';
        $madrasha->division_name = $madrasha->division ? $madrasha->division->Division : null;
        $madrasha->district_name = $madrasha->district ? $madrasha->district->District : null;
        $madrasha->thana_name = $madrasha->thana ? $madrasha->thana->Thana : null;

        // রিলেশনশিপ অবজেক্টগুলো অপসারণ
        unset($madrasha->division);
        unset($madrasha->district);
        unset($madrasha->thana);

        return $madrasha;
    });

    return response()->json($madrashas);
}




public function madrashaListUnderMarkaz($markazId)
{
    // Get all MRID values from stu_rledger_p table where MDID matches the markaz ID
    $mridValues = DB::table('stu_rledger_p')
        ->where('MDID', $markazId)
        ->pluck('MRID')
        ->unique()
        ->toArray();

    // Get only the names of madrashas where id matches any of the MRID values
    $madrashas = Madrasha::whereIn('id', $mridValues)
        ->select('id', 'MName as name','ElhaqNo')
        ->get();

    return Inertia::render('markaz_for_admin/madrasha_list_underMarkaz', [
        'madrashas' => $madrashas,
        'markazId' => $markazId
    ]);
}















    public function index(Request $request)
    {
        $query = madrasha::query()
            ->select('madrashas.*', 'divisions.divisionUni', 'districts.District_U', 'thanas.Thana_U')
            ->leftJoin('divisions', 'madrashas.division_id', '=', 'divisions.id')
            ->leftJoin('districts', 'madrashas.district_id', '=', 'districts.Des_ID')
            ->leftJoin('thanas', 'madrashas.thana_id', '=', 'thanas.id');

        if ($request->searchTerm) {
            $query->where(function($q) use ($request) {
                $q->where('MName_uni', 'LIKE', '%' . $request->searchTerm . '%')
                  ->orWhere('ElhaqNo', 'LIKE', '%' . $request->searchTerm . '%');
            });
        }

        if ($request->type) {
            $query->where('MType', $request->type);
        }

        if ($request->stage) {
            $query->where('Stage', $request->stage);
        }

        if ($request->division) {
            $query->where('madrashas.division_id', $request->division);
        }

        if ($request->district) {
            $query->where('madrashas.district_id', $request->district);
        }

        if ($request->thana) {
            $query->where('madrashas.thana_id', $request->thana);
        }

        return $query->paginate($request->per_page ?? 10);
    }

    public function getDivisions()
    {
        // Shows: ID=3, Division_U="সিলেট"
        return Division::select('id', 'Division as Division')->get();
    }

    public function getDistricts($divisionId)
    {
        // Shows districts where DID=3 (Sylhet Division)
        // Example: District_U="সুনামগঞ্জ", "মৌলভীবাজার", "হবিগঞ্জ", "সিলেট"
        return District::select('DesID', 'District')
            ->where('DID', $divisionId)  // DID=3 for Sylhet
            ->get();
    }

    public function getThanas($district_Id)
    {
        return Thana::select('Thana_ID', 'Thana')
            ->where('Des_ID', $district_Id)  // This matches thana.Des_ID with district.DesID
            ->get();
    }

    }
















