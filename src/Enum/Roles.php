<?php 

namespace App\Enum;

enum Roles: string{
    case ADMIN = 'admin';
    case CUSTOMER = 'customer';
    case ACCUNTANT = 'accountant';
}