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
        public function ShowGroup(Request $req){
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
    
    
}
