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



    /////////////////////////// --------------- Floor List Methods Start Here ---------- //////////////////////////
    // Show Floor
    public function ShowFloor(Request $req){
        $name = "Floor";
        $js = 'hospital/setup/floor';
        if ($req->ajax()) {
            return view('admin_setup.floor.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('admin_setup.floor.main', compact('name', 'js'));
        }
    }// End Method



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

    

    /////////////////////////// --------------- Bed List Methods Start Here ---------- //////////////////////////
    // Show Bed List
    public function ShowBedList(Request $req){
        $name = "Bed List";
        $js = 'hospital/setup/bed_list';
        if ($req->ajax()) {
            return view('admin_setup.bed_list.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('admin_setup.bed_list.main', compact('name', 'js'));
        }
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





    /////////////////////////// --------------- Patient Registrations Methods Start Here ---------- //////////////////////////
    // Show Patient Registrations
    public function ShowPatientRegistrations(Request $req){
        $name = "Patient Registration";
        $js = 'patient_registration';
        if ($req->ajax()) {
            return view('admin_setup.hospital.patient_registration.ajaxBlade', compact('name','js'));
        }
        else{
            return view('admin_setup.hospital.patient_registration.main', compact('name', 'js'));
        }
    } // End Method





    /////////////////////////// --------------- Transaction Groupe Table Methods start ---------- //////////////////////////
    // Show All Transaction Groupes
    public function ShowHospitalGroupe(Request $req){
        $name = "HospitalGroupe";
        if ($req->ajax()) {
            return view('admin_setup.tran_groupe.ajaxBlade', compact('name'));
        }
        else{
            return view('admin_setup.tran_groupe.main', compact('name'));
        }
    } // End Method





    /////////////////////////// --------------- Transaction Heads Table Methods start ---------- //////////////////////////
    // Show All Transaction Heads
    public function ShowHospitalServices(Request $req){
        $name = "HospitalServices";
        if ($req->ajax()) {
            return view('admin_setup.tran_head.ajaxBlade', compact('name'));
        }
        else{
            return view('admin_setup.tran_head.main', compact('name'));
        }
    } // End Method


     /////////////////////////// --------------- Hospital Appointment ---------- //////////////////////////
    // Show All Transaction Heads
    public function ShowPatientAppointment(Request $req){
        $name = "Hospital Appointment";
        if ($req->ajax()) {
            return view('admin_setup.hospital.appointment.ajaxBlade', compact('name'));
        }
        else{
            return view('admin_setup.hospital.appointment.main', compact('name'));
        }
    } // End Method





    /////////////////////////// --------------- Hospital Bed Transfer Methods Start Here ---------- //////////////////////////
    // Show Hospital Bed Transfer
    public function ShowBedTransfer(Request $req){
        $name = "Bed Transfer";
        $js = 'hospital/bed_transfer';
        if ($req->ajax()) {
            return view('admin_setup.bed_transfer.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('admin_setup.bed_transfer.main', compact('name', 'js'));
        }
    } // End Method






    /////////////////////////// --------------- Hospital Bed Status Methods Start Here ---------- //////////////////////////
    // Show Hospital Bed Status
    public function ShowBedStatus(Request $req){
        $name = "Bed Status";
        $js = 'hospital/bed_status';
        if ($req->ajax()) {
            return view('admin_setup.bed_status.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('admin_setup.bed_status.main', compact('name', 'js'));
        }
    } // End Method
}