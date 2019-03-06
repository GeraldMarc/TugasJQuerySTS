<?php

namespace Tests\Feature\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductImageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetProductImageByProductID()
    {
        $response = $this->get('/api/ProductImage/GetWithParam/1');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'product_image_url',
                            'main_image',
                            'product_id',
                            'created_at',
                            'updated_at',
                            'deleted_at',
                        ],
                    ],
                ]);
    }

    public function testAddProductImage(){
        $response = $this->json('POST', '/api/ProductImage/Store', [
                                                                'product_image_url' => 'https://www.google.com',
                                                                'main_image' => 'false',
                                                                'product_id' => '51',
                                                                ]);
        
        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'success'
                ]);
    }

    public function testSetMainImage(){
        $response = $this->json('PUT', '/api/ProductImage/SetMainImage/1', [
                                                                'main_image' => 'true',
                                                                ]);
        
        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'success'
                ]);
    }

    public function testRemoveProductImage(){
        $response = $this->json('DELETE', '/api/ProductImage/Delete/1');
        
        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'success'
                ]);
    }
}
