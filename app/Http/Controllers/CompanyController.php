<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CompanyResource;
use Illuminate\Support\Facades\Mail;
use App\Mail\CompanyCreatedEmail;



class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CompanyResource::collection( Company::paginate(10));
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
            'name'=>'required',                                   
            'email'=>'email',                                   
        ]);

        if ($validator->fails()){ return response()->json(['message'=>$validator->errors()->first()], 400);  }
        
        try {
            
            $company = Company::create( $request->all());
            
            //send email after company has been created
            
            $companyEmail = $request["email"];
            $companyName = $request["name"];

            //send email to the company and copy the admin
            Mail::to($companyEmail)
            ->cc("admin@admin.com")
            ->send(new CompanyCreatedEmail( $companyName));
    
           return CompanyResource::make($company);
    
        } catch (\Exception $e){
            return response()->json(['message'=>$e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        try {
            return CompanyResource::make($company);
    
        } catch (\Exception $e){
            return response()->json(['message'=>$e->getMessage()], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        try {
            $company->update( $request->all());
            return CompanyResource::make($company);
        } catch (\Exception $e){
            return response()->json(['message'=>$e->getMessage()], 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        try {
            $company->delete();
            return response()->json(['message'=>"Company deleted successfully"], 200);
        } catch (\Exception $e){
            return response()->json(['message'=>$e->getMessage()], 400);
        }

    }

    /**
     * UPLOAD THE COMPANY LOGO
     */
    public function uploadLogo(Request $request){

        $validator =  Validator::make($request->all(), [
            'company_id'=>'required|exists:companies,id',                                   
            'logo' => 'required|image|dimensions:min_width=100,min_height=100',
        ]);

        if ($validator->fails()){ return response()->json(['message'=>$validator->errors()->first()], 400);  }
        

        try {
            $path = $request->file('logo')->store('/public');
            $company =Company::where('id', $request->company_id)->first();
            $company->update( ['logo'=>$path]);
            return CompanyResource::make($company);


        } catch (\Exception $e){
            return response()->json(['message'=>$e->getMessage()], 400);
        }

    }
}
