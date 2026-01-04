<?php namespace App\Http\Controllers;

use Input;
use Sentinel;
use Session;
use DB;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function loginView()
	{
		try{
			if(!Sentinel::check()){
				return view('layouts.sammy_new.login');
			}else{
				$redirect = Session::get('loginRedirect', '');
				Session::forget('loginRedirect');

				return redirect($redirect);
			}
		}catch(\Exception $e){
			return view('layouts.sammy_new.login')->withErrors(['login' => $e->getMessage()]);
		}
	}

	public function login()
	{

		$credentials = array(
			'username'    => Input::get('username'),
			'password' => Input::get('password')
		);

		if(Input::get('remember')){
			$remember = true;
		}
		else{
			$remember = false;
		}

		try{
			$users = DB::table('user')->where(['username' => Input::get('username'), 'status' => 1, 'varified_status' => 1])->first();
			if($users){
				$user = Sentinel::authenticate($credentials, $remember);
				if ($user){
					$redirect = Session::get('loginRedirect', '');
					Session::forget('loginRedirect');

					return redirect($redirect);

				}else{
					$msg = 'Invalid username/password. Try again!';
				}
			}else{
				$msg = "User account pending for approval.";
			}

		}catch(\Exception $e){
			$msg = $e->getMessage();
		}
		return redirect()->route('user.login')->withErrors(array(
				'login' => $msg))->withInput(Input::except('password'));
	}

	/*
	*	@method logout()
	*	@description Logging out the logged in user
	*	@return URL redirection
	*/
	public function logout(){
		 Sentinel::logout();
		 return redirect()->route('user.login');

	}

}
