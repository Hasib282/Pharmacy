<?php

return [
    // ----------------------------- Administrator Menu Permissions ----------------------------- //
    1 => [ 
        ['uri' => 'api/admin/users/admins', 'method' => 'GET'],
        ['uri' => 'api/admin/users/admins/search', 'method' => 'GET'],
        ['uri' => 'api/admin/users/admins/details', 'method' => 'GET'],
        ['uri' => 'admin/users/admins', 'method' => 'GET'],
        ['uri' => 'admin/users/admins/search', 'method' => 'GET'],
    ],
    2 => [
        ['uri' => 'api/admin/users/admins', 'method' => 'POST'],
    ],
    3 => [
        ['uri' => 'api/admin/users/admins/edit', 'method' => 'GET'],
        ['uri' => 'api/admin/users/admins', 'method' => 'PUT'],
    ],
    4 => [
        ['uri' => 'api/admin/users/admins', 'method' => 'DELETE'],
    ],
    5 => [
        ['uri' => 'api/admin/permission/userpermissions', 'method' => 'GET'],
        ['uri' => 'api/admin/permission/userpermissions/search', 'method' => 'GET'],
        ['uri' => 'admin/permission/userpermissions', 'method' => 'GET'],
        ['uri' => 'admin/permission/userpermissions/search', 'method' => 'GET'],
    ],
    6 => [
        ['uri' => 'api/admin/permission/userpermissions/edit', 'method' => 'GET'],
        ['uri' => 'api/admin/permission/userpermissions', 'method' => 'PUT'],
        ['uri' => 'api/admin/permission/userpermissions/copy', 'method' => 'PUT'],
        ['uri' => 'api/admin/permission/userpermissions/from', 'method' => 'GET'],
        ['uri' => 'api/admin/permission/userpermissions/to', 'method' => 'GET'],
    ],
    7 => [
        ['uri' => 'api/admin/banks', 'method' => 'GET'],
        ['uri' => 'api/admin/banks/search', 'method' => 'GET'],
        ['uri' => 'api/admin/banks/details', 'method' => 'GET'],
        ['uri' => 'admin/banks', 'method' => 'GET'],
        ['uri' => 'admin/banks/search', 'method' => 'GET'],
    ],
    8 => [
        ['uri' => 'api/admin/locations', 'method' => 'GET'],
        ['uri' => 'api/admin/locations/search', 'method' => 'GET'],
        ['uri' => 'admin/locations', 'method' => 'GET'],
        ['uri' => 'admin/locations/search', 'method' => 'GET'],
    ],
    9 => [
        ['uri' => 'api/admin/stores', 'method' => 'GET'],
        ['uri' => 'api/admin/stores/search', 'method' => 'GET'],
        ['uri' => 'admin/stores', 'method' => 'GET'],
        ['uri' => 'admin/stores/search', 'method' => 'GET'],
    ],
    10 => [
        ['uri' => 'api/admin/stores', 'method' => 'POST'],
    ],
    11 => [
        ['uri' => 'api/admin/stores/edit', 'method' => 'GET'],
        ['uri' => 'api/admin/stores', 'method' => 'PUT'],
    ],
    12 => [
        ['uri' => 'api/admin/stores', 'method' => 'Delete'],
    ],





    // ----------------------------- General Transaction Menu Permissions ----------------------------- //
    // SETUP
    13 => [
        ['uri' => 'api/transaction/setup/groupes', 'method' => 'GET'],
        ['uri' => 'api/transaction/setup/groupes/search', 'method' => 'GET'],
        ['uri' => 'transaction/setup/groupes', 'method' => 'GET'],
        ['uri' => 'transaction/setup/groupes/search', 'method' => 'GET'],
    ],
    14 => [
        ['uri' => 'api/transaction/setup/groupes', 'method' => 'POST'],
    ],
    15 => [
        ['uri' => 'api/transaction/setup/groupes/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/setup/groupes', 'method' => 'PUT'],
    ],
    16 => [
        ['uri' => 'api/transaction/setup/groupes', 'method' => 'DELETE'],
    ],
    17 => [
        ['uri' => 'api/transaction/setup/heads', 'method' => 'GET'],
        ['uri' => 'api/transaction/setup/heads/search', 'method' => 'GET'],
        ['uri' => 'transaction/setup/heads', 'method' => 'GET'],
        ['uri' => 'transaction/setup/heads/search', 'method' => 'GET'],
    ],
    18 => [
        ['uri' => 'api/transaction/setup/heads', 'method' => 'POST'],
    ],
    19 => [
        ['uri' => 'api/transaction/setup/heads/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/setup/heads', 'method' => 'PUT'],
    ],
    20 => [
        ['uri' => 'api/transaction/setup/heads', 'method' => 'DELETE'],
    ],



    // USERS
    21 => [
        ['uri' => 'api/transaction/users/usertype', 'method' => 'GET'],
        ['uri' => 'api/transaction/users/usertype/search', 'method' => 'GET'],
        ['uri' => 'transaction/users/usertype', 'method' => 'GET'],
        ['uri' => 'transaction/users/usertype/search', 'method' => 'GET'],
    ],
    22 => [
        ['uri' => 'api/transaction/users/usertype', 'method' => 'POST'],
    ],
    23 => [
        ['uri' => 'api/transaction/users/usertype/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/users/usertype', 'method' => 'PUT'],
    ],
    24 => [
        ['uri' => 'api/transaction/users/usertype', 'method' => 'DELETE'],
    ],
    25 => [
        ['uri' => 'api/transaction/users/clients', 'method' => 'GET'],
        ['uri' => 'api/transaction/users/clients/search', 'method' => 'GET'],
        ['uri' => 'api/transaction/users/clients/details', 'method' => 'GET'],
        ['uri' => 'transaction/users/clients', 'method' => 'GET'],
        ['uri' => 'transaction/users/clients/search', 'method' => 'GET'],
    ],
    26 => [
        ['uri' => 'api/transaction/users/clients', 'method' => 'POST'],
    ],
    27 => [
        ['uri' => 'api/transaction/users/clients/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/users/clients', 'method' => 'PUT'],
    ],
    28 => [
        ['uri' => 'api/transaction/users/clients', 'method' => 'DELETE'],
    ],
    29 => [
        ['uri' => 'api/transaction/users/suppliers', 'method' => 'GET'],
        ['uri' => 'api/transaction/users/suppliers/search', 'method' => 'GET'],
        ['uri' => 'api/transaction/users/suppliers/details', 'method' => 'GET'],
        ['uri' => 'transaction/users/suppliers', 'method' => 'GET'],
        ['uri' => 'transaction/users/suppliers/search', 'method' => 'GET'],
    ],
    30 => [
        ['uri' => 'api/transaction/users/suppliers', 'method' => 'POST'],
    ],
    31 => [
        ['uri' => 'api/transaction/users/suppliers/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/users/suppliers', 'method' => 'PUT'],
    ],
    32 => [
        ['uri' => 'api/transaction/users/suppliers', 'method' => 'DELETE'],
    ],




    // Transactions
    33 => [
        ['uri' => 'api/transaction/receive', 'method' => 'GET'],
        ['uri' => 'api/transaction/receive/search', 'method' => 'GET'],
        ['uri' => 'transaction/receive', 'method' => 'GET'],
        ['uri' => 'transaction/receive/search', 'method' => 'GET'],
    ],
    34 => [
        ['uri' => 'api/transaction/receive', 'method' => 'POST'],
    ],
    35 => [
        ['uri' => 'api/transaction/receive/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/receive', 'method' => 'PUT'],
    ],
    36 => [
        ['uri' => 'api/transaction/receive', 'method' => 'DELETE'],
    ],
    37 => [
        ['uri' => 'api/transaction/payment', 'method' => 'GET'],
        ['uri' => 'api/transaction/payment/search', 'method' => 'GET'],
        ['uri' => 'transaction/payment', 'method' => 'GET'],
        ['uri' => 'transaction/payment/search', 'method' => 'GET'],
    ],
    38 => [
        ['uri' => 'api/transaction/payment', 'method' => 'POST'],
    ],
    39 => [
        ['uri' => 'api/transaction/payment/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/payment', 'method' => 'PUT'],
    ],
    40 => [
        ['uri' => 'api/transaction/payment', 'method' => 'DELETE'],
    ],




    // Party Payment
    41 => [
        ['uri' => 'api/transaction/party/receive', 'method' => 'GET'],
        ['uri' => 'api/transaction/party/receive/search', 'method' => 'GET'],
        ['uri' => 'transaction/party/receive', 'method' => 'GET'],
        ['uri' => 'transaction/party/receive/search', 'method' => 'GET'],
    ],
    42 => [
        ['uri' => 'api/transaction/party/receive', 'method' => 'POST'],
    ],
    43 => [
        ['uri' => 'api/transaction/party/receive/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/party/receive', 'method' => 'PUT'],
    ],
    44 => [
        ['uri' => 'api/transaction/party/receive', 'method' => 'DELETE'],
    ],
    45 => [
        ['uri' => 'api/transaction/party/payment', 'method' => 'GET'],
        ['uri' => 'api/transaction/party/payment/search', 'method' => 'GET'],
        ['uri' => 'transaction/party/payment', 'method' => 'GET'],
        ['uri' => 'transaction/party/payment/search', 'method' => 'GET'],
    ],
    46 => [
        ['uri' => 'api/transaction/party/payment', 'method' => 'POST'],
    ],
    47 => [
        ['uri' => 'api/transaction/party/payment/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/party/payment', 'method' => 'PUT'],
    ],
    48 => [
        ['uri' => 'api/transaction/party/payment', 'method' => 'DELETE'],
    ],







    // ----------------------------- Bank Transaction Menu Permissions ----------------------------- //
    49 => [
        ['uri' => 'api/transaction/bank/deposit', 'method' => 'GET'],
        ['uri' => 'api/transaction/bank/deposit/search', 'method' => 'GET'],
        ['uri' => 'transaction/bank/deposit', 'method' => 'GET'],
        ['uri' => 'transaction/bank/deposit/search', 'method' => 'GET'],
    ],
    50 => [
        ['uri' => 'api/transaction/bank/deposit', 'method' => 'POST'],
    ],
    51 => [
        ['uri' => 'api/transaction/bank/deposit/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/bank/deposit', 'method' => 'PUT'],
    ],
    52 => [
        ['uri' => 'api/transaction/bank/deposit', 'method' => 'DELETE'],
    ],
    53 => [
        ['uri' => 'api/transaction/bank/withdraw', 'method' => 'GET'],
        ['uri' => 'api/transaction/bank/withdraw/search', 'method' => 'GET'],
        ['uri' => 'transaction/bank/withdraw', 'method' => 'GET'],
        ['uri' => 'transaction/bank/withdraw/search', 'method' => 'GET'],
    ],
    54 => [
        ['uri' => 'api/transaction/bank/withdraw', 'method' => 'POST'],
    ],
    55 => [
        ['uri' => 'api/transaction/bank/withdraw/edit', 'method' => 'GET'],
        ['uri' => 'api/transaction/bank/withdraw', 'method' => 'PUT'],
    ],
    56 => [
        ['uri' => 'api/transaction/bank/withdraw', 'method' => 'DELETE'],
    ],






    // ----------------------------- HR & Payroll Menu Permissions ----------------------------- //
    // SETUP
    57 => [
        ['uri' => 'api/hr/setup/departments', 'method' => 'GET'],
        ['uri' => 'api/hr/setup/departments/search', 'method' => 'GET'],
        ['uri' => 'hr/setup/departments', 'method' => 'GET'],
        ['uri' => 'hr/setup/departments/search', 'method' => 'GET'],
    ],
    58 => [
        ['uri' => 'api/hr/setup/departments', 'method' => 'POST'],
    ],
    59 => [
        ['uri' => 'api/hr/setup/departments/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/setup/departments', 'method' => 'PUT'],
    ],
    60 => [
        ['uri' => 'api/hr/setup/departments', 'method' => 'DELETE'],
    ],
    61 => [
        ['uri' => 'api/hr/setup/designations', 'method' => 'GET'],
        ['uri' => 'api/hr/setup/designations/search', 'method' => 'GET'],
        ['uri' => 'hr/setup/designations', 'method' => 'GET'],
        ['uri' => 'hr/setup/designations/search', 'method' => 'GET'],
    ],
    62 => [
        ['uri' => 'api/hr/setup/designations', 'method' => 'POST'],
    ],
    63 => [
        ['uri' => 'api/hr/setup/designations/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/setup/designations', 'method' => 'PUT'],
    ],
    64 => [
        ['uri' => 'api/hr/setup/designations', 'method' => 'DELETE'],
    ],




    // USERS / EMPLOYEE
    65 => [
        ['uri' => 'api/hr/employee/usertype', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/usertype/search', 'method' => 'GET'],
        ['uri' => 'hr/employee/usertype', 'method' => 'GET'],
        ['uri' => 'hr/employee/usertype/search', 'method' => 'GET'],
    ],
    66 => [
        ['uri' => 'api/hr/employee/usertype', 'method' => 'POST'],
    ],
    67 => [
        ['uri' => 'api/hr/employee/usertype/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/usertype', 'method' => 'PUT'],
    ],
    68 => [
        ['uri' => 'api/hr/employee/usertype', 'method' => 'DELETE'],
    ],
    69 => [
        ['uri' => 'api/hr/employee/all', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/all/search', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/all/details', 'method' => 'GET'],
        ['uri' => 'hr/employee/all', 'method' => 'GET'],
        ['uri' => 'hr/employee/all/search', 'method' => 'GET'],
    ],
    70 => [
        ['uri' => 'api/hr/employee/all', 'method' => 'POST'],
    ],
    71 => [
        ['uri' => 'api/hr/employee/all/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/all', 'method' => 'PUT'],
    ],
    72 => [
        ['uri' => 'api/hr/employee/all', 'method' => 'DELETE'],
    ],
    73 => [
        ['uri' => 'api/hr/employee/personal', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/personal/search', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/personal/details', 'method' => 'GET'],
        ['uri' => 'hr/employee/personal', 'method' => 'GET'],
        ['uri' => 'hr/employee/personal/search', 'method' => 'GET'],
    ],
    74 => [
        ['uri' => 'api/hr/employee/personal', 'method' => 'POST'],
    ],
    75 => [
        ['uri' => 'api/hr/employee/personal/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/personal', 'method' => 'PUT'],
    ],
    76 => [
        ['uri' => 'api/hr/employee/personal', 'method' => 'Delete'],
    ],
    77 => [
        ['uri' => 'api/hr/employee/education', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/education/search', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/education/details', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/education/grid', 'method' => 'GET'],
        ['uri' => 'hr/employee/education', 'method' => 'GET'],
        ['uri' => 'hr/employee/education/search', 'method' => 'GET'],
    ],
    78 => [
        ['uri' => 'api/hr/employee/education', 'method' => 'POST'],
    ],
    79 => [
        ['uri' => 'api/hr/employee/education/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/education', 'method' => 'PUT'],
    ],
    80 => [
        ['uri' => 'api/hr/employee/education', 'method' => 'DELETE'],
    ],
    81 => [
        ['uri' => 'api/hr/employee/training', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/training/search', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/training/details', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/training/grid', 'method' => 'GET'],
        ['uri' => 'hr/employee/training', 'method' => 'GET'],
        ['uri' => 'hr/employee/training/search', 'method' => 'GET'],
    ],
    82 => [
        ['uri' => 'api/hr/employee/training', 'method' => 'POST'],
    ],
    83 => [
        ['uri' => 'api/hr/employee/training/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/training', 'method' => 'PUT'],
    ],
    84 => [
        ['uri' => 'api/hr/employee/training', 'method' => 'DELETE'],
    ],
    85 => [
        ['uri' => 'api/hr/employee/experience', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/experience/search', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/experience/details', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/experience/grid', 'method' => 'GET'],
        ['uri' => 'hr/employee/experience', 'method' => 'GET'],
        ['uri' => 'hr/employee/experience/search', 'method' => 'GET'],
    ],
    86 => [
        ['uri' => 'api/hr/employee/experience', 'method' => 'POST'],
    ],
    87 => [
        ['uri' => 'api/hr/employee/experience/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/experience', 'method' => 'PUT'],
    ],
    88 => [
        ['uri' => 'api/hr/employee/experience', 'method' => 'DELETE'],
    ],
    89 => [
        ['uri' => 'api/hr/employee/organization', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/organization/search', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/organization/details', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/organization/grid', 'method' => 'GET'],
        ['uri' => 'hr/employee/organization', 'method' => 'GET'],
        ['uri' => 'hr/employee/organization/search', 'method' => 'GET'],
    ],
    90 => [
        ['uri' => 'api/hr/employee/organization', 'method' => 'POST'],
    ],
    91 => [
        ['uri' => 'api/hr/employee/organization/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/organization', 'method' => 'PUT'],
    ],
    92 => [
        ['uri' => 'api/hr/employee/organization', 'method' => 'DELETE'],
    ],
    93 => [
        ['uri' => 'api/hr/employee/attendence', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/attendence/search', 'method' => 'GET'],
        ['uri' => 'hr/employee/attendence', 'method' => 'GET'],
        ['uri' => 'hr/employee/attendence/search', 'method' => 'GET'],
    ],
    94 => [
        ['uri' => 'api/hr/employee/attendence', 'method' => 'POST'],
    ],
    95 => [
        ['uri' => 'api/hr/employee/attendence/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/employee/attendence', 'method' => 'PUT'],
    ],








    // Payroll / Transactions
    96 => [
        ['uri' => 'api/hr/payroll/heads', 'method' => 'GET'],
        ['uri' => 'api/hr/payroll/heads/search', 'method' => 'GET'],
        ['uri' => 'hr/payroll/heads', 'method' => 'GET'],
        ['uri' => 'hr/payroll/heads/search', 'method' => 'GET'],
    ],
    97 => [
        ['uri' => 'api/hr/payroll/heads', 'method' => 'POST'],
    ],
    98 => [
        ['uri' => 'api/hr/payroll/heads/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/payroll/heads', 'method' => 'PUT'],
    ],
    99 => [
        ['uri' => 'api/hr/payroll/heads', 'method' => 'DELETE'],
    ],
    100 => [
        ['uri' => 'api/hr/payroll/setup', 'method' => 'GET'],
        ['uri' => 'api/hr/payroll/setup/search', 'method' => 'GET'],
        ['uri' => 'hr/payroll/setup', 'method' => 'GET'],
        ['uri' => 'hr/payroll/setup/search', 'method' => 'GET'],
    ],
    101 => [ 
        ['uri' => 'api/hr/payroll/setup', 'method' => 'POST'],
    ],
    102 => [
        ['uri' => 'api/hr/payroll/setup/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/payroll/setup', 'method' => 'PUT'],
    ],
    103 => [
        ['uri' => 'api/hr/payroll/setup', 'method' => 'DELETE'],
    ],
    104 => [
        ['uri' => 'api/hr/payroll/middlewire', 'method' => 'GET'],
        ['uri' => 'api/hr/payroll/middlewire/search', 'method' => 'GET'],
        ['uri' => 'hr/payroll/middlewire', 'method' => 'GET'],
        ['uri' => 'hr/payroll/middlewire/search', 'method' => 'GET'],
    ],
    105 => [
        ['uri' => 'api/hr/payroll/middlewire', 'method' => 'POST'],
    ],
    106 => [
        ['uri' => 'api/hr/payroll/middlewire/edit', 'method' => 'GET'],
        ['uri' => 'api/hr/payroll/middlewire', 'method' => 'PUT'],
    ],
    107 => [
        ['uri' => 'api/hr/payroll/middlewire', 'method' => 'DELETE'],
    ],
    108 => [
        ['uri' => 'api/hr/payroll/process', 'method' => 'GET'],
        ['uri' => 'api/hr/payroll/process/search', 'method' => 'GET'],
        ['uri' => 'hr/payroll/process', 'method' => 'GET'],
        ['uri' => 'hr/payroll/process/search', 'method' => 'GET'],
    ],
    109 => [
        ['uri' => 'api/hr/payroll/process', 'method' => 'POST'],
    ],
    110 => [
        ['uri' => 'api/hr/report/salary/summary', 'method' => 'GET'],
        ['uri' => 'api/hr/report/salary/summary/search', 'method' => 'GET'],
        ['uri' => 'hr/report/salary/summary', 'method' => 'GET'],
        ['uri' => 'hr/report/salary/summary/search', 'method' => 'GET'],
    ],
    111 => [
        ['uri' => 'api/hr/report/salary/details', 'method' => 'GET'],
        ['uri' => 'api/hr/report/salary/details/search', 'method' => 'GET'],
        ['uri' => 'hr/report/salary/details', 'method' => 'GET'],
        ['uri' => 'hr/report/salary/details/search', 'method' => 'GET'],
    ],







    // ----------------------------- Pharmacy Menu Permissions ----------------------------- //
    // SETUP
    112 => [
        ['uri' => 'api/pharmacy/setup/manufacturer', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/manufacturer/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/manufacturer', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/manufacturer/search', 'method' => 'GET'],
    ],
    113 => [
        ['uri' => 'api/pharmacy/setup/manufacturer', 'method' => 'POST'],
    ],
    114 => [
        ['uri' => 'api/pharmacy/setup/manufacturer/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/manufacturer', 'method' => 'PUT'],
    ],
    115 => [
        ['uri' => 'api/pharmacy/setup/manufacturer', 'method' => 'DELETE'],
    ],
    116 => [
        ['uri' => 'api/pharmacy/setup/category', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/category/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/category', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/category/search', 'method' => 'GET'],
    ],
    117 => [
        ['uri' => 'api/pharmacy/setup/category', 'method' => 'POST'],
    ],
    118 => [
        ['uri' => 'api/pharmacy/setup/category/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/category', 'method' => 'PUT'],
    ],
    119 => [
        ['uri' => 'api/pharmacy/setup/category', 'method' => 'DELETE'],
    ],
    120 => [
        ['uri' => 'api/pharmacy/setup/unit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/unit/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/unit', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/unit/search', 'method' => 'GET'],
    ],
    121 => [
        ['uri' => 'api/pharmacy/setup/unit', 'method' => 'POST'],
    ],
    122 => [
        ['uri' => 'api/pharmacy/setup/unit/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/unit', 'method' => 'PUT'],
    ],
    123 => [
        ['uri' => 'api/pharmacy/setup/unit', 'method' => 'DELETE'],
    ],
    124 => [
        ['uri' => 'api/pharmacy/setup/form', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/form/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/form', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/form/search', 'method' => 'GET'],
    ],
    125 => [
        ['uri' => 'api/pharmacy/setup/form', 'method' => 'POST'],
    ],
    126 => [
        ['uri' => 'api/pharmacy/setup/form/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/form', 'method' => 'PUT'],
    ],
    127 => [
        ['uri' => 'api/pharmacy/setup/form', 'method' => 'DELETE'],
    ],
    128 => [
        ['uri' => 'api/pharmacy/setup/groupes', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/groupes/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/groupes', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/groupes/search', 'method' => 'GET'],
    ],
    129 => [
        ['uri' => 'api/pharmacy/setup/groupes', 'method' => 'POST'],
    ],
    130 => [
        ['uri' => 'api/pharmacy/setup/groupes/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/groupes', 'method' => 'PUT'],
    ],
    131 => [
        ['uri' => 'api/pharmacy/setup/groupes', 'method' => 'DELETE'],
    ],
    132 => [
        ['uri' => 'api/pharmacy/setup/product', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/product/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/product', 'method' => 'GET'],
        ['uri' => 'pharmacy/setup/product/search', 'method' => 'GET'],
    ],
    133 => [
        ['uri' => 'api/pharmacy/setup/product', 'method' => 'POST'],
    ],
    134 => [
        ['uri' => 'api/pharmacy/setup/product/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/setup/product', 'method' => 'PUT'],
    ],
    135 => [
        ['uri' => 'api/pharmacy/setup/product', 'method' => 'DELETE'],
    ],






    // USERS
    136 => [
        ['uri' => 'api/pharmacy/users/usertype', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/users/usertype/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/users/usertype', 'method' => 'GET'],
        ['uri' => 'pharmacy/users/usertype/search', 'method' => 'GET'],
    ],
    137 => [
        ['uri' => 'api/pharmacy/users/usertype', 'method' => 'POST'],
    ],
    138 => [
        ['uri' => 'api/pharmacy/users/usertype/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/users/usertype', 'method' => 'PUT'],
    ],
    139 => [
        ['uri' => 'api/pharmacy/users/usertype', 'method' => 'DELETE'],
    ],
    140 => [
        ['uri' => 'api/pharmacy/users/clients', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/users/clients/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/users/clients', 'method' => 'GET'],
        ['uri' => 'pharmacy/users/clients/search', 'method' => 'GET'],
    ],
    141 => [
        ['uri' => 'api/pharmacy/users/clients', 'method' => 'POST'],
    ],
    142 => [
        ['uri' => 'api/pharmacy/users/clients/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/users/clients', 'method' => 'PUT'],
    ],
    143 => [
        ['uri' => 'api/pharmacy/users/clients', 'method' => 'DELETE'],
    ],
    144 => [
        ['uri' => 'api/pharmacy/users/suppliers', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/users/suppliers/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/users/suppliers', 'method' => 'GET'],
        ['uri' => 'pharmacy/users/suppliers/search', 'method' => 'GET'],
    ],
    145 => [
        ['uri' => 'api/pharmacy/users/suppliers', 'method' => 'POST'],
    ],
    146 => [
        ['uri' => 'api/pharmacy/users/suppliers/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/users/suppliers', 'method' => 'PUT'],
    ],
    147 => [
        ['uri' => 'api/pharmacy/users/suppliers', 'method' => 'Delete'],
    ],
    
    






    // Transactions
    148 => [
        ['uri' => 'api/pharmacy/transaction/purchase', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/transaction/purchase/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/transaction/purchase', 'method' => 'GET'],
        ['uri' => 'pharmacy/transaction/purchase/search', 'method' => 'GET'],
    ],
    149 => [
        ['uri' => 'api/pharmacy/transaction/purchase', 'method' => 'POST'],
    ],
    150 => [
        ['uri' => 'api/pharmacy/transaction/purchase/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/transaction/purchase', 'method' => 'PUT'],
    ],
    151 => [
        ['uri' => 'api/pharmacy/transaction/purchase', 'method' => 'DELETE'],
    ],
    152 => [
        ['uri' => 'api/pharmacy/transaction/purchase/verify', 'method' => 'POST'],
    ],
    153 => [
        ['uri' => 'api/pharmacy/transaction/issue', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/transaction/issue/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/transaction/issue', 'method' => 'GET'],
        ['uri' => 'pharmacy/transaction/issue/search', 'method' => 'GET'],
    ],
    154 => [
        ['uri' => 'api/pharmacy/transaction/issue', 'method' => 'POST'],
    ],
    155 => [
        ['uri' => 'api/pharmacy/transaction/issue/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/transaction/issue', 'method' => 'PUT'],
    ],
    156 => [
        ['uri' => 'api/pharmacy/transaction/issue', 'method' => 'DELETE'],
    ],
    157 => [
        ['uri' => 'api/pharmacy/transaction/return/client', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/transaction/return/client/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/transaction/return/client', 'method' => 'GET'],
        ['uri' => 'pharmacy/transaction/return/client/search', 'method' => 'GET'],
    ],
    158 => [
        ['uri' => 'api/pharmacy/transaction/return/client', 'method' => 'POST'],
    ],
    159 => [
        ['uri' => 'api/pharmacy/transaction/return/client/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/transaction/return/client', 'method' => 'PUT'],
    ],
    160 => [
        ['uri' => 'api/pharmacy/transaction/return/client', 'method' => 'DELETE'],
    ],
    161 => [
        ['uri' => 'api/pharmacy/transaction/return/supplier', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/transaction/return/supplier/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/transaction/return/supplier', 'method' => 'GET'],
        ['uri' => 'pharmacy/transaction/return/supplier/search', 'method' => 'GET'],
    ],
    162 => [
        ['uri' => 'api/pharmacy/transaction/return/supplier', 'method' => 'POST'],
    ],
    163 => [
        ['uri' => 'api/pharmacy/transaction/return/supplier/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/transaction/return/supplier', 'method' => 'PUT'],
    ],
    164 => [
        ['uri' => 'api/pharmacy/transaction/return/supplier', 'method' => 'DELETE'],
    ],
    





    // ADJUSTMENT
    165 => [
        ['uri' => 'api/pharmacy/adjustment/positive', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/adjustment/positive/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/adjustment/positive', 'method' => 'GET'],
        ['uri' => 'pharmacy/adjustment/positive/search', 'method' => 'GET'],
    ],
    166 => [
        ['uri' => 'api/pharmacy/adjustment/positive', 'method' => 'POST'],
    ],
    167 => [
        ['uri' => 'api/pharmacy/adjustment/positive/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/adjustment/positive', 'method' => 'PUT'],
    ],
    168 => [
        ['uri' => 'api/pharmacy/adjustment/positive', 'method' => 'DELETE'],
    ],
    169 => [
        ['uri' => 'api/pharmacy/adjustment/negative', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/adjustment/negative/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/adjustment/negative', 'method' => 'GET'],
        ['uri' => 'pharmacy/adjustment/negative/search', 'method' => 'GET'],
    ],
    170 => [
        ['uri' => 'api/pharmacy/adjustment/negative', 'method' => 'POST'],
    ],
    171 => [
        ['uri' => 'api/pharmacy/adjustment/negative/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/adjustment/negative', 'method' => 'PUT'],
    ],
    172 => [
        ['uri' => 'api/pharmacy/adjustment/negative', 'method' => 'DELETE'],
    ],






    // PARTY PAYMENT
    173 => [
        ['uri' => 'api/pharmacy/party/receive', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/party/receive/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/party/receive', 'method' => 'GET'],
        ['uri' => 'pharmacy/party/receive/search', 'method' => 'GET'],
    ],
    174 => [
        ['uri' => 'api/pharmacy/party/receive', 'method' => 'POST'],
    ],
    175 => [
        ['uri' => 'api/pharmacy/party/receive/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/party/receive', 'method' => 'PUT'],
    ],
    176 => [
        ['uri' => 'api/pharmacy/party/receive', 'method' => 'DELETE'],
    ],
    177 => [
        ['uri' => 'api/pharmacy/party/payment', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/party/payment/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/party/payment', 'method' => 'GET'],
        ['uri' => 'pharmacy/party/payment/search', 'method' => 'GET'],
    ],
    178 => [
        ['uri' => 'api/pharmacy/party/payment', 'method' => 'POST'],
    ],
    179 => [
        ['uri' => 'api/pharmacy/party/payment/edit', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/party/payment', 'method' => 'PUT'],
    ],
    180 => [
        ['uri' => 'api/pharmacy/party/payment', 'method' => 'DELETE'],
    ],
    






    // REPORTS
    181 => [
        ['uri' => 'api/pharmacy/report/item/flow', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/item/flow/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/item/flow', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/item/flow/search', 'method' => 'GET'],
    ],
    182 => [
        ['uri' => 'api/pharmacy/report/stock/summary', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/stock/summary/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/stock/summary', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/stock/summary/search', 'method' => 'GET'],
    ],
    183 => [
        ['uri' => 'api/pharmacy/report/stock/details', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/stock/details/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/stock/details', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/stock/details/search', 'method' => 'GET'],
    ],
    184 => [
        ['uri' => 'api/pharmacy/report/profitability/statement', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/profitability/statement/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/profitability/statement', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/profitability/statement/search', 'method' => 'GET'],
    ],
    185 => [
        ['uri' => 'api/pharmacy/report/expiry/statement', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/expiry/statement/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/expiry/statement', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/expiry/statement/search', 'method' => 'GET'],
    ],
    186 => [
        ['uri' => 'api/pharmacy/report/purchase/summary', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/purchase/summary/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/purchase/summary', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/purchase/summary/search', 'method' => 'GET'],
    ],
    187 => [
        ['uri' => 'api/pharmacy/report/purchase/details', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/purchase/details/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/purchase/details', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/purchase/details/search', 'method' => 'GET'],
    ],
    188 => [
        ['uri' => 'api/pharmacy/report/issue/summary', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/issue/summary/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/issue/summary', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/issue/summary/search', 'method' => 'GET'],
    ],
    189 => [
        ['uri' => 'api/pharmacy/report/issue/details', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/issue/details/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/issue/details', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/issue/details/search', 'method' => 'GET'],
    ],
    190 => [
        ['uri' => 'api/pharmacy/report/return/client/summary', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/return/client/summary/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/return/client/summary', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/return/client/summary/search', 'method' => 'GET'],
    ],
    191 => [
        ['uri' => 'api/pharmacy/report/return/client/details', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/return/client/details/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/return/client/details', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/return/client/details/search', 'method' => 'GET'],
    ],
    192 => [
        ['uri' => 'api/pharmacy/report/return/supplier/summary', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/return/supplier/summary/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/return/supplier/summary', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/return/supplier/summary/search', 'method' => 'GET'],
    ],
    193 => [
        ['uri' => 'api/pharmacy/report/return/supplier/details', 'method' => 'GET'],
        ['uri' => 'api/pharmacy/report/return/supplier/details/search', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/return/supplier/details', 'method' => 'GET'],
        ['uri' => 'pharmacy/report/return/supplier/details/search', 'method' => 'GET'],
    ],









    








    // ----------------------------- Inventory Menu Permissions ----------------------------- //
    // SETUP
    194 => [
        ['uri' => 'api/inventory/setup/manufacturer', 'method' => 'GET'],
        ['uri' => 'api/inventory/setup/manufacturer/search', 'method' => 'GET'],
        ['uri' => 'inventory/setup/manufacturer', 'method' => 'GET'],
        ['uri' => 'inventory/setup/manufacturer/search', 'method' => 'GET'],
    ],
    195 => [
        ['uri' => 'api/inventory/setup/manufacturer', 'method' => 'POST'],
    ],
    196 => [
        ['uri' => 'api/inventory/setup/manufacturer/edit', 'method' => 'GET'],
        ['uri' => 'api/inventory/setup/manufacturer', 'method' => 'PUT'],
    ],
    197 => [
        ['uri' => 'api/inventory/setup/manufacturer', 'method' => 'DELETE'],
    ],
    198 => [
        ['uri' => 'api/inventory/setup/category', 'method' => 'GET'],
        ['uri' => 'api/inventory/setup/category/search', 'method' => 'GET'],
        ['uri' => 'inventory/setup/category', 'method' => 'GET'],
        ['uri' => 'inventory/setup/category/search', 'method' => 'GET'],
    ],
    199 => [
        ['uri' => 'api/inventory/setup/category', 'method' => 'POST'],
    ],
    200 => [
        ['uri' => 'api/inventory/setup/category/edit', 'method' => 'GET'],
        ['uri' => 'api/inventory/setup/category', 'method' => 'PUT'],
    ],
    201 => [
        ['uri' => 'api/inventory/setup/category', 'method' => 'DELETE'],
    ],
    202 => [
        ['uri' => 'api/inventory/setup/unit', 'method' => 'GET'],
        ['uri' => 'api/inventory/setup/unit/search', 'method' => 'GET'],
        ['uri' => 'inventory/setup/unit', 'method' => 'GET'],
        ['uri' => 'inventory/setup/unit/search', 'method' => 'GET'],
    ],
    203 => [
        ['uri' => 'api/inventory/setup/unit', 'method' => 'POST'],
    ],
    204 => [
        ['uri' => 'api/inventory/setup/unit/edit', 'method' => 'GET'],
        ['uri' => 'api/inventory/setup/unit', 'method' => 'PUT'],
    ],
    205 => [
        ['uri' => 'api/inventory/setup/unit', 'method' => 'DELETE'],
    ],
    206 => [
        ['uri' => 'api/inventory/setup/form', 'method' => 'GET'],
        ['uri' => 'api/inventory/setup/form/search', 'method' => 'GET'],
        ['uri' => 'inventory/setup/form', 'method' => 'GET'],
        ['uri' => 'inventory/setup/form/search', 'method' => 'GET'],
    ],
    207 => [
        ['uri' => 'api/inventory/setup/form', 'method' => 'POST'],
    ],
    208 => [
        ['uri' => 'api/inventory/setup/form/edit', 'method' => 'GET'],
        ['uri' => 'api/inventory/setup/form', 'method' => 'PUT'],
    ],
    209 => [
        ['uri' => 'api/inventory/setup/form', 'method' => 'DELETE'],
    ],
    210 => [
        ['uri' => 'api/inventory/setup/groupes', 'method' => 'GET'],
        ['uri' => 'api/inventory/setup/groupes/search', 'method' => 'GET'],
        ['uri' => 'inventory/setup/groupes', 'method' => 'GET'],
        ['uri' => 'inventory/setup/groupes/search', 'method' => 'GET'],
    ],
    211 => [
        ['uri' => 'api/inventory/setup/groupes', 'method' => 'POST'],
    ],
    212 => [
        ['uri' => 'api/inventory/setup/groupes/edit', 'method' => 'GET'],
        ['uri' => 'api/inventory/setup/groupes', 'method' => 'PUT'],
    ],
    213 => [
        ['uri' => 'api/inventory/setup/groupes', 'method' => 'DELETE'],
    ],
    214 => [
        ['uri' => 'api/inventory/setup/product', 'method' => 'GET'],
        ['uri' => 'api/inventory/setup/product/search', 'method' => 'GET'],
        ['uri' => 'inventory/setup/product', 'method' => 'GET'],
        ['uri' => 'inventory/setup/product/search', 'method' => 'GET'],
    ],
    215 => [
        ['uri' => 'api/inventory/setup/product', 'method' => 'POST'],
    ],
    216 => [
        ['uri' => 'api/inventory/setup/product/edit', 'method' => 'GET'],
        ['uri' => 'api/inventory/setup/product', 'method' => 'PUT'],
    ],
    217 => [
        ['uri' => 'api/inventory/setup/product', 'method' => 'DELETE'],
    ],






    // USERS
    218 => [
        ['uri' => 'api/inventory/users/usertype', 'method' => 'GET'],
        ['uri' => 'api/inventory/users/usertype/search', 'method' => 'GET'],
        ['uri' => 'inventory/users/usertype', 'method' => 'GET'],
        ['uri' => 'inventory/users/usertype/search', 'method' => 'GET'],
    ],
    219 => [
        ['uri' => 'api/inventory/users/usertype', 'method' => 'POST'],
    ],
    220 => [
        ['uri' => 'api/inventory/users/usertype/edit', 'method' => 'GET'],
        ['uri' => 'api/inventory/users/usertype', 'method' => 'PUT'],
    ],
    221 => [
        ['uri' => 'api/inventory/users/usertype', 'method' => 'DELETE'],
    ],
    222 => [
        ['uri' => 'api/inventory/users/clients', 'method' => 'GET'],
        ['uri' => 'api/inventory/users/clients/search', 'method' => 'GET'],
        ['uri' => 'inventory/users/clients', 'method' => 'GET'],
        ['uri' => 'inventory/users/clients/search', 'method' => 'GET'],
    ],
    223 => [
        ['uri' => 'api/inventory/users/clients', 'method' => 'POST'],
    ],
    224 => [
        ['uri' => 'api/inventory/users/clients/edit', 'method' => 'GET'],
        ['uri' => 'api/inventory/users/clients', 'method' => 'PUT'],
    ],
    225 => [
        ['uri' => 'api/inventory/users/clients', 'method' => 'DELETE'],
    ],
    226 => [
        ['uri' => 'api/inventory/users/suppliers', 'method' => 'GET'],
        ['uri' => 'api/inventory/users/suppliers/search', 'method' => 'GET'],
        ['uri' => 'inventory/users/suppliers', 'method' => 'GET'],
        ['uri' => 'inventory/users/suppliers/search', 'method' => 'GET'],
    ],
    227 => [
        ['uri' => 'api/inventory/users/suppliers', 'method' => 'POST'],
    ],
    228 => [
        ['uri' => 'api/inventory/users/suppliers/edit', 'method' => 'GET'],
        ['uri' => 'api/inventory/users/suppliers', 'method' => 'PUT'],
    ],
    229 => [
        ['uri' => 'api/inventory/users/suppliers', 'method' => 'Delete'],
    ],
    
    






    // Transactions
    230 => [
        ['uri' => 'api/inventory/transaction/purchase', 'method' => 'GET'],
        ['uri' => 'api/inventory/transaction/purchase/search', 'method' => 'GET'],
        ['uri' => 'inventory/transaction/purchase', 'method' => 'GET'],
        ['uri' => 'inventory/transaction/purchase/search', 'method' => 'GET'],
    ],
    231 => [
        ['uri' => 'api/inventory/transaction/purchase', 'method' => 'POST'],
    ],
    232 => [
        ['uri' => 'api/inventory/transaction/purchase/edit', 'method' => 'GET'],
        ['uri' => 'api/inventory/transaction/purchase', 'method' => 'PUT'],
    ],
    233 => [
        ['uri' => 'api/inventory/transaction/purchase', 'method' => 'DELETE'],
    ],
    234 => [
        ['uri' => 'api/inventory/transaction/purchase/verify', 'method' => 'DELETE'],
    ],
    235 => [
        ['uri' => 'api/inventory/transaction/issue', 'method' => 'GET'],
        ['uri' => 'api/inventory/transaction/issue/search', 'method' => 'GET'],
        ['uri' => 'inventory/transaction/issue', 'method' => 'GET'],
        ['uri' => 'inventory/transaction/issue/search', 'method' => 'GET'],
    ],
    236 => [
        ['uri' => 'api/inventory/transaction/issue', 'method' => 'POST'],
    ],
    237 => [
        ['uri' => 'api/inventory/transaction/issue/edit', 'method' => 'GET'],
        ['uri' => 'api/inventory/transaction/issue', 'method' => 'PUT'],
    ],
    238 => [
        ['uri' => 'api/inventory/transaction/issue', 'method' => 'DELETE'],
    ],
    239 => [
        ['uri' => 'api/inventory/transaction/return/client', 'method' => 'GET'],
        ['uri' => 'api/inventory/transaction/return/client/search', 'method' => 'GET'],
        ['uri' => 'inventory/transaction/return/client', 'method' => 'GET'],
        ['uri' => 'inventory/transaction/return/client/search', 'method' => 'GET'],
    ],
    240 => [
        ['uri' => 'api/inventory/transaction/return/client', 'method' => 'POST'],
    ],
    241 => [
        ['uri' => 'api/inventory/transaction/return/client/edit', 'method' => 'GET'],
        ['uri' => 'api/inventory/transaction/return/client', 'method' => 'PUT'],
    ],
    242 => [
        ['uri' => 'api/inventory/transaction/return/client', 'method' => 'DELETE'],
    ],
    243 => [
        ['uri' => 'api/inventory/transaction/return/supplier', 'method' => 'GET'],
        ['uri' => 'api/inventory/transaction/return/supplier/search', 'method' => 'GET'],
        ['uri' => 'inventory/transaction/return/supplier', 'method' => 'GET'],
        ['uri' => 'inventory/transaction/return/supplier/search', 'method' => 'GET'],
    ],
    244 => [
        ['uri' => 'api/inventory/transaction/return/supplier', 'method' => 'POST'],
    ],
    245 => [
        ['uri' => 'api/inventory/transaction/return/supplier/edit', 'method' => 'GET'],
        ['uri' => 'api/inventory/transaction/return/supplier', 'method' => 'PUT'],
    ],
    246 => [
        ['uri' => 'api/inventory/transaction/return/supplier', 'method' => 'DELETE'],
    ],
    





    // ADJUSTMENT
    247 => [
        ['uri' => 'api/inventory/adjustment/positive', 'method' => 'GET'],
        ['uri' => 'api/inventory/adjustment/positive/search', 'method' => 'GET'],
        ['uri' => 'inventory/adjustment/positive', 'method' => 'GET'],
        ['uri' => 'inventory/adjustment/positive/search', 'method' => 'GET'],
    ],
    248 => [
        ['uri' => 'api/inventory/adjustment/positive', 'method' => 'POST'],
    ],
    249 => [
        ['uri' => 'api/inventory/adjustment/positive/edit', 'method' => 'GET'],
        ['uri' => 'api/inventory/adjustment/positive', 'method' => 'PUT'],
    ],
    250 => [
        ['uri' => 'api/inventory/adjustment/positive', 'method' => 'DELETE'],
    ],
    251 => [
        ['uri' => 'api/inventory/adjustment/negative', 'method' => 'GET'],
        ['uri' => 'api/inventory/adjustment/negative/search', 'method' => 'GET'],
        ['uri' => 'inventory/adjustment/negative', 'method' => 'GET'],
        ['uri' => 'inventory/adjustment/negative/search', 'method' => 'GET'],
    ],
    252 => [
        ['uri' => 'api/inventory/adjustment/negative', 'method' => 'POST'],
    ],
    253 => [
        ['uri' => 'api/inventory/adjustment/negative/edit', 'method' => 'GET'],
        ['uri' => 'api/inventory/adjustment/negative', 'method' => 'PUT'],
    ],
    254 => [
        ['uri' => 'api/inventory/adjustment/negative', 'method' => 'DELETE'],
    ],






    // PARTY PAYMENT
    255 => [
        ['uri' => 'api/inventory/party/receive', 'method' => 'GET'],
        ['uri' => 'api/inventory/party/receive/search', 'method' => 'GET'],
        ['uri' => 'inventory/party/receive', 'method' => 'GET'],
        ['uri' => 'inventory/party/receive/search', 'method' => 'GET'],
    ],
    256 => [
        ['uri' => 'api/inventory/party/receive', 'method' => 'POST'],
    ],
    257 => [
        ['uri' => 'api/inventory/party/receive/edit', 'method' => 'GET'],
        ['uri' => 'api/inventory/party/receive', 'method' => 'PUT'],
    ],
    258 => [
        ['uri' => 'api/inventory/party/receive', 'method' => 'DELETE'],
    ],
    259 => [
        ['uri' => 'api/inventory/party/payment', 'method' => 'GET'],
        ['uri' => 'api/inventory/party/payment/search', 'method' => 'GET'],
        ['uri' => 'inventory/party/payment', 'method' => 'GET'],
        ['uri' => 'inventory/party/payment/search', 'method' => 'GET'],
    ],
    260 => [
        ['uri' => 'api/inventory/party/payment', 'method' => 'POST'],
    ],
    261 => [
        ['uri' => 'api/inventory/party/payment/edit', 'method' => 'GET'],
        ['uri' => 'api/inventory/party/payment', 'method' => 'PUT'],
    ],
    262 => [
        ['uri' => 'api/inventory/party/payment', 'method' => 'DELETE'],
    ],
    






    // REPORTS
    263 => [
        ['uri' => 'api/inventory/report/item/flow', 'method' => 'GET'],
        ['uri' => 'api/inventory/report/item/flow/search', 'method' => 'GET'],
        ['uri' => 'inventory/report/item/flow', 'method' => 'GET'],
        ['uri' => 'inventory/report/item/flow/search', 'method' => 'GET'],
    ],
    264 => [
        ['uri' => 'api/inventory/report/stock/summary', 'method' => 'GET'],
        ['uri' => 'api/inventory/report/stock/summary/search', 'method' => 'GET'],
        ['uri' => 'inventory/report/stock/summary', 'method' => 'GET'],
        ['uri' => 'inventory/report/stock/summary/search', 'method' => 'GET'],
    ],
    265 => [
        ['uri' => 'api/inventory/report/stock/details', 'method' => 'GET'],
        ['uri' => 'api/inventory/report/stock/details/search', 'method' => 'GET'],
        ['uri' => 'inventory/report/stock/details', 'method' => 'GET'],
        ['uri' => 'inventory/report/stock/details/search', 'method' => 'GET'],
    ],
    266 => [
        ['uri' => 'api/inventory/report/profitability/statement', 'method' => 'GET'],
        ['uri' => 'api/inventory/report/profitability/statement/search', 'method' => 'GET'],
        ['uri' => 'inventory/report/profitability/statement', 'method' => 'GET'],
        ['uri' => 'inventory/report/profitability/statement/search', 'method' => 'GET'],
    ],
    267 => [
        ['uri' => 'api/inventory/report/expiry/statement', 'method' => 'GET'],
        ['uri' => 'api/inventory/report/expiry/statement/search', 'method' => 'GET'],
        ['uri' => 'inventory/report/expiry/statement', 'method' => 'GET'],
        ['uri' => 'inventory/report/expiry/statement/search', 'method' => 'GET'],
    ],
    268 => [
        ['uri' => 'api/inventory/report/purchase/summary', 'method' => 'GET'],
        ['uri' => 'api/inventory/report/purchase/summary/search', 'method' => 'GET'],
        ['uri' => 'inventory/report/purchase/summary', 'method' => 'GET'],
        ['uri' => 'inventory/report/purchase/summary/search', 'method' => 'GET'],
    ],
    269 => [
        ['uri' => 'api/inventory/report/purchase/details', 'method' => 'GET'],
        ['uri' => 'api/inventory/report/purchase/details/search', 'method' => 'GET'],
        ['uri' => 'inventory/report/purchase/details', 'method' => 'GET'],
        ['uri' => 'inventory/report/purchase/details/search', 'method' => 'GET'],
    ],
    270 => [
        ['uri' => 'api/inventory/report/issue/summary', 'method' => 'GET'],
        ['uri' => 'api/inventory/report/issue/summary/search', 'method' => 'GET'],
        ['uri' => 'inventory/report/issue/summary', 'method' => 'GET'],
        ['uri' => 'inventory/report/issue/summary/search', 'method' => 'GET'],
    ],
    271 => [
        ['uri' => 'api/inventory/report/issue/details', 'method' => 'GET'],
        ['uri' => 'api/inventory/report/issue/details/search', 'method' => 'GET'],
        ['uri' => 'inventory/report/issue/details', 'method' => 'GET'],
        ['uri' => 'inventory/report/issue/details/search', 'method' => 'GET'],
    ],
    272 => [
        ['uri' => 'api/inventory/report/return/client/summary', 'method' => 'GET'],
        ['uri' => 'api/inventory/report/return/client/summary/search', 'method' => 'GET'],
        ['uri' => 'inventory/report/return/client/summary', 'method' => 'GET'],
        ['uri' => 'inventory/report/return/client/summary/search', 'method' => 'GET'],
    ],
    273 => [
        ['uri' => 'api/inventory/report/return/client/details', 'method' => 'GET'],
        ['uri' => 'api/inventory/report/return/client/details/search', 'method' => 'GET'],
        ['uri' => 'inventory/report/return/client/details', 'method' => 'GET'],
        ['uri' => 'inventory/report/return/client/details/search', 'method' => 'GET'],
    ],
    274 => [
        ['uri' => 'api/inventory/report/return/supplier/summary', 'method' => 'GET'],
        ['uri' => 'api/inventory/report/return/supplier/summary/search', 'method' => 'GET'],
        ['uri' => 'inventory/report/return/supplier/summary', 'method' => 'GET'],
        ['uri' => 'inventory/report/return/supplier/summary/search', 'method' => 'GET'],
    ],
    275 => [
        ['uri' => 'api/inventory/report/return/supplier/details', 'method' => 'GET'],
        ['uri' => 'api/inventory/report/return/supplier/details/search', 'method' => 'GET'],
        ['uri' => 'inventory/report/return/supplier/details', 'method' => 'GET'],
        ['uri' => 'inventory/report/return/supplier/details/search', 'method' => 'GET'],
    ],








    // ----------------------------- Reports & Queries Menu Permissions ----------------------------- //
    276 => [
        ['uri' => 'api/report/account/summary', 'method' => 'GET'],
        ['uri' => 'api/report/account/summary/search', 'method' => 'GET'],
        ['uri' => 'report/account/summary', 'method' => 'GET'],
        ['uri' => 'report/account/summary/search', 'method' => 'GET'],
    ],
    277 => [
        ['uri' => 'api/report/account/summarygroupe', 'method' => 'GET'],
        ['uri' => 'api/report/account/summarygroupe/search', 'method' => 'GET'],
        ['uri' => 'report/account/summarygroupe', 'method' => 'GET'],
        ['uri' => 'report/account/summarygroupe/search', 'method' => 'GET'],
    ],
    278 => [
        ['uri' => 'api/report/account/details', 'method' => 'GET'],
        ['uri' => 'api/report/account/details/search', 'method' => 'GET'],
        ['uri' => 'report/account/details', 'method' => 'GET'],
        ['uri' => 'report/account/details/search', 'method' => 'GET'],
    ],
    279 => [
        ['uri' => 'api/report/party/summary', 'method' => 'GET'],
        ['uri' => 'api/report/party/summary/search', 'method' => 'GET'],
        ['uri' => 'report/party/summary', 'method' => 'GET'],
        ['uri' => 'report/party/summary/search', 'method' => 'GET'],
    ],
    280 => [
        ['uri' => 'api/report/party/details', 'method' => 'GET'],
        ['uri' => 'api/report/party/details/search', 'method' => 'GET'],
        ['uri' => 'report/party/details', 'method' => 'GET'],
        ['uri' => 'report/party/details/search', 'method' => 'GET'],
    ],
    













    281 => [
        ['uri' => 'admin/locations', 'method' => 'POST'],
    ],
    282 => [
        ['uri' => 'admin/locations/edit', 'method' => 'GET'],
        ['uri' => 'admin/locations', 'method' => 'PUT'],
    ],
    283 => [
        ['uri' => 'admin/locations', 'method' => 'DELETE'],
    ],


    284 => [
        ['uri' => 'api/admin/banks', 'method' => 'POST'],
    ],
    285 => [
        ['uri' => 'api/admin/banks/edit', 'method' => 'GET'],
        ['uri' => 'api/admin/banks', 'method' => 'PUT'],
    ],
    286 => [
        ['uri' => 'api/admin/banks', 'method' => 'DELETE'],
    ],
    
    
    287 => [ 
        ['uri' => 'api/admin/payment_method', 'method' => 'GET'],
        ['uri' => 'api/admin/payment_method/search', 'method' => 'GET'],
        ['uri' => 'api/admin/payment_method/details', 'method' => 'GET'],
        ['uri' => 'admin/payment_method', 'method' => 'GET'],
        ['uri' => 'admin/payment_method/search', 'method' => 'GET'],
    ],
    288 => [
        ['uri' => 'api/admin/payment_method', 'method' => 'POST'],
    ],
    289 => [
        ['uri' => 'api/admin/payment_method/edit', 'method' => 'GET'],
        ['uri' => 'api/admin/payment_method', 'method' => 'PUT'],
    ],
    290 => [
        ['uri' => 'api/admin/payment_method', 'method' => 'DELETE'],
    ],
    
    
    291 => [ 
        ['uri' => 'api/admin/corporate', 'method' => 'GET'],
        ['uri' => 'api/admin/corporate/search', 'method' => 'GET'],
        ['uri' => 'api/admin/corporate/details', 'method' => 'GET'],
        ['uri' => 'admin/corporate', 'method' => 'GET'],
        ['uri' => 'admin/corporate/search', 'method' => 'GET'],
    ],
    292 => [
        ['uri' => 'api/admin/corporate', 'method' => 'POST'],
    ],
    293 => [
        ['uri' => 'api/admin/corporate/edit', 'method' => 'GET'],
        ['uri' => 'api/admin/corporate', 'method' => 'PUT'],
    ],
    294 => [
        ['uri' => 'api/admin/corporate', 'method' => 'DELETE'],
    ],
    
    







    ///////////////////////////
    295 => [ 
        ['uri' => 'api/hotel/setup/floor', 'method' => 'GET'],
        ['uri' => 'api/hotel/setup/floor/search', 'method' => 'GET'],
        ['uri' => 'api/hotel/setup/floor/details', 'method' => 'GET'],
        ['uri' => 'hotel/setup/floor', 'method' => 'GET'],
        ['uri' => 'hotel/setup/floor/search', 'method' => 'GET'],
    ],
    296 => [
        ['uri' => 'api/hotel/setup/floor', 'method' => 'POST'],
    ],
    297 => [
        ['uri' => 'api/hotel/setup/floor/edit', 'method' => 'GET'],
        ['uri' => 'api/hotel/setup/floor', 'method' => 'PUT'],
    ],
    298 => [
        ['uri' => 'api/hotel/setup/floor', 'method' => 'DELETE'],
    ],
    
    
    299 => [ 
        ['uri' => 'api/hotel/setup/roomcatagory', 'method' => 'GET'],
        ['uri' => 'api/hotel/setup/roomcatagory/search', 'method' => 'GET'],
        ['uri' => 'api/hotel/setup/roomcatagory/details', 'method' => 'GET'],
        ['uri' => 'hotel/setup/roomcatagory', 'method' => 'GET'],
        ['uri' => 'hotel/setup/roomcatagory/search', 'method' => 'GET'],
    ],
    300 => [
        ['uri' => 'api/hotel/setup/roomcatagory', 'method' => 'POST'],
    ],
    301 => [
        ['uri' => 'api/hotel/setup/roomcatagory/edit', 'method' => 'GET'],
        ['uri' => 'api/hotel/setup/roomcatagory', 'method' => 'PUT'],
    ],
    302 => [
        ['uri' => 'api/hotel/setup/roomcatagory', 'method' => 'DELETE'],
    ],
    
    
    303 => [ 
        ['uri' => 'api/hotel/setup/roomlist', 'method' => 'GET'],
        ['uri' => 'api/hotel/setup/roomlist/search', 'method' => 'GET'],
        ['uri' => 'api/hotel/setup/roomlist/details', 'method' => 'GET'],
        ['uri' => 'hotel/setup/roomlist', 'method' => 'GET'],
        ['uri' => 'hotel/setup/roomlist/search', 'method' => 'GET'],
    ],
    304 => [
        ['uri' => 'api/hotel/setup/roomlist', 'method' => 'POST'],
    ],
    305 => [
        ['uri' => 'api/hotel/setup/roomlist/edit', 'method' => 'GET'],
        ['uri' => 'api/hotel/setup/roomlist', 'method' => 'PUT'],
    ],
    306 => [
        ['uri' => 'api/hotel/setup/roomlist', 'method' => 'DELETE'],
    ],
    
    
    307 => [ 
        ['uri' => 'api/hotel/setup/groupe', 'method' => 'GET'],
        ['uri' => 'api/hotel/setup/groupe/search', 'method' => 'GET'],
        ['uri' => 'api/hotel/setup/groupe/details', 'method' => 'GET'],
        ['uri' => 'hotel/setup/groupe', 'method' => 'GET'],
        ['uri' => 'hotel/setup/groupe/search', 'method' => 'GET'],
    ],
    308 => [
        ['uri' => 'api/hotel/setup/groupe', 'method' => 'POST'],
    ],
    309 => [
        ['uri' => 'api/hotel/setup/groupe/edit', 'method' => 'GET'],
        ['uri' => 'api/hotel/setup/groupe', 'method' => 'PUT'],
    ],
    310 => [
        ['uri' => 'api/hotel/setup/groupe', 'method' => 'DELETE'],
    ],
    
    
    311 => [ 
        ['uri' => 'api/hotel/setup/service', 'method' => 'GET'],
        ['uri' => 'api/hotel/setup/service/search', 'method' => 'GET'],
        ['uri' => 'api/hotel/setup/service/details', 'method' => 'GET'],
        ['uri' => 'hotel/setup/service', 'method' => 'GET'],
        ['uri' => 'hotel/setup/service/search', 'method' => 'GET'],
    ],
    312 => [
        ['uri' => 'api/hotel/setup/service', 'method' => 'POST'],
    ],
    313 => [
        ['uri' => 'api/hotel/setup/service/edit', 'method' => 'GET'],
        ['uri' => 'api/hotel/setup/service', 'method' => 'PUT'],
    ],
    314 => [
        ['uri' => 'api/hotel/setup/service', 'method' => 'DELETE'],
    ],
    
    
    315 => [ 
        ['uri' => 'api/hotel/booking', 'method' => 'GET'],
        ['uri' => 'api/hotel/booking/search', 'method' => 'GET'],
        ['uri' => 'api/hotel/booking/details', 'method' => 'GET'],
        ['uri' => 'hotel/booking', 'method' => 'GET'],
        ['uri' => 'hotel/booking/search', 'method' => 'GET'],
    ],
    316 => [
        ['uri' => 'api/hotel/booking', 'method' => 'POST'],
    ],
    317 => [
        ['uri' => 'api/hotel/booking/edit', 'method' => 'GET'],
        ['uri' => 'api/hotel/booking', 'method' => 'PUT'],
    ],
    318 => [
        ['uri' => 'api/hotel/booking', 'method' => 'DELETE'],
    ],
    
    
    319 => [ 
        ['uri' => 'api/hotel/roomtransfer', 'method' => 'GET'],
        ['uri' => 'api/hotel/roomtransfer/search', 'method' => 'GET'],
        ['uri' => 'api/hotel/roomtransfer/details', 'method' => 'GET'],
        ['uri' => 'hotel/roomtransfer', 'method' => 'GET'],
        ['uri' => 'hotel/roomtransfer/search', 'method' => 'GET'],
    ],
    320 => [
        ['uri' => 'api/hotel/roomtransfer', 'method' => 'POST'],
    ],
    321 => [
        ['uri' => 'api/hotel/roomtransfer/edit', 'method' => 'GET'],
        ['uri' => 'api/hotel/roomtransfer', 'method' => 'PUT'],
    ],
    322 => [
        ['uri' => 'api/hotel/roomtransfer', 'method' => 'DELETE'],
    ],
    
    
    323 => [ 
        ['uri' => 'api/hotel/roomstatus', 'method' => 'GET'],
        ['uri' => 'api/hotel/roomstatus/search', 'method' => 'GET'],
        ['uri' => 'api/hotel/roomstatus/details', 'method' => 'GET'],
        ['uri' => 'hotel/roomstatus', 'method' => 'GET'],
        ['uri' => 'hotel/roomstatus/search', 'method' => 'GET'],
    ],
    324 => [
        ['uri' => 'api/hotel/roomstatus', 'method' => 'POST'],
    ],
    325 => [
        ['uri' => 'api/hotel/roomstatus/edit', 'method' => 'GET'],
        ['uri' => 'api/hotel/roomstatus', 'method' => 'PUT'],
    ],
    326 => [
        ['uri' => 'api/hotel/roomstatus', 'method' => 'DELETE'],
    ],
    
    
    327 => [ 
        ['uri' => 'api/hotel/users/guests', 'method' => 'GET'],
        ['uri' => 'api/hotel/users/guests/search', 'method' => 'GET'],
        ['uri' => 'api/hotel/users/guests/details', 'method' => 'GET'],
        ['uri' => 'hotel/users/guests', 'method' => 'GET'],
        ['uri' => 'hotel/users/guests/search', 'method' => 'GET'],
    ],
    328 => [
        ['uri' => 'api/hotel/users/guests', 'method' => 'POST'],
    ],
    329 => [
        ['uri' => 'api/hotel/users/guests/edit', 'method' => 'GET'],
        ['uri' => 'api/hotel/users/guests', 'method' => 'PUT'],
    ],
    330 => [
        ['uri' => 'api/hotel/users/guests', 'method' => 'DELETE'],
    ],
    
    
    331 => [ 
        ['uri' => 'api/hotel/transaction/services', 'method' => 'GET'],
        ['uri' => 'api/hotel/transaction/services/search', 'method' => 'GET'],
        ['uri' => 'api/hotel/transaction/services/details', 'method' => 'GET'],
        ['uri' => 'hotel/transaction/services', 'method' => 'GET'],
        ['uri' => 'hotel/transaction/services/search', 'method' => 'GET'],
    ],
    332 => [
        ['uri' => 'api/hotel/transaction/services', 'method' => 'POST'],
    ],
    333 => [
        ['uri' => 'api/hotel/transaction/services/edit', 'method' => 'GET'],
        ['uri' => 'api/hotel/transaction/services', 'method' => 'PUT'],
    ],
    334 => [
        ['uri' => 'api/hotel/transaction/services', 'method' => 'DELETE'],
    ],
    
    
    335 => [ 
        ['uri' => 'api/hotel/transaction/deposits', 'method' => 'GET'],
        ['uri' => 'api/hotel/transaction/deposits/search', 'method' => 'GET'],
        ['uri' => 'api/hotel/transaction/deposits/details', 'method' => 'GET'],
        ['uri' => 'hotel/transaction/deposits', 'method' => 'GET'],
        ['uri' => 'hotel/transaction/deposits/search', 'method' => 'GET'],
    ],
    336 => [
        ['uri' => 'api/hotel/transaction/deposits', 'method' => 'POST'],
    ],
    337 => [
        ['uri' => 'api/hotel/transaction/deposits/edit', 'method' => 'GET'],
        ['uri' => 'api/hotel/transaction/deposits', 'method' => 'PUT'],
    ],
    338 => [
        ['uri' => 'api/hotel/transaction/deposits', 'method' => 'DELETE'],
    ],
    
    
    339 => [ 
        ['uri' => 'api/hotel/transaction/refunds', 'method' => 'GET'],
        ['uri' => 'api/hotel/transaction/refunds/search', 'method' => 'GET'],
        ['uri' => 'api/hotel/transaction/refunds/details', 'method' => 'GET'],
        ['uri' => 'hotel/transaction/refunds', 'method' => 'GET'],
        ['uri' => 'hotel/transaction/refunds/search', 'method' => 'GET'],
    ],
    340 => [
        ['uri' => 'api/hotel/transaction/refunds', 'method' => 'POST'],
    ],
    341 => [
        ['uri' => 'api/hotel/transaction/refunds/edit', 'method' => 'GET'],
        ['uri' => 'api/hotel/transaction/refunds', 'method' => 'PUT'],
    ],
    342 => [
        ['uri' => 'api/hotel/transaction/refunds', 'method' => 'DELETE'],
    ],
    
    
    343 => [ 
        ['uri' => 'api/hotel/billsettlement', 'method' => 'GET'],
        ['uri' => 'api/hotel/billsettlement/search', 'method' => 'GET'],
        ['uri' => 'api/hotel/billsettlement/details', 'method' => 'GET'],
        ['uri' => 'hotel/billsettlement', 'method' => 'GET'],
        ['uri' => 'hotel/billsettlement/search', 'method' => 'GET'],
    ],
    344 => [
        ['uri' => 'api/hotel/billsettlement', 'method' => 'POST'],
    ],
    345 => [
        ['uri' => 'api/hotel/billsettlement/edit', 'method' => 'GET'],
        ['uri' => 'api/hotel/billsettlement', 'method' => 'PUT'],
    ],





/////////////////////////Hospital////////////////////////////////////////////


    346 => [ 
        ['uri' => 'api/hospital/setup/specialization', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/specialization/search', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/specialization/details', 'method' => 'GET'],
        ['uri' => 'hospital/setup/specialization', 'method' => 'GET'],
        ['uri' => 'hospital/setup/specialization/search', 'method' => 'GET'],
    ],
    347 => [
        ['uri' => 'api/hospital/setup/specialization', 'method' => 'POST'],
    ],
    348 => [
        ['uri' => 'api/hospital/setup/specialization/edit', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/specialization', 'method' => 'PUT'],
    ],
    349 => [
        ['uri' => 'api/hospital/setup/specialization', 'method' => 'DELETE'],
    ],


    350 => [ 
        ['uri' => 'api/hospital/setup/floor', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/floor/search', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/floor/details', 'method' => 'GET'],
        ['uri' => 'hospital/setup/floor', 'method' => 'GET'],
        ['uri' => 'hospital/setup/floor/search', 'method' => 'GET'],
    ],
    351 => [
        ['uri' => 'api/hospital/setup/floor', 'method' => 'POST'],
    ],
    352 => [
        ['uri' => 'api/hospital/setup/floor/edit', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/floor', 'method' => 'PUT'],
    ],
    353 => [
        ['uri' => 'api/hospital/setup/floor', 'method' => 'DELETE'],
    ],


    354 => [ 
        ['uri' => 'api/hospital/setup/nursingstation', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/nursingstation/search', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/nursingstation/details', 'method' => 'GET'],
        ['uri' => 'hospital/setup/nursingstation', 'method' => 'GET'],
        ['uri' => 'hospital/setup/nursingstation/search', 'method' => 'GET'],
    ],
    355 => [
        ['uri' => 'api/hospital/setup/nursingstation', 'method' => 'POST'],
    ],
    356 => [
        ['uri' => 'api/hospital/setup/nursingstation/edit', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/nursingstation', 'method' => 'PUT'],
    ],
    357 => [
        ['uri' => 'api/hospital/setup/nursingstation', 'method' => 'DELETE'],
    ],


    358 => [ 
        ['uri' => 'api/hospital/setup/bedcategory', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/bedcategory/search', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/bedcategory/details', 'method' => 'GET'],
        ['uri' => 'hospital/setup/bedcategory', 'method' => 'GET'],
        ['uri' => 'hospital/setup/bedcategory/search', 'method' => 'GET'],
    ],
    359 => [
        ['uri' => 'api/hospital/setup/bedcategory', 'method' => 'POST'],
    ],
    360 => [
        ['uri' => 'api/hospital/setup/bedcategory/edit', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/bedcategory', 'method' => 'PUT'],
    ],
    361 => [
        ['uri' => 'api/hospital/setup/bedcategory', 'method' => 'DELETE'],
    ],


    362 => [ 
        ['uri' => 'api/hospital/setup/bedlist', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/bedlist/search', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/bedlist/details', 'method' => 'GET'],
        ['uri' => 'hospital/setup/bedlist', 'method' => 'GET'],
        ['uri' => 'hospital/setup/bedlist/search', 'method' => 'GET'],
    ],
    363 => [
        ['uri' => 'api/hospital/setup/bedlist', 'method' => 'POST'],
    ],
    364 => [
        ['uri' => 'api/hospital/setup/bedlist/edit', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/bedlist', 'method' => 'PUT'],
    ],
    365 => [
        ['uri' => 'api/hospital/setup/bedlist', 'method' => 'DELETE'],
    ],



    366 => [ 
        ['uri' => 'api/hospital/setup/groupe', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/groupe/search', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/groupe/details', 'method' => 'GET'],
        ['uri' => 'hospital/setup/groupe', 'method' => 'GET'],
        ['uri' => 'hospital/setup/groupe/search', 'method' => 'GET'],
    ],
    367 => [
        ['uri' => 'api/hospital/setup/groupe', 'method' => 'POST'],
    ],
    368 => [
        ['uri' => 'api/hospital/setup/groupe/edit', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/groupe', 'method' => 'PUT'],
    ],
    369 => [
        ['uri' => 'api/hospital/setup/groupe', 'method' => 'DELETE'],
    ],



    370 => [ 
        ['uri' => 'api/hospital/setup/services', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/services/search', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/services/details', 'method' => 'GET'],
        ['uri' => 'hospital/setup/services', 'method' => 'GET'],
        ['uri' => 'hospital/setup/services/search', 'method' => 'GET'],
    ],
    371 => [
        ['uri' => 'api/hospital/setup/services', 'method' => 'POST'],
    ],
    372 => [
        ['uri' => 'api/hospital/setup/services/edit', 'method' => 'GET'],
        ['uri' => 'api/hospital/setup/services', 'method' => 'PUT'],
    ],
    373 => [
        ['uri' => 'api/hospital/setup/services', 'method' => 'DELETE'],
    ],




    374 => [ 
        ['uri' => 'api/hospital/ptnappointment', 'method' => 'GET'],
        ['uri' => 'api/hospital/ptnappointment/search', 'method' => 'GET'],
        ['uri' => 'api/hospital/ptnappointment/details', 'method' => 'GET'],
        ['uri' => 'hospital/ptnappointment', 'method' => 'GET'],
        ['uri' => 'hospital/ptnappointment/search', 'method' => 'GET'],
    ],
    375 => [
        ['uri' => 'api/hospital/ptnappointment', 'method' => 'POST'],
    ],
    376 => [
        ['uri' => 'api/hospital/ptnappointment/edit', 'method' => 'GET'],
        ['uri' => 'api/hospital/ptnappointment', 'method' => 'PUT'],
    ],
    377 => [
        ['uri' => 'api/hospital/ptnappointment', 'method' => 'DELETE'],
    ],



    378 => [ 
        ['uri' => 'api/hospital/ptnregistration', 'method' => 'GET'],
        ['uri' => 'api/hospital/ptnregistration/search', 'method' => 'GET'],
        ['uri' => 'api/hospital/ptnregistration/details', 'method' => 'GET'],
        ['uri' => 'hospital/ptnregistration', 'method' => 'GET'],
        ['uri' => 'hospital/ptnregistration/search', 'method' => 'GET'],
    ],
    379 => [
        ['uri' => 'api/hospital/ptnregistration', 'method' => 'POST'],
    ],
    380 => [
        ['uri' => 'api/hospital/ptnregistration/edit', 'method' => 'GET'],
        ['uri' => 'api/hospital/ptnregistration', 'method' => 'PUT'],
    ],
    381 => [
        ['uri' => 'api/hospital/ptnregistration', 'method' => 'DELETE'],
    ],



    382 => [ 
        ['uri' => 'api/hospital/bedtransfer', 'method' => 'GET'],
        ['uri' => 'api/hospital/bedtransfer/search', 'method' => 'GET'],
        ['uri' => 'api/hospital/bedtransfer/details', 'method' => 'GET'],
        ['uri' => 'hospital/bedtransfer', 'method' => 'GET'],
        ['uri' => 'hospital/bedtransfer/search', 'method' => 'GET'],
    ],
    383 => [
        ['uri' => 'api/hospital/bedtransfer', 'method' => 'POST'],
    ],
    384 => [
        ['uri' => 'api/hospital/bedtransfer/edit', 'method' => 'GET'],
        ['uri' => 'api/hospital/bedtransfer', 'method' => 'PUT'],
    ],
    385 => [
        ['uri' => 'api/hospital/bedtransfer', 'method' => 'DELETE'],
    ],



    386 => [ 
        ['uri' => 'api/hospital/bedstatus', 'method' => 'GET'],
        ['uri' => 'api/hospital/bedstatus/search', 'method' => 'GET'],
        ['uri' => 'api/hospital/bedstatus/details', 'method' => 'GET'],
        ['uri' => 'hospital/bedstatus', 'method' => 'GET'],
        ['uri' => 'hospital/bedstatus/search', 'method' => 'GET'],
    ],
    387 => [
        ['uri' => 'api/hospital/bedstatus', 'method' => 'POST'],
    ],
    388 => [
        ['uri' => 'api/hospital/bedstatus/edit', 'method' => 'GET'],
        ['uri' => 'api/hospital/bedstatus', 'method' => 'PUT'],
    ],
    389 => [
        ['uri' => 'api/hospital/bedstatus', 'method' => 'DELETE'],
    ],





    390 => [ 
        ['uri' => 'api/hospital/users/doctors', 'method' => 'GET'],
        ['uri' => 'api/hospital/users/doctors/search', 'method' => 'GET'],
        ['uri' => 'api/hospital/users/doctors/details', 'method' => 'GET'],
        ['uri' => 'hospital/users/doctors', 'method' => 'GET'],
        ['uri' => 'hospital/users/doctors/search', 'method' => 'GET'],
    ],
    391 => [
        ['uri' => 'api/hospital/users/doctors', 'method' => 'POST'],
    ],
    392 => [
        ['uri' => 'api/hospital/users/doctors/edit', 'method' => 'GET'],
        ['uri' => 'api/hospital/users/doctors', 'method' => 'PUT'],
    ],
    393 => [
        ['uri' => 'api/hospital/users/doctors', 'method' => 'DELETE'],
    ], 


    394 => [ 
        ['uri' => 'api/hospital/users/patients', 'method' => 'GET'],
        ['uri' => 'api/hospital/users/patients/search', 'method' => 'GET'],
        ['uri' => 'api/hospital/users/patients/details', 'method' => 'GET'],
        ['uri' => 'hospital/users/patients', 'method' => 'GET'],
        ['uri' => 'hospital/users/patients/search', 'method' => 'GET'],
    ],
    395 => [
        ['uri' => 'api/hospital/users/patients', 'method' => 'POST'],
    ],
    396 => [
        ['uri' => 'api/hospital/users/patients/edit', 'method' => 'GET'],
        ['uri' => 'api/hospital/users/patients', 'method' => 'PUT'],
    ],
    397 => [
        ['uri' => 'api/hospital/users/patients', 'method' => 'DELETE'],
    ], 


    398 => [ 
        ['uri' => 'api/hospital/transaction/admission', 'method' => 'GET'],
        ['uri' => 'api/hospital/transaction/admission/search', 'method' => 'GET'],
        ['uri' => 'api/hospital/transaction/admission/details', 'method' => 'GET'],
        ['uri' => 'hospital/transaction/admission', 'method' => 'GET'],
        ['uri' => 'hospital/transaction/admission/search', 'method' => 'GET'],
    ],
    399 => [
        ['uri' => 'api/hospital/transaction/admission', 'method' => 'POST'],
    ],
    400 => [
        ['uri' => 'api/hospital/transaction/admission/edit', 'method' => 'GET'],
        ['uri' => 'api/hospital/transaction/admission', 'method' => 'PUT'],
    ],
    401 => [
        ['uri' => 'api/hospital/transaction/admission', 'method' => 'DELETE'],
    ], 


    402 => [ 
        ['uri' => 'api/hospital/transaction/deposit', 'method' => 'GET'],
        ['uri' => 'api/hospital/transaction/deposit/search', 'method' => 'GET'],
        ['uri' => 'api/hospital/transaction/deposit/details', 'method' => 'GET'],
        ['uri' => 'hospital/transaction/deposit', 'method' => 'GET'],
        ['uri' => 'hospital/transaction/deposit/search', 'method' => 'GET'],
    ],
    403 => [
        ['uri' => 'api/hospital/transaction/deposit', 'method' => 'POST'],
    ],
    404 => [
        ['uri' => 'api/hospital/transaction/deposit/edit', 'method' => 'GET'],
        ['uri' => 'api/hospital/transaction/deposit', 'method' => 'PUT'],
    ],
    405 => [
        ['uri' => 'api/hospital/transaction/deposit', 'method' => 'DELETE'],
    ], 


    406 => [ 
        ['uri' => 'api/hospital/transaction/depositrefund', 'method' => 'GET'],
        ['uri' => 'api/hospital/transaction/depositrefund/search', 'method' => 'GET'],
        ['uri' => 'api/hospital/transaction/depositrefund/details', 'method' => 'GET'],
        ['uri' => 'hospital/transaction/depositrefund', 'method' => 'GET'],
        ['uri' => 'hospital/transaction/depositrefund/search', 'method' => 'GET'],
    ],
    407 => [
        ['uri' => 'api/hospital/transaction/depositrefund', 'method' => 'POST'],
    ],
    408 => [
        ['uri' => 'api/hospital/transaction/depositrefund/edit', 'method' => 'GET'],
        ['uri' => 'api/hospital/transaction/depositrefund', 'method' => 'PUT'],
    ],
    409 => [
        ['uri' => 'api/hospital/transaction/depositrefund', 'method' => 'DELETE'],
    ], 


    410 => [ 
        ['uri' => 'api/hospital/transaction/services', 'method' => 'GET'],
        ['uri' => 'api/hospital/transaction/services/search', 'method' => 'GET'],
        ['uri' => 'api/hospital/transaction/services/details', 'method' => 'GET'],
        ['uri' => 'hospital/transaction/services', 'method' => 'GET'],
        ['uri' => 'hospital/transaction/services/search', 'method' => 'GET'],
    ],
    411 => [
        ['uri' => 'api/hospital/transaction/services', 'method' => 'POST'],
    ],
    412 => [
        ['uri' => 'api/hospital/transaction/services/edit', 'method' => 'GET'],
        ['uri' => 'api/hospital/transaction/services', 'method' => 'PUT'],
    ],
    413 => [
        ['uri' => 'api/hospital/transaction/services', 'method' => 'DELETE'],
    ],
    
];