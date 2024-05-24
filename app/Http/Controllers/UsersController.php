<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use App\Models\user;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class usersController extends Controller
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

    public function user($id)
    {
        $user = User::find($id);
        $interventionsCount = $user->interventions()->count();

        return view('tables.user')->with([
            'user' => $user,
            'interventionsCount' => $interventionsCount
        ]);
    }

    public function userUpdate(Request $request, $id)
    {

        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;

        $user->update();

        return redirect()->back();
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */

    public function users()
    {
        $users = User::paginate(10);
        $interventions = Intervention::all();


        return view('tables.users')->with(['users' => $users, 'interventions' => $interventions,]);
    }

    public function userDelete($id)
    {
        $user = User::find($id);

        $user->delete();

        return redirect()->action([UsersController::class, 'users']);

    }

    public function userCreate(Request $request)
    {
        // dd($request->all());

        $user = new User();

        $validatedData = $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
            ],
            'name' => 'required',
            'password' => 'required|min:8',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();

        return redirect()->back();
    }

    public function employees(Request $request)
    {
        $employees = User::where('departamento_id', $request->departamento_id)->get();
        return response()->json($employees);
    }

    public function checkusernameEmail(Request $request)
    {

        $email = $request->input('email');

        $email_exists = User::where('email', $email)->exists();

        return response()->json(['email_exists' => $email_exists]);
    }
}


