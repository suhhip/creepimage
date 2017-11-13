<?php
namespace App\Http\Controllers;

class MainController extends Controller
{
	public function encreeptionView()
	{
		return view('encreeption');
	}

	public function decreeptionView()
	{
		return view('decreeption');
	}

	public function redirToEncreeption()
	{
		return redirect('encreeption');
	}
}
