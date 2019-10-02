<?php

namespace Tests\Feature;

use App\Photos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
/**
 * A basic feature test example.
 *
 * @package Tests\Feature
 * @covers
 */


class PhotosControllerTest extends TestCase
{
    use RefreshDatabase;
    /**

     * @test
     */

    public function shows_no_photos_at_init_state()
    {
        //1 PREPARE skip

        //2 EXECUTE
        $this->withoutExceptionHandling();
//        $this->json('GET','/api/v1/photos');
        $response = $this->json('GET','/api/v1/photos');

        //3 ASSERT
        $response->assertSuccessful();

//        $response -> hhttp response  message http paquet.
        $photosJSON=$response->getContent();
        $photos=json_decode($photosJSON);

        $response->assertJsonCount(0);
        $this->assertEquals($photosJSON,"[]");
        $this->assertCount(0,$photos);

    }
   /** @test*/
   public function shows_photos_ok()
   {
       //1 prepare ->Seed database with
       //models
       Photos::create([
           'name' => 'test'
       ]);
       Photos::create([
           'name' => 'Yu yu hakusho'
       ]);
       Photos::create([
           'name' => 'Hunter x hunter'
       ]);
       $response = $this->json('GET','/api/v1/photos');


       $response->assertSuccessful();


       $photosJSON=$response->getContent();
       $photos=json_decode($photosJSON);

       $response->assertJsonCount(3);
//        $this->assertTrue(is_array($photosJSON,"[]"));
       $this->assertCount(3,$photos);

       $this->assertEquals($photos[0]->name,'test');
       $this->assertEquals($photos[1]->name,'Yu yu hakusho');
       $this->assertEquals($photos[2]->name,'Hunter x hunter');


   }
}
