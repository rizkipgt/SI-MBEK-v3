<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdminProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('superadmin.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(SuperAdminProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('super-admin.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::guard('super_admin')->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/super-admin/login');
    }
    public function destroyuser(User $user)
{
    $imagePath = public_path('upload/profilImage/' . $user->profile_picture);

    // Cek dulu apakah user punya foto dan file-nya ada
    if ($user->profile_picture && file_exists($imagePath)) {
        // Opsional: atur permission jika memang perlu
        @chmod($imagePath, 0755);

        // Hapus file
        @unlink($imagePath);
    }

    // Hapus user dari database
    $user->delete();

    return redirect()->back()->with('success', 'Data user berhasil dihapus');
}


    public function penitip(Request $request, $type = null)
{
    $query = User::query()->withCount(['kambing', 'domba']);
    
    if ($type) {
        $relation = $type === 'kambing' ? 'kambing' : 'domba';
        $query->has($relation);
    }

    $users = $query->paginate(10);
    
    return view('superadmin.pengguna', [
        'users' => $users,
        'currentType' => $type
    ]);
}
}
