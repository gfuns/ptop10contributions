<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Members;
use App\Models\MemberSavings;
use App\Models\PlatformFeature;
use App\Models\User;
use App\Models\UserPermission;
use App\Models\UserRole;
use Auth;
use Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        return view("admin.dashboard");
    }

    /**
     * platformFeatures
     *
     * @return void
     */
    public function platformFeatures()
    {
        $platformFeatures = PlatformFeature::all();
        return view("admin.platform_features", compact("platformFeatures"));
    }

    /**
     * userRoles
     *
     * @return void
     */
    public function userRoles()
    {
        $userRoles = UserRole::where("id", ">", 1)->get();
        return view("admin.user_roles", compact("userRoles"));
    }

    /**
     * storeUserRole
     *
     * @param Request request
     *
     * @return void
     */
    public function storeUserRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|unique:user_roles',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $userRole       = new UserRole;
        $userRole->role = ucwords(strtolower($request->role));
        if ($userRole->save()) {
            toast('User Role Created Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();

        }
    }

    /**
     * updateUserRole
     *
     * @param Request request
     *
     * @return void
     */
    public function updateUserRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|numeric',
            'role'    => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $userRole       = UserRole::find($request->role_id);
        $userRole->role = ucwords(strtolower($request->role));
        if ($userRole->save()) {
            toast('User Role Updated Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * userManagement
     *
     * @return void
     */
    public function agentManagement()
    {
        $status    = request()->status;
        $search    = request()->search;
        $userRoles = UserRole::where("role_type", "agent")->get();

        $query = User::query();

        $query->where("role_id", 2);

        if (isset(request()->search)) {
            $query->whereLike(["last_name", "other_names", "email", "phone_number"], $search);
        }

        if (isset(request()->status)) {
            $query->whereLike('status', $status);
        }

        $lastRecord = $query->count();
        $marker     = $this->getMarkers($lastRecord, request()->page);
        $users      = $query->paginate(50);

        return view("admin.agent_management", compact('users', 'userRoles', 'status', 'search'));
    }

    /**
     * storeUser
     *
     * @param Request request
     *
     * @return void
     */
    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'other_names'  => 'required',
            'last_name'    => 'required',
            'email'        => 'required|unique:users',
            'phone_number' => 'required|unique:users',
            'role'         => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $role               = UserRole::find($request->role);
        $user               = new User;
        $user->other_names  = ucwords(strtolower($request->other_names));
        $user->last_name    = ucwords(strtolower($request->last_name));
        $user->email        = strtolower($request->email);
        $user->phone_number = $request->phone_number;
        $user->password     = Hash::make($request->phone_number);
        $user->role_id      = $role->id;
        $user->token        = Str::random(60);
        if ($user->save()) {
            toast('Agent Information Stored Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * updateUser
     *
     * @param Request request
     *
     * @return void
     */
    public function updateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'      => 'required',
            'other_names'  => 'required',
            'last_name'    => 'required',
            'email'        => 'required',
            'phone_number' => 'required',
            'role'         => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $emailTaken = User::where("id", "!=", $request->user_id)->where("email", $request->email)->first();
        if (isset($emailTaken)) {
            toast('This Email Has Already Been Taken By Another Agent.', 'error');
            return back();
        }

        $phoneTaken = User::where("id", "!=", $request->user_id)->where("phone_number", $request->phone_number)->first();
        if (isset($phoneTaken)) {
            toast('This Phone Number Has Already Been Taken By Another Agent.', 'error');
            return back();
        }

        $role               = UserRole::find($request->role);
        $user               = User::find($request->user_id);
        $user->other_names  = ucwords(strtolower($request->other_names));
        $user->last_name    = ucwords(strtolower($request->last_name));
        $user->email        = strtolower($request->email);
        $user->phone_number = $request->phone_number;
        $user->role_id      = $role->id;
        if ($user->save()) {
            toast('Agent Information Updated Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * suspendUser
     *
     * @param mixed id
     *
     * @return void
     */
    public function suspendUser($id)
    {
        $user         = User::find($id);
        $user->status = "suspended";
        if ($user->save()) {
            toast('User Account Suspended Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * activateUser
     *
     * @param mixed id
     *
     * @return void
     */
    public function activateUser($id)
    {
        $user         = User::find($id);
        $user->status = "active";
        if ($user->save()) {
            toast('User Account Activated Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * memberManagement
     *
     * @return void
     */
    public function memberManagement()
    {
        $status = request()->status;
        $search = request()->search;

        $query = Members::query();

        if (isset(request()->search)) {
            $query->whereLike(["last_name", "other_names", "email", "phone_number"], $search);
        }

        if (isset(request()->status)) {
            $query->whereLike('status', $status);
        }

        $lastRecord = $query->count();
        $marker     = $this->getMarkers($lastRecord, request()->page);
        $users      = $query->paginate(50);

        return view("admin.member_management", compact('users', 'status', 'search'));
    }

    /**
     * storeMember
     *
     * @param Request request
     *
     * @return void
     */
    public function storeMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'other_names'     => 'required',
            'last_name'       => 'required',
            'email'           => 'nullable',
            'phone_number'    => 'required|unique:members',
            'contact_address' => 'required',
            'photograph'      => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $member                  = new Members;
        $member->other_names     = ucwords(strtolower($request->other_names));
        $member->last_name       = ucwords(strtolower($request->last_name));
        $member->email           = strtolower($request->email);
        $member->phone_number    = $request->phone_number;
        $member->contact_address = $request->contact_address;

        if ($request->has('photograph')) {
            $uploadedFileUrl    = Cloudinary::upload($request->file('photograph')->getRealPath())->getSecurePath();
            $member->photograph = $uploadedFileUrl;
        }

        if ($member->save()) {
            toast('Member Information Stored Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * updateMember
     *
     * @param Request request
     *
     * @return void
     */
    public function updateMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_id'       => 'required',
            'other_names'     => 'required',
            'last_name'       => 'required',
            'email'           => 'nullable',
            'phone_number'    => 'required',
            'contact_address' => 'required',
            'photograph'      => 'nullable',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $emailTaken = Members::where("id", "!=", $request->member_id)->where("email", $request->email)->first();
        if (isset($emailTaken)) {
            toast('This Email Has Already Been Taken By Another Member.', 'error');
            return back();
        }

        $phoneTaken = Members::where("id", "!=", $request->member_id)->where("phone_number", $request->phone_number)->first();
        if (isset($phoneTaken)) {
            toast('This Phone Number Has Already Been Taken By Another Member.', 'error');
            return back();
        }

        $member                  = Members::find($request->member_id);
        $member->other_names     = ucwords(strtolower($request->other_names));
        $member->last_name       = ucwords(strtolower($request->last_name));
        $member->email           = strtolower($request->email);
        $member->phone_number    = $request->phone_number;
        $member->contact_address = $request->contact_address;

        if ($request->has('photograph')) {
            $uploadedFileUrl    = Cloudinary::upload($request->file('photograph')->getRealPath())->getSecurePath();
            $member->photograph = $uploadedFileUrl;
        }

        if ($member->save()) {
            toast('Member Information Updated Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * managePermissions
     *
     * @param mixed id
     *
     * @return void
     */
    public function managePermissions($id)
    {
        $role             = UserRole::find($id);
        $platformFeatures = PlatformFeature::all();
        return view("admin.permissions", compact("role", "platformFeatures"));
    }

    /**
     * grantFeaturePermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function grantFeaturePermission($role, $feature)
    {
        $permission             = new UserPermission;
        $permission->role_id    = $role;
        $permission->feature_id = $feature;
        if ($permission->save()) {
            toast('Feature Permission Granted', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * revokeFeaturePermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function revokeFeaturePermission($role, $feature)
    {
        $permission = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        if ($permission->delete()) {
            toast('Feature Permission Revoked', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * grantCreatePermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function grantCreatePermission($role, $feature)
    {
        $permission             = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        $permission->can_create = 1;
        if ($permission->save()) {
            toast('Can Create Permission Granted', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * revokeCreatePermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function revokeCreatePermission($role, $feature)
    {
        $permission             = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        $permission->can_create = 0;
        if ($permission->save()) {
            toast('Can Create Permission Revoked', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * grantEditPermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function grantEditPermission($role, $feature)
    {
        $permission           = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        $permission->can_edit = 1;
        if ($permission->save()) {
            toast('Can Edit Permission Granted', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * revokeEditPermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function revokeEditPermission($role, $feature)
    {
        $permission           = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        $permission->can_edit = 0;
        if ($permission->save()) {
            toast('Can Edit Permission Revoked', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * grantDeletePermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function grantDeletePermission($role, $feature)
    {
        $permission             = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        $permission->can_delete = 1;
        if ($permission->save()) {
            toast('Can Delete Permission Granted', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * revokeDeletePermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function revokeDeletePermission($role, $feature)
    {
        $permission             = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        $permission->can_delete = 0;
        if ($permission->save()) {
            toast('Can Delete Permission Revoked', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * savingsRecords
     *
     * @return void
     */
    public function savingsRecords()
    {
        $date   = request()->date;
        $cardno = request()->cardno;

        $query = MemberSavings::query();

        if (isset(request()->cardno)) {
            $query->where("card_number", $cardno);
        }

        if (isset(request()->date)) {
            $query->whereDate("created_at", $date);
        }

        $lastRecord = $query->count();
        $marker     = $this->getMarkers($lastRecord, request()->page);
        $savings    = $query->paginate(50);

        return view("admin.savings_records", compact('savings', 'date', 'cardno'));
    }

    /**
     * storeMemberSavings
     *
     * @param Request request
     *
     * @return void
     */
    public function storeMemberSavings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_number'  => 'required',
            'amount_saved' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $memberExist = Members::where("card_number", $request->card_number)->first();
        if (! isset($memberExist)) {
            toast('We could not find a member with the provided card number.', 'error');
            return back();
        }

        $totalSavings = MemberSavings::where("member_id", $memberExist->id)->sum("amount");

        $savings                = new MemberSavings;
        $savings->user_id       = Auth::user()->id;
        $savings->member_id     = $memberExist->id;
        $savings->card_number   = $request->card_number;
        $savings->amount        = $request->amount_saved;
        $savings->current_total = ($request->amount_saved + $totalSavings);
        if ($savings->save()) {
            toast('Member Savings Recorded Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * getMarkers Helper Function
     *
     * @param mixed lastRecord
     * @param mixed pageNum
     *
     * @return void
     */
    public function getMarkers($lastRecord, $pageNum)
    {
        if ($pageNum == null) {
            $pageNum = 1;
        }
        $end    = (50 * ((int) $pageNum));
        $marker = [];
        if ((int) $pageNum == 1) {
            $marker["begin"] = (int) $pageNum;
            $marker["index"] = (int) $pageNum;
        } else {
            $marker["begin"] = number_format(((50 * ((int) $pageNum)) - 49), 0);
            $marker["index"] = number_format(((50 * ((int) $pageNum)) - 49), 0);
        }

        if ($end > $lastRecord) {
            $marker["end"] = number_format($lastRecord, 0);
        } else {
            $marker["end"] = number_format($end, 0);
        }

        return $marker;
    }
}
