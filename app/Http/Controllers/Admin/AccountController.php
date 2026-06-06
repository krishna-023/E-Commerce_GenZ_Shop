<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;


class AccountController extends Controller
{
   public function accountSettings()
{
    $user = Auth::user();

    $addresses = $user->addresses ?? [];
    $notifications = $user->notification_settings ?? [
        'email' => true,
        'sms' => false,
    ];
    $theme = $user->theme ?? 'light';

    return view('admin.account.settings', compact('user', 'addresses', 'notifications', 'theme'));
}

    public function saveAddress(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:50',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:50',
            'zip' => 'nullable|string|max:10',
        ]);

        $user = Auth::user();
        $user->addresses = array_merge($user->addresses ?? [], [$request->only('label','address','city','zip')]);
        $user->save();

        return back()->with('success', '✅ Delivery address saved!');
    }

    public function savePayment(Request $request)
    {
        $request->validate([
            'esewa_id' => 'required|string|max:100',
        ]);

        $user = Auth::user();
        $user->esewa_id = $request->esewa_id;
        $user->save();

        return back()->with('success', '✅ eSewa account linked successfully!');
    }

   public function saveNotificationSettings(Request $request)
{
    $request->validate([
        'email' => 'required|boolean',
        'sms'   => 'required|boolean',
    ]);

    $user = Auth::user();
    $user->notification_settings = $request->only(['email', 'sms']);
    $user->save();

    return back()->with('success', 'Notification settings updated successfully!');
}
    public function saveTheme(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:light,dark',
        ]);

        $user = Auth::user();
        $user->theme = $request->theme;
        $user->save();

        return back()->with('success', '✅ Theme updated successfully!');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:6',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        $user->name = $validated['username'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $user->profile_picture = $request->file('profile_picture')->store('profiles', 'public');
        }

        $user->save();

        return back()->with('success', '✅ Profile updated successfully!');
    }
}

