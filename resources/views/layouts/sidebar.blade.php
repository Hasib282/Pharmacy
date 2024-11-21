<aside id="mySidenav" class="sidenav">
    {{-- <a href="{{ route('show.profile', auth()->user()->id) }}"> --}}
        <div class="user-details">
            <div class="user-image">
                <img src="{{ rtrim(env('API_URL'), '/api') }}/storage/profiles/{{ auth()->user()->image != null ? auth()->user()->image : (auth()->user()->gender == 'female' ? 'female.png' : 'male.png') }}" alt="">
            </div>
            <div class="user-name">
                <strong>{{ auth()->user()->user_name }}</strong>
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
                    <i class="fas fa-angle-right"></i>
                </div>
                <ul class="sub-menu {{ Request::segment(1) == 'admin' ? 'show':''}}">
                    @if(auth()->user()->hasPermissionToRoute('show.companytype'))
                        <li data-url="{{route('show.companytype')}}" class="sub-menu-item">
                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'companytype') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-house-circle-exclamation"></i>
                                    Company Types
                                </p>
                            </div>
                        </li>
                    @endif
                    
                    @if(auth()->user()->hasPermissionToRoute('show.companies'))
                        <li data-url="{{route('show.companies')}}" class="sub-menu-item">
                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'companies') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-house-user"></i>
                                    Company Details
                                </p>
                            </div>
                        </li>
                    @endif

                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-users"></i>
                                Users
                            </p>
                            <i class="fas fa-angle-right"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users') ? 'show':''}}">
                            @if(auth()->user()->hasPermissionToRoute('show.superAdmins'))
                                <li data-url="{{route('show.superAdmins')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users' && Request::segment(3) == 'superadmins') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-secret"></i>
                                            Super Admin
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.admins'))
                                <li data-url="{{route('show.admins')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users' && Request::segment(3) == 'admins') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-tie"></i>
                                            Admin 
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.clients'))
                                <li data-url="{{route('show.clients')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'users' && Request::segment(3) == 'clients') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-users"></i>
                                            Client
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.suppliers'))
                                <li data-url="{{route('show.suppliers')}}" class="sub-menu1-item">
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
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'auth') ? 'active':''}}">
                            <p>
                                <i class="fa-solid fa-users"></i>
                                Auth Setup
                            </p>
                            <i class="fas fa-angle-right"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'auth') ? 'show':''}}">
                            @if(auth()->user()->hasPermissionToRoute('show.roles'))
                                <li data-url="{{route('show.roles')}}" class="sub-menu1-item">
                                    <div class="menu-title  {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'auth' && Request::segment(3) == 'roles') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-user-secret"></i>
                                            Roles
                                        </p>
                                    </div>
                                </li>
                            @endif
                            <li class="sub-menu1-item">
                                <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'auth' && Request::segment(3) == 'permission') ? 'active':''}}">
                                    <p>
                                        <i class="fa-solid fa-people-carry-box"></i>
                                        Permission
                                    </p>
                                    <i class="fas fa-angle-right"></i>
                                </div>
                                <ul class="sub-menu2 {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'auth' && Request::segment(3) == 'permission') ? 'show':''}}">
                                    @if(auth()->user()->hasPermissionToRoute('show.permissionMainheads'))
                                        <li data-url="{{route('show.permissionMainheads')}}" class="sub-menu2-item">
                                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'auth' && Request::segment(3) == 'permission' && Request::segment(4) == 'mainhead') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-user-secret"></i>
                                                    Permission Main Head
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                            
                                    @if(auth()->user()->hasPermissionToRoute('show.permissions'))
                                        <li data-url="{{route('show.permissions')}}" class="sub-menu2-item">
                                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'auth' && Request::segment(3) == 'permission' && Request::segment(4) == '') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-user-secret"></i>
                                                    Permission Heads
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                            
                                    @if(auth()->user()->hasPermissionToRoute('show.routePermissions'))
                                        <li data-url="{{route('show.routePermissions')}}" class="sub-menu2-item">
                                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'auth' && Request::segment(3) == 'permission' && Request::segment(4) == 'routepermissions') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-user-secret"></i>
                                                    Route Permissions
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                            
                                    @if(auth()->user()->hasPermissionToRoute('show.userPermissions'))
                                        <li data-url="{{route('show.userPermissions')}}" class="sub-menu2-item">
                                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'auth' && Request::segment(3) == 'permission' && Request::segment(4) == 'userpermissions') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-user-secret"></i>
                                                    User Permissions
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                            
                                    @if(auth()->user()->hasPermissionToRoute('show.rolePermissions'))
                                        <li data-url="{{route('show.rolePermissions')}}" class="sub-menu2-item">
                                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'auth' && Request::segment(3) == 'permission' && Request::segment(4) == 'rolepermissions') ? 'active':''}}">
                                                <p>
                                                    <i class="fa-solid fa-user-secret"></i>
                                                    Role Permissions
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </li>
                                
                    @if(auth()->user()->hasPermissionToRoute('show.banks'))
                        <li data-url="{{route('show.banks')}}" class="sub-menu-item">
                            <div class="menu-title  {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'banks') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-people-roof"></i>
                                    Bank
                                </p>
                            </div>
                        </li>
                    @endif
                                
                    @if(auth()->user()->hasPermissionToRoute('show.locations'))
                        <li data-url="{{route('show.locations')}}" class="sub-menu-item">
                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'locations') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-location-dot"></i>
                                    Locations
                                </p>
                            </div>
                        </li>
                    @endif
                            
                    @if(auth()->user()->hasPermissionToRoute('show.stores'))
                        <li data-url="{{route('show.stores')}}" class="sub-menu-item">
                            <div class="menu-title  {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'store') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-shop"></i>
                                    Store Details
                                </p>
                            </div>
                        </li>
                    @endif
                            
                    @if(auth()->user()->hasPermissionToRoute('show.mainhead'))
                        <li data-url="{{route('show.mainhead')}}" class="sub-menu-item">
                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'mainhead') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-money-check-dollar"></i>
                                    Main Head 
                                </p>
                            </div>
                        </li>
                    @endif
                            
                    @if(auth()->user()->hasPermissionToRoute('show.tranwith'))
                        <li data-url="{{route('show.tranwith')}}" class="sub-menu-item">
                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'tranwith') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-users-gear"></i>
                                    User Types
                                </p>
                            </div>
                        </li>
                    @endif
                            
                    @if(auth()->user()->hasPermissionToRoute('show.tranGroupes'))
                        <li data-url="{{route('show.tranGroupes')}}" class="sub-menu-item">
                            <div class="menu-title {{ (Request::segment(1) == 'admin' && Request::segment(2) == 'trangroupes') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-dice-six"></i>
                                    Transaction Group
                                </p>
                            </div>
                        </li>
                    @endif
                            
                    @if(auth()->user()->hasPermissionToRoute('show.tranHeads'))
                        <li data-url="{{route('show.tranHeads')}}" class="sub-menu-item">
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
                        <li data-url="{{route('show.transactionReceive')}}" class="sub-menu-item">
                            <div class="menu-title {{ (Request::segment(1) == 'transaction' && Request::segment(2) == 'receive') ? 'active':''}}">
                                <p>
                                    <i class="far fa-circle nav-icon"></i>
                                    Transaction Receive
                                </p>
                            </div>
                        </li>
                    @endif
                            
                    @if(auth()->user()->hasPermissionToRoute('show.transactionPayment'))
                        <li data-url="{{route('show.transactionPayment')}}" class="sub-menu-item">
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
                        <li data-url="{{route('show.withdraws')}}" class="sub-menu-item">
                            <div class="menu-title {{ (Request::segment(1) == 'bank' && Request::segment(2) == 'withdraw') ? 'active':''}}">
                                <p>
                                    <i class="far fa-circle nav-icon"></i>
                                    Withdraw from Bank
                                </p>
                            </div>
                        </li>
                    @endif
                    
                    @if(auth()->user()->hasPermissionToRoute('show.deposits'))
                        <li data-url="{{route('show.deposits')}}" class="sub-menu-item">
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
                                <li data-url="{{route('show.employees')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'all') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            All Employee
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.employeePersonal'))
                                <li data-url="{{ route('show.employeePersonal') }}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'personal') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Add Personal Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.employeeEducation'))
                                <li data-url="{{ route('show.employeeEducation') }}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'education') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Add Education Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.employeeTraining'))
                                <li data-url="{{ route('show.employeeTraining') }}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'training') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Add Training Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.employeeExperience'))
                                <li data-url="{{ route('show.employeeExperience') }}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'experience') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Add Experience Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.employeeOrganization'))
                                <li data-url="{{ route('show.employeeOrganization') }}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'employee' && Request::segment(3) == 'organization') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Add Organization Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.employeeAttendence'))
                                <li data-url="{{ route('show.employeeAttendence') }}" class="sub-menu1-item">
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
                                <li data-url="{{route('show.payrollSetup')}}" class="sub-menu1-item">
                                    <div class="menu-title  {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'payroll' && Request::segment(3) == 'setup') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Payroll Setup
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.payrollMiddlewire'))
                                <li data-url="{{route('show.payrollMiddlewire')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'payroll' && Request::segment(3) == 'middlewire') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Payroll Middlewire
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.payroll'))
                                <li data-url="{{route('show.payroll')}}" class="sub-menu1-item">
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
                        <li data-url="{{route('show.departments')}}" class="sub-menu-item">
                            <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'departments') ? 'active':''}}">
                                <p>
                                    <i class="fa-solid fa-building"></i>
                                    Department
                                </p>
                            </div>
                        </li>
                    @endif
                                
                    @if(auth()->user()->hasPermissionToRoute('show.designations'))
                        <li data-url="{{route('show.designations')}}" class="sub-menu-item">
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
                                <li data-url="{{route('show.salarySummaryReport')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'hr' && Request::segment(2) == 'report' && Request::segment(4) == 'summary') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Summary
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.salaryDetailsReport'))
                                <li data-url="{{route('show.salaryDetailsReport')}}" class="sub-menu1-item">
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
                                <li data-url="{{route('show.pharmacyManufacturer')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'setup' && Request::segment(3) == 'manufacturer') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Item Manufacturer
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.pharmacyCategory'))
                                <li data-url="{{route('show.pharmacyCategory')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'setup' && Request::segment(3) == 'category') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-table-cells-large"></i>
                                            Item Category
                                        </p>
                                    </div>
                                </li>
                            @endif
                            
                            @if(auth()->user()->hasPermissionToRoute('show.pharmacyUnit'))
                                <li data-url="{{route('show.pharmacyUnit')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'setup' && Request::segment(3) == 'unit') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-scale-unbalanced"></i>
                                            Item Unit
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.pharmacyForm'))
                                <li data-url="{{route('show.pharmacyForm')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'setup' && Request::segment(3) == 'form') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-list-ul"></i>
                                            Item Form
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.pharmacyProduct'))
                                <li data-url="{{route('show.pharmacyProduct')}}" class="sub-menu1-item">
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
                                <li data-url="{{route('show.pharmacyPurchase')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'transaction' && Request::segment(3) == 'purchase') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Pharmacy Purchase
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.pharmacyIssue'))
                                <li data-url="{{route('show.pharmacyIssue')}}" class="sub-menu1-item">
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
                                        <li data-url="{{route('show.pharmacyClientReturn')}}" class="sub-menu2-item">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'transaction' && Request::segment(3) == 'return' && Request::segment(4) == 'client') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Client Return
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.pharmacySupplierReturn'))
                                        <li data-url="{{route('show.pharmacySupplierReturn')}}" class="sub-menu2-item">
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
                                <li data-url="{{route('show.pharmacyPosAdjustment')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'adjustment' && Request::segment(3) == 'positive') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Positive Adjustment
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.pharmacyNegAdjustment'))
                                <li data-url="{{route('show.pharmacyNegAdjustment')}}" class="sub-menu1-item">
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
                                <li data-url="{{route('show.pharmacyItemFlow')}}" class="sub-menu1-item">
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
                                        <li data-url="{{route('show.pharmacyStockDetails')}}" class="sub-menu2-item">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'stock' && Request::segment(4) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Stock Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.pharmacyStockSummary'))
                                        <li data-url="{{route('show.pharmacyStockSummary')}}" class="sub-menu2-item">
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
                                <li data-url="{{route('show.pharmacyProfit')}}" class="sub-menu1-item">
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
                                <li data-url="{{route('show.pharmacyExpiry')}}" class="sub-menu1-item">
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
                                        <li data-url="{{route('show.pharmacyPurchaseDetails')}}" class="sub-menu2-item">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'purchase' && Request::segment(4) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Purchase Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.pharmacyPurchaseSummary'))
                                        <li data-url="{{route('show.pharmacyPurchaseSummary')}}" class="sub-menu2-item">
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
                                        <li data-url="{{route('show.pharmacyIssueDetails')}}" class="sub-menu2-item">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'issue' && Request::segment(4) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Issue Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.pharmacyIssueSummary'))
                                        <li data-url="{{route('show.pharmacyIssueSummary')}}" class="sub-menu2-item">
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
                                        <li data-url="{{route('show.pharmacyClientReturnDetails')}}" class="sub-menu2-item">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'client' && Request::segment(5) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Client Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.pharmacyClientReturnSummary'))
                                        <li data-url="{{route('show.pharmacyClientReturnSummary')}}" class="sub-menu2-item">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'client' && Request::segment(5) == 'summary') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Client Summary
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.pharmacySupplierReturnDetails'))
                                        <li data-url="{{route('show.pharmacySupplierReturnDetails')}}" class="sub-menu2-item">
                                            <div class="menu-title {{ (Request::segment(1) == 'pharmacy' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'supplier' && Request::segment(5) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Supplier Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.pharmacySupplierReturnSummary'))
                                        <li data-url="{{route('show.pharmacySupplierReturnSummary')}}" class="sub-menu2-item">
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
                                <li data-url="{{route('show.invManufacturer')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'setup' && Request::segment(3) == 'manufacturer') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-industry"></i>
                                            Item Manufacturer
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.invCategory'))
                                <li data-url="{{route('show.invCategory')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'setup' && Request::segment(3) == 'category') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-table-cells-large"></i>
                                            Item Category
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.invUnit'))
                                <li data-url="{{route('show.invUnit')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'setup' && Request::segment(3) == 'unit') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-scale-unbalanced"></i>
                                            Item Unit
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.invForm'))
                                <li data-url="{{route('show.invForm')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'setup' && Request::segment(3) == 'form') ? 'active':''}}">
                                        <p>
                                            <i class="fa-solid fa-list-ul"></i>
                                            Item Form
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.invProduct'))
                                <li data-url="{{route('show.invProduct')}}" class="sub-menu1-item">
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
                                <li data-url="{{route('show.invPurchase')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'transaction' && Request::segment(3) == 'purchase') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Inventory Purchase
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.invIssue'))
                                <li data-url="{{route('show.invIssue')}}" class="sub-menu1-item">
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
                                        <li data-url="{{route('show.invClientReturn')}}" class="sub-menu2-item">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'transaction' && Request::segment(3) == 'return' && Request::segment(4) == 'client') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Client Return
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.invSupplierReturn'))
                                        <li data-url="{{route('show.invSupplierReturn')}}" class="sub-menu2-item">
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
                                <li data-url="{{route('show.invPosAdjustment')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'adjustment' && Request::segment(3) == 'positive') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Positive Adjustment
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.invNegAdjustment'))
                                <li data-url="{{route('show.invNegAdjustment')}}" class="sub-menu1-item">
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
                                <li data-url="{{route('show.invItemFlow')}}" class="sub-menu1-item">
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
                                        <li data-url="{{route('show.invStockDetails')}}" class="sub-menu2-item">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'stock' && Request::segment(4) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Stock Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.invStockSummary'))
                                        <li data-url="{{route('show.invStockSummary')}}" class="sub-menu2-item">
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
                                <li data-url="{{route('show.invProfit')}}" class="sub-menu1-item">
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
                                <li data-url="{{route('show.invExpiry')}}" class="sub-menu1-item">
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
                                        <li data-url="{{route('show.invPurchaseDetails')}}" class="sub-menu2-item">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'purchase' && Request::segment(4) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Purchase Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.invPurchaseSummary'))
                                        <li data-url="{{route('show.invPurchaseSummary')}}" class="sub-menu2-item">
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
                                        <li data-url="{{route('show.invIssueDetails')}}" class="sub-menu2-item">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'issue' && Request::segment(4) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Issue Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.invIssueSummary'))
                                        <li data-url="{{route('show.invIssueSummary')}}" class="sub-menu2-item">
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
                                        <li data-url="{{route('show.invClientReturnDetails')}}" class="sub-menu2-item">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'client' && Request::segment(5) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Client Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.invClientSReturnummary'))
                                        <li data-url="{{route('show.invClientReturnSummary')}}" class="sub-menu2-item">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'client' && Request::segment(5) == 'summary') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Client Summary
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.invSupplierReturnDetails'))
                                        <li data-url="{{route('show.invSupplierReturnDetails')}}" class="sub-menu2-item">
                                            <div class="menu-title {{ (Request::segment(1) == 'inventory' && Request::segment(2) == 'report' && Request::segment(3) == 'return' && Request::segment(4) == 'supplier' && Request::segment(5) == 'details') ? 'active':''}}">
                                                <p>
                                                    <i class="far fa-circle nav-icon"></i>
                                                    Supplier Details
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                
                                    @if(auth()->user()->hasPermissionToRoute('show.invSupplierReturnSummary'))
                                        <li data-url="{{route('show.invSupplierReturnSummary')}}" class="sub-menu2-item">
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
                        <li data-url="{{route('show.partyReceive')}}" class="sub-menu-item">
                            <div class="menu-title {{ (Request::segment(1) == 'party' && Request::segment(2) == 'receive') ? 'active':''}}">
                                <p>
                                    <i class="far fa-circle nav-icon"></i>
                                    Receive from Client
                                </p>
                            </div>
                        </li>
                    @endif
                                
                    @if(auth()->user()->hasPermissionToRoute('show.partyPayment'))
                        <li data-url="{{route('show.partyPayment')}}" class="sub-menu-item">
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
                    <li class="sub-menu-item">
                        <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'balancesheet') ? 'active':''}}">
                            <p>
                            <i class="fa-solid fa-sheet-plastic"></i>
                                Balance Sheet
                            </p>
                            <i class="fas fa-angle-right"></i>
                        </div>
                        <ul class="sub-menu1 {{ (Request::segment(1) == 'report' && Request::segment(2) == 'balancesheet') ? 'show':''}}">
                            @if(auth()->user()->hasPermissionToRoute('show.balanceSheetDetails'))
                                <li data-url="{{route('show.balanceSheetDetails')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'balancesheet' && Request::segment(3) == 'details') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.balanceSheetSummary'))
                                <li data-url="{{route('show.balanceSheetSummary')}}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'balancesheet' && Request::segment(3) == 'summary') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Summary
                                        </p>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </li>

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
                                <li data-url="{{ route('show.accountSummary') }}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'account' && Request::segment(3) == 'summary') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Summary
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.accountSummaryByGroupe'))
                                <li data-url="{{ route('show.accountSummaryByGroupe') }}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'account' && Request::segment(3) == 'summarygroupe') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Summary(By Groupe)
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.accountDetails'))
                                <li data-url="{{ route('show.accountDetails') }}" class="sub-menu1-item">
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
                                <li data-url="{{ route('show.partyDetails') }}" class="sub-menu1-item">
                                    <div class="menu-title {{ (Request::segment(1) == 'report' && Request::segment(2) == 'party' && Request::segment(3) == 'details') ? 'active':''}}">
                                        <p>
                                            <i class="far fa-circle nav-icon"></i>
                                            Details
                                        </p>
                                    </div>
                                </li>
                            @endif
                                
                            @if(auth()->user()->hasPermissionToRoute('show.partySummary'))
                                <li data-url="{{ route('show.partySummary') }}" class="sub-menu1-item">
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
                                
                    @if(auth()->user()->hasPermissionToRoute('show.groupeReport'))
                        <li data-url="{{route('show.groupeReport')}}" class="sub-menu-item">
                            <div class="menu-title">
                                <p>
                                    <i class="far fa-circle nav-icon"></i>
                                    Report By Groupe
                                </p>
                            </div>
                        </li>
                    @endif
                                
                    @if(auth()->user()->hasPermissionToRoute('show.summaryReport'))
                        <li data-url="{{route('show.summaryReport')}}" class="sub-menu-item">
                            <div class="menu-title">
                                <p>
                                    <i class="far fa-circle nav-icon"></i>
                                    Summary Report
                                </p>
                            </div>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
    </ul>
</aside>