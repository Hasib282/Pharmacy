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
                return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
            }
            else{
                return view('common_modals.single_input.main', compact('name', 'js'));
            }
        }// End Method



        // Show Room Catagory
        public function ShowRoomCatagory(Request $req){
            $name = "Room Catagory";
            $js = 'hotel/setup/roomcatagory';
            if ($req->ajax()) {
                return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
            }
            else{
                return view('common_modals.single_input.main', compact('name', 'js'));
            }
        }// End Method



        // Show Room List
        public function ShowRoomList(Request $req){
            $name = "Room List";
            $js = 'hotel/setup/roomlist';
            if ($req->ajax()) {
                return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
            }
            else{
                return view('common_modals.single_input.main', compact('name', 'js'));
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
    
}
