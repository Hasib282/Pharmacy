<?php

namespace App\Http\Controllers\Frontend\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HotelSetupController extends Controller
{
    /////////////////////////// --------------- Floor List Methods Start Here ---------- //////////////////////////
    // Show Floor
    public function ShowFloor(Request $req){
        $name = "Floor";
        $js = 'hotel/setup/floor';
        if ($req->ajax()) {
            return view('admin_setup.floor.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('admin_setup.floor.main', compact('name', 'js'));
        }
    }// End Method



    /////////////////////////// --------------- Room Category Methods Start Here ---------- //////////////////////////
    // Show Room Catagory
    public function ShowRoomCatagory(Request $req){
        $name = "Room Catagory";
        $js = 'hotel/setup/room_catagory';
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('common_modals.single_input.main', compact('name', 'js'));
        }
    }// End Method



    /////////////////////////// --------------- Room List Methods Start Here ---------- //////////////////////////
    // Show Room List
    public function ShowRoomList(Request $req){
        $name = "Room List";
        $js = 'hotel/setup/room_list';
        if ($req->ajax()) {
            return view('admin_setup.bed_list.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('admin_setup.bed_list.main', compact('name', 'js'));
        }
    }// End Method



    /////////////////////////// --------------- Hotel Services Groupe Methods Start Here ---------- //////////////////////////
    // Show group
    public function ShowGroupe(Request $req){
        $name = "Group";
        $js = 'hotel/tran_groupe';
        if ($req->ajax()) {
            return view('admin_setup.tran_groupe.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('admin_setup.tran_groupe.main', compact('name', 'js'));
        }
    }// End Method



    /////////////////////////// --------------- Hotel Services Methods Start Here ---------- //////////////////////////
    // Show Service
    public function ShowService(Request $req){
        $name = "Service";
        $js = 'hotel/tran_head';
        if ($req->ajax()) {
            return view('admin_setup.tran_head.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('admin_setup.tran_head.main', compact('name', 'js'));
        }
    }// End Method

    
    
    /////////////////////////// --------------- Hotel Booking Methods Start Here ---------- //////////////////////////
    // Show booking
    public function ShowBooking(Request $req){
        $name = "Hotel Booking";
        $js = 'hotel/setup/hotel_booking';
        if ($req->ajax()) {
            return view('admin_setup.hotel.hotel_booking.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('admin_setup.hotel.hotel_booking.main', compact('name', 'js'));
        }
    }// End Method



    /////////////////////////// --------------- Hotel Room Transfer Methods Start Here ---------- //////////////////////////
    // Show Hotel Room Transfer
    public function ShowRoomTransfer(Request $req){
        $name = "Room Transfer";
        $js = 'hotel/room_transfer';
        if ($req->ajax()) {
            return view('admin_setup.hotel.bed_transfer.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('admin_setup.hotel.bed_transfer.main', compact('name', 'js'));
        }
    }// End Method






    /////////////////////////// --------------- Hotel Room Status Methods Start Here ---------- //////////////////////////
    // Show Room Status
    public function ShowRoomstatus(Request $req){
        $name = "Room Status";
        $js = 'hotel/room_status';
        if ($req->ajax()) {
            return view('admin_setup.hotel.bed_status.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('admin_setup.hotel.bed_status.main', compact('name', 'js'));
        }
    }// End Method
    
    
    
    
    
    /////////////////////////// --------------- Hotel Bill Clearence Methods start ---------- //////////////////////////
    // Show All Hotel Bill Clearence
    public function ShowBillClearence(Request $req){
        $name = "Bill Clearence";
        $js = 'hotel/bill_clearence';
        if ($req->ajax()) {
            return view('admin_setup.hotel.bill_clearence.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('admin_setup.hotel.bill_clearence.main', compact('name', 'js'));
        }
    } // End Method
}