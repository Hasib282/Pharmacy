@extends('layouts.layout')
@section('main-content')
    <h2 style="text-align: center;">Profile Details</h2>
    <div class="rows">
        <div class="c-3">
            <div class="center-col">
                <img src="/storage/profiles/{{ $profile->image != null ? $profile->image : ($profile->gender == 'female' ? 'female.png' : 'male.png') }}" alt="" height="200px" width="200px">
                <h4>{{ $profile->user_name }}</h4>
                <h6>{{ $profile->user_email }}</h6>
            </div>
        </div>
        <div class="c-5">
            <div class="rows">
                <div class="c-12"><div class="form-input-group"><label for="name">Name</label><input type="text" class="form-input" placeholder="enter name" value="{{ $profile->user_name }}" id="name"></div></div>
                <div class="c-6"><div class="form-input-group"><label for="email">Email</label><input type="text" class="form-input" placeholder="enter email" value="{{ $profile->user_email }}" id="email"></div></div>
                <div class="c-6"><div class="form-input-group"><label for="phone">Phone</label><input type="text" class="form-input" placeholder="enter phone number" value="{{ $profile->user_phone }}" id="phone"></div></div>
                <div class="c-6"><div class="form-input-group"><label for="user">User Type</label><input type="text" class="form-input" placeholder="enter user type" value="{{ $profile->user_type }}" id="user"></div></div>
                <div class="c-6"><div class="form-input-group"><label for="tran_user">User Category</label><input type="text" class="form-input" placeholder="enter user category" value="{{ $profile->tran_user_type }}" id="tran_user"></div></div>
                <div class="c-6"><div class="form-input-group"><label for="department">Department</label><input type="text" class="form-input" placeholder="enter department" value="{{ $profile->department }}" id="department"></div></div>
                <div class="c-6"><div class="form-input-group"><label for="designation">Designation</label><input type="text" class="form-input" placeholder="enter designation" value="{{ $profile->designation }}" id="designation"></div></div>
                <div class="c-6"><div class="form-input-group"><label for="dob">DOB</label><input type="date" class="form-input" value="{{ $profile->dob }}" id="dob"></div></div>
                <div class="c-6"><div class="form-input-group"><label for="nid">NID</label><input type="text" class="form-input" placeholder="enter nid" value="{{ $profile->nid }}" id="nid"></div></div>
                <div class="c-12"><div class="form-input-group"><label for="location">Location</label><input type="text" class="form-input" placeholder="enter location" value="{{ $profile->location->upazila }}" id="location"></div></div>
                <div class="c-12"><div class="form-input-group"><label for="address">Address</label><input type="text" class="form-input" placeholder="enter address" value="{{ $profile->address }}" id="address"></div></div>
                <div class="c-12"><div class="form-input-group"><label for="image">Image</label><input type="file" class="form-input" id="image"></div></div>
            </div>
            <div class="center"><input type="submit" class="btn-blue" value="Save Profile"></div>
        </div>
        <div class="c-4">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center experience"><span>Edit Experience</span><span class="border px-3 p-1 add-experience"><i class="fa fa-plus"></i>&nbsp;Experience</span></div><br>
                <div class="form-input-group"><label for="">Experience in Designing</label><input type="text" class="form-input" placeholder="experience" value="{{ $profile->user_name }}" id=""></div> <br>
                <div class="form-input-group"><label for="">Additional Details</label><input type="text" class="form-input" placeholder="additional details" value="{{ $profile->user_name }}" id=""></div>
            </div>
        </div>
    </div>
@endsection
