<?php

namespace App\Http\Controllers\Frontend\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HotelSetupController extends Controller
{

        // Show Floor
        public function ShowFloor(Request $req){
            $name = "Floor";
            $js = 'hotel/setup/floor';
            if ($req->ajax()) {
                return view('admin_setup.hotel.setup.floor.ajaxBlade', compact('name', 'js'));
            }
            else{
                return view('admin_setup.hotel.setup.floor.main', compact('name', 'js'));
            }
        }// End Method



        // Show Room Catagory
        public function ShowRoomCatagory(Request $req){
            $name = "Room Catagory";
            $js = 'hotel/setup/room_catagory';
            if ($req->ajax()) {
                return view('admin_setup.hotel.setup.room_catagory.ajaxBlade', compact('name', 'js'));
            }
            else{
                return view('admin_setup.hotel.setup.room_catagory.main', compact('name', 'js'));
            }
        }// End Method



        // Show Room List
        public function ShowRoomList(Request $req){
            $name = "Room List";
            $js = 'hotel/setup/room_list';
            if ($req->ajax()) {
                return view('admin_setup.hotel.setup.room_list.ajaxBlade', compact('name', 'js'));
            }
            else{
                return view('admin_setup.hotel.setup.room_list.main', compact('name', 'js'));
            }
        }// End Method



        // Show group
        public function ShowGroup(Request $req){
            $name = "Group";
            $js = 'hotel/setup/group';
            if ($req->ajax()) {
                return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
            }
            else{
                return view('common_modals.single_input.main', compact('name', 'js'));
            }
        }// End Method



        // Show Service
        public function ShowService(Request $req){
            $name = "Service";
            $js = 'hotel/setup/service';
            if ($req->ajax()) {
                return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
            }
            else{
                return view('common_modals.single_input.main', compact('name', 'js'));
            }
        }// End Method

        
        
        // Show booking
        public function ShowBooking(Request $req){
            $name = "Hotel Booking";
            $js = 'hotel/booking';
            if ($req->ajax()) {
                return view('admin_setup.hotel.hotel_booking.ajaxBlade', compact('name', 'js'));
            }
            else{
                return view('admin_setup.hotel.hotel_booking.main', compact('name', 'js'));
            }
        }// End Method
    
    
}
