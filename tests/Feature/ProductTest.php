<?php

namespace Tests\Feature\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testProductGetAll()
    {
        $response = $this->get('/api/Product/GetAll');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'unit_price',
                        ],
                    ],
                ]);
    }

    public function testProductGetByID()
    {
        $response = $this->get('/api/Product/GetByID/1');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'sku',
                        'name',
                        'description',
                        'unit_price',
                        'created_at',
                        'updated_at',
                        'deleted_at',
                    ],
                ]);
    }

    public function testStoreProduct(){
        $response = $this->json('POST', '/api/Product/Store', [
                                                                'name' => 'Bambang',
                                                                'sku' => 'SkU5k0',
                                                                'description' => 'Kedatangan Bambang nomor 2',
                                                                'unit_price' => '50000',
                                                                'product_category_id' => '5'
                                                                ]);
        
        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'success'
                ]);
    }

    public function testUpdateProduct(){
        $response = $this->json('PUT', '/api/Product/Update/1', [
                                                                'name' => 'Bambang',
                                                                'sku' => 'SkU5k0',
                                                                'description' => 'Kedatangan Bambang nomor 2',
                                                                'unit_price' => '50000',
                                                                'product_category_id' => '5'
                                                                ]);
        
        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'success'
                ]);
    }

    public function testDeleteProduct(){
        $response = $this->json('DELETE', '/api/Product/Delete/2');
        
        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'success'
                ]);
    }
}
