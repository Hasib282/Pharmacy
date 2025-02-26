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
}