<?php
namespace App\Http\Controllers;

use App\Mail\PasswordReset as PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mail;
use Session;

class OnboardingController extends Controller
{
    //

    /**
     * verifyWithLink
     *
     * @param mixed token
     *
     * @return void
     */
    public function verifyWithLink($token)
    {
        $user = User::where("token", $token)->first();
        if (isset($user)) {
            $user->email_verified_at = now();
            $user->token             = null;
            $user->save();

            $status = "Successful";

            return view("verification_status", compact("status"));
        } else {
            $status = "Failed";
            return view("verification_status", compact("status"));
        }
    }

    /**
     * Initiate User Password Reset
     *
     * @param Request request
     *
     */
    public function initiatePasswordReset(Request $request)
    {
        $validator = $this->validate($request, [
            'email' => 'required|',
        ]);

        $user = User::where("email", $request->email)->where("status", "!=", "deleted")->first();

        if (! $user) {
            return back()->with(['error' => "We could not find an account for the provided email"]);
        }

        $user->token = Str::random(60);

        if ($user->save()) {
            try {
                Mail::to($user)->send(new PasswordReset($user));
                return back()->with(['success' => "Password Reset Mail Sent Successfully"]);
            } catch (\Exception $e) {
                report($e);
                return back()->with(['error' => "Something went wrong. We could not process your request"]);
            }
        } else {
            return back()->with(['error' => "Something went wrong. We could not process your request"]);
        }

    }

    /**
     * verifyPasswordReset
     *
     * @param mixed token
     *
     * @return void
     */
    public function verifyPasswordReset($token)
    {

        $user = User::where("token", $token)->first();
        if (! $user) {
            Session::put("passwordResetFailed", "We could not verify the token for this request.");
            return view("auth.passwords.email", compact("user"));
        }

        return view("auth.passwords.reset", compact("user"));
    }

    /**
     * resetPassword
     *
     * @param Request request
     *
     * @return void
     */
    public function resetPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email'    => 'required',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            return back()->with(['error' => $errors]);
        }

        if ($request->password != $request->password_confirmation) {
            return back()->with(['error' => "Your newly seleted passwords do not match."]);
        } else {
            $user           = User::where("email", $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->token    = null;
            if ($user->save()) {
                return redirect()->route("login")->with(['success' => "Password was reset successfully"]);
            } else {
                return back()->with(['error' => "Something went wrong. Request could not be processed."]);
            }
        }

    }

}
