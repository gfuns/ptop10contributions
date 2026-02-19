<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberLoans;
use App\Models\Members;
use App\Models\MemberSavings;
use App\Models\PlatformFeature;
use App\Models\User;
use App\Models\UserPermission;
use App\Models\UserRole;
use Auth;
use Cloudinary;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Session;

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
        $search = request()->search;

        $query = MemberSavings::query();

        if (isset(request()->search)) {
            $query->where(function ($q) use ($search) {

                $q->where('card_number', 'like', "%{$search}%")
                    ->orWhereHas('member', function ($sub) use ($search) {
                        $sub->where('last_name', 'like', "%{$search}%")
                            ->orWhere('other_names', 'like', "%{$search}%");
                    });

            });

        }

        if (isset(request()->date)) {
            $query->whereDate("created_at", $date);
        }

        $lastRecord = $query->count();
        $marker     = $this->getMarkers($lastRecord, request()->page);
        $savings    = $query->orderBy("id", "desc")->paginate(50);

        return view("admin.savings_records", compact('savings', 'date', 'search'));
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

        $todaySavings = MemberSavings::where("member_id", $memberExist->id)->whereDate("created_at", today())->first();

        if (! isset($todaySavings)) {
            $savings              = new MemberSavings;
            $savings->user_id     = Auth::user()->id;
            $savings->member_id   = $memberExist->id;
            $savings->card_number = $request->card_number;
            $savings->amount      = $request->amount_saved;
            if ($savings->save()) {
                toast('Member Savings Recorded Successfully', 'success');
                return back();
            } else {
                toast('Something went wrong. Please try again', 'error');
                return back();
            }
        } else {
            toast('Savings For Today Already Recorded for this Member.', 'error');
            return back();
        }
    }

    /**
     * updateSavingsAmount
     *
     * @param Request request
     *
     * @return void
     */
    public function updateSavingsAmount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'savings_id'     => 'required',
            'savings_amount' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $savings         = MemberSavings::find($request->savings_id);
        $savings->amount = $request->savings_amount;
        if ($savings->save()) {
            toast('Savings Amount Updated Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * memberSavings
     *
     * @param mixed id
     *
     * @return void
     */
    public function memberSavings($id)
    {
        $member = Members::find($id);

        $date = request()->date;

        $query = MemberSavings::query();

        $query->where("member_id", $id);

        if (isset(request()->date)) {
            $query->whereDate("created_at", $date);
        }

        $lastRecord = $query->count();
        $marker     = $this->getMarkers($lastRecord, request()->page);
        $savings    = $query->orderBy("id", "desc")->paginate(50);
        return view("admin.member_savings", compact("member", "savings", "date"));
    }

    /**
     * loanApplications
     *
     * @return void
     */
    public function loanApplications()
    {
        $date   = request()->date;
        $search = request()->search;

        $query = MemberLoans::query();

        $query->whereIn("approval_status", ["pending", "denied"]);

        if (isset(request()->search)) {
            $query->where(function ($q) use ($search) {

                $q->where('card_number', 'like', "%{$search}%")
                    ->orWhereHas('member', function ($sub) use ($search) {
                        $sub->where('last_name', 'like', "%{$search}%")
                            ->orWhere('other_names', 'like', "%{$search}%");
                    });

            });

        }

        if (isset(request()->date)) {
            $query->whereDate("created_at", $date);
        }

        $lastRecord = $query->count();
        $marker     = $this->getMarkers($lastRecord, request()->page);
        $loans      = $query->orderBy("id", "desc")->paginate(50);

        return view("admin.loan_applications", compact('loans', 'date', 'search'));
    }

    /**
     * rejectLoan
     *
     * @param mixed id
     *
     * @return void
     */
    public function rejectLoan($id)
    {
        $loan                  = MemberLoans::find($id);
        $loan->approval_status = "denied";
        if ($loan->save()) {
            toast('Loan Application Rejected.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();

        }
    }

    /**
     * approveLoan
     *
     * @param mixed id
     *
     * @return void
     */
    public function approveLoan($id)
    {
        $disbursementDate = now();

        for ($i = 1; $i <= 8; $i++) {
            $schedule[] = [
                'installment_number' => $i,
                'due_date'           => $disbursementDate->copy()->addWeeks($i),
            ];
        }

        $loan                    = MemberLoans::find($id);
        $loan->approval_status   = "approved";
        $loan->disbursement_date = $disbursementDate;
        $loan->loan_refinancing  = "ongoing";
        $loan->first_payment     = $schedule[0]["due_date"];
        $loan->second_payment    = $schedule[1]["due_date"];
        $loan->third_payment     = $schedule[2]["due_date"];
        $loan->fourth_payment    = $schedule[3]["due_date"];
        $loan->fifth_payment     = $schedule[4]["due_date"];
        $loan->sixth_payment     = $schedule[5]["due_date"];
        $loan->seventh_payment   = $schedule[6]["due_date"];
        $loan->eigth_payment     = $schedule[7]["due_date"];
        if ($loan->save()) {
            toast('Loan Application Approved.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();

        }
    }

    /**
     * loanRecords
     *
     * @return void
     */
    public function loanRecords()
    {
        $date   = request()->date;
        $search = request()->search;

        $query = MemberLoans::query();
        $query->where("approval_status", "approved");

        if (isset(request()->search)) {
            $query->where(function ($q) use ($search) {

                $q->where('card_number', 'like', "%{$search}%")
                    ->orWhereHas('member', function ($sub) use ($search) {
                        $sub->where('last_name', 'like', "%{$search}%")
                            ->orWhere('other_names', 'like', "%{$search}%");
                    });

            });

        }

        if (isset(request()->date)) {
            $query->whereDate("created_at", $date);
        }

        $lastRecord = $query->count();
        $marker     = $this->getMarkers($lastRecord, request()->page);
        $loans      = $query->orderBy("id", "desc")->paginate(50);

        return view("admin.loan_records", compact('loans', 'date', 'search'));
    }

    /**
     * memberLoans
     *
     * @param mixed id
     *
     * @return void
     */
    public function memberLoans($id)
    {
        $member = Members::find($id);

        $date = request()->date;

        $query = MemberLoans::query();

        $query->where("member_id", $id)->where("approval_status", "approved");

        if (isset(request()->date)) {
            $query->whereDate("created_at", $date);
        }

        $lastRecord = $query->count();
        $marker     = $this->getMarkers($lastRecord, request()->page);
        $loans      = $query->orderBy("id", "desc")->paginate(50);
        return view("admin.member_loans", compact("member", "loans", "date"));
    }

    /**
     * newLoan
     *
     * @return void
     */
    public function newLoan()
    {
        return view("admin.new_loan");
    }

    /**
     * storeLoanApplication
     *
     * @param Request request
     *
     * @return void
     */
    public function storeLoanApplication(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_number'           => 'required',
            'guarantor_card_number' => 'required',
            'loan_amount'           => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $memberExist = Members::where("card_number", $request->card_number)->first();
        if (! isset($memberExist)) {
            toast('We could not find an applicant with the provided card number.', 'error');
            return back();
        }

        $guarantorExist = Members::where("card_number", $request->guarantor_card_number)->first();
        if (! isset($guarantorExist)) {
            toast('We could not find a guarantor with the provided card number.', 'error');
            return back();
        }

        $loan                   = new MemberLoans;
        $loan->user_id          = Auth::user()->id;
        $loan->member_id        = $memberExist->id;
        $loan->guarantor_id     = $guarantorExist->id;
        $loan->card_number      = $request->card_number;
        $loan->amount           = $request->loan_amount;
        $loan->weekly_repayment = (double) ($request->loan_amount / 8);
        if ($loan->save()) {
            toast('Member Loan Application Recorded Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * updateLoanAmount
     *
     * @param Request request
     *
     * @return void
     */
    public function updateLoanAmount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loan_id'     => 'required',
            'loan_amount' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $loan                   = MemberLoans::find($request->loan_id);
        $loan->amount           = $request->loan_amount;
        $loan->weekly_repayment = (double) ($request->loan_amount / 8);
        if ($loan->save()) {
            toast('Loan Amount Updated Successfully', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * loanRepaySchedule
     *
     * @param mixed id
     *
     * @return void
     */
    public function loanRepaySchedule($id)
    {

        $loan = MemberLoans::find($id);

        $payments = [];

        $mapping = [
            1 => ['first_payment', 'first_payment_status'],
            2 => ['second_payment', 'second_payment_status'],
            3 => ['third_payment', 'third_payment_status'],
            4 => ['fourth_payment', 'fourth_payment_status'],
            5 => ['fifth_payment', 'fifth_payment_status'],
            6 => ['sixth_payment', 'sixth_payment_status'],
            7 => ['seventh_payment', 'seventh_payment_status'],
            8 => ['eigth_payment', 'eigth_payment_status'],
        ];

        foreach ($mapping as $number => $fields) {
            $payments[] = [
                'week'     => "Week " . $number,
                'due_date' => date_format(new DateTime($loan->{$fields[0]}), 'jS F, Y'),
                'status'   => ucwords($loan->{$fields[1]}),
                'amount'   => number_format($loan->weekly_repayment, 2),
            ];
        }

        return response()->json([
            'items' => $payments,
        ]);
    }

    /**
     * loanRepayment
     *
     * @return void
     */
    public function loanRepayment()
    {
        return view("admin.loan_repayment");
    }

    /**
     * profile
     *
     * @return void
     */
    public function viewProfile()
    {
        return view("admin.profile_information");
    }

    /**
     * updateProfile
     *
     * @param Request request
     *
     * @return void
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'last_name'       => 'required',
            'other_names'     => 'required',
            'phone_number'    => 'required',
            'contact_address' => 'required',
            'profile_photo'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $state = Auth::user()->profile_updated;

        $parseEmail = User::where("email", $request->email)->where("id", "!=", Auth::user()->id)->count();
        if ($parseEmail > 0) {
            toast('Email already used by someone else.', 'error');
            return back();
        }

        $parsePhone = User::where("email", $request->phone_number)->where("id", "!=", Auth::user()->id)->count();
        if ($parsePhone > 0) {
            toast('Phone number already used by someone else.', 'error');
            return back();
        }

        $user                  = Auth::user();
        $user->last_name       = $request->last_name;
        $user->other_names     = $request->other_names;
        $user->phone_number    = $request->phone_number;
        $user->contact_address = $request->contact_address;
        $user->profile_updated = 1;
        if ($request->has('profile_photo')) {
            $uploadedFileUrl     = Cloudinary::upload($request->file('profile_photo')->getRealPath())->getSecurePath();
            $user->profile_photo = $uploadedFileUrl;
        }

        if ($user->save()) {
            toast('Profile Information Successfully Updated.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }

    }

    /**
     * updatePassword
     *
     * @param Request request
     *
     * @return void
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password'          => 'required',
            'new_password'              => 'required',
            'new_password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            toast('Invalid current password provided.', 'error');
            return back();
        } else {
            if ($request->new_password != $request->new_password_confirmation) {
                toast('Your newly seleted passwords do not match.', 'error');
                return back();
            } else {
                $user->password = Hash::make($request->new_password);
                $user->save();
            }
        }

        if ($user->save()) {
            toast('Password Successfully Updated.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }

    }

    /**
     * security
     *
     * @return void
     */
    public function security()
    {
        $google2fa       = app('pragmarx.google2fa');
        $google2faSecret = $google2fa->generateSecretKey();
        $QRImage         = $google2fa->getQRCodeInline(
            env('APP_NAME'),
            Auth::user()->email,
            $google2faSecret
        );
        return view("admin.account_security", compact("google2faSecret", "QRImage"));
    }

    /**
     * enableGA
     *
     * @param Request request
     *
     * @return void
     */
    public function enableGA(Request $request)
    {
        $gaCode   = $request->google2fa_code;
        $gaSecret = $request->google2fa_secret;

        if ($gaCode == null || $gaSecret == null) {
            toast('Please enter a valid Google 2FA Code.', 'error');
            return back();
        }

        $user      = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $valid     = $google2fa->verifyKey($gaSecret, $gaCode);

        if ($valid) {
            $user->google2fa_secret = $gaSecret;
            if ($user->save()) {
                toast('Successfully Enabled Google Authenticator on your account', 'success');
                return back();
            } else {
                toast('Something went wrong.', 'error');
                return back();
            }

        } else {
            toast('Invalid Google 2FA Code.', 'error');
            return back();

        }

    }

    /**
     * select2FA
     *
     * @param Request request
     *
     * @return void
     */
    public function select2FA(Request $request)
    {

        $user = Auth::user();

        if ($request->param == "google_auth2fa") {
            if (isset($user->google2fa_secret) && $request->status == 1) {
                $data = [
                    'id'   => Auth::user()->id,
                    'time' => now(),
                ];
                Session::put('myGoogle2fa', $data);
                $user->auth_2fa = "GoogleAuth";
            } else if (isset($user->google2fa_secret) && $request->status == 0) {
                $user->auth_2fa = null;
                Session::forget('myGoogle2fa');
            } else {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Please Setup Google Authenticator to be able to enable this option.',
                ]);
            }
        }

        if ($request->param == "email_auth2fa") {
            if ($request->status == 1) {
                $user->auth_2fa = "Email";
                $data           = [
                    'id'   => Auth::user()->id,
                    'time' => now(),
                ];
                Session::put('myValid2fa', $data);
            } else {
                $user->auth_2fa = null;
                Session::forget('myValid2fa');
            }
        }

        if ($user->save()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Authentication 2FA Method Updated Successfully',
            ]);
        } else {
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong! Please try again',
            ]);
        }

    }

    /**
     * adminReports
     *
     * @return void
     */
    public function adminReports()
    {
        alert()->info('', 'Coming Soon');
        return redirect()->route("admin.dashboard");
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
