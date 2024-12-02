<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
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

     public function show(): View
    {
        return view('chat.show');
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
        ]);
    
        $user = $request->user();
        $user->name = $request->name;
        $user->email = $request->email;
    
        $user->save();
    
        return response()->json(['message' => 'Profile updated successfully.']);
    }
    
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);
    
        $user = $request->user();
    
        Auth::logout();
    
        $user->delete();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return response()->json(['message' => 'User account deleted successfully.']);
    }
    
          
    public function logout(Request $request)
    {
        Auth::logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken();  
    
        return response()->json(['message' => 'User logged out successfully.'], 200);
    }
    
}
