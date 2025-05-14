<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\reg_stu_information;

class SaveStudentInfoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $requestData;
    protected $marhalaId;
    protected $userId;
    protected $madrashaId;
    protected $madrashaName;
    protected $userName;

    /**
     * Create a new job instance.
     */
    public function __construct($requestData, $marhalaId, $userId, $madrashaId, $madrashaName, $userName)
    {
        $this->requestData = $requestData;
        $this->marhalaId = $marhalaId;
        $this->userId = $userId;
        $this->madrashaId = $madrashaId;
        $this->madrashaName = $madrashaName;
        $this->userName = $userName;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get the latest active exam from exam_setups table
        $examSetup = DB::table('exam_setups')
            ->select('id', 'exam_name')
            ->latest('id')
            ->first();

        $marhala = DB::table('marhalas')
            ->select('id', 'marhala_name_bn')
            ->where('id', $this->marhalaId)
            ->first();

        // Get markaz ID from stu_rledger_p table
        $markazId = null;
        $markazName = null;

        $markazFromRledger = DB::table('stu_rledger_p')
            ->where('MRID', $this->madrashaId)
            ->select('MDID')
            ->first();

        if ($markazFromRledger) {
            $markazId = $markazFromRledger->MDID;
            // Get markaz name from madrasha table using the markaz ID
            $markazInfo = DB::table('madrasha')
                ->where('id', $markazId)
                ->select('MName')
                ->first();

            if ($markazInfo) {
                $markazName = $markazInfo->MName;
            }
        }

        // Create new record in reg_stu_informations table
        reg_stu_information::create([
            'current_madrasha' => $this->madrashaName,
            'madrasha_id' => $this->madrashaId,
            'user_id' => $this->userId,
            'user_name' => $this->userName,
            'exam_id' => $examSetup ? $examSetup->id : null,
            'exam_name_Bn' => $examSetup ? $examSetup->exam_name : null,
            'current_class' => $marhala ? $marhala->marhala_name_bn : null,
            'marhala_id' => $this->marhalaId,
            'markaz_id' => $markazId,
            'current_markaz' => $markazName,
            'name_bn' => $this->requestData['name_bn'],
            'name_en' => $this->requestData['name_en'],
            'name_ar' => $this->requestData['name_ar'],
            'father_name_bn' => $this->requestData['father_name_bn'],
            'father_name_en' => $this->requestData['father_name_en'],
            'father_name_ar' => $this->requestData['father_name_ar'],
            'mother_name_bn' => $this->requestData['mother_name_bn'],
            'mother_name_en' => $this->requestData['mother_name_en'],
            'mother_name_ar' => $this->requestData['mother_name_ar'],
            'BRN_no' => $this->requestData['BRN_no'],
            'NID_no' => $this->requestData['NID_no'],
            'class' => $this->requestData['class'] ?? null,
            'Division' => $this->requestData['Division'] ?? null,
            'Date_of_birth' => $this->requestData['Date_of_birth'] ?? null,
            'student_type' => $this->requestData['student_type'] ?? 'নিয়মিত',
            'current_class' => $this->requestData['current_class'] ?? null,
            'mobile_no' => $this->requestData['mobile_no'],
            'board_name' => $this->requestData['board_name'] ?? null,
            'present_division_name' => $this->requestData['present_division_name'],
            'presernt_DID' => $this->requestData['presernt_DID'],
            'present_district_name' => $this->requestData['present_district_name'],
            'present_desId' => $this->requestData['present_desId'] ?? null,
            'present_thana_name' => $this->requestData['present_thana_name'],
            'present_TID' => $this->requestData['present_TID'],
            'parmanent_division_name' => $this->requestData['parmanent_division_name'],
            'parmanent_DID' => $this->requestData['parmanent_DID'],
            'parmanent_district_name' => $this->requestData['parmanent_district_name'],
            'parmanent_desId' => $this->requestData['parmanent_desId'],
            'parmanent_thana_name' => $this->requestData['parmanent_thana_name'],
            'parmanent_TID' => $this->requestData['parmanent_TID'],
            'student_image' => $this->requestData['student_image_path'],
            'NID_attach' => $this->requestData['nid_attachment_path'],
        ]);
    }









}
