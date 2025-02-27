<?php

namespace App\Http\Controllers\Frontend\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HospitalSetupConrtoller extends Controller
{
    /////////////////////////// ---------------Specialization Methods Start Here ---------- //////////////////////////
    // Show Specialization
    public function ShowSpecialization(Request $req){
        $name = "Specialization";
        $js = 'hospital/setup/specialization';
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('common_modals.single_input.main', compact('name', 'js'));
        }
    } // End Method



    // Search Specialization
    public function SearchSpecialization(Request $req){
        $name = "Specialization";
        $js = 'hospital/setup/specialization';
        return view('common_modals.single_input.main', compact('name', 'js'));
    } // End Method



    /////////////////////////// --------------- Bed Category Methods Start Here ---------- //////////////////////////
    // Show Bed Category
    public function ShowBedCategory(Request $req){
        $name = "Bed Category";
        $js = 'hospital/setup/bed_category';
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('common_modals.single_input.main', compact('name', 'js'));
        }
    } // End Method



    // Search Bed Category
    public function SearchBedCategory(Request $req){
        $name = "Bed Category";
        $js = 'hospital/setup/bed_category';
        return view('common_modals.single_input.main', compact('name', 'js'));
    } // End Method

    

    /////////////////////////// --------------- Bed List Methods Start Here ---------- //////////////////////////
    // Show Bed List
    public function ShowBedList(Request $req){
        $name = "Bed List";
        $js = 'hospital/setup/bed_list';
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('common_modals.single_input.main', compact('name', 'js'));
        }
    } // End Method



    // Search BedList
    public function SearchBedList(Request $req){
        $name = "Bed List";
        $js = 'hospital/setup/bed_list';
        return view('common_modals.single_input.main', compact('name', 'js'));
    } // End Method
    
    
    
    
    /////////////////////////// --------------- Nursing Station Methods Start Here ---------- //////////////////////////
    // Show Nursing Station
    public function ShowNursingStation(Request $req){
        $name = "Nursing Station";
        $js = '';
        if ($req->ajax()) {
            return view('admin_setup.hospital.nursing_station.ajaxBlade', compact('name','js'));
        }
        else{
            return view('admin_setup.hospital.nursing_station.main', compact('name', 'js'));
        }
    } // End Method



    // Search Nursing Station
    public function SearchNursingStation(Request $req){
        $name = "Nursing Station";
        $js = '';
        return view('admin_setup.hospital.nursing_station.main', compact('name', 'js'));
    } // End Method
    
    
    
    /////////////////////////// --------------- Doctor Methods Start Here ---------- //////////////////////////
    // Show Doctors
    public function ShowDoctors(Request $req){
        $name = "Doctor";
        $js = '';
        if ($req->ajax()) {
            return view('admin_setup.hospital.doctor_information.ajaxBlade', compact('name','js'));
        }
        else{
            return view('admin_setup.hospital.doctor_information.main', compact('name', 'js'));
        }
    } // End Method



    // Search Doctors
    public function SearchDoctors(Request $req){
        $name = "Doctor";
        $js = '';
        return view('admin_setup.hospital.doctor_information.main', compact('name', 'js'));
    } // End Method
    
    
    
    /////////////////////////// --------------- Patient Methods Start Here ---------- //////////////////////////
    // Show Patients
    public function ShowPatients(Request $req){
        $name = "Patient";
        $js = '';
        if ($req->ajax()) {
            return view('admin_setup.hospital.patient_registration.ajaxBlade', compact('name','js'));
        }
        else{
            return view('admin_setup.hospital.patient_registration.main', compact('name', 'js'));
        }
    } // End Method



    // Search Patients
    public function SearchPatients(Request $req){
        $name = "Patient";
        $js = '';
        return view('admin_setup.hospital.patient_registration.main', compact('name', 'js'));
    } // End Method
}