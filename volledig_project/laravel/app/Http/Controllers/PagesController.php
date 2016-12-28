<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use App\Http\Requests;
use Auth;
use DB;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$vakantie = DB::table('vakanties')->get();
		return view('index', compact('vakantie'));
    }
	
	public function vorige_pagina()
	{
		return redirect()->intended('index.php');
	}
	
	public function individueel()
    {
		return view('individueel');
    }
	
	public function vlucht_verblijf()
    {
		return view('vlucht_verblijf');
    }
	
	public function citytrips()
    {
		$citytrips = DB::table('vakanties')->where('type', 'citytrips')->get();
		return view('citytrips', compact('citytrips'));
    }
	
	public function ski()
    {
		$ski = DB::table('vakanties')->where('type', 'ski')->get();
		return view('ski', compact('ski'));
    }
	
	public function all_in()
    {
		return view('all_in');
    }
	
	public function groepen()
    {
		return view('groepen');
    }
	
	public function boeken($id)
    {
		$vakdata = DB::table('vakanties')->where('id', $id)->first();
		$kamerdata = DB::table('kamers')->where('reisID', $id)->get();
		return view('boeken', compact('vakdata', 'kamerdata'));
    }
	
	public function betalen($kamerTypes, $aantPers, $reisID, $totaalPrijs, $daterange)
	{
		$gebruikerID = Auth::id();
		DB::insert('insert into boekingen (gebruikerID, kamerTypes, personen, reisID, totaalPrijs, daterange) values (?, ?, ?, ?, ?, ?)', [$gebruikerID, $kamerTypes, $aantPers, $reisID, $totaalPrijs, $daterange]);
		return redirect('/');
	}
	
	public function login()
    {
		return view('auth/login');
    }
	
	public function register()
    {
		return view('auth/register');
    }
	
	public function toonVakantie($id)
    {
		$vakdata = DB::table('vakanties')->where('id', $id)->first();
		$kamerdata = DB::table('kamers')->where('reisID', $id)->get();
		return view('vakantie', compact('vakdata', 'kamerdata'));
    }
}
