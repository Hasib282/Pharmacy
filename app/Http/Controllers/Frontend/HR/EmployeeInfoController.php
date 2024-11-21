<?php

namespace App\Http\Controllers\Frontend\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User_Info;
use App\Models\Attendence;
use App\Models\Pay_Roll_Setup;

use App\Models\Transaction_With;
use App\Models\Employee_Personal_Detail;
use App\Models\Employee_Training_Detail;
use App\Models\Employee_Education_Detail;
use App\Models\Employee_Experience_Detail;
use App\Models\Employee_Organization_Detail;

class EmployeeInfoController extends Controller
{
    /////////////////////////// --------------- Employee Attendance Table Methods Starts ---------- //////////////////////////
    // Show All Attendance 
    public function EmployeeAttendenceList(Request $req){
        $allData = Attendence::select('date')->groupBy('date')->orderBy('id','asc')->get();

        return view('hr.attendance.view_employee_attend',compact('allData'));
    } // End Method 



    // Add Attendence Modal
    public function AddEmployeeAttendence(){
        $employees = User_Info::where('user_role', 6)->get();

        return view('hr.attendance.add_employee_attend',compact('employees'));
    } // End Method 



    // Insert Employee Attendence
    public function InsertEmployeeAttendence(Request $req){

        Attendence::where('date',date('Y-m-d',strtotime($req->date)))->delete();

        $countemployee = count($req->employee_id);

        for ($i=0; $i < $countemployee ; $i++) { 
           $attend_status = 'attend_status'.$i;
           $attend = new Attendence();
           $attend->date = date('Y-m-d',strtotime($req->date));
           $attend->employee_id = $req->employee_id[$i];
           $attend->attend_status  = $req->$attend_status;
           $attend->save();
        }

         $notification = array(
            'message' => 'Data Inseted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('employee.attendence')->with($notification); 
    } // End Method 



    // Edit Attendence
    public function EditEmployeeAttendence($date){
        $employees = User_Info::where('user_role', 6)->get();
        $editData = Attendence::where('date',$date)->get();
        return view('hr.attendance.edit_employee_attend',compact('employees','editData'));

    } // End Method 



    // View Attendence
    public function ViewEmployeeAttendence($date){
        $details = Attendence::where('date',$date)->get();
        return view('hr.attendance.details_employee_attend',compact('details'));
    } // End Method 

    /////////////////////////// ---------------  Employee Attendance Table Methods End---------- //////////////////////////





    /////////////////////////// --------------- All Employees Details Table Methods Starts---------- //////////////////////////
    // Show All Employees
    public function ShowEmployees(Request $req){
        if ($req->ajax()) {
            return view('hr.employee_info.employees.ajaxBlade');
        }
        else{
            return view('hr.employee_info.employees.employees');
        }
    } // End Method



    // Search Employees
    public function SearchEmployees(Request $req){
        return view('hr.employee_info.employees.employees');
    } // End Method



    // Show Employee Details
    public function ShowEmployeeDetails(Request $req){
        $employee = User_Info::with('Designation','Department','Location','Withs','personalDetail','educationDetail','trainingDetail','experienceDetail','organizationDetail')->where('user_id', "=", $req->id)->first();
        $education = Employee_Education_Detail::where('emp_id', $req->id)->orderBy('created_at','asc')->get();
        $training = Employee_Training_Detail::where('emp_id', $req->id)->orderBy('created_at','asc')->get();
        $experience = Employee_Experience_Detail::where('emp_id', $req->id)->orderBy('created_at','asc')->get();
        $payroll = Pay_Roll_Setup::with('Head','Employee')->where('emp_id', $employee->user_id)->get();
        
        return response()->json([
            'data'=>view('hr.employee_info.employees.details', compact('employee','education','training','experience','payroll'))->render(),
        ]);
    } // End Method



    // // Insert Employees
    // public function InsertEmployees(Request $req){
    //     $req->validate([
    //         "name" => 'required',
    //         "email" => 'required|email|unique:user__infos,user_email,email',
    //         "phone" => 'required|numeric|unique:user__infos,user_phone,phone',
    //         "gender" => 'required|in:Male,Female,Others',
    //         "location" => 'required',
    //         "type" => 'required',
    //         "department" => 'required',
    //         "designation" => 'required',
    //         "dob" => 'required',
    //         "nid" => 'required',
    //         "address" => 'required',
    //         "image" => 'image|mimes:jpg,jpeg,png,gif|max:2048',
    //         "password" => 'required|confirmed',
    //     ]);

    //     //generates Auto Increment Employee Id
    //     $latestEmployee = User_Info::where('user_role', 6)->orderBy('added_at','desc')->first();
    //     $id = ($latestEmployee) ? 'E' . str_pad((intval(substr($latestEmployee->user_id, 1)) + 1), 9, '0', STR_PAD_LEFT) : 'E000000101';

    //     //process the image name and store it to storage/app/public/profiles directory
    //     if ($req->hasFile('image') && $req->file('image')->isValid()) {
    //         $originalName = $req->file('image')->getClientOriginalName();
    //         $imageName = $id. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
    //         $imagePath = $req->file('image')->storeAs('public/profiles', $imageName);
    //     }
    //     else{
    //         $imageName = null;
    //     }

    //     User_Info::insert([
    //         "user_id" => $id,
    //         "user_name" => $req->name,
    //         "user_email" => $req->email,
    //         "user_phone" => $req->phone,
    //         "gender" => $req->gender,
    //         "loc_id" => $req->location,
    //         "user_role" => 6,
    //         "tran_user_type" => $req->type,
    //         "dob" => $req->dob,
    //         "nid" => $req->nid,
    //         "address" => $req->address,
    //         "image" => $imageName,
    //         "password" => $req->password,
    //     ]);

    //     return response()->json([
    //         'status'=>'success',
    //     ]);
    // } // End Method



    // // Edit Employees
    // public function EditEmployees(Request $req){
    //     $employee = User_Info::with('Department','Designation','Location')->findOrFail($req->id);
    //     $tranwith = Transaction_With::where('user_role', 6)->get();
    //     return response()->json([
    //         'employee'=>$employee,
    //         'tranwith'=>$tranwith,
    //     ]);
    // } // End Method



    // // Update Employees
    // public function UpdateEmployees(Request $req){
    //     $req->validate([
    //         "name" => 'required',
    //         "email" => ['required','email',Rule::unique('user__infos', 'user_email')->ignore($req->id)],
    //         "phone" => ['required','numeric',Rule::unique('user__infos', 'user_phone')->ignore($req->id)],
    //         "gender" => 'required|in:Male,Female,Others',
    //         "location" => 'required',
    //         "type" => 'required',
    //         "department" => 'required',
    //         "designation" => 'required',
    //         "dob" => 'required',
    //         "nid" => 'required',
    //         "address" => 'required',
    //         "password" => 'required',
    //     ]);

    //     $employee = User_Info::findOrFail($req->id);
    //     $path = 'public/profiles/'.$employee->image;
    //     // dd($path);
    //     if($req->image != null){
    //         $req->validate([
    //             "image" => 'image|mimes:jpg,jpeg,png,gif|max:2048',
    //         ]);

    //         //process the image name and store it to storage/app/public/profiles directory
    //         if ($req->hasFile('image') && $req->file('image')->isValid()) {
    //             Storage::delete($path);
    //             $imageName = $req->empId. '('. $req->name . ').' . $req->file('image')->getClientOriginalExtension();
    //             $imagePath = $req->file('image')->storeAs('public/profiles', $imageName);
    //         }
    //     }
    //     else{
    //         $imageName = $employee->image;
    //     }

    //     $update = User_Info::findOrFail($req->id)->update([
    //         "user_name" => $req->name,
    //         "user_email" => $req->email,
    //         "user_phone" => $req->phone,
    //         "gender" => $req->gender,
    //         "loc_id" => $req->location,
    //         "user_role" => 6,
    //         "tran_user_type" => $req->type,
    //         "dept_id" => $req->department,
    //         "designation_id" => $req->designation,
    //         "dob" => $req->dob,
    //         "nid" => $req->nid,
    //         "address" => $req->address,
    //         "image" => $imageName,
    //         "password" => $req->password,
    //         "updated_at" => now()
    //     ]);
    //     if($update){
    //         return response()->json([
    //             'status'=>'success'
    //         ]); 
    //     }
    // } // End Method

    /////////////////////////// --------------- All Employees Details Table Methods End---------- //////////////////////////





    /////////////////////////// --------------- Employee Personal Details Table Methods Start---------- //////////////////////////
    // Show All Employee
    public function PersonalDetails(Request $req){
        if ($req->ajax()) {
            return view('hr.employee_info.personal_details.ajaxBlade');
        }
        else{
            return view('hr.employee_info.personal_details.employeePersonals');
        }
    } // End Method


    // Search Employee Personal Details
    public function SearchPersonalDetails(Request $req){
        return view('hr.employee_info.personal_details.employeePersonals');
    } // End Method



    // Show Employee Personal Details
    public function ShowPersonalDetails(Request $req){
        $employeepersonal = Employee_Personal_Detail::where('employee_id', $req->id)->get();
        return response()->json([
            'data'=>view('hr.employee_info.personal_details.details', compact('employeepersonal'))->render(),
        ]);
    } // End Method

    /////////////////////////// --------------- Employee Personal Details Table Methods End---------- //////////////////////////




    /////////////////////////// --------------- Employee Education Details Table Methods Start---------- //////////////////////////
    // Show All Employees
    public function EducationDetails(Request $req){
        if ($req->ajax()) {
            return view('hr.employee_info.education_details.ajaxBlade');
        }
        else{
            return view('hr.employee_info.education_details.employeeEducations');
        }
    } // End Method



    // Search Employee Education Details by Name
    public function SearchEducationDetails(Request $req){
        return view('hr.employee_info.education_details.employeeEducations');
    } // End Method



    // Show Employee Education Details
    public function ShowEmployeesEducationDetails(Request $req){
        $employeeeducation = Employee_Education_Detail::with('personalDetail')->where('emp_id', $req->id)->get();
        $personaldetail = Employee_Personal_Detail::where('employee_id', $req->id)->get();

        return response()->json([
            'data'=>view('hr.employee_info.education_details.details', compact('employeeeducation', 'personaldetail'))->render(),
        ]);
    } // End Method



    // Employee Education Details Grid
    public function EmployeesEducationDetailsGrid(Request $req){
        $employeeeducation = Employee_Education_Detail::with('personalDetail')->where('emp_id', $req->id)->paginate(15);
        
        return response()->json([
            'data'=>view('hr.employee_info.education_details.detailsEducation', compact('employeeeducation'))->render(),
        ]);
    } // End Method

    /////////////////////////// --------------- Employee Education Details Table Methods End---------- //////////////////////////



    /////////////////////////// --------------- Employee Training Details Table Methods Start---------- //////////////////////////
    // Show All Employee
    public function TrainingDetails(Request $req){
        if ($req->ajax()) {
            return view('hr.employee_info.training_details.ajaxBlade');
        }
        else{
            return view('hr.employee_info.training_details.employeeTrainings');
        }
    } // End Method



    // Search Employee by Name
    public function SearchTrainingDetails(Request $req){
        return view('hr.employee_info.training_details.employeeTrainings');
    } // End Method



    // Show Employee Training Details
    public function ShowTrainingDetails(Request $req){
        $employeetraining = Employee_Training_Detail::with('personalDetail')->where('emp_id', "=", $req->id)->get();
        $personaldetail = Employee_Personal_Detail::where('employee_id', $req->id)->get();

        return response()->json([
            'data'=>view('hr.employee_info.training_details.details', compact('employeetraining', 'personaldetail'))->render(),
        ]);
    } // End Method



    // Show Employee Training Details Grid
    public function EmployeeTrainingDetailsGrid(Request $req){
        $employeetraining = Employee_Training_Detail::with('personalDetail')->where('emp_id', $req->id)->paginate(15);
        
        return response()->json([
            'data'=>view('hr.employee_info.training_details.detailsTraining', compact('employeetraining'))->render(),
        ]);
    } // End Method

    /////////////////////////// --------------- Employee Training Details Table Methods End---------- //////////////////////////



    /////////////////////////// --------------- Employee Experience Details Table Methods Start---------- //////////////////////////
    // Show All Employees
    public function ExperienceDetails(Request $req){
        if ($req->ajax()) {
            return view('hr.employee_info.experience_details.ajaxBlade');
        }
        else{
            return view('hr.employee_info.experience_details.employeeExperiences');
        }
    } // End Method



    // Search Employee by Name
    public function SearchExperienceDetails(Request $req){
        return view('hr.employee_info.experience_details.employeeExperiences');
    } // End Method



    // Show Employee Experience Details
    public function ShowExperienceDetails(Request $req){
        $employeeexperience = Employee_Experience_Detail::with('personalDetail')->where('emp_id', $req->id)->get();
        $personaldetail = Employee_Personal_Detail::where('employee_id', $req->id)->get();

        return response()->json([
            'data'=>view('hr.employee_info.experience_details.details', compact('employeeexperience', 'personaldetail'))->render(),
        ]);
    } // End Method



    // Show Employee Experience Grid
    public function EmployeeExperienceDetailsGrid(Request $req){
        $employeeexperience = Employee_Experience_Detail::with('personalDetail')->where('emp_id', $req->id)->paginate(15);
        
        return response()->json([
            'data'=>view('hr.employee_info.experience_details.detailsExperiences', compact('employeeexperience'))->render(),
        ]);
    } // End Method

    /////////////////////////// --------------- Employee Experience Details Table Methods End---------- //////////////////////////
    
    
    
    /////////////////////////// --------------- Employee Organization Details Table Methods Start---------- //////////////////////////
    // Show All Employee Details
    public function OrganizationDetails(Request $req){
        if ($req->ajax()) {
            return view('hr.employee_info.organization_details.ajaxBlade');
        }
        else{
            return view('hr.employee_info.organization_details.employeeOrganizations');
        }
    } // End Method



    // Search Employee by Name
    public function SearchOrganizationDetails(Request $req){
        return view('hr.employee_info.organization_details.employeeOrganizations');
    } // End Method



    // Show Employee Organization Details
    public function ShowOrganizationDetails(Request $req){
        $employeeorganization = Employee_Organization_Detail::with('personalDetail')->where('emp_id', $req->id)->paginate(15);
        $personaldetail = Employee_Personal_Detail::where('employee_id', $req->id)->get();

        return response()->json([
            'data'=>view('hr.employee_info.organization_details.details', compact('employeeorganization', 'personaldetail'))->render(),
        ]);
    } // End Method



    // Show Employee Organization Details Grid
    public function EmployeeOrganizationDetailsGrid(Request $req){
        $employeeorganization = Employee_Organization_Detail::with('personalDetail')->where('emp_id', $req->id)->paginate(15);
        
        return response()->json([
            'data'=>view('hr.employee_info.organization_details.detailsOrganizations', compact('employeeorganization'))->render(),
        ]);
    } // End Method

    /////////////////////////// --------------- Employee Organization Details Table Methods Start---------- //////////////////////////
}
