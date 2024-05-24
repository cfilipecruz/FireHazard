<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Fluid_type;
use App\Models\Intervention;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class TablesController extends Controller
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
     * @return Renderable
     */
//View Tables
    public function tables()
    {
        return view('tables');
    }

    //----------------------------------Fluids----------------------------------------
//View Fluids
    public function fluids()
    {
        $fluids = Fluid_type::orderByDesc('id')->paginate(5);
        $interventions = Intervention::all();

        return view('tables.fluids')->with(['fluids' => $fluids,
            'interventions' => $interventions,
        ]);
    }

//Create Fluid
    public function fluidsCreate(Request $request)
    {
        $fluid = new Fluid_type();

        $fluid->name = $request->name;
        $fluid->description = $request->description;

        $fluid->save();

        return redirect()->route('fluids')->with('success', 'Fluid type created successfully.');
    }

//View Fluid with id
    public function fluid($id)
    {
        $fluid = Fluid_type::find($id);
        $interventionsCount = $fluid->interventions()->count();

        return view('tables.fluid')->with(['fluid' => $fluid,
            'interventionsCount' => $interventionsCount
        ]);
    }


    public function fluidUpdate(Request $request, $id)
    {
        // Find the car to update
        $fluid = Fluid_type::find($id);

        // Update the car properties
        $fluid->name = $request->name;
        $fluid->description = $request->description;

        // Save the updated car to the database
        $fluid->save();

        // Redirect back to the car list
        return redirect()->back();
    }

    public function fluidDelete($id)
    {
        $fluid = Fluid_Type::find($id);

        $fluid->delete();

        return redirect()->action([TablesController::class, 'fluids']);

    }

//--------------------------------------------------Cars------------------------------------------------------------
//View Cars
    public function cars()
    {
        $cars = Car::orderByDesc('id')->paginate(5);
        $interventions = Intervention::all();

        return view('tables.cars')->with(['cars' => $cars,
            'interventions' => $interventions,
        ]);
    }

//Create Cars
    public function carsCreate(Request $request)
    {
        $car = new Car();

        $car->brand = $request->brand;
        $car->model = $request->model;
        $car->licensePlate = $request->licensePlate;

        $car->save();

        return redirect()->action([TablesController::class, 'cars']);
    }

//View Car with id
    public function car($id)
    {
        $car = Car::find($id);
        $interventionsCount = $car->interventions()->count();

        return view('tables.car')->with(['car' => $car,
            'interventionsCount' => $interventionsCount
        ]);
    }

    //Edit Cars
    public function carUpdate(Request $request, $id)
    {
        // Find the car to update
        $car = Car::find($id);

        // Update the car properties
        $car->brand = $request->brand;
        $car->model = $request->model;
        $car->licensePlate = $request->licensePlate;

        // Save the updated car to the database
        $car->save();

        // Redirect back to the car list
        return redirect()->back();
    }

    // Verify License Plate in edit cars
    public function checkPlateEdit(Request $request)
    {
        $licensePlate = $request->licensePlate;
        $carId = $request->carId;

        $car = Car::where('licensePlate', 'like', $licensePlate)
            ->where('id', '!=', $carId)
            ->first();

        return response()->json([
            'exists' => $car
        ]);
    }

    //Verify License Plate
    public function checkPlate(Request $request)
    {
        $licensePlate = $request->licensePlate;
        //dd($licensePlate);
        $car = Car::where('licensePlate', 'like', $licensePlate)->first();
        // dd($car);
        return response()->json([
            'exists' => $car
        ]);
    }

    public function carDelete($id)
    {
        $car = car::find($id);

        $car->delete();

        return redirect()->action([TablesController::class, 'cars']);

    }
}
