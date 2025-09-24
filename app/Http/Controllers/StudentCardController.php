<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\User;
use Inertia\Inertia;

class StudentCardController extends Controller
{
    // Show registration card view (for preview/download)
    public function show($id)
    {
        $student = User::findOrFail($id);
        $qrData = json_encode([
            'id' => $student->id,
            'name' => $student->fullNameBangla,
            'session_year' => $student->session_year,
            'phone' => $student->phoneNumber,
        ]);
        $qrCode = QrCode::format('svg')->size(150)->generate($qrData);
        return Response::make($qrCode, 200, [
            'Content-Type' => 'image/svg+xml',
            'Content-Disposition' => 'inline; filename="student_qr_'.$student->id.'.svg"',
        ]);
    }

    // API endpoint for card data (for Vue)
    public function cardData($id)
    {
        $student = User::findOrFail($id);
        return response()->json([
            'id' => $student->id,
            'name' => $student->fullNameBangla,
            'session_year' => $student->session_year,
            'phone' => $student->phoneNumber,
            'photo' => $student->photo,
        ]);
    }
}
