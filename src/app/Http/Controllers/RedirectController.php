<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function toLogin(){
        return redirect(route('parttimer.login'));
    }
    // public function toRegister(){
    //     return redirect(route('parttimer.register'));
    // }
    public function toRegister(){
        return redirect(route('admin.register'));
    }
    
}
