<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Company;

class CompanyTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAllCompanies()
    {
        $response = $this->get('/api/v1/company');

        $response->assertStatus(200);
    }

    public function testGetCompany()
    {
        $company1 = Company::create(["name"=>"company1", "email"=>"company@email.com"]);

        $response = $this->get('/api/v1/company/'.$company1->id);
        
        $response->assertOk();
    }


    public function testAddCompany()
    {
        
        $data =[
            "name"=>"Sample Company",
            "email"=>"mycompany@gmail.com",
            "logo"=>"logo.url",
            "website"=>"website.url"
        ];
        
        $response = $this->post('/api/v1/company', $data);
        
        $response ->assertjsonFragment($data);
       
    }

    public function testUpdateCompany()
    {
        $company1 = Company::create(["name"=>"company1", "email"=>"company@email.com"]);
        
        $data =[
            "name"=>"Sample Company",
            "email"=>"mycompany@gmail.com",
            "logo"=>"logo.url",
            "website"=>"website.url"
        ];
        
        $response = $this->put('/api/v1/company/'.$company1->id, $data);
        
        $response   //->dump()
                    ->assertjsonFragment($data);
       
    }

    public function testDeleteCompany()
    {
        $company1 = Company::create(["name"=>"company1", "email"=>"company@email.com"]);
        
        $response = $this->delete('/api/v1/company/'.$company1->id);
        
        $response->assertOk($data);
       
    }
}
