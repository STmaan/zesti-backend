<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Otp;
use App\Models\OtpVerification;
use App\Models\User;
use Exception;

class appController extends Controller
{
    public function requestUserOtp(Request $request)
    {
        try {
            $validated = $request->validate([
                'contact_num' => 'required',
                'country' => 'required'
            ]);

            $otpCode = rand(1000, 9999);  // Generate a random OTP

            // Save OTP in the database
            Otp::create([
                'contact_num' => $validated['contact_num'],
                'country' => $validated['country'],
                'otp' => $otpCode,
                'verified' => false,
            ]);

            // Logic to send the OTP to the user would go here

            return response()->json([
                'timestamp' => now(),
                'status' => 200,
                'message' => 'OTP sent successfully',
                'body' => null
            ]);
        } catch (Exception $e) {
            return response()->json([
                'timestamp' => now(),
                'status' => 400,
                'message' => $e->getMessage(),
                'body' => null
            ], 400);
        }
    }


    public function requestVerifyContactNumber(Request $request)
    {
        try {
            $validated = $request->validate([
                'contact_num' => 'required',
                'country' => 'required',
                'otp' => 'required'
            ]);

            $otp = Otp::where('contact_num', $validated['contact_num'])
                ->where('otp', $validated['otp'])
                ->first();

            if ($otp && $otp->verified == false) {
                $otp->verified = true;
                $otp->save();

                return response()->json([
                    'timestamp' => now(),
                    'status' => 200,
                    'message' => 'OTP verified',
                    'body' => null
                ]);
            }

            return response()->json([
                'timestamp' => now(),
                'status' => 400,
                'message' => 'Invalid OTP',
                'body' => null
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'timestamp' => now(),
                'status' => 400,
                'message' => $e->getMessage(),
                'body' => null
            ], 400);
        }
    }

    public function signup(Request $request)
    {
        try {
            $validated = $request->validate([
                'contact_num' => 'required',
                'country' => 'required',
                'picture_id' => 'nullable',
                'name' => 'required',
                'home_town' => 'nullable',
                'gender' => 'required',
                'dob' => 'required|date',
                'language' => 'nullable'
            ]);

            // Save the user to the database
            $user = User::create($validated);

            return response()->json([
                'timestamp' => now(),
                'status' => 200,
                'message' => 'User signup successful',
                'body' => null
            ]);
        } catch (Exception $e) {
            return response()->json([
                'timestamp' => now(),
                'status' => 400,
                'message' => $e->getMessage(),
                'body' => null
            ], 400);
        }
    }
}
