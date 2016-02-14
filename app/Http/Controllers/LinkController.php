<?php

namespace App\Http\Controllers;

use App\Link;
use Redirect;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Product;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * [showRefLink description]
     * Route::get('{link?}', ['as' => 'reflink', 'uses' => 'LinkController@showRefLink']);
     *
     * @param [text] $link [referral link]
     *
     * @return [json] [all info about the link]
     */
     public function showRefLink($link = null)
     {
        // if Link is not Active! refer the link of the Next Active Upline
         if(!Link::findByLink($link)->active){ // if Link Not Active!
            $sponsor = Link::findByLink($link);
            $sp_lid = $sponsor->id;
            $sp_lid= $sponsor->activeSponsor($sp_lid);
            
            try {
             // If has $Link then Look in Database if Exist
            $link  = Link::find($sp_lid)->load('user.profile');

            // $splink = $link->toArray();
            $splink = [];
            $splink['id'] = $link->id;
            $splink['user_id'] = $link->user_id;
            $splink['link'] = $link->link;
            $product = Product::find(1);
            
            // Note Cookie Wont Be Created if Exceeded More than 4kb
            $cookie = \Cookie::queue('sponsor', $splink, 2628000);

            // Return Referral View with Variable Link
              return view('pages.referralLink')->with(compact('link','product'));

        // If No Record Found Throw Exception!
         } catch (ModelNotFoundException $e) {
             // Return Back to Home
        return Redirect::to('/');

            // return view('nosponsor');
         }

            }
        //  // If it has a Sponsor Cookie
         if (\Cookie::has('sponsor')) {
            $cookie = \Cookie::get('sponsor');
            $link = $cookie['link'];
            if(Link::findByLink($link)->active){
            $link  = Link::findByLink($link)->load('user.profile');
            $product = Product::find(1);
             return view('pages.referralLink')->with(compact('link','product')); 
            }
            
         }
         if (is_null($link)) {
             return Redirect::to('/'); // Redirect To HomePage
         }

         try {
             // If has $Link then Look in Database if Exist
            $link  = Link::findByLink($link)->load('user.profile');

            // $splink = $link->toArray();
            $splink = [];
            $splink['id'] = $link->id;
            $splink['user_id'] = $link->user_id;
            $splink['link'] = $link->link;
            $product = Product::find(1);
            
            // Note Cookie Wont Be Created if Exceeded More than 4kb
            $cookie = \Cookie::queue('sponsor', $splink, 2628000);

            // Return Referral View with Variable Link
              return view('pages.referralLink')->with(compact('link','product'));

        // If No Record Found Throw Exception!
         } catch (ModelNotFoundException $e) {
             // Return Back to Home
        return Redirect::to('/');

            // return view('nosponsor');
         }
     }

}
