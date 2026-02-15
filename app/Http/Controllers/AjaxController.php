<?php
namespace App\Http\Controllers;

use App\Models\Members;

class AjaxController extends Controller
{
    //

    /**
     * getMemberName
     *
     * @param mixed cardno
     *
     * @return void
     */
    public function getMemberName($cardno)
    {
        try {
            $member = Members::where("card_number", $cardno)->first();

            if (isset($member)) {
                return response()->json([
                    'status' => true,
                    'name'   => $member->last_name . ", " . $member->other_names,
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Member with the provided card number does not exist.',
            ], 500);

        } catch (\Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Unable to validate provided card number.',
            ], 500);
        }
    }

    public function getGuarantorName($cardno)
    {
        try {
            $member = Members::where("card_number", $cardno)->first();

            if (isset($member)) {
                return response()->json([
                    'status' => true,
                    'name'   => $member->last_name . ", " . $member->other_names,
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Member with the provided card number does not exist.',
            ], 500);

        } catch (\Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Unable to validate provided card number.',
            ], 500);
        }
    }
}
