<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BulkMail;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Models\Contact;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class AdminHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified'])
            ->except(['root', 'login', 'register', 'lang']);
    }

    /** Dashboard / Index */
    public function index()
    {
        return view('admin.items.index');
    }

    /** Login Page */
    public function root()
    {
        $categories = Category::withCount('items')->get();
        $chartData = [
            'categories' => $categories->pluck('Category_Name')->toArray(),
            'itemCounts' => $categories->pluck('items_count')->toArray(),
        ];

        return view('auth.login', compact('chartData'));
    }

    /** Login */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            return match (Auth::user()->role) {
                'super-admin' => redirect()->route('dashboard'),
                'admin'       => redirect()->route('item.index'),
                'user'        => redirect()->route('home'),
                default       => back()->withErrors(['email' => 'You are not authorized.']),
            };
        }

        return back()->withErrors(['email' => 'The provided credentials are incorrect.'])
                     ->onlyInput('email');
    }

    /** Logout */
    public function logout(Request $request)
{
    // Delete API tokens if using Sanctum
    if ($request->user()) {
        $request->user()->tokens()->delete();
    }

    // Logout via the auth facade, not via $request->user()
    Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', '✅ Logged out successfully!');
}
public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        event(new \Illuminate\Auth\Events\Registered($user));

       return redirect()
    ->route('home')
    ->with('success', 'Registration successful. You are now logged in.');
    }
public function bulkAction(Request $request)
{
    $request->validate([
        'action' => 'required|in:send_message,send_email',
        'user_ids' => 'required|string',
        'message' => 'required|string',
        'subject' => 'required_if:action,send_email|string|max:255',
    ]);

    $userIds = explode(',', $request->user_ids);
    $users = User::whereIn('id', $userIds)->get();

    foreach ($users as $user) {
        if ($request->action === 'send_message') {
            // TODO: implement SMS sending
        } else if ($request->action === 'send_email') {
            Mail::to($user->email)->send(new BulkMail($request->subject, $request->message));
        }
    }

    return back()->with('success', '✅ Action sent successfully!');
}

public function userIndex()
    {
        // Eager load any relationships if needed
$users = User::orderBy('created_at', 'desc')->paginate(10); // 10 users per page

        // Get all permissions from role_permissions config
        $permissions = config('role_permissions.menu', []);

        return view('admin.users.index', compact('users', 'permissions'));
    }


  public function userDestroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
    /** Create User Form */
    public function create()
{
    $authUser = Auth::user();

    $permissions = [];

    // Only admins and super-admins can assign permissions
    if ($authUser->role !== 'user') {
        // Flatten all permissions from config
        $permissions = collect(config('role_permissions'))
            ->flatten()
            ->unique()
            ->map(function ($perm, $key) {
                return (object)[
                    'id' => $perm,
                    'name' => ucfirst(str_replace('_', ' ', $perm))
                ];
            });
    }

    return view('auth.usersadd', [
        'permissions' => $permissions,
        'authUser'    => $authUser,
    ]);
}
    /** Store User */
  /** Store User */
