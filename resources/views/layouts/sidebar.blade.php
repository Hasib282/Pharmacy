<aside id="mySidenav" class="sidenav">
    {{-- <a href="{{ route('show.profile', auth()->user()->id) }}"> --}}
        <div class="user-details">
            <div class="user-image">
                <img src="{{ rtrim(env('API_URL'), '/api') }}/storage/{{ auth()->user()->image != null ? auth()->user()->image : (auth()->user()->gender == 'female' ? 'female.png' : 'male.png') }}" alt="">
            </div>
            <div class="user-name">
                <strong>{{ auth()->user()->user_name }}</strong>
            </div>
        </div>
        {{-- {{ auth()->user()}} --}}
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
                    <i class="fas fa-angle-right"></i>
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
                                <i class="fas fa-angle-right"></i>
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
                            <i class="fas fa-angle-right"></i>
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
                                
                            @if(auth()->user()->hasPermissionToRoute('show.admins'))
                                <li class="sub-menu1-item" data-url="{{route('show.admins')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users' && Request::segment(3) == 'admins') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-tie"></i>
                                            Admin 
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.clients'))
                                <li class="sub-menu1-item" data-url="{{route('show.clients')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users' && Request::segment(3) == 'clients') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-users"></i>
                                            Client
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.suppliers'))
                                <li class="sub-menu1-item" data-url="{{route('show.suppliers')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users' && Request::segment(3) == 'suppliers') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-people-carry-box"></i>
                                            Supplier
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
                            <i class="fas fa-angle-right"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'permission') ? 'show':''}}">
                            @if(auth()->user()->hasPermissionToRoute('show.permissionMainheads'))
                                <li class="sub-menu1-item" data-url="{{route('show.permissionMainheads')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'permission' && Request::segment(3) == 'mainhead') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-secret"></i>
                                            Permission Main Head
                                        </p>
                                    </div>
                                </li>
                            @endif
                    
                            @if(auth()->user()->hasPermissionToRoute('show.permissions'))
                                <li class="sub-menu1-item" data-url="{{route('show.permissions')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'permission' && Request::segment(3) == '') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-secret"></i>
                                            Permission Heads
                                        </p>
                                    </div>
                                </li>
                            @endif
                    
                            @if(auth()->user()->hasPermissionToRoute('show.routePermissions'))
                                <li class="sub-menu1-item" data-url="{{route('show.routePermissions')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'permission' && Request::segment(3) == 'routepermissions') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-secret"></i>
                                            Route Permissions
                                        </p>
                                    </div>
                                </li>
                            @endif

                            @if(auth()->user()->hasPermissionToRoute('show.rolePermissions'))
                                <li class="sub-menu1-item" data-url="{{route('show.rolePermissions')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'permission' && Request::segment(3) == 'rolepermissions') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-secret"></i>
                                            Role Permissions
                                        </p>
                                    </div>
                                </li>
                            @endif
                    
                            @if(auth()->user()->hasPermissionToRoute('show.userPermissions'))
                                <li class="sub-menu1-item" data-url="{{route('show.userPermissions')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'permission' && Request::segment(3) == 'userpermissions') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-secret"></i>
                                            User Permissions
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>
                                
                    @if(auth()->user()->hasPermissionToRoute('show.banks'))
                        <li class="sub-menu-item" data-url="{{route('show.banks')}}">
                            <div class="menu-title  {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'banks') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-people-roof"></i>
                                    Bank
                                </p>
                            </div>
                        </li>
                    @endif
                                
                    @if(auth()->user()->hasPermissionToRoute('show.locations'))
                        <li class="sub-menu-item" data-url="{{route('show.locations')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'locations') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-location-dot"></i>
                                    Locations
                                </p>
                            </div>
                        </li>
                    @endif
                            
                    @if(auth()->user()->hasPermissionToRoute('show.stores'))
                        <li class="sub-menu-item" data-url="{{route('show.stores')}}">
                            <div class="menu-title  {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'store') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-shop"></i>
                                    Store Details
                                </p>
                            </div>
                        </li>
                    @endif
                            
                    @if(auth()->user()->hasPermissionToRoute('show.mainhead'))
                        <li class="sub-menu-item" data-url="{{route('show.mainhead')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'mainheads') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-money-check-dollar"></i>
                                    Main Head 
                                </p>
                            </div>
                        </li>
                    @endif
                            
                    @if(auth()->user()->hasPermissionToRoute('show.tranwith'))
                        <li class="sub-menu-item" data-url="{{route('show.tranwith')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'tranwith') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-users-gear"></i>
                                    User Types
                                </p>
                            </div>
                        </li>
                    @endif
                            
                    @if(auth()->user()->hasPermissionToRoute('show.tranGroupes'))
                        <li class="sub-menu-item" data-url="{{route('show.tranGroupes')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'trangroupes') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-dice-six"></i>
                                    Transaction Group
                                </p>
                            </div>
                        </li>
                    @endif
                            
                    @if(auth()->user()->hasPermissionToRoute('show.tranHeads'))
                        <li class="sub-menu-item" data-url="{{route('show.tranHeads')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'tranheads') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-dice-one"></i>
                                    Transaction Head
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
                <div class="menu-title {{ Request::segment(1) == 'transaction' ? 'active':''}}">
                    <p>
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        GENERAL TRANSACTION
                    </p>
                    <i class="fas fa-angle-right"></i>
                </div>
                <ul class="sub-menu {{ Request::segment(1) == 'transaction' ? 'show':''}}">
                    @if(auth()->user()->hasPermissionToRoute('show.transactionReceive'))
                        <li class="sub-menu-item" data-url="{{route('show.transactionReceive')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'receive') ? 'active':''}}">
                                <p>
                                    <i class="far fa-circle nav-icon"></i>
                                    Transaction Receive
                                </p>
                            </div>
                        </li>
                    @endif
                            
                    @if(auth()->user()->hasPermissionToRoute('show.transactionPayment'))
                        <li class="sub-menu-item" data-url="{{route('show.transactionPayment')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'payment') ? 'active':''}}">
                                <p>
                                    <i class="far fa-circle nav-icon"></i>
                                    Transaction Payment
                                </p>
                            </div>
                        </li>
                    @endif
                </ul>
            </li>

            <hr>
        @endif
        
        <!-- Transaction With Bank -->
        @if(auth()->user()->hasPermissionMainHead('3'))
            <li class="menu-item">
                <div class="menu-title {{ Request::segment(1) == 'bank' ? 'active':''}}">
                    <p>
                        <i class="fa-solid fa-building-columns"></i>
                        BANK TRANSACTION
                    </p>
                    <i class="fas fa-angle-right"></i>
                </div>
                <ul class="sub-menu {{ Request::segment(1) == 'bank' ? 'show':''}}">
                    @if(auth()->user()->hasPermissionToRoute('show.withdraws'))
                        <li class="sub-menu-item" data-url="{{route('show.withdraws')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'bank' && Request::segment(2) == 'withdraw') ? 'active':''}}">
                                <p>
                                    <i class="far fa-circle nav-icon"></i>
                                    Withdraw from Bank
                                </p>
                            </div>
                        </li>
                    @endif
                    
                    @if(auth()->user()->hasPermissionToRoute('show.deposits'))
                        <li class="sub-menu-item" data-url="{{route('show.deposits')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'bank' && Request::segment(2) == 'deposit') ? 'active':''}}">
                                <p>
                                    <i class="far fa-circle nav-icon"></i>
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
                    <i class="fas fa-angle-right"></i>
                </div>
                <ul class="sub-menu {{ Request::segment(1) == 'hr' ? 'show':''}}">
                    <!-- EMPLOYEE -->
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-users"></i>
                                Employee
                            </p>
                            <i class="fas fa-angle-right"></i>
                        </div>
                        <ul class=" sub-menu1 {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee') ? 'show':''}}">
                            @if(auth()->user()->hasPermissionToRoute('show.employees'))
                                <li class="sub-menu1-item" data-url="{{route('show.employees')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'all') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            All Employee
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.employeePersonal'))
                                <li class="sub-menu1-item" data-url="{{ route('show.employeePersonal') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'personal') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Add Personal Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.employeeEducation'))
                                <li class="sub-menu1-item" data-url="{{ route('show.employeeEducation') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'education') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Add Education Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.employeeTraining'))
                                <li class="sub-menu1-item" data-url="{{ route('show.employeeTraining') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'training') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Add Training Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.employeeExperience'))
                                <li class="sub-menu1-item" data-url="{{ route('show.employeeExperience') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'experience') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Add Experience Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.employeeOrganization'))
                                <li class="sub-menu1-item" data-url="{{ route('show.employeeOrganization') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'organization') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Add Organization Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.employeeAttendence'))
                                <li class="sub-menu1-item" data-url="{{ route('show.employeeAttendence') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'attendence') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Attendence List
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
                                <i class="fa-solid fa-envelope"></i>
                                Payroll
                            </p>
                            <i class="fas fa-angle-right"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'payroll') ? 'show':''}}">
                            @if(auth()->user()->hasPermissionToRoute('show.payrollSetup'))
                                <li class="sub-menu1-item" data-url="{{route('show.payrollSetup')}}">
                                    <div class="menu-title  {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'payroll' && Request::segment(3) == 'setup') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Payroll Setup
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.payrollMiddlewire'))
                                <li class="sub-menu1-item" data-url="{{route('show.payrollMiddlewire')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'payroll' && Request::segment(3) == 'middlewire') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Payroll Middlewire
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.payroll'))
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
                    
                    @if(auth()->user()->hasPermissionToRoute('show.departments'))
                        <li class="sub-menu-item" data-url="{{route('show.departments')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'departments') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-building"></i>
                                    Department
                                </p>
                            </div>
                        </li>
                    @endif
                                
                    @if(auth()->user()->hasPermissionToRoute('show.designations'))
                        <li class="sub-menu-item" data-url="{{route('show.designations')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'designations') ? 'active':''}}">
                                <p>
                                    <i class="fas fa-id-badge"></i>
                                    Designation
                                </p>
                            </div>
                        </li>
                    @endif
                    
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'report') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                Report
                            </p>
                            <i class="fas fa-angle-right"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'report') ? 'show':''}}">
                            @if(auth()->user()->hasPermissionToRoute('show.salarySummaryReport'))
                                <li class="sub-menu1-item" data-url="{{route('show.salarySummaryReport')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'report' && Request::segment(4) == 'summary') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Summary
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.salaryDetailsReport'))
                                <li class="sub-menu1-item" data-url="{{route('show.salaryDetailsReport')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'report' && Request::segment(4) == 'details') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
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
                    <i class="fas fa-angle-right"></i>
                </div>
                <ul class="sub-menu {{ Request::segment(1) == 'pharmacy' ? 'show':''}}">
                    {{-- Pharmacy Setup Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'setup') ? 'active':''}}">
                            <p>
                                <i class="fas fa-prescription-bottle"></i>
                                Pharmacy Setup
                            </p>
                            <i class="fas fa-angle-right"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'setup') ? 'show':''}}">
                            @if(auth()->user()->hasPermissionToRoute('show.pharmacyManufacturer'))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyManufacturer')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'setup' && Request::segment(3) == 'manufacturer') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Item Manufacturer
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.pharmacyCategory'))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyCategory')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'setup' && Request::segment(3) == 'category') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-table-cells-large"></i>
                                            Item Category
                                        </p>
                                    </div>
                                </li>
                            @endif
                            
                            @if(auth()->user()->hasPermissionToRoute('show.pharmacyUnit'))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyUnit')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'setup' && Request::segment(3) == 'unit') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-scale-unbalanced"></i>
                                            Item Unit
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.pharmacyForm'))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyForm')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'setup' && Request::segment(3) == 'form') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-list-ul"></i>
                                            Item Form
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.pharmacyProduct'))
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

                    {{-- Pharmacy Transaction Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'transaction') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                Pharmacy Transactions
                            </p>
                            <i class="fas fa-angle-right"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'transaction') ? 'show':''}}">
                            @if(auth()->user()->hasPermissionToRoute('show.pharmacyPurchase'))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyPurchase')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'transaction' && Request::segment(3) == 'purchase') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Pharmacy Purchase
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.pharmacyIssue'))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyIssue')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'transaction' && Request::segment(3) == 'issue') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Pharmacy Issue
                                        </p>
                                    </div>
                                </li>
                            @endif
                            
                            <li class="sub-menu1-item">
                                <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'transaction' && Request::segment(3) == 'return') ? 'active':''}}">
                                    <p>
                                        <i class="far fa-circle nav-icon"></i>
                                        Pharmacy Return
                                    </p>
                                    <i class="fas fa-angle-right"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'transaction' && Request::segment(3) == 'return' ) ? 'show':''}}">
                                    @if(auth()->user()->hasPermissionToRoute('show.pharmacyClientReturn'))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacyClientReturn')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'transaction' && Request::segment(3) == 'return' && Request::segment(4) == 'client') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Client Return
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.pharmacySupplierReturn'))
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
                                Adjustment
                            </p>
                            <i class="fas fa-angle-right"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'adjustment') ? 'show':''}}">
                            @if(auth()->user()->hasPermissionToRoute('show.pharmacyPosAdjustment'))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyPosAdjustment')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'adjustment' && Request::segment(3) == 'positive') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Positive Adjustment
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.pharmacyNegAdjustment'))
                                <li class="sub-menu1-item" data-url="{{route('show.pharmacyNegAdjustment')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'adjustment' && Request::segment(3) == 'negative') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Negative Adjustment
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
                            <i class="fa-solid fa-sheet-plastic"></i>
                                Pharmacy Reports
                            </p>
                            <i class="fas fa-angle-right"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report') ? 'show':''}}">
                            {{-- Item Flow statement start --}}
                            @if(auth()->user()->hasPermissionToRoute('show.pharmacyItemFlow'))
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
                                    <i class="fas fa-angle-right"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'stock') ? 'show':''}}">
                                    @if(auth()->user()->hasPermissionToRoute('show.pharmacyStockDetails'))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacyStockDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'stock' && Request::segment(4) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Stock Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.pharmacyStockSummary'))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacyStockSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'stock' && Request::segment(4) == 'summary') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Stock Summary
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </li>

                            
                            
                            {{-- Profitability statement start --}}    
                            @if(auth()->user()->hasPermissionToRoute('show.pharmacyProfit'))
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
                            @if(auth()->user()->hasPermissionToRoute('show.pharmacyExpiry'))
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
                                    <i class="fas fa-angle-right"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'purchase') ? 'show':''}}">
                                    @if(auth()->user()->hasPermissionToRoute('show.pharmacyPurchaseDetails'))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacyPurchaseDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'purchase' && Request::segment(4) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Purchase Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.pharmacyPurchaseSummary'))
                                        <li  class="sub-menu2-item"data-url="{{route('show.pharmacyPurchaseSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'purchase' && Request::segment(4) == 'summary') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
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
                                    <i class="fas fa-angle-right"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'issue') ? 'show':''}}">
                                    @if(auth()->user()->hasPermissionToRoute('show.pharmacyIssueDetails'))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacyIssueDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'issue' && Request::segment(4) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Issue Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.pharmacyIssueSummary'))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacyIssueSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'issue' && Request::segment(4) == 'summary') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
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
                                    <i class="fas fa-angle-right"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'return') ? 'show':''}}">
                                    @if(auth()->user()->hasPermissionToRoute('show.pharmacyClientReturnDetails'))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacyClientReturnDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'client' && Request::segment(5) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Client Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.pharmacyClientReturnSummary'))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacyClientReturnSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'client' && Request::segment(5) == 'summary') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Client Summary
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.pharmacySupplierReturnDetails'))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacySupplierReturnDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'supplier' && Request::segment(5) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Supplier Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.pharmacySupplierReturnSummary'))
                                        <li class="sub-menu2-item" data-url="{{route('show.pharmacySupplierReturnSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'supplier' && Request::segment(5) == 'summary') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
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
                    <i class="fas fa-angle-right"></i>
                </div>
                <ul class="sub-menu {{ Request::segment(1) == 'inventory' ? 'show':''}}">
                    {{-- Inventory Setup Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'setup') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-cart-flatbed"></i>
                                Inventory Setup
                            </p>
                            <i class="fas fa-angle-right"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'setup') ? 'show':''}}">
                            @if(auth()->user()->hasPermissionToRoute('show.invManufacturer'))
                                <li class="sub-menu1-item" data-url="{{route('show.invManufacturer')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'setup' && Request::segment(3) == 'manufacturer') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Item Manufacturer
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.invCategory'))
                                <li class="sub-menu1-item" data-url="{{route('show.invCategory')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'setup' && Request::segment(3) == 'category') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-table-cells-large"></i>
                                            Item Category
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.invUnit'))
                                <li class="sub-menu1-item" data-url="{{route('show.invUnit')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'setup' && Request::segment(3) == 'unit') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-scale-unbalanced"></i>
                                            Item Unit
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.invForm'))
                                <li class="sub-menu1-item" data-url="{{route('show.invForm')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'setup' && Request::segment(3) == 'form') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-list-ul"></i>
                                            Item Form
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.invProduct'))
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

                    {{-- Inventory Transaction Sub Menu --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'transaction') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                Inventory Transactions
                            </p>
                            <i class="fas fa-angle-right"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'transaction') ? 'show':''}}">
                            @if(auth()->user()->hasPermissionToRoute('show.invPurchase'))
                                <li class="sub-menu1-item" data-url="{{route('show.invPurchase')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'transaction' && Request::segment(3) == 'purchase') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Inventory Purchase
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.invIssue'))
                                <li class="sub-menu1-item" data-url="{{route('show.invIssue')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'transaction' && Request::segment(3) == 'issue') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Inventory Issue
                                        </p>
                                    </div>
                                </li>
                            @endif

                            <li class="sub-menu1-item">
                                <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'transaction' && Request::segment(3) == 'return') ? 'active':''}}">
                                    <p>
                                        <i class="far fa-circle nav-icon"></i>
                                        Inventory Return
                                    </p>
                                    <i class="fas fa-angle-right"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'transaction' && Request::segment(3) == 'return' ) ? 'show':''}}">
                                    @if(auth()->user()->hasPermissionToRoute('show.invClientReturn'))
                                        <li class="sub-menu2-item" data-url="{{route('show.invClientReturn')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'transaction' && Request::segment(3) == 'return' && Request::segment(4) == 'client') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Client Return
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.invSupplierReturn'))
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
                                Adjustment
                            </p>
                            <i class="fas fa-angle-right"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'adjustment') ? 'show':''}}">
                            @if(auth()->user()->hasPermissionToRoute('show.invPosAdjustment'))
                                <li class="sub-menu1-item" data-url="{{route('show.invPosAdjustment')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'adjustment' && Request::segment(3) == 'positive') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Positive Adjustment
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.invNegAdjustment'))
                                <li class="sub-menu1-item" data-url="{{route('show.invNegAdjustment')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'adjustment' && Request::segment(3) == 'negative') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Negative Adjustment
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
                            <i class="fa-solid fa-sheet-plastic"></i>
                                Inventory Reports
                            </p>
                            <i class="fas fa-angle-right"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report') ? 'show':''}}">
                            {{-- Item Flow statement start --}}
                            @if(auth()->user()->hasPermissionToRoute('show.invItemFlow'))
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
                                    <i class="fas fa-angle-right"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'stock') ? 'show':''}}">
                                    @if(auth()->user()->hasPermissionToRoute('show.invStockDetails'))
                                        <li class="sub-menu2-item" data-url="{{route('show.invStockDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'stock' && Request::segment(4) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Stock Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.invStockSummary'))
                                        <li class="sub-menu2-item" data-url="{{route('show.invStockSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'stock' && Request::segment(4) == 'summary') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Stock Summary
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </li>

                            {{-- Profitability statement start --}}
                            @if(auth()->user()->hasPermissionToRoute('show.invProfit'))
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
                            @if(auth()->user()->hasPermissionToRoute('show.invExpiry'))
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
                                    <i class="fas fa-angle-right"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'purchase') ? 'show':''}}">
                                    @if(auth()->user()->hasPermissionToRoute('show.invPurchaseDetails'))
                                        <li class="sub-menu2-item" data-url="{{route('show.invPurchaseDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'purchase' && Request::segment(4) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Purchase Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.invPurchaseSummary'))
                                        <li class="sub-menu2-item" data-url="{{route('show.invPurchaseSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'purchase' && Request::segment(4) == 'summary') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
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
                                    <i class="fas fa-angle-right"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'issue') ? 'show':''}}">
                                    @if(auth()->user()->hasPermissionToRoute('show.invIssueDetails'))
                                        <li class="sub-menu2-item" data-url="{{route('show.invIssueDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'issue' && Request::segment(4) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Issue Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.invIssueSummary'))
                                        <li class="sub-menu2-item" data-url="{{route('show.invIssueSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'issue' && Request::segment(4) == 'summary') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
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
                                    <i class="fas fa-angle-right"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'return') ? 'show':''}}">
                                    @if(auth()->user()->hasPermissionToRoute('show.invClientReturnDetails'))
                                        <li class="sub-menu2-item" data-url="{{route('show.invClientReturnDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'client' && Request::segment(5) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Client Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.invClientSReturnummary'))
                                        <li class="sub-menu2-item" data-url="{{route('show.invClientReturnSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'client' && Request::segment(5) == 'summary') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Client Summary
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.invSupplierReturnDetails'))
                                        <li class="sub-menu2-item" data-url="{{route('show.invSupplierReturnDetails')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'supplier' && Request::segment(5) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Supplier Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.invSupplierReturnSummary'))
                                        <li class="sub-menu2-item" data-url="{{route('show.invSupplierReturnSummary')}}">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'supplier' && Request::segment(5) == 'summary') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
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

        <!-- Party Payments -->
        @if(auth()->user()->hasPermissionMainHead('7'))
            <li class="menu-item">
                <div class="menu-title {{ Request::segment(1) == 'party' ? 'active':''}}">
                    <p>
                        <i class="fa-brands fa-cc-amazon-pay"></i>
                        PARTY PAYMENT
                    </p>
                    <i class="fas fa-angle-right"></i>
                </div>
                <ul class="sub-menu {{ Request::segment(1) == 'party' ? 'show':''}}">
                    @if(auth()->user()->hasPermissionToRoute('show.partyReceive'))
                        <li class="sub-menu-item" data-url="{{route('show.partyReceive')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'party' && Request::segment(2) == 'receive') ? 'active':''}}">
                                <p>
                                    <i class="far fa-circle nav-icon"></i>
                                    Receive from Client
                                </p>
                            </div>
                        </li>
                    @endif
                                
                    @if(auth()->user()->hasPermissionToRoute('show.partyPayment'))
                        <li class="sub-menu-item" data-url="{{route('show.partyPayment')}}">
                            <div class="menu-title {{ (Request::segment(1) == 'party' && Request::segment(2) == 'payment') ? 'active':''}}">
                                <p>
                                    <i class="far fa-circle nav-icon"></i>
                                    Payment to Supplier
                                </p>
                            </div>
                        </li>
                    @endif
                </ul>
            </li>
            <hr>
        @endif
        
        {{-- Reports and Querrys  --}}
        @if(auth()->user()->hasPermissionMainHead('8'))
            <li class="menu-item">
                <div class="menu-title {{ Request::segment(1) == 'report' ? 'active':''}}">
                    <p>
                        <i class="fa-solid fa-book-open"></i>
                        REPORTS & QUERIES
                    </p>
                    <i class="fas fa-angle-right"></i>
                </div>
                <ul class="sub-menu {{ Request::segment(1) == 'report' ? 'show':''}}">
                    {{-- <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'balancesheet') ? 'active':''}}">
                            <p>
                            <i class="fa-solid fa-sheet-plastic"></i>
                                Balance Sheet
                            </p>
                            <i class="fas fa-angle-right"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'report' && Request::segment(2) == 'balancesheet') ? 'show':''}}">
                            @if(auth()->user()->hasPermissionToRoute('show.balanceSheetDetails'))
                                <li class="sub-menu1-item" data-url="{{route('show.balanceSheetDetails')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'balancesheet' && Request::segment(3) == 'details') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.balanceSheetSummary'))
                                <li class="sub-menu1-item" data-url="{{route('show.balanceSheetSummary')}}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'balancesheet' && Request::segment(3) == 'summary') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Summary
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li> --}}

                    {{-- accounts statement part start --}}
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'account') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-file-invoice"></i>
                                Account Statement
                            </p>
                            <i class="fas fa-angle-right"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'report' && Request::segment(2) == 'account') ? 'show':''}}">
                            @if(auth()->user()->hasPermissionToRoute('show.accountSummary'))
                                <li class="sub-menu1-item" data-url="{{ route('show.accountSummary') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'account' && Request::segment(3) == 'summary') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Summary
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.accountSummaryByGroupe'))
                                <li class="sub-menu1-item" data-url="{{ route('show.accountSummaryByGroupe') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'account' && Request::segment(3) == 'summarygroupe') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Summary(By Groupe)
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.accountDetails'))
                                <li class="sub-menu1-item" data-url="{{ route('show.accountDetails') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'account' && Request::segment(3) == 'details') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
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
                                <i class="fa-solid fa-file-invoice"></i>
                                Party Statement
                            </p>
                            <i class="fas fa-angle-right"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'report' && Request::segment(2) == 'party') ? 'show':''}}">
                            @if(auth()->user()->hasPermissionToRoute('show.partyDetails'))
                                <li class="sub-menu1-item" data-url="{{ route('show.partyDetails') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'party' && Request::segment(3) == 'details') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.partySummary'))
                                <li class="sub-menu1-item" data-url="{{ route('show.partySummary') }}">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'party' && Request::segment(3) == 'summary') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Summary
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>
                                
                    {{-- @if(auth()->user()->hasPermissionToRoute('show.groupeReport'))
                        <li class="sub-menu-item" data-url="{{route('show.groupeReport')}}">
                            <div class="menu-title">
                                <p>
                                    <i class="far fa-circle nav-icon"></i>
                                    Report By Groupe
                                </p>
                            </div>
                        </li>
                    @endif
                                
                    @if(auth()->user()->hasPermissionToRoute('show.summaryReport'))
                        <li class="sub-menu-item" data-url="{{route('show.summaryReport')}}">
                            <div class="menu-title">
                                <p>
                                    <i class="far fa-circle nav-icon"></i>
                                    Summary Report
                                </p>
                            </div>
                        </li>
                    @endif --}}
                </ul>
            </li>
        @endif
    </ul>
</aside>