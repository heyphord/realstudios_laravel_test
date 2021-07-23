<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\EmployeeResource;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EmployeeResource::collection(Employee::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'first_name'=>'required',                                   
            'last_name'=>'required',                                   
            'email'=>'email|unique:employees',                                   
            'company_id'=>'exists:companies,id',                                   
        ]);

        if ($validator->fails()){ return response()->json(['message'=>$validator->errors()->first()], 400);  }
        
        try {
            //add request data to DB
           
    
            $employee = Employee::create( $request->all());

            //todo send email after employee has been created
    
            return EmployeeResource::make($employee);
    
        } catch (\Exception $e){
            return response()->json(['message'=>$e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        try {
            return EmployeeResource::make($employee);
    
        } catch (\Exception $e){
            return response()->json(['message'=>$e->getMessage()], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        try {
            $employee->update( $request->all());
            EmployeeResource::make($employee);
        } catch (\Exception $e){
            return response()->json(['message'=>$e->getMessage()], 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();
            return response()->json(['message'=>"Employee deleted successfully"], 200);
        } catch (\Exception $e){
            return response()->json(['message'=>$e->getMessage()], 400);
        }

    }
}
