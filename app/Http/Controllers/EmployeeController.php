<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::paginate(5);
        return view('employees.index', ['employees' => $employees]);
    }
    public function show($id)
    {
        $employee = Employee::find($id);
        return view('employees.show', ['employee' => $employee]);
    }
    public function create()
    {
        return view('employees.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'isbn' => 'required|min:8|unique:Employees'
        ]);
        Employee::create([
            'name' => $request->name,
            'isbn' => $request->isbn,
            'price' => $request->price,
            'quantity' => $request->quantity
        ]);
        Session::flash('success', 'Employees added sucessfully');
        return back();
    }
    public function edit($id)
    {
        $employee = Employee::find($id);
        return view('employees.edit', ['Employee' => $Employee]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'isbn' => 'required|min:8|unique:Employees'
        ]);
        Employee::where('id', $id)->update([
            'name' => $request->name,
            'isbn' => $request->isbn,
            'price' => $request->price,
            'quantity' => $request->quantity
        ]);
        Session::flash('success', 'Employees updated sucessfully');
        return back();
    }
    public function destroy($id)
    {
        Employee::where('id', $id)->delete();
        Session::flash('success', 'Employees deleted sucessfully');
        return back();
    }
    public function search(Request $request)
    {
        $name = $request->name;
        $Employees = Employee::where('name', 'like', '%' . $name . '%')->paginate(5);
        return view('employees.index', ['Employees' => $Employees]);
    }
    public function generatePdf()
    {
        $Employees = Employee::get();
        $pdf = PDF::loadView('Employees.download', compact('Employees'));
        return $pdf->download('employees.pdf');
    }
}
