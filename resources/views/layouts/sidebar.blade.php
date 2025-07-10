<aside id="mySidenav" class="sidenav">
    {{-- <a href="{{ route('show.profile', auth()->user()->id) }}"> --}}
        <div class="user-details">
            <div class="user-image">
                <img src="{{ rtrim(env('API_URL'), '/api') }}/storage/{{ auth()->user()->image != null ? auth()->user()->image : (auth()->user()->gender == 'female' ? 'female.png' : 'male.png') }}" alt="">
            </div>
            <div class="user-name">
                <strong>{{ auth()->user()->user_name }}</strong> <br>
                <strong style="color:#00aaffcf;">{{ auth()->user()->role->name }}</strong>
            </div>
        </div>
    {{-- </a> --}}
    <hr>
    <!-- Sidebar menue starts -->
    <ul class="sidebar-menu">
        @if(auth()->user()->hasPermissionMainHead('1'))
            <li class="menu-item">
                <div class="menu-title {{ Request::segment(1) == 'admin' ? 'active':''}}">
                    <p>
                        <i class="fa-solid fa-house"></i>
                        ADMINISTRATOR
                    </p>
                    <i class="fas fa-angle-right {{ Request::segment(1) == 'admin' ? 'rotate':''}}"></i>
                </div>
                <ul class="sub-menu {{ Request::segment(1) == 'admin' ? 'show':''}}">
                    {{-- Company Menu --}}
                    @if(auth()->user()->user_role == 1)
                        <li class="sub-menu-item">
                            <div class="menu-title {{ (Request::segment(1) == 'admin' && (Request::segment(2) == 'companytype' || Request::segment(2) == 'companies')) ? 'active' : '' }}">
                                <p>
                                    <i class="fa-solid fa-building"></i>
                                    Company
                                </p>
                                <i class="fas fa-angle-right {{ (Request::segment(1) == 'admin' && (Request::segment(2) == 'companytype' || Request::segment(2) == 'companies')) ? 'rotate' : '' }}"></i>
                            </div>
                            <ul class="sub-menu1 {{ (Request::segment(1) == 'admin' && (Request::segment(2) == 'companytype' || Request::segment(2) == 'companies')) ? 'show':''}}">
                                <li class="sub-menu1-item" data-url="{{route('show.companytype')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'companytype') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-house-circle-exclamation"></i>
                                            Types
                                        </p>
                                    </div>
                                </li>

                                <li class="sub-menu1-item" data-url="{{route('show.companies')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'companies') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-house-user"></i>
                                            Details
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    @endif

                    {{-- Users Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-users"></i>
                                Users
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users') ? 'show':''}}">
                            @if(auth()->user()->user_role == 1)
                                <li class="sub-menu1-item" data-url="{{route('show.roles')}}">
                                    <div class="menu-title  {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users' && Request::segment(3) == 'roles') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-dice-six"></i>
                                            Roles
                                        </p>
                                    </div>
                                </li>
                            
                                <li class="sub-menu1-item" data-url="{{route('show.superAdmins')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users' && Request::segment(3) == 'superadmins') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-secret"></i>
                                            Super Admin
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(1))
                                <li class="sub-menu1-item" data-url="{{route('show.admins')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users' && Request::segment(3) == 'admins') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-tie"></i>
                                            Admin 
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>

                    {{-- Permissions Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'permission') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-user-lock"></i>
                                Permissions
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'permission') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'permission') ? 'show':''}}">
                            @if(auth()->user()->user_role == 1)
                                <li class="sub-menu1-item" data-url="{{route('show.permissionMainheads')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'permission' && Request::segment(3) == 'mainhead') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-secret"></i>
                                            Main Head
                                        </p>
                                    </div>
                                </li>
                                
                                <li class="sub-menu1-item" data-url="{{route('show.permissions')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'permission' && Request::segment(3) == 'heads') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-secret"></i>
                                            Heads
                                        </p>
                                    </div>
                                </li>
                                
                                <li class="sub-menu1-item" data-url="{{route('show.companyTypePermissions')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'permission' && Request::segment(3) == 'company_type_permissions') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-house-circle-exclamation"></i>
                                            Company Type
                                        </p>
                                    </div>
                                </li>
                                
                                <li class="sub-menu1-item" data-url="{{route('show.companyPermissions')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'permission' && Request::segment(3) == 'company_permissions') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-house-user"></i>
                                            Company
                                        </p>
                                    </div>
                                </li>
                            @endif
                    
                            @if(auth()->user()->hasPermission(5))
                                <li class="sub-menu1-item" data-url="{{route('show.userPermissions')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'permission' && Request::segment(3) == 'userpermissions') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-shield"></i>
                                            User Permissions
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>
                                
                    @if(auth()->user()->hasPermission(7))
                        <li class="sub-menu-item" data-url="{{route('show.banks')}}">
                            <div class="menu-title  {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'banks') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-people-roof"></i>
                                    Bank
                                </p>
                            </div>
                        </li>
                    @endif
                                
                    @if(auth()->user()->hasPermission(8))
                        <li class="sub-menu-item" data-url="{{route('show.locations')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'locations') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-location-dot"></i>
                                    Locations
                                </p>
                            </div>
                        </li>
                    @endif
                            
                    @if(auth()->user()->hasPermission(9))
                        <li class="sub-menu-item" data-url="{{route('show.stores')}}">
                            <div class="menu-title  {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'stores') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-shop"></i>
                                    Store Details
                                </p>
                            </div>
                        </li>
                    @endif

                    @if(auth()->user()->hasPermission(287))
                        <li class="sub-menu-item" data-url="{{route('show.paymentMethod')}}">
                            <div class="menu-title  {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'payment_method') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-credit-card"></i>
                                    Payment Method
                                </p>
                            </div>
                        </li>
                    @endif
                            
                    @if(auth()->user()->user_role == 1)
                        <li class="sub-menu-item" data-url="{{route('show.mainhead')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'mainheads') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-money-check-dollar"></i>
                                    Main Head 
                                </p>
                            </div>
                        </li>
                        
                        <li class="sub-menu-item" data-url="{{route('show.groupes')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'trangroupes') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-layer-group"></i>
                                    Transaction Group
                                </p>
                            </div>
                        </li>
                        
                        <li class="sub-menu-item" data-url="{{route('show.heads')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'tranheads') ? 'active':''}}">
                                <p>
                                    <i class="fa-brands fa-raspberry-pi"></i>
                                    Transaction Head
                                </p>
                            </div>
                        </li>
                    @endif

                    @if(auth()->user()->hasPermission(291))
                    <li class="sub-menu-item" data-url="{{route('show.corporate')}}">
                        <div class="menu-title  {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'corporate') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-building-columns"></i>
                                Corporate
                            </p>
                        </div>
                    </li>
                @endif
                </ul>
            </li>
            <hr>
        @endif




        <!-- General Transaction Menue -->
        @if(auth()->user()->hasPermissionMainHead('2'))
            <li class="menu-item">
                <div class="menu-title {{ (Request::segment(1) == 'transaction' && (Request::segment(2) == 'receive' || Request::segment(2) == 'payment' || Request::segment(2) == 'party' || Request::segment(2) == 'setup' || Request::segment(2) == 'users')) ? 'active':''}}">
                    <p>
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        GENERAL TRANSACTION
                    </p>
                    <i class="fas fa-angle-right {{ (Request::segment(1) == 'transaction' && (Request::segment(2) == 'receive' || Request::segment(2) == 'payment' || Request::segment(2) == 'party' || Request::segment(2) == 'setup' || Request::segment(2) == 'users')) ? 'rotate':''}}"></i>
                </div>
                <ul class="sub-menu {{ (Request::segment(1) == 'transaction' && (Request::segment(2) == 'receive' || Request::segment(2) == 'payment' || Request::segment(2) == 'party' || Request::segment(2) == 'setup' || Request::segment(2) == 'users')) ? 'show':''}}">
                    {{-- Transaction Setup Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'setup') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-gears"></i>
                                SETUP
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'setup') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'setup') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(13))
                                <li class="sub-menu1-item" data-url="{{route('show.tranGroupes')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'setup' && Request::segment(3) == 'groupes') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-layer-group"></i>
                                            Groupes
                                        </p>
                                    </div>
                                </li>
                            @endif
                                    
                            @if(auth()->user()->hasPermission(17))
                                <li class="sub-menu1-item" data-url="{{route('show.tranHeads')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'setup' && Request::segment(3) == 'heads') ? 'active':''}}">
                                        <p>
                                            <i class="fa-brands fa-raspberry-pi"></i>
                                            Service / Product
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>

                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'users') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-users-gear"></i>
                                USERS
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'users') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'users') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(21))
                                <li class="sub-menu1-item" data-url="{{route('show.tranUserType')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'users' && Request::segment(3) == 'usertype') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-tag"></i>
                                            Client/Supplier Type
                                        </p>
                                    </div>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission(25))
                                <li class="sub-menu1-item" data-url="{{route('show.clients')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'users' && Request::segment(3) == 'clients') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-users"></i>
                                            Client
                                        </p>
                                    </div>
                                </li>
                            @endif
                            
                            @if(auth()->user()->hasPermission(29))
                                <li class="sub-menu1-item" data-url="{{route('show.suppliers')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'users' && Request::segment(3) == 'suppliers') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-people-carry-box"></i>
                                            Supplier
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>

                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'transaction' && (Request::segment(2) == 'receive' || Request::segment(2) == 'payment')) ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                TRANSACTION
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'transaction' && (Request::segment(2) == 'receive' || Request::segment(2) == 'payment')) ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'transaction' && (Request::segment(2) == 'receive' || Request::segment(2) == 'payment')) ? 'show':''}}">
                            @if(auth()->user()->hasPermission(33))
                                <li class="sub-menu1-item" data-url="{{route('show.transactionReceive')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'receive') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-users-rectangle"></i>
                                            With Client
                                        </p>
                                    </div>
                                </li>
                            @endif
                                    
                            @if(auth()->user()->hasPermission(37))
                                <li class="sub-menu1-item" data-url="{{route('show.transactionPayment')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'payment') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-people-carry-box"></i>
                                            With Supplier
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>

                    {{-- Party Payments --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'party') ? 'active':''}}">
                            <p>
                                <i class="fa-regular fa-credit-card"></i>
                                PARTY PAYMENT
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'party') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'party') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(41))
                                <li class="sub-menu1-item" data-url="{{route('show.partyReceive')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'party' && Request::segment(3) == 'receive') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-users"></i>
                                            Receive from Client
                                        </p>
                                    </div>
                                </li>
                            @endif
                                        
                            @if(auth()->user()->hasPermission(45))
                                <li class="sub-menu1-item" data-url="{{route('show.partyPayment')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'party' && Request::segment(3) == 'payment') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-people-carry-box"></i>
                                            Payment to Supplier
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </li>

            <hr>
        @endif
        
        <!-- Transaction With Bank -->
        @if(auth()->user()->hasPermissionMainHead('3'))
            <li class="menu-item">
                <div class="menu-title {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'bank') ? 'active':''}}">
                    <p>
                        <i class="fa-solid fa-building-columns"></i>
                        BANK TRANSACTION
                    </p>
                    <i class="fas fa-angle-right {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'bank') ? 'rotate':''}}"></i>
                </div>
                <ul class="sub-menu {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'bank') ? 'show':''}}">
                    @if(auth()->user()->hasPermission(53))
                        <li class="sub-menu-item" data-url="{{route('show.withdraws')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'transaction' && Request::segment(3) == 'withdraw') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-sack-dollar"></i>
                                    Withdraw from Bank
                                </p>
                            </div>
                        </li>
                    @endif
                    
                    @if(auth()->user()->hasPermission(49))
                        <li class="sub-menu-item" data-url="{{route('show.deposits')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'transaction' && Request::segment(3) == 'deposit') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-hand-holding-dollar"></i>
                                    Deposit to Bank
                                </p>
                            </div>
                        </li>
                    @endif
                </ul>
            </li>
            <hr>
        @endif


        <!-- HR & PAYROLL -->
        @if(auth()->user()->hasPermissionMainHead('4'))
            <li class="menu-item">
                <div class="menu-title {{ Request::segment(1) == 'hr' ? 'active':''}}">
                    <p>
                        <i class="fa-solid fa-house"></i>
                        HR & PAYROLL
                    </p>
                    <i class="fas fa-angle-right {{ Request::segment(1) == 'hr' ? 'rotate':''}}"></i>
                </div>
                <ul class="sub-menu {{ Request::segment(1) == 'hr' ? 'show':''}}">
                    {{-- Transaction Setup Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'setup') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-gears"></i>
                                SETUP
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'setup') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'setup') ? 'show':''}}">                                    
                            @if(auth()->user()->hasPermission(57))
                                <li class="sub-menu1-item" data-url="{{route('show.departments')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(3) == 'departments') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-building"></i>
                                            Department
                                        </p>
                                    </div>
                                </li>
                            @endif
                                        
                            @if(auth()->user()->hasPermission(61))
                                <li class="sub-menu1-item" data-url="{{route('show.designations')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(3) == 'designations') ? 'active':''}}">
                                        <p>
                                            <i class="fas fa-id-badge"></i>
                                            Designation
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>

                    <!-- EMPLOYEE -->
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-users-gear"></i>
                                Employee
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee') ? 'rotate':''}}"></i>
                        </div>
                        <ul class=" sub-menu1 {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(65))
                                <li class="sub-menu1-item" data-url="{{route('show.hrUserType')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'usertype') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-tag"></i>
                                            Employee Type
                                        </p>
                                    </div>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission(69))
                                <li class="sub-menu1-item" data-url="{{route('show.employees')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'all') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-users"></i>
                                            All Employee
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(73))
                                <li class="sub-menu1-item" data-url="{{ route('show.employeePersonal') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'personal') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-plus"></i>
                                            Personal Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(77))
                                <li class="sub-menu1-item" data-url="{{ route('show.employeeEducation') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'education') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-address-book"></i>
                                            Education Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(81))
                                <li class="sub-menu1-item" data-url="{{ route('show.employeeTraining') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'training') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-gear"></i>
                                            Training Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(85))
                                <li class="sub-menu1-item" data-url="{{ route('show.employeeExperience') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'experience') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-tie"></i>
                                            Experience Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(89))
                                <li class="sub-menu1-item" data-url="{{ route('show.employeeOrganization') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'organization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-building-user"></i>
                                            Organization Details
                                        </p>
                                    </div>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission(93))
                                <li class="sub-menu1-item" data-url="{{route('show.employeeAttendence')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'attendence') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-clipboard-user"></i>
                                            Attendence
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>

                    <!-- PAYROLL -->
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'payroll') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                PAYROLL
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'payroll') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'payroll') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(96))
                                <li class="sub-menu1-item" data-url="{{route('show.hrHeads')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'payroll' && Request::segment(3) == 'heads') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-dice-one"></i>
                                            Payroll Category
                                        </p>
                                    </div>
                                </li>
                            @endif
                            
                            @if(auth()->user()->hasPermission(100))
                                <li class="sub-menu1-item" data-url="{{route('show.payrollSetup')}}">
                                    <div class="menu-title  {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'payroll' && Request::segment(3) == 'setup') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Payroll Setup
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(104))
                                <li class="sub-menu1-item" data-url="{{route('show.payrollMiddlewire')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'payroll' && Request::segment(3) == 'middlewire') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Payroll Middlewire
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(108))
                                <li class="sub-menu1-item" data-url="{{route('show.payroll')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'payroll' && Request::segment(3) == 'process') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Payroll / Salary Payment
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>
                    
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'report') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                REPORTS
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'report') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'report') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(110))
                                <li class="sub-menu1-item" data-url="{{route('show.salarySummaryReport')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'report' && Request::segment(4) == 'summary') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Summary
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(111))
                                <li class="sub-menu1-item" data-url="{{route('show.salaryDetailsReport')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'report' && Request::segment(4) == 'details') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </li>
            <hr>
        @endif
        
        <!-- Pharmacy Menu Start -->
        @if(auth()->user()->hasPermissionMainHead('5'))
            <li class="menu-item">
                <div class="menu-title {{ Request::segment(1) == 'pharmacy' ? 'active':''}}">
                    <p>
                        <i class="fa-solid fa-house-chimney-medical"></i>
                        PHARMACY
                    </p>
                    <i class="fas fa-angle-right {{ Request::segment(1) == 'pharmacy' ? 'rotate':''}}"></i>
                </div>
                <ul class="sub-menu {{ Request::segment(1) == 'pharmacy' ? 'show':''}}">
                    {{-- Pharmacy Setup Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'setup') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-gears"></i>
                                SETUP
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'setup') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'setup') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(112))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyManufacturer')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'setup' && Request::segment(3) == 'manufacturer') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Item Manufacturer
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(116))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyCategory')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'setup' && Request::segment(3) == 'category') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-table-cells-large"></i>
                                            Item Category
                                        </p>
                                    </div>
                                </li>
                            @endif
                            
                            @if(auth()->user()->hasPermission(120))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyUnit')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'setup' && Request::segment(3) == 'unit') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-scale-unbalanced"></i>
                                            Item Unit
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(124))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyForm')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'setup' && Request::segment(3) == 'form') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-list-ul"></i>
                                            Item Form
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(128))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyGroupes')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'setup' && Request::segment(3) == 'groupes') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-layer-group"></i>
                                            Item Groupe
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(132))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyProduct')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'setup' && Request::segment(3) == 'product') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-cart-shopping"></i>
                                            Pharmacy Products
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>

                    {{-- Pharmacy Users Menu Start  --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'users') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-users-gear"></i>
                                USERS
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'users') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'users') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(136))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyUserType')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'users' && Request::segment(3) == 'usertype') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-tag"></i>
                                            Client/Supplier Type
                                        </p>
                                    </div>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission(140))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyClients')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'users' && Request::segment(3) == 'clients') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-users"></i>
                                            Client
                                        </p>
                                    </div>
                                </li>
                            @endif
                            
                            @if(auth()->user()->hasPermission(144))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacySuppliers')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'users' && Request::segment(3) == 'suppliers') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-people-carry-box"></i>
                                            Supplier
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>

                    {{-- Pharmacy Transaction Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'transaction') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                TRANSACTIONS
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'transaction') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'transaction') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(148))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyPurchase')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'transaction' && Request::segment(3) == 'purchase') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-bag-shopping"></i>
                                            Pharmacy Purchase
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(153))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyIssue')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'transaction' && Request::segment(3) == 'issue') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-cash-register"></i>
                                            Pharmacy Issue
                                        </p>
                                    </div>
                                </li>
                            @endif
                            
                            <li class="sub-menu1-item">
                                <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'transaction' && Request::segment(3) == 'return') ? 'active':''}}">
                                    <p>
                                        <i class="fa-solid fa-hand-holding-dollar"></i>
                                        Pharmacy Return
                                    </p>
                                    <i class="fas fa-angle-right {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'transaction' && Request::segment(3) == 'return') ? 'rotate':''}}"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'transaction' && Request::segment(3) == 'return' ) ? 'show':''}}">
                                    @if(auth()->user()->hasPermission(157))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacyClientReturn')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'transaction' && Request::segment(3) == 'return' && Request::segment(4) == 'client') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Client Return
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermission(161))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacySupplierReturn')}}">
                                            <div class="menu-title  {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'transaction' && Request::segment(3) == 'return' && Request::segment(4) == 'supplier') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Supplier Return
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </li>
                    

                    {{-- Pharmacy Adjustment Sub menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'adjustment') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-hand-holding-dollar"></i>
                                ADJUSTMENT
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'adjustment') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'adjustment') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(165))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyPosAdjustment')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'adjustment' && Request::segment(3) == 'positive') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-folder-plus"></i>
                                            Positive Adjustment
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(169))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyNegAdjustment')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'adjustment' && Request::segment(3) == 'negative') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-folder-minus"></i>
                                            Negative Adjustment
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>

                    {{-- Party Payments --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'party') ? 'active':''}}">
                            <p>
                                <i class="fa-regular fa-credit-card"></i>
                                PARTY PAYMENT
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'party') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'party') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(173))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyPartyReceive')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'party' && Request::segment(3) == 'receive') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-users"></i>
                                            Receive from Client
                                        </p>
                                    </div>
                                </li>
                            @endif
                                        
                            @if(auth()->user()->hasPermission(177))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyPartyPayment')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'party' && Request::segment(3) == 'payment') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-people-carry-box"></i>
                                            Payment to Supplier
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>

                    {{-- Pharmacy Reports Sub menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                REPORTS
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report') ? 'show':''}}">
                            {{-- Item Flow statement start --}}
                            @if(auth()->user()->hasPermission(181))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyItemFlow')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'item') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-hand-holding-dollar"></i>
                                            Item Flow Statement
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            {{-- Stock statement start --}}
                            <li class="sub-menu1-item">
                                <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'stock') ? 'active':''}}">
                                    <p>
                                        <i class="fa-solid fa-cubes"></i>
                                        Stock Statement
                                    </p>
                                    <i class="fas fa-angle-right {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'stock') ? 'rotate':''}}"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'stock') ? 'show':''}}">
                                    @if(auth()->user()->hasPermission(183))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacyStockDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'stock' && Request::segment(4) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-file-invoice"></i>
                                                    Stock Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermission(182))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacyStockSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'stock' && Request::segment(4) == 'summary') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-file-invoice"></i>
                                                    Stock Summary
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </li>

                            
                            
                            {{-- Profitability statement start --}}    
                            @if(auth()->user()->hasPermission(184))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyProfit')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'profitability') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-hand-holding-dollar"></i>
                                            Profitability Statement
                                        </p>
                                    </div>
                                </li>
                            @endif

                            {{-- Expiry statement start --}}    
                            @if(auth()->user()->hasPermission(185))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyExpiry')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'expiry') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-tag"></i>
                                            Expiry Statement
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            
                            {{-- Purchase statement start --}}
                            <li class="sub-menu1-item">
                                <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'purchase') ? 'active':''}}">
                                    <p>
                                        <i class="fa-solid fa-cart-plus"></i>
                                        Purchase Statement
                                    </p>
                                    <i class="fas fa-angle-right {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'purchase') ? 'rotate':''}}"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'purchase') ? 'show':''}}">
                                    @if(auth()->user()->hasPermission(187))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacyPurchaseDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'purchase' && Request::segment(4) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-file-invoice"></i>
                                                    Purchase Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermission(186))
                                        <li  class="sub-menu2-item"data-url="{{route('show.pharmacyPurchaseSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'purchase' && Request::segment(4) == 'summary') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-file-invoice"></i>
                                                    Purchase Summary
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </li>

                            {{-- Issue statement start --}}
                            <li class="sub-menu1-item">
                                <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'issue') ? 'active':''}}">
                                    <p>
                                        <i class="fa-solid fa-list-check"></i>
                                        Issue Statement
                                    </p>
                                    <i class="fas fa-angle-right {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'issue') ? 'rotate':''}}"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'issue') ? 'show':''}}">
                                    @if(auth()->user()->hasPermission(189))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacyIssueDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'issue' && Request::segment(4) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-file-invoice"></i>
                                                    Issue Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermission(188))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacyIssueSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'issue' && Request::segment(4) == 'summary') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-file-invoice"></i>
                                                    Issue Summary
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                            {{-- Return statement start --}}
                            <li class="sub-menu1-item">
                                <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'return') ? 'active':''}}">
                                    <p>
                                        <i class="fa-solid fa-hand-holding-hand"></i>
                                        Return Statement
                                    </p>
                                    <i class="fas fa-angle-right {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'return') ? 'rotate':''}}"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'return') ? 'show':''}}">
                                    @if(auth()->user()->hasPermission(191))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacyClientReturnDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'client' && Request::segment(5) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-file-invoice"></i>
                                                    Client Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermission(190))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacyClientReturnSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'client' && Request::segment(5) == 'summary') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-file-invoice"></i>
                                                    Client Summary
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermission(193))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacySupplierReturnDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'supplier' && Request::segment(5) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-file-invoice"></i>
                                                    Supplier Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermission(192))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacySupplierReturnSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'supplier' && Request::segment(5) == 'summary') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-file-invoice"></i>
                                                    Supplier Summary
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <hr>
        @endif
        

                       
        
            
        {{-- Reports and Querrys  --}}
        @if(auth()->user()->hasPermissionMainHead('12'))
            <li class="menu-item">
                <div class="menu-title {{ Request::segment(1) == 'report' ? 'active':''}}">
                    <p>
                        <i class="fa-solid fa-book-open"></i>
                        REPORTS & QUERIES
                    </p>
                    <i class="fas fa-angle-right {{ Request::segment(1) == 'report' ? 'rotate':''}}"></i>
                </div>
                <ul class="sub-menu {{ Request::segment(1) == 'report' ? 'show':''}}">
                    {{-- accounts statement part start --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'account') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                Account Statement
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'report' && Request::segment(2) == 'account') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'report' && Request::segment(2) == 'account') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(276))
                                <li class="sub-menu1-item" data-url="{{ route('show.accountSummary') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'account' && Request::segment(3) == 'summary') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Summary
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(277))
                                <li class="sub-menu1-item" data-url="{{ route('show.accountSummaryByGroupe') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'account' && Request::segment(3) == 'summarygroupe') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Summary(By Groupe)
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(278))
                                <li class="sub-menu1-item" data-url="{{ route('show.accountDetails') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'account' && Request::segment(3) == 'details') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>

                    {{-- Party statement part start --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'party') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                Party Statement
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'report' && Request::segment(2) == 'party') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'report' && Request::segment(2) == 'party') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(280))
                                <li class="sub-menu1-item" data-url="{{ route('show.partyDetails') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'party' && Request::segment(3) == 'details') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(279))
                                <li class="sub-menu1-item" data-url="{{ route('show.partySummary') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'party' && Request::segment(3) == 'summary') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Summary
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>

                     {{-- Collections statement part start --}}

                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'collection') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                Collections Statement
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'report' && Request::segment(2) == 'collection') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'report' && Request::segment(2) == 'collection') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(414))
                                <li class="sub-menu1-item" data-url="{{ route('show.collectionDetails') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'collection' && Request::segment(3) == 'details') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(415))
                                <li class="sub-menu1-item" data-url="{{ route('show.collectionSummary') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'collection' && Request::segment(3) == 'summary') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Summary
                                        </p>
                                    </div>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission(416))
                                <li class="sub-menu1-item" data-url="{{ route('show.collectionInvoiceDetails') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'collection' && Request::segment(3) == 'invoice_details') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Details (Invoice)
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(417))
                                <li class="sub-menu1-item" data-url="{{ route('show.collectionInvoiceSummary') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'collection' && Request::segment(3) == 'invoice_summary') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Summary (Invoice)
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>


                    {{-- Payment statement part start --}}

                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'payment') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                Payment Statement
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'report' && Request::segment(2) == 'payment') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'report' && Request::segment(2) == 'payment') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(418))
                                <li class="sub-menu1-item" data-url="{{ route('show.paymentDetails') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'payment' && Request::segment(3) == 'details') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(419))
                                <li class="sub-menu1-item" data-url="{{ route('show.paymentSummary') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'payment' && Request::segment(3) == 'summary') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Summary
                                        </p>
                                    </div>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission(420))
                                <li class="sub-menu1-item" data-url="{{ route('show.paymentInvoiceDetails') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'payment' && Request::segment(3) == 'invoice_details') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Details (Invoice)
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(421))
                                <li class="sub-menu1-item" data-url="{{ route('show.paymentInvoiceSummary') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'payment' && Request::segment(3) == 'invoice_summary') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Summary (Invoice)
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>



                     {{-- Consolidated statement part start --}}

                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'consolidated') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                Consolidated Statement
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'report' && Request::segment(2) == 'consolidated') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'report' && Request::segment(2) == 'consolidated') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(422))
                                <li class="sub-menu1-item" data-url="{{ route('show.consolidatedDetails') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'consolidated' && Request::segment(3) == 'details') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(423))
                                <li class="sub-menu1-item" data-url="{{ route('show.consolidatedSummary') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'consolidated' && Request::segment(3) == 'summary') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Summary
                                        </p>
                                    </div>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission(424))
                                <li class="sub-menu1-item" data-url="{{ route('show.consolidatedInvoiceDetails') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'consolidated' && Request::segment(3) == 'invoice_details') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Details (Invoice)
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(425))
                                <li class="sub-menu1-item" data-url="{{ route('show.consolidatedInvoiceSummary') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'consolidated' && Request::segment(3) == 'invoice_summary') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Summary (Invoice)
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>
                </ul>
                </ul>
            </li>
        @endif
    </ul>
</aside>