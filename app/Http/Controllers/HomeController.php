<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookNotify;
use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceReview;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserFav;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $date = now();
        $Jan = now()->subMonth(1);
        $Feb = now()->subMonth(12);
        $Mar = now()->subMonth(11);
        $Apr = now()->subMonth(10);
        $May = now()->subMonth(9);
        $Jun = now()->subMonth(8);
        $Jul = now()->subMonth(7);
        $Aug = now()->subMonth(6);
        $Sep = now()->subMonth(5);
        $Oct = now()->subMonth(4);
        $Nov = now()->subMonth(3);
        $Dec = now()->subMonth(2);
//        dd($Feb);

        $book1  = Booking::whereDate('created_at', '=', date('Y-m-d'))->sum('total');
        $book2 = Booking::whereBetween('created_at', [$Jan, $date])->sum('total');
        $book3 = Booking::whereBetween('created_at', [$Feb, $Jan])->sum('total');
        $book4 = Booking::whereBetween('created_at', [$Mar, $Feb])->sum('total');
        $book5 = Booking::whereBetween('created_at', [$Apr, $Mar])->sum('total');
        $book6 = Booking::whereBetween('created_at', [$May, $Apr])->sum('total');
        $book7 = Booking::whereBetween('created_at', [$Jun, $May])->sum('total');
        $book8 = Booking::whereBetween('created_at', [$Jul, $Jun])->sum('total');
        $book9 = Booking::whereBetween('created_at', [$Aug, $Jul])->sum('total');
        $book10 = Booking::whereBetween('created_at', [$Sep, $Aug])->sum('total');
        $book11 = Booking::whereBetween('created_at', [$Oct, $Sep])->sum('total');
        $book12 = Booking::whereBetween('created_at', [$Nov, $Oct])->sum('total');
        $book13 = Booking::whereBetween('created_at', [$Dec, $Nov])->sum('total');
        $book14 = Booking::whereBetween('created_at', [$date, $Dec])->sum('total');

//        dd($book14);
        $lang = app()->getLocale();
        $user =User::where('role_id',2)->count();
        $pro =User::where('role_id',3)->count();
        $serv =Service::where('lang',$lang)->count();
        $earning=Booking::where('accept',1)->sum('total');

        $book =Booking::where('accept',1)->count();
        $cat =Category::where('lang',$lang)->count();
        $notify=BookNotify::all()->count();
        $rev =ServiceReview::where('accept',1)->count();
        $add =UserAddress::all()->count();
        $fav =UserFav::all()->count();
        return view('admin.home',compact('user','pro','cat','serv','book','earning','notify','rev','add','fav','book1','book2','book3','book4','book5','book6','book7','book8','book9','book10','book11','book12','book13','book14'));

//        return view('admin.home');
    }
}
