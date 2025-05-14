<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            
            // Setup related permissions
            $table->boolean('setup_access')->default(false);
            $table->boolean('marhala_setup')->default(false);
            $table->boolean('subject_setup')->default(false);
            $table->boolean('central_exam_setup')->default(false);
            $table->boolean('user_setup')->default(false);
            $table->boolean('instruction')->default(false);
            
            // Bill related permissions
            $table->boolean('bill_access')->default(false);
            $table->boolean('negran_bill')->default(false);
            $table->boolean('mumtahin_bill')->default(false);
            $table->boolean('markaz_admin_bill')->default(false);
            $table->boolean('zonal_bill')->default(false);
            
            // Madrasa related permissions
            $table->boolean('madrasa_access')->default(false);
            $table->boolean('madrasa_list')->default(false);
            $table->boolean('madrasa_misc')->default(false);
            $table->boolean('madrasa_admin')->default(false);
            $table->boolean('draft_soft_delete')->default(false);
            $table->boolean('madrasa_payment')->default(false);
            
            // Markaz related permissions
            $table->boolean('markaz_access')->default(false);
            $table->boolean('markaz_application_list')->default(false);
            $table->boolean('proposed_markaz')->default(false);
            $table->boolean('markaz_list')->default(false);
            $table->boolean('markaz_change_application')->default(false);
            $table->boolean('markaz_admin')->default(false);
            $table->boolean('markaz_admin_training')->default(false);
            $table->boolean('markaz_group')->default(false);
            $table->boolean('answer_sheet_group_setup')->default(false);
            $table->boolean('mumtahin_group')->default(false);
            
            // Exam routine permissions
            $table->boolean('exam_routine_access')->default(false);
            $table->boolean('exam_routine_group')->default(false);
            $table->boolean('exam_routine')->default(false);
            $table->boolean('oral_exam_mumtahin')->default(false);
            
            // Registration related permissions
            $table->boolean('registration_access')->default(false);
            $table->boolean('madrasa_list_reg')->default(false);
            $table->boolean('registration_list')->default(false);
            $table->boolean('cancelled_registration_list')->default(false);
            $table->boolean('payment_list')->default(false);
            $table->boolean('board_return_list')->default(false);
            $table->boolean('registration_card_create')->default(false);
            
            // Inclusion related permissions
            $table->boolean('inclusion_access')->default(false);
            $table->boolean('inclusion_list')->default(false);
            $table->boolean('roll_generate')->default(false);
            $table->boolean('admit_card_create')->default(false);
            $table->boolean('inclusion_payment')->default(false);
            $table->boolean('cancelled_inclusion_list')->default(false);
            
            // Khata and Loose related permissions
            $table->boolean('khata_loose_access')->default(false);
            $table->boolean('khata_loose_setup')->default(false);
            $table->boolean('khata_loose_generate')->default(false);
            $table->boolean('khata_loose_account')->default(false);
            $table->boolean('khata_loose_others')->default(false);
            
            // Negran related permissions
            $table->boolean('negran_access')->default(false);
            $table->boolean('negran_application_list')->default(false);
            $table->boolean('negran_proposed_list')->default(false);
            $table->boolean('negran_pending_list')->default(false);
            $table->boolean('negran_cancelled_list')->default(false);
            $table->boolean('negran_mumtahin_list')->default(false);
            $table->boolean('negran_report')->default(false);
            $table->boolean('negran_allowance')->default(false);
            
            // Mumtahin related permissions
            $table->boolean('mumtahin_access')->default(false);
            $table->boolean('mumtahin_application_list')->default(false);
            $table->boolean('mumtahin_proposed_list')->default(false);
            $table->boolean('inspector_setup')->default(false);
            $table->boolean('mumtahin_list')->default(false);
            $table->boolean('darsiyat_mumtahin')->default(false);
            $table->boolean('hifz_mumtahin_selection')->default(false);
            $table->boolean('kirat_mumtahin_selection')->default(false);
            $table->boolean('mumtahin_training')->default(false);
            
            // Zone related permissions
            $table->boolean('zone_access')->default(false);
            $table->boolean('zone_setup')->default(false);
            $table->boolean('zonal_selection')->default(false);
            $table->boolean('sub_zone_setup')->default(false);
            $table->boolean('zone_wise_markaz_setup')->default(false);
            
            // Attendance related permissions
            $table->boolean('attendance_access')->default(false);
            $table->boolean('examinee_attendance')->default(false);
            $table->boolean('negran_attendance')->default(false);
            
            // Result related permissions
            $table->boolean('result_access')->default(false);
            $table->boolean('result_condition')->default(false);
            $table->boolean('merit_condition')->default(false);
            $table->boolean('inspection_formula')->default(false);
            $table->boolean('darsiyat_result')->default(false);
            $table->boolean('oral_result')->default(false);
            $table->boolean('result_correction')->default(false);
            $table->boolean('result_review')->default(false);
            $table->boolean('review_result_correction')->default(false);
            
            // Other permissions
            $table->boolean('messaging')->default(false);
            $table->boolean('notice')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_permissions');
    }
};
