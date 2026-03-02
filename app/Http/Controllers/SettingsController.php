<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $settings = $user->settings ?? [];
        return view('settings', compact('settings'));
    }

    public function updateNotifications(Request $request)
    {
        $user = auth()->user();
        $current = $user->settings ?? [];

        $current['email_concerns']      = $request->has('email_concerns');
        $current['email_appointments']  = $request->has('email_appointments');
        $current['email_system']        = $request->has('email_system');
        $current['app_concerns']        = $request->has('app_concerns');
        $current['app_appointments']    = $request->has('app_appointments');
        $current['app_messages']        = $request->has('app_messages');

        $user->update(['settings' => $current]);

        return redirect()->route('settings')->with('success', 'Notification settings saved successfully!');
    }

    public function updatePrivacy(Request $request)
    {
        $user = auth()->user();
        $current = $user->settings ?? [];

        $current['show_email']          = $request->has('show_email');
        $current['show_phone']          = $request->has('show_phone');
        $current['anonymous_default']   = $request->has('anonymous_default');
        $current['data_analytics']      = $request->has('data_analytics');
        $current['remember_login']      = $request->has('remember_login');

        $user->update(['settings' => $current]);

        return redirect()->route('settings')->with('success', 'Privacy settings saved successfully!');
    }

    public function updateCounseling(Request $request)
    {
        $user = auth()->user();
        $current = $user->settings ?? [];

        $request->validate([
            'preferred_counselor'  => ['nullable', 'integer'],
            'appointment_reminder' => ['required', 'in:15,30,60,1440'],
            'contact_method'       => ['required', 'in:email,phone,both'],
        ]);

        $current['preferred_counselor']  = $request->preferred_counselor;
        $current['appointment_reminder'] = $request->appointment_reminder;
        $current['contact_method']       = $request->contact_method;

        $user->update(['settings' => $current]);

        return redirect()->route('settings')->with('success', 'Counseling preferences saved successfully!');
    }
}
