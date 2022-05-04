<?php

namespace App\Http\Controllers;

use App\Mail\UserApproveDeclineMail;
use App\Models\Account;
use App\Models\PaymentMailLogs;
use App\Models\TempEmail;
use App\Models\User;
use Illuminate\Http\Request;

class UnsubscribeController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->id;
        $type = $request->type;

        Account::where('PlatformUserID', $id)->where('AccountType', $type)->update([
            'SubscribedStatus' => 'Unsubscribed',
        ]);

        return redirect('success');
    }

    public function success()
    {
        return view('unsubscribed');
    }

    public function openEmail(Request $request)
    {
        if ($request->eid) {
            $tempEmail = TempEmail::where('email', $request->eid)->where('campaign_id', $request->cid)->where('email_opened', '')->first();
            if ($tempEmail) {
                $tempEmail->email_opened = 'opened';
                $tempEmail->email_open_date = date('Y-m-d');
                $tempEmail->email_open_time = date('h:i:s');
                $tempEmail->save();
            }
        }
    }

    public function paymentOpenEmail(Request $request)
    {
        if ($request->id) {
            $tempEmail = PaymentMailLogs::where('id', $request->id)->where('affiliate_id', $request->aid)->where('email_opened', 0)->first();
            if ($tempEmail) {
                $tempEmail->email_opened = 1;
                $tempEmail->email_open_date = date('Y-m-d');
                $tempEmail->email_open_time = date('h:i:s');
                $tempEmail->save();
            }
        }
    }

    public function userApproval($id = 0)
    {
        if ($id != 0) {
            $user = User::where('id', $id)->first();
            if ($user->approved == 1) {
                $user->approved = 0;
            } else {
                $user->approved = 1;
            }
            $user->save();

            $userdata = [
                'email_subject'=>'Your registration is approved!',
                'email_body'=>'<p><strong>Hello '.$user->first_name.'</strong></p> <p>Your registration is approved please log in at your convenience. <a href="'.route('login').'">Click Here</a></p>',
            ];
            \Mail::to($user->email)->send(new UserApproveDeclineMail($userdata));
        }

        return redirect()->back()->with('success', 'Successfully changed user status!');
    }

    public function userDeclined($id = 0)
    {
        if ($id != 0) {
            $user = User::where('id', $id)->first();

            $userdata = [
                'email_subject'=>'Your registration was not approved!',
                'email_body'=>'<p><strong>Hello '.$user->first_name.'</strong></p> <p>Your registration was not approved. Please contact us for further details.',
            ];
            \Mail::to($user->email)->send(new UserApproveDeclineMail($userdata));

            $user->team()->delete();
            $user->delete();
        }

        return redirect()->back()->with('success', 'User successfully declined!');
    }
}
