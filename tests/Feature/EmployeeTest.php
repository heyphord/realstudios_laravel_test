<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Employee;
use App\Models\Company;


class EmployeeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAllEmployees()
    {
        $response = $this->get('/api/v1/employee');

        $response->assertStatus(200);
    }

    public function testGetEmployee()
    {
        $company1 = Company::create(["name"=>"company1", "email"=>"company@email.com"]);

        $employee1 = Employee::create(["first_name"=>"employee1","last_name"=>"employee1", "email"=>"employee@email.com","phone"=>"32343443","company_id"=>$company1->id]);

        $response = $this->get('/api/v1/employee/'.$employee1->id);
        
        $response->assertOk();
    }


    public function testAddEmployee()
    {
        $company1 = Company::create(["name"=>"company1", "email"=>"company@email.com"]);
        
        $data =["first_name"=>"employee1","last_name"=>"employee1", "email"=>"employee@email.com","phone"=>"32343443","company_id"=>$company1->id];

        
        $response = $this->post('/api/v1/employee', $data);
        
        $response ->assertjsonFragment($data);
       
    }

    public function testUpdateEmployee()
    {
        $company1 = Company::create(["name"=>"company1", "email"=>"company@email.com"]);

        $employee1 = Employee::create(["first_name"=>"employee1","last_name"=>"employee1", "email"=>"employee@email.com","company_id"=>$company1->id]);
        
        $data =[
            "first_name"=>"Sample Employee",
            "last_name"=>"Sample Employee2",
            "email"=>"myemployee@gmail.com",
            "phone"=>"2354534343",
            "picture"=>"logo.url"
        ];
        
        $response = $this->put('/api/v1/employee/'.$employee1->id, $data);
        
        $response   //->dump()
                    ->assertjsonFragment($data);
       
    }

    public function testDeleteEmployee()
    {
        $company1 = Company::create(["name"=>"company1", "email"=>"company@email.com"]);

        $employee1 = Employee::create(["name"=>"employee1", "email"=>"employee@email.com","company_id"=>$company1->id]);
        
        $response = $this->delete('/api/v1/employee/'.$employee1->id);
        
        $response->assertOk($data);
       
    }
}
