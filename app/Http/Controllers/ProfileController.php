<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        // Check if this is a photo-only update (no other fields modified)
        $isPhotoOnly = $request->hasFile('profile_photo') && 
                       $request->filled('name') && 
                       $request->filled('email') &&
                       $request->name === $user->name &&
                       $request->email === $user->email;
        
        $validationRules = [
            'name'           => 'required|string|max:255',
            'email'          => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone'          => 'nullable|string|max:20',
            'date_of_birth'  => 'nullable|date',
            'gender'         => 'nullable|in:male,female,other',
            'address'        => 'nullable|string|max:500',
            'profile_photo'  => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'lrn'            => 'nullable|string|max:50',
            'grade_level'    => 'nullable|string|max:50',
            'section'        => 'nullable|string|max:50',
            'adviser'        => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'advisee'        => 'nullable|string|max:255',
        ];

        // For students, make certain fields required only if not photo-only update
        if ($user->isStudent() && !$isPhotoOnly) {
            $validationRules['lrn'] = 'required|string|max:50';
            $validationRules['grade_level'] = 'required|string|max:50';
            $validationRules['section'] = 'required|string|max:50';
            $validationRules['adviser'] = 'required|string|max:255';
            $validationRules['contact_person'] = 'required|string|max:255';
            $validationRules['contact_number'] = 'required|string|max:20';
        }

        $request->validate($validationRules);

        $data = [
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'date_of_birth'  => $request->date_of_birth,
            'gender'         => $request->gender,
            'address'        => $request->address,
            'lrn'            => $request->lrn,
            'grade_level'    => $request->grade_level,
            'section'        => $request->section,
            'adviser'        => $request->adviser,
            'contact_person' => $request->contact_person,
            'contact_number' => $request->contact_number,
            'advisee'        => $request->advisee,
        ];

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $user->update($data);

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function removePhoto()
    {
        $user = auth()->user();
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->update(['profile_photo' => null]);
        }
        return redirect()->route('profile')->with('success', 'Profile photo removed.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile')->with('success', 'Password updated successfully!');
    }
}
