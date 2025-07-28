<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\District;
use App\Models\Thana;
use Illuminate\Http\Request;

class DivishionController extends Controller
{
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
