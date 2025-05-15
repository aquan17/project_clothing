<?php

namespace App\Http\Controllers\client\blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BLogController extends Controller
{
    public function about(){
        return view('client.blog.about_us');
    }
    public function purchase(){
        return view('client.blog.purchase-guide');
    }
    public function ecommerce(){
        return view('client.blog.ecommerce-faq');
    }
    public function privacy(){
        return view('client.blog.privacy-policy');
    }
    public function terms(){
        return view('client.blog.terms-conditions');
    }
    public function contact(){
        return view('client.blog.contact_us');
    }
}
