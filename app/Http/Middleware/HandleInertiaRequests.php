<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\admin_permission;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $admin = $request->user('admin');
        
        // Load permissions if admin is logged in
        if ($admin) {
            $permissions = admin_permission::where('admin_id', $admin->id)->first();
            if ($permissions) {
                // Convert to array and remove unnecessary fields
                $permissionsArray = collect($permissions->toArray())
                    ->except(['id', 'admin_id', 'created_at', 'updated_at'])
                    ->toArray();
                
                // Add permissions to admin object
                $admin = $admin->toArray();
                $admin['permissions'] = $permissionsArray;
            }
        }
        
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'admin' => $admin,
            ],
        ];
    }
}