public function store(Request $request)
{
    $request->validate([
        'name'            => 'required|string|max:255',
        'email'           => 'required|email|unique:users,email',
        'password'        => 'required|string|min:6|confirmed',
        'role'            => 'required|in:user,admin,super-admin',
        'permissions'     => 'nullable|array',
        'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = $request->only(['name', 'email', 'role']);
    $data['password'] = Hash::make($request->password);

    // Only admin/super-admin can assign permissions
    if (Auth::user()->role !== 'user') {
        $data['permissions'] = $request->permissions ? json_encode($request->permissions) : null;
    }

    // Handle profile picture
    if ($request->hasFile('profile_picture')) {
        $file = $request->file('profile_picture');
        $filename = strtolower(str_replace(' ', '_', $request->name)) . '_profile.' . $file->getClientOriginalExtension();
        $file->storeAs('profile_picture', $filename, 'public');
        $data['profile_picture'] = 'profile_picture/' . $filename;
    }

    User::create($data);

    return redirect()->route('dashboard')->with('success', '✅ User added successfully!');
}
    /** Update Profile */
   /** Update Profile */
public function updateProfile(Request $request, User $user)
{
    // Validate only the fields that are present
    $validated = $request->validate([
        'username' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:users,email,' . $user->id,
        'password' => 'nullable|confirmed|min:6',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'role' => 'nullable|string|in:user,admin,super-admin',
        'permissions' => 'nullable|array',
    ]);

    // Update name/email only if present
    if (isset($validated['username'])) {
        $user->name = $validated['username'];
    }
    if (isset($validated['email'])) {
        $user->email = $validated['email'];
    }

    // Update password if provided
    if (!empty($validated['password'])) {
        $user->password = Hash::make($validated['password']);
    }

    // Update profile picture if provided
    if ($request->hasFile('profile_picture')) {
        // Delete old picture if exists
        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $path = $request->file('profile_picture')->store('profiles', 'public');
        $user->profile_picture = $path;
    }

    // Role & permissions updates only for admin/super-admin
    if (in_array(Auth::user()->role, ['admin', 'super-admin'])) {
        $user->role = $validated['role'] ?? $user->role;
        $user->permissions = $validated['permissions'] ?? $user->permissions;
    }

    $user->save();

    return back()->with('success', '✅ Profile updated successfully!');
}

public function updateProfilePicture(Request $request, User $user)
{
    $request->validate([
        'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    // Delete old picture if exists
    if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
        Storage::disk('public')->delete($user->profile_picture);
    }

    $path = $request->file('profile_picture')->store('profiles', 'public');
    $user->profile_picture = $path;
    $user->save();

    return back()->with('success', '✅ Profile picture updated successfully!');
}


public function userProfileEdit($id)
{
    $currentUser = Auth::user();
    $user = User::findOrFail($id);

    // Admin cannot edit super-admins
    if ($currentUser->role === 'admin' && $user->role === 'super-admin') {
        abort(403, 'You cannot edit a super-admin.');
    }

    return view('admin.items.profile.settings', [
        'editUser' => $user,
        'currentUser' => $currentUser,
    ]);
}
public function updateUserProfile(Request $request, $id = null)
{
    $currentUser = Auth::user();

    // Determine which user is being edited
    $user = $id ? User::findOrFail($id) : $currentUser;

    // Validation rules
    $rules = [
        'username' => 'required|string|max:255',
        'email' => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
        'password' => 'nullable|string|confirmed|min:6',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ];

    // Only super-admin/admin editing allowed users can change role & permissions
    if (($currentUser->role === 'super-admin') || ($currentUser->role === 'admin' && $user->role !== 'super-admin')) {
        $rules['role'] = ['required', Rule::in(['user','admin','super-admin'])];
        $rules['permissions'] = 'nullable|array';
    }

    $validated = $request->validate($rules);

    // Update basic fields
    $user->name = $validated['username'];
    $user->email = $validated['email'];

    // Update password if provided
    if (!empty($validated['password'])) {
        $user->password = Hash::make($validated['password']);
    }

    // Handle profile picture
    if ($request->hasFile('profile_picture')) {
        $file = $request->file('profile_picture');
        $path = $file->store('profiles', 'public');
        $user->profile_picture = $path;
    }

    // Handle role & permissions
    if (isset($validated['role'])) {
        // Admin cannot assign super-admin role
        if ($currentUser->role === 'admin' && $validated['role'] === 'super-admin') {
            return back()->withErrors(['role' => 'Admin cannot assign super-admin role.']);
        }
        $user->role = $validated['role'];

        // Permissions
        $permissions = $validated['permissions'] ?? [];

        // Admin cannot assign permissions they do not have
        if ($currentUser->role === 'admin') {
            $allowedPermissions = config('role_permissions.roles.admin');
            $permissions = array_intersect($permissions, $allowedPermissions);
        }

        $user->permissions = $permissions;
    }

    $user->save();

    return back()->with('success', 'Profile updated successfully.');
}

    /** Update Password */
    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password'         => 'required|string|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', '✅ Password updated successfully!');
    }

    /** Switch Language */
    public function lang($locale)
    {
        App::setLocale($locale);
        Session::put('lang', $locale);
        return redirect()->back()->with('locale', $locale);
    }

    /** Get Authenticated User (API) */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /** Dashboard Data */
    public function dashboardindex()
    {
        $usersCount      = User::count();
        $categoriesCount = Category::count();
        $itemsCount      = Item::count();
        $visitorsCount   = Visitor::count();

        $usersPerMonth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $itemsAdded    = Item::where('created_at', '>=', now()->subMonth())->count();
        $itemsModified = Item::where('updated_at', '>=', now()->subMonth())->count();

        $categoriesChartData = Category::withCount('items')
            ->get()
            ->map(fn($c) => [
                'category'    => $c->Category_Name,
                'items_count' => $c->items_count,
            ]);

        $latestUsers = User::latest()->take(5)->get();
        $latestItems = Item::latest()->take(5)->with('category.parent')->get();

        return view('admin.items.dashboard', compact(
            'usersCount',
            'categoriesCount',
            'itemsCount',
            'visitorsCount',
            'usersPerMonth',
            'itemsAdded',
            'itemsModified',
            'categoriesChartData',
            'latestUsers',
            'latestItems'
        ));
    }

    /** Delete Item */
    public function deleteItem($id)
    {
        $item = Item::find($id);

        if ($item) {
            $item->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    /** API JSON Data */
    public function data()
    {
        return response()->json([
            'usersCount'         => User::count(),
            'categoriesCount'    => Category::count(),
            'itemsCount'         => Item::count(),
            'visitorsCount'      => Visitor::count(),
            'usersPerMonth'      => User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                                        ->groupBy('month')
                                        ->pluck('count', 'month')
                                        ->toArray(),
            'itemsAdded'         => Item::where('created_at', '>=', now()->subMonth())->count(),
            'itemsModified'      => Item::where('updated_at', '>=', now()->subMonth())->count(),
            'categoriesChartData'=> Category::withCount('items')->get()->map(fn($c) => [
                'category'    => $c->Category_Name,
                'items_count' => $c->items_count,
            ]),
            'latestUsers'        => User::latest()->take(5)->get(),
            'latestItems'        => Item::latest()->take(5)->with('category.parent')->get(),
        ]);
    }


}
