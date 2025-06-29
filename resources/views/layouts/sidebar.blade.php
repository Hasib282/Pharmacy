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
                        <div class="menu-title  {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'advance_receive') ? 'active':''}}">
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
        
        <!-- Inventory Menu Start -->
        @if(auth()->user()->hasPermissionMainHead('6'))
            <li class="menu-item">
                <div class="menu-title {{ Request::segment(1) == 'inventory' ? 'active':''}}">
                    <p>
                        <i class="fa-solid fa-truck-ramp-box"></i>
                        INVENTORY
                    </p>
                    <i class="fas fa-angle-right {{ Request::segment(1) == 'inventory' ? 'rotate':''}}"></i>
                </div>
                <ul class="sub-menu {{ Request::segment(1) == 'inventory' ? 'show':''}}">
                    {{-- Inventory Setup Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'setup') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-gears"></i>
                                SETUP
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'setup') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'setup') ? 'show':''}}">              
                            @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.invManufacturer')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'setup' && Request::segment(3) == 'manufacturer') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Item Manufacturer
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(198))
                                <li class="sub-menu1-item" data-url="{{route('show.invCategory')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'setup' && Request::segment(3) == 'category') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-table-cells-large"></i>
                                            Item Category
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(202))
                                <li class="sub-menu1-item" data-url="{{route('show.invUnit')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'setup' && Request::segment(3) == 'unit') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-scale-unbalanced"></i>
                                            Item Unit
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(206))
                                <li class="sub-menu1-item" data-url="{{route('show.invForm')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'setup' && Request::segment(3) == 'form') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-list-ul"></i>
                                            Item Form
                                        </p>
                                    </div>
                                </li>
                            @endif
                            
                            @if(auth()->user()->hasPermission(210))
                                <li class="sub-menu1-item" data-url="{{route('show.invGroupes')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'setup' && Request::segment(3) == 'groupes') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-layer-group"></i>
                                            Item Groupe
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(214))
                                <li class="sub-menu1-item" data-url="{{route('show.invProduct')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'setup' && Request::segment(3) == 'product') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-cart-shopping"></i>
                                            Inventory Products
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>

                    {{-- Pharmacy Users Menu Start  --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'users') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-users-gear"></i>
                                USERS
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'users') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'users') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(218))
                                <li class="sub-menu1-item" data-url="{{route('show.invUserType')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'users' && Request::segment(3) == 'usertype') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-tag"></i>
                                            Client/Supplier Type
                                        </p>
                                    </div>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission(222))
                                <li class="sub-menu1-item" data-url="{{route('show.invClients')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'users' && Request::segment(3) == 'clients') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-users"></i>
                                            Client
                                        </p>
                                    </div>
                                </li>
                            @endif
                            
                            @if(auth()->user()->hasPermission(226))
                                <li class="sub-menu1-item" data-url="{{route('show.invSuppliers')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'users' && Request::segment(3) == 'suppliers') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-people-carry-box"></i>
                                            Supplier
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>

                    {{-- Inventory Transaction Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'transaction') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                TRANSACTIONS
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'transaction') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'transaction') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(230))
                                <li class="sub-menu1-item" data-url="{{route('show.invPurchase')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'transaction' && Request::segment(3) == 'purchase') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-bag-shopping"></i>
                                            Inventory Purchase
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(235))
                                <li class="sub-menu1-item" data-url="{{route('show.invIssue')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'transaction' && Request::segment(3) == 'issue') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-cash-register"></i>
                                            Inventory Issue
                                        </p>
                                    </div>
                                </li>
                            @endif

                            <li class="sub-menu1-item">
                                <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'transaction' && Request::segment(3) == 'return') ? 'active':''}}">
                                    <p>
                                        <i class="fa-solid fa-hand-holding-dollar"></i>
                                        Inventory Return
                                    </p>
                                    <i class="fas fa-angle-right {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'transaction' && Request::segment(3) == 'return') ? 'rotate':''}}"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'transaction' && Request::segment(3) == 'return' ) ? 'show':''}}">
                                    @if(auth()->user()->hasPermission(239))
                                        <li class="sub-menu2-item" data-url="{{route('show.invClientReturn')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'transaction' && Request::segment(3) == 'return' && Request::segment(4) == 'client') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Client Return
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermission(243))
                                        <li class="sub-menu2-item" data-url="{{route('show.invSupplierReturn')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'transaction' && Request::segment(3) == 'return'  && Request::segment(4) == 'supplier') ? 'active':''}}">
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

                    {{-- Inventory Adjustment Sub menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'adjustment') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-hand-holding-dollar"></i>
                                ADJUSTMENT
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'adjustment') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'adjustment') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(247))
                                <li class="sub-menu1-item" data-url="{{route('show.invPosAdjustment')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'adjustment' && Request::segment(3) == 'positive') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-folder-plus"></i>
                                            Positive Adjustment
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermission(251))
                                <li class="sub-menu1-item" data-url="{{route('show.invNegAdjustment')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'adjustment' && Request::segment(3) == 'negative') ? 'active':''}}">
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
                        <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'party') ? 'active':''}}">
                            <p>
                                <i class="fa-regular fa-credit-card"></i>
                                PARTY PAYMENT
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'party') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'party') ? 'show':''}}">
                            @if(auth()->user()->hasPermission(255))
                                <li class="sub-menu1-item" data-url="{{route('show.invPartyReceive')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'party' && Request::segment(3) == 'receive') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-users"></i>
                                            Receive from Client
                                        </p>
                                    </div>
                                </li>
                            @endif
                                        
                            @if(auth()->user()->hasPermission(259))
                                <li class="sub-menu1-item" data-url="{{route('show.invPartyPayment')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'party' && Request::segment(3) == 'payment') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-people-carry-box"></i>
                                            Payment to Supplier
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>

                    {{-- Inventory Reports Sub menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                REPORTS
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report') ? 'show':''}}">
                            {{-- Item Flow statement start --}}
                            @if(auth()->user()->hasPermission(263))
                                <li class="sub-menu1-item" data-url="{{route('show.invItemFlow')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'item') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-hand-holding-dollar"></i>
                                            Item Flow Statement
                                        </p>
                                    </div>
                                </li>
                            @endif

                            {{-- Stock statement start --}}    
                            <li class="sub-menu1-item">
                                <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'stock') ? 'active':''}}">
                                    <p>
                                        <i class="fa-solid fa-cubes"></i>
                                        Stock Statement
                                    </p>
                                    <i class="fas fa-angle-right {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'stock') ? 'rotate':''}}"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'stock') ? 'show':''}}">
                                    @if(auth()->user()->hasPermission(265))
                                        <li class="sub-menu2-item" data-url="{{route('show.invStockDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'stock' && Request::segment(4) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-file-invoice"></i>
                                                    Stock Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermission(264))
                                        <li class="sub-menu2-item" data-url="{{route('show.invStockSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'stock' && Request::segment(4) == 'summary') ? 'active':''}}">
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
                            @if(auth()->user()->hasPermission(266))
                                <li class="sub-menu1-item" data-url="{{route('show.invProfit')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'profitability') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-hand-holding-dollar"></i>
                                            Profitability Statement
                                        </p>
                                    </div>
                                </li>
                            @endif

                            {{-- Expiry statement start --}}
                            @if(auth()->user()->hasPermission(267))
                                <li class="sub-menu1-item" data-url="{{route('show.invExpiry')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'expiry') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-tag"></i>
                                            Expiry Statement
                                        </p>
                                    </div>
                                </li>
                            @endif

                            {{-- Purchase statement start --}}    
                            <li class="sub-menu1-item">
                                <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'purchase') ? 'active':''}}">
                                    <p>
                                        <i class="fa-solid fa-cart-plus"></i>
                                        Purchase Statement
                                    </p>
                                    <i class="fas fa-angle-right {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'purchase') ? 'rotate':''}}"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'purchase') ? 'show':''}}">
                                    @if(auth()->user()->hasPermission(269))
                                        <li class="sub-menu2-item" data-url="{{route('show.invPurchaseDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'purchase' && Request::segment(4) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-file-invoice"></i>
                                                    Purchase Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermission(268))
                                        <li class="sub-menu2-item" data-url="{{route('show.invPurchaseSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'purchase' && Request::segment(4) == 'summary') ? 'active':''}}">
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
                                <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'issue') ? 'active':''}}">
                                    <p>
                                        <i class="fa-solid fa-list-check"></i>
                                        Issue Statement
                                    </p>
                                    <i class="fas fa-angle-right {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'issue') ? 'rotate':''}}"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'issue') ? 'show':''}}">
                                    @if(auth()->user()->hasPermission(271))
                                        <li class="sub-menu2-item" data-url="{{route('show.invIssueDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'issue' && Request::segment(4) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-file-invoice"></i>
                                                    Issue Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermission(270))
                                        <li class="sub-menu2-item" data-url="{{route('show.invIssueSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'issue' && Request::segment(4) == 'summary') ? 'active':''}}">
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
                                <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'return') ? 'active':''}}">
                                    <p>
                                        <i class="fa-solid fa-hand-holding-hand"></i>
                                        Return Statement
                                    </p>
                                    <i class="fas fa-angle-right {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'return') ? 'rotate':''}}"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'return') ? 'show':''}}">
                                    @if(auth()->user()->hasPermission(273))
                                        <li class="sub-menu2-item" data-url="{{route('show.invClientReturnDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'client' && Request::segment(5) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-file-invoice"></i>
                                                    Client Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermission(272))
                                        <li class="sub-menu2-item" data-url="{{route('show.invClientReturnSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'client' && Request::segment(5) == 'summary') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-file-invoice"></i>
                                                    Client Summary
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermission(275))
                                        <li class="sub-menu2-item" data-url="{{route('show.invSupplierReturnDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'supplier' && Request::segment(5) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-file-invoice"></i>
                                                    Supplier Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermission(274))
                                        <li class="sub-menu2-item" data-url="{{route('show.invSupplierReturnSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'supplier' && Request::segment(5) == 'summary') ? 'active':''}}">
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

        
        <!-- Hospital Menu Start -->
        @if(auth()->user()->hasPermissionMainHead('7'))
            <li class="menu-item">
                <div class="menu-title {{ Request::segment(1) == 'hospital' ? 'active':''}}">
                    <p>
                        <i class="fa-solid fa-hospital"></i>
                        Hospital
                    </p>
                    <i class="fas fa-angle-right {{ Request::segment(1) == 'hospital' ? 'rotate':''}}"></i>
                </div>
                <ul class="sub-menu {{ Request::segment(1) == 'hospital' ? 'show':''}}">
                    {{-- Hospital Setup Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'setup') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-gears"></i>
                                SETUP
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'setup') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'setup') ? 'show':''}}">              
                            @if(auth()->user()->hasPermission(346))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'setup' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission(350))
                                <li class="sub-menu1-item" data-url="{{route('show.hospitalFloors')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'setup' && Request::segment(3) == 'floor') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Floors
                                        </p>
                                    </div>
                                </li>
                            @endif
                            
                            @if(auth()->user()->hasPermission(354))
                                <li class="sub-menu1-item" data-url="{{route('show.nursingStation')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'setup' && Request::segment(3) == 'nursingstation') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Nursing Station
                                        </p>
                                    </div>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission(358))
                                <li class="sub-menu1-item" data-url="{{route('show.bedcategory')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'setup' && Request::segment(3) == 'bedcategory') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Bed Category
                                        </p>
                                    </div>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission(362))
                                <li class="sub-menu1-item" data-url="{{route('show.bedlist')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'setup' && Request::segment(3) == 'bedlist') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Bed List
                                        </p>
                                    </div>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission(366))
                                <li class="sub-menu1-item" data-url="{{route('show.hospitalGroupe')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'setup' && Request::segment(3) == 'groupe') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Hospital Groupe
                                        </p>
                                    </div>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission(370))
                                <li class="sub-menu1-item" data-url="{{route('show.hospitalServices')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'setup' && Request::segment(3) == 'services') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Hospital Services
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>

                    {{-- Hospital Setup Sub Menu --}}
                    @if(auth()->user()->hasPermission(374))
                        <li class="sub-menu-item" data-url="{{route('show.patientAppointment')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'ptnappointment') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-gears"></i>
                                    APPOINMENT
                                </p>
                            </div>
                        </li>
                    @endif
                    
                    {{-- Hospital Setup Sub Menu --}}
                    @if(auth()->user()->hasPermission(378))
                        <li class="sub-menu-item" data-url="{{route('show.patientRegistration')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'ptnregistration') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-gears"></i>
                                    PATIENTS  REGISTRATION
                                </p>
                            </div>
                        </li>
                    @endif


                    {{-- Bed Transfer User Sub Menu --}}
                    @if(auth()->user()->hasPermission(382))
                        <li class="sub-menu-item"data-url="{{route('show.bedTransfer')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'bedtransfer') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-users-gear"></i>
                                    Bed Transfer 
                                </p>
                            </div>
                        </li>
                    @endif
    

                    {{-- Bed Status Sub Menu --}}
                    @if(auth()->user()->hasPermission(386))
                        <li class="sub-menu-item"data-url="{{route('show.bedStatus')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'bedstatus') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-users-gear"></i>
                                    Bed Status
                                </p>
                            </div>
                        </li>
                    @endif

                    {{-- Hospital User Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'users') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-users-gear"></i>
                                USERS
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'users') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'users') ? 'show':''}}">              
                            @if(auth()->user()->hasPermission(390))
                                <li class="sub-menu1-item" data-url="{{route('show.doctors')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'users' && Request::segment(3) == 'doctors') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Doctors
                                        </p>
                                    </div>
                                </li>
                            @endif
                            
                            @if(auth()->user()->hasPermission(394))
                                <li class="sub-menu1-item" data-url="{{route('show.patients')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'users' && Request::segment(3) == 'patients') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Patients
                                        </p>
                                    </div>
                                </li>
                            @endif
                            
                            
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.sr')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'users' && Request::segment(3) == 'sr') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            SR
                                        </p>
                                    </div>
                                </li>
                            @endif
                            
                            @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.marketinghead')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'users' && Request::segment(3) == 'marketinghead') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Marketing Head
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </li>
                    
                    {{-- Hospital Transaction Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'transaction') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                TRANSACTION
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'transaction') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'transaction') ? 'show':''}}">              
                            @if(auth()->user()->hasPermission(398))
                                <li class="sub-menu1-item" data-url="{{route('show.admission')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'transaction' && Request::segment(3) == 'admission') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Admission Fee
                                        </p>
                                    </div>
                                </li>
                            @endif
                            
                            @if(auth()->user()->hasPermission(402))
                                <li class="sub-menu1-item" data-url="{{route('show.deposit')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'transaction' && Request::segment(3) == 'deposit') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Deposit
                                        </p>
                                    </div>
                                </li>
                            @endif
                            
                            @if(auth()->user()->hasPermission(406))
                                <li class="sub-menu1-item" data-url="{{route('show.depositrefund')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'transaction' && Request::segment(3) == 'depositrefund') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Deposit Refunds
                                        </p>
                                    </div>
                                </li>
                            @endif
                            
                            @if(auth()->user()->hasPermission(410))
                                <li class="sub-menu1-item" data-url="{{route('show.services')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'transaction' && Request::segment(3) == 'services') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Services
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>
                    
                    {{-- Hospital Party Payment Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'party') ? 'active':''}}">
                            <p>
                                <i class="fa-regular fa-credit-card"></i>
                                PARTY PAYMENT
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'party') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'party') ? 'show':''}}">              
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'party' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </li>
                    
                    {{-- Hospital Reports Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'report') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                REPORTS
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'report') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'report') ? 'show':''}}">              
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hospital' && Request::segment(2) == 'report' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </li>
                </ul>
            </li> 
            <hr>
        @endif
        
        
        <!-- Hotel Menu Start -->
        @if(auth()->user()->hasPermissionMainHead('8'))
            <li class="menu-item">
                <div class="menu-title {{ Request::segment(1) == 'hotel' ? 'active':''}}">
                    <p>
                        <i class="fa-solid fa-hotel"></i>
                        HOTEL
                    </p>
                    <i class="fas fa-angle-right {{ Request::segment(1) == 'hotel' ? 'rotate':''}}"></i>
                </div>
                <ul class="sub-menu {{ Request::segment(1) == 'hotel' ? 'show':''}}">
                    {{-- Hotel Setup Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'setup') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-gears"></i>
                                SETUP
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'setup') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'setup') ? 'show':''}}">    
                            
                            {{-- Hotel,Setup Sub Menu  Floor --}}
                            @if(auth()->user()->hasPermission(295))
                                <li class="sub-menu1-item" data-url="{{route('show.floor')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'setup' && Request::segment(3) == 'floor') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Floor
                                        </p>
                                    </div>
                                </li>
                            @endif


                            {{-- Hotel,Setup Sub Menu  Floor Room Catagory --}}
                            @if(auth()->user()->hasPermission(299))
                                <li class="sub-menu1-item" data-url="{{route('show.roomcatagory')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'setup' && Request::segment(3) == 'roomcatagory') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Room Catagory
                                        </p>
                                    </div>
                                </li>
                            @endif


                            {{-- Hotel,Setup Sub Menu  Room List --}}
                            @if(auth()->user()->hasPermission(303))
                                <li class="sub-menu1-item" data-url="{{route('show.roomlist')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'setup' && Request::segment(3) == 'roomlist') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Room List
                                        </p>
                                    </div>
                                </li>
                            @endif 



                            {{-- Hotel,Setup Sub Menu  Group --}}
                            @if(auth()->user()->hasPermission(307))
                                <li class="sub-menu1-item" data-url="{{route('show.groupe')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'setup' && Request::segment(3) == 'groupe') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Groupe
                                        </p>
                                    </div>
                                </li>
                            @endif 


                            {{-- Hotel,Setup Sub Menu Service --}}
                            @if(auth()->user()->hasPermission(311))
                                <li class="sub-menu1-item"  data-url="{{route('show.service')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'setup' && Request::segment(3) == 'service') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                           Service
                                        </p>
                                    </div>
                                </li>
                            @endif 
                            
                        </ul>
                    </li>

                    {{-- Hotel User Sub Menu --}}
                    @if(auth()->user()->hasPermission(315))
                        <li class="sub-menu-item"data-url="{{route('show.booking')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'booking') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-users-gear"></i>
                                    Hotel Booking
                                </p>
                            </div>
                        </li>
                    @endif 

                    {{-- Room Transfer User Sub Menu --}}
                    @if(auth()->user()->hasPermission(319))
                        <li class="sub-menu-item"data-url="{{route('show.roomTransfer')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'roomtransfer') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-users-gear"></i>
                                    Room Transfer 
                                </p>
                            </div>
                        </li>
                    @endif 
    

                    {{-- Hotel Room Status Sub Menu --}}
                    @if(auth()->user()->hasPermission(323))
                        <li class="sub-menu-item"data-url="{{route('show.roomStatus')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'roomstatus') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-users-gear"></i>
                                    Room Status
                                </p>
                            </div>
                        </li>
                    @endif 

                    {{-- Hotel Users Sub Menu --}}
                   
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'users') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-gears"></i>
                                Users
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'users') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'users') ? 'show':''}}">    
                            {{-- Hotel Users Sub Menu Guest List--}}
                            @if(auth()->user()->hasPermission(327))
                                <li class="sub-menu1-item" data-url="{{route('show.hotelGuests')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'users' && Request::segment(3) == 'guests') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Guest List
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>
                    
                    {{-- Hotel Transaction Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'transaction') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                TRANSACTION
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'transaction') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'transaction') ? 'show':''}}">   
                            
                            
                            
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'transaction' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif --}}



                                 
                                
                            @if(auth()->user()->hasPermission(331))
                                <li class="sub-menu1-item" data-url="{{route('show.hotelServices')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'transaction' && Request::segment(3) == 'services') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Services
                                        </p>
                                    </div>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission(335))
                                <li class="sub-menu1-item" data-url="{{route('show.hotelDeposits')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'transaction' && Request::segment(3) == 'deposits') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Deposits
                                        </p>
                                    </div>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermission(339))
                                <li class="sub-menu1-item" data-url="{{route('show.hotelRefunds')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'transaction' && Request::segment(3) == 'refunds') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Refunds
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>
                    
                    {{-- Hotel Party Payment Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'party') ? 'active':''}}">
                            <p>
                                <i class="fa-regular fa-credit-card"></i>
                                PARTY PAYMENT
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'party') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'party') ? 'show':''}}">              
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'party' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </li>

                    {{-- Hotel Bill Settlement Sub Menu --}}
                    @if(auth()->user()->hasPermission(343))
                        <li class="sub-menu-item"data-url="{{route('show.billSettlement')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'billsettlement') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-users-gear"></i>
                                    Bill Settlement
                                </p>
                            </div>
                        </li>
                    @endif
                    
                    {{-- Hotel Reports Sub Menu --}}
                    
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'report') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                REPORTS
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'report') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'report') ? 'show':''}}">              
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hotel' && Request::segment(2) == 'report' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </li>
                </ul>
            </li> 
            <hr>
        @endif
        
        
        
        <!-- Restaurant Menu Start -->
        @if(auth()->user()->hasPermissionMainHead('9'))
            <li class="menu-item">
                <div class="menu-title {{ Request::segment(1) == 'resturant' ? 'active':''}}">
                    <p>
                        <i class="fa-solid fa-shop"></i>
                        RESTAURANT
                    </p>
                    <i class="fas fa-angle-right {{ Request::segment(1) == 'resturant' ? 'rotate':''}}"></i>
                </div>
                <ul class="sub-menu {{ Request::segment(1) == 'resturant' ? 'show':''}}">
                    {{-- Restaurant Setup Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'setup') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-gears"></i>
                                SETUP
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'setup') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'setup') ? 'show':''}}">              
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'setup' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.bedcatagory')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'setup' && Request::segment(3) == 'bedcatagory') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Bed Catagory
                                        </p>
                                    </div>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.bedlist')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'setup' && Request::segment(3) == 'bedlist') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Bed List
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </li>

                    {{-- Restaurant User Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'users') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-users-gear"></i>
                                USERS
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'users') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'users') ? 'show':''}}">              
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'users' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </li>
                    
                    {{-- Restaurant Transaction Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'transaction') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                TRANSACTION
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'transaction') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'transaction') ? 'show':''}}">              
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'transaction' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </li>
                    
                    {{-- Restaurant Party Payment Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'party') ? 'active':''}}">
                            <p>
                                <i class="fa-regular fa-credit-card"></i>
                                PARTY PAYMENT
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'party') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'party') ? 'show':''}}">              
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'party' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </li>
                    
                    {{-- Restaurant Reports Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'report') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                REPORTS
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'report') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'report') ? 'show':''}}">              
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'resturant' && Request::segment(2) == 'report' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </li>
                </ul>
            </li> 
            <hr>
        @endif
        
        
        <!-- Diagnosis Menu Start -->
        @if(auth()->user()->hasPermissionMainHead('10'))
            <li class="menu-item">
                <div class="menu-title {{ Request::segment(1) == 'diagnosis' ? 'active':''}}">
                    <p>
                        <i class="fa-solid fa-stethoscope"></i>
                        DIAGNOSIS
                    </p>
                    <i class="fas fa-angle-right {{ Request::segment(1) == 'diagnosis' ? 'rotate':''}}"></i>
                </div>
                <ul class="sub-menu {{ Request::segment(1) == 'diagnosis' ? 'show':''}}">
                    {{-- Diagnosis Setup Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'setup') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-gears"></i>
                                SETUP
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'setup') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'setup') ? 'show':''}}">              
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'setup' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.bedcatagory')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'setup' && Request::segment(3) == 'bedcatagory') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Bed Catagory
                                        </p>
                                    </div>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.bedlist')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'setup' && Request::segment(3) == 'bedlist') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Bed List
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </li>

                    {{-- Diagnosis User Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'users') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-users-gear"></i>
                                USERS
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'users') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'users') ? 'show':''}}">              
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'users' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </li>
                    
                    {{-- Diagnosis Transaction Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'transaction') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                TRANSACTION
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'transaction') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'transaction') ? 'show':''}}">              
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'transaction' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </li>
                    
                    {{-- Diagnosis Party Payment Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'party') ? 'active':''}}">
                            <p>
                                <i class="fa-regular fa-credit-card"></i>
                                PARTY PAYMENT
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'party') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'party') ? 'show':''}}">              
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'party' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </li>
                    
                    {{-- Diagnosis Reports Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'report') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                REPORTS
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'report') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'report') ? 'show':''}}">              
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'diagnosis' && Request::segment(2) == 'report' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </li>
                </ul>
            </li> 
            <hr>
        @endif
        
        
        <!-- School Menu Start -->
        @if(auth()->user()->hasPermissionMainHead('11'))
            <li class="menu-item">
                <div class="menu-title {{ Request::segment(1) == 'school' ? 'active':''}}">
                    <p>
                        <i class="fa-solid fa-school"></i>
                        SCHOOL
                    </p>
                    <i class="fas fa-angle-right {{ Request::segment(1) == 'school' ? 'rotate':''}}"></i>
                </div>
                <ul class="sub-menu {{ Request::segment(1) == 'school' ? 'show':''}}">
                    {{-- School Setup Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'school' && Request::segment(2) == 'setup') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-gears"></i>
                                SETUP
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'school' && Request::segment(2) == 'setup') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'school' && Request::segment(2) == 'setup') ? 'show':''}}">              
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'school' && Request::segment(2) == 'setup' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.bedcatagory')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'school' && Request::segment(2) == 'setup' && Request::segment(3) == 'bedcatagory') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Bed Catagory
                                        </p>
                                    </div>
                                </li>
                            @endif
                            @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.bedlist')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'school' && Request::segment(2) == 'setup' && Request::segment(3) == 'bedlist') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Bed List
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </li>

                    {{-- School User Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'school' && Request::segment(2) == 'users') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-users-gear"></i>
                                USERS
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'school' && Request::segment(2) == 'users') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'school' && Request::segment(2) == 'users') ? 'show':''}}">              
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'school' && Request::segment(2) == 'users' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </li>
                    
                    {{-- School Transaction Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'school' && Request::segment(2) == 'transaction') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                TRANSACTION
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'school' && Request::segment(2) == 'transaction') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'school' && Request::segment(2) == 'transaction') ? 'show':''}}">              
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'school' && Request::segment(2) == 'transaction' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </li>
                    
                    {{-- School Party Payment Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'school' && Request::segment(2) == 'party') ? 'active':''}}">
                            <p>
                                <i class="fa-regular fa-credit-card"></i>
                                PARTY PAYMENT
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'school' && Request::segment(2) == 'party') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'school' && Request::segment(2) == 'party') ? 'show':''}}">              
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'school' && Request::segment(2) == 'party' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
                        </ul>
                    </li>
                    
                    {{-- School Reports Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'school' && Request::segment(2) == 'report') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                REPORTS
                            </p>
                            <i class="fas fa-angle-right {{ (Request::segment(1) == 'school' && Request::segment(2) == 'report') ? 'rotate':''}}"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'school' && Request::segment(2) == 'report') ? 'show':''}}">              
                            {{-- @if(auth()->user()->hasPermission(194))
                                <li class="sub-menu1-item" data-url="{{route('show.specialization')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'school' && Request::segment(2) == 'report' && Request::segment(3) == 'specialization') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Specialization
                                        </p>
                                    </div>
                                </li>
                            @endif --}}
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
                            {{-- @if(auth()->user()->hasPermission(280)) --}}
                                <li class="sub-menu1-item" data-url="{{ route('show.collectionDetails') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'collection' && Request::segment(3) == 'details') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Details
                                        </p>
                                    </div>
                                </li>
                            {{-- @endif --}}
                                
                            {{-- @if(auth()->user()->hasPermission(279)) --}}
                                <li class="sub-menu1-item" data-url="{{ route('show.collectionSummary') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'collection' && Request::segment(3) == 'summary') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Summary
                                        </p>
                                    </div>
                                </li>
                            {{-- @endif --}}
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
                            {{-- @if(auth()->user()->hasPermission(280)) --}}
                                <li class="sub-menu1-item" data-url="{{ route('show.paymentDetails') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'payment' && Request::segment(3) == 'details') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Details
                                        </p>
                                    </div>
                                </li>
                            {{-- @endif --}}
                                
                            {{-- @if(auth()->user()->hasPermission(279)) --}}
                                <li class="sub-menu1-item" data-url="{{ route('show.paymentSummary') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'payment' && Request::segment(3) == 'summary') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Summary
                                        </p>
                                    </div>
                                </li>
                            {{-- @endif --}}
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
                            {{-- @if(auth()->user()->hasPermission(280)) --}}
                                <li class="sub-menu1-item" data-url="{{ route('show.consolidatedDetails') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'consolidated' && Request::segment(3) == 'details') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Details
                                        </p>
                                    </div>
                                </li>
                            {{-- @endif --}}
                                
                            {{-- @if(auth()->user()->hasPermission(279)) --}}
                                <li class="sub-menu1-item" data-url="{{ route('show.consolidatedSummary') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'consolidated' && Request::segment(3) == 'summary') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-file-invoice"></i>
                                            Summary
                                        </p>
                                    </div>
                                </li>
                            {{-- @endif --}}
                        </ul>
                    </li>
                </ul>
                </ul>
            </li>
        @endif
    </ul>
</aside>