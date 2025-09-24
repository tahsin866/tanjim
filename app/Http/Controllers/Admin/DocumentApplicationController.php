<?php

namespace App\Http\Controllers\Admin;
use App\Services\DocumentApplicationService;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;




class DocumentApplicationController extends Controller
{
    /**
     * Display document application list
     */
protected DocumentApplicationService $documentApplicationService;

    public function __construct(DocumentApplicationService $documentApplicationService)
    {
        $this->documentApplicationService = $documentApplicationService;
    }

    public function index(Request $request): Response|RedirectResponse
    {
        $currentAdmin = Auth::guard('admin')->user();
        Log::info('DocumentApplicationController accessed', [
            'admin_id' => $currentAdmin->id,
            'admin_role' => $currentAdmin->role,
            'permissions' => $currentAdmin->permissions,
            'permissions_type' => gettype($currentAdmin->permissions)
        ]);

        // Service-এ permission check
        if (!$this->documentApplicationService->hasAccess($currentAdmin)) {
            Log::warning("DocumentApplicationController: Moderator {$currentAdmin->id} lacks document_management_access. Redirecting to dashboard.");
            return redirect()
                ->route('admin.admin_Dashboard')
                ->withErrors(['error' => 'আপনার দস্তরবন্দি ব্যবস্থাপনার অনুমতি নেই।']);
        }

        // Data fetch Service-এর মাধ্যমে
        $data = $this->documentApplicationService->getIndexData($request, $currentAdmin);

        return Inertia::render('admin/DocumentApplications/Index', $data);
    }






 public function getApproveList(Request $request): Response|RedirectResponse
    {
        $currentAdmin = Auth::guard('admin')->user();

        Log::info('DocumentApplicationController accessed', [
            'admin_id' => $currentAdmin->id,
            'admin_role' => $currentAdmin->role,
            'permissions' => $currentAdmin->permissions,
            'permissions_type' => gettype($currentAdmin->permissions)
        ]);

        if (!$this->documentApplicationService->hasAccess($currentAdmin)) {
            Log::warning("DocumentApplicationController: Moderator {$currentAdmin->id} lacks document_management_access. Redirecting to dashboard.");
            return redirect()
                ->route('admin.admin_Dashboard')
                ->withErrors(['error' => 'আপনার দস্তরবন্দি ব্যবস্থাপনার অনুমতি নেই।']);
        }

        $data = $this->documentApplicationService->getApproveListData($request, $currentAdmin);

        return Inertia::render('admin/DocumentApplications/aprovedList', $data);
    }











    /**
     * Show user details
     */
    public function show(User $user): Response|RedirectResponse
    {
        $currentAdmin = Auth::guard('admin')->user();
        $result = $this->documentApplicationService->getUserDetails($user, $currentAdmin);
        if (isset($result['error'])) {
            if ($result['error'] === 'permission') {
                Log::warning('DocumentApplicationController: Moderator ' . $currentAdmin->id . ' lacks document_management_access. Redirecting to dashboard.');
                return redirect()->route('admin.admin_Dashboard')->withErrors(['error' => 'আপনার দস্তরবন্দি ব্যবস্থাপনার অনুমতি নেই।']);
            } elseif ($result['error'] === 'graduation_year') {
                Log::warning('DocumentApplicationController: Moderator ' . $currentAdmin->id . ' tried to view user ' . $user->id . ' outside their graduation year. Redirecting.');
                return redirect()->route('admin.documents.applications.index')->withErrors(['error' => 'আপনি শুধুমাত্র আপনার পাস সালের ডাটা দেখতে পারেন।']);
            }
        }
        return Inertia::render('admin/DocumentApplications/Show', $result);
    }

    /**
     * Approve user application
     */
    public function approve(User $user): RedirectResponse
    {
        $currentAdmin = Auth::guard('admin')->user();
        $result = $this->documentApplicationService->approveUser($user, $currentAdmin);
        if (isset($result['error'])) {
            if ($result['error'] === 'permission') {
                return redirect()->back()->withErrors(['error' => 'আপনার অনুমোদন দেওয়ার অনুমতি নেই।']);
            } elseif ($result['error'] === 'graduation_year') {
                return redirect()->back()->withErrors(['error' => 'আপনি শুধুমাত্র আপনার পাস সালের আবেদন অনুমোদন করতে পারেন।']);
            }
        }
        Log::info("User {$user->id} approved by admin {$currentAdmin->id}");
        return redirect()->back()->with('success', 'আবেদনটি সফলভাবে অনুমোদন করা হয়েছে।');
    }

    /**
     * Reject user application - Only Super Admin
     */
    public function reject(User $user): RedirectResponse
    {
        $currentAdmin = Auth::guard('admin')->user();
        $result = $this->documentApplicationService->rejectUser($user, $currentAdmin);
        if (isset($result['error'])) {
            return redirect()->back()->withErrors(['error' => 'শুধুমাত্র সুপার এডমিন আবেদন বাতিল করতে পারেন।']);
        }
        Log::info("User {$user->id} rejected by super admin {$currentAdmin->id}");
        return redirect()->back()->with('success', 'আবেদনটি সফলভাবে বাতিল করা হয়েছে।');
    }

    /**
     * Suspend user application - Only Super Admin
     */
    public function suspend(User $user): RedirectResponse
    {
        $currentAdmin = Auth::guard('admin')->user();
        $result = $this->documentApplicationService->suspendUser($user, $currentAdmin);
        if (isset($result['error'])) {
            return redirect()->back()->withErrors(['error' => 'শুধুমাত্র সুপার এডমিন আবেদন স্থগিত করতে পারেন।']);
        }
        Log::info("User {$user->id} suspended by super admin {$currentAdmin->id}");
        return redirect()->back()->with('success', 'আবেদনটি সফলভাবে স্থগিত করা হয়েছে।');
    }

    /**
     * Delete user application - Only Super Admin
     */
    public function destroy(User $user): RedirectResponse
    {
        $currentAdmin = Auth::guard('admin')->user();
        $result = $this->documentApplicationService->deleteUser($user, $currentAdmin);
        if (isset($result['error'])) {
            return redirect()->back()->withErrors(['error' => 'শুধুমাত্র সুপার এডমিন আবেদন মুছতে পারেন।']);
        }
        Log::info("User {$user->id} ({$user->fullNameBangla}) deleted by super admin {$currentAdmin->id}");
        return redirect()->route('admin.documents.applications.index')->with('success', "আবেদনটি ({$result['userName']}) সফলভাবে মুছে ফেলা হয়েছে।");
    }

    /**
     * Check if admin has specific permission
     */
    private function checkPermission($admin, $permission)
    {
        // Super admin has all permissions
        if ($admin->role === 'super_admin') {
            return true;
        }

        $permissions = $admin->permissions;
        
        // Handle permissions as both array and object format
        if (is_string($permissions)) {
            try {
                $permissions = json_decode($permissions, true);
            } catch (\Exception $e) {
                return false;
            }
        }
        
        if (is_array($permissions)) {
            // Check if it's indexed array (like ['permission1', 'permission2'])
            if (isset($permissions[0])) {
                return in_array($permission, $permissions);
            }
            // Check if it's associative array (like ['permission1' => true])
            return isset($permissions[$permission]) && $permissions[$permission] === true;
        }
        
        return false;
    }
}
