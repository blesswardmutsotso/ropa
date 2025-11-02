<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class DashboardController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function admin()
    {
        $user = auth()->user();
        return view('admindashboard.dashboard', compact('user'));
    }

    /**
     * Show user dashboard.
     */
    public function user()
    {
        $user = auth()->user();
        return view('dashboard', compact('user'));
    }

    /**
     * Show profile edit form.
     */
    public function edit()
    {
        $user = auth()->user();
        return view('admin.edit', compact('user'));
    }

    /**
     * Update user profile.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'required',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update user fields
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }



    /**
     * Show all users for admin (User Management).
     */
   public function adminUsersIndex(Request $request)
{
    // Capture the search input
    $search = $request->input('search');

    // Query users with optional search
    $users = User::query()
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('job_title', 'like', "%{$search}%");
        })
        ->orderBy('name')
        ->paginate(10);

    return view('admindashboard.user.index', compact('users', 'search'));
}



public function editUser($id)
{
    $user = User::findOrFail($id);
    return view('admindashboard.user.edit', compact('user'));
}

public function updateUser(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'user_type' => 'required|in:0,1',
        'department' => 'nullable|string|max:255',
        'job_title' => 'nullable|string|max:255',
    ]);

    $user = User::findOrFail($id);
    $user->update($request->only(['name', 'email', 'user_type', 'department', 'job_title']));

    return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
}



public function toggleStatus(User $user)
{
    // Prevent admin from changing their own status
    if (auth()->id() === $user->id) {
        return redirect()->route('admin.users.index')
                         ->with('error', 'You cannot change your own account status.');
    }

    // Toggle the active status
    $user->active = !$user->active;
    $user->save();

    $status = $user->active ? 'activated' : 'deactivated';

    return redirect()->route('admin.users.index')
                     ->with('success', "User account {$status} successfully.");
}


public function show(User $user)
{
    return view('admindashboard.user.show', compact('user'));
}



}
