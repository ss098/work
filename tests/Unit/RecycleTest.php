<?php

namespace Tests\Unit;

use App\Form;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class RecycleTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testGetAll()
    {
        $response = $this->get('/all');

        $response->assertStatus(200);
    }

    public function testCreateRecycle()
    {
        $response = $this->json('post', '/create', ['name' => 'unit test data']);

        $response->assertStatus(200);
    }

    public function testPostRecycle()
    {
        $recycle_id = Form::orderBy('id', 'desc')->value('id');

        $attachment = collect(range(1, rand(1, 20)))->map(function () {
            $name = str_random(16) . '.jpg';
            $image = UploadedFile::fake()->image($name, 32, 32);

            return [
                'name' => $name,
                'size' => $image->getSize(),
                'data' => 'data:image/jpeg;base64,' . base64_encode($image->get())
            ];
        });

        $response = $this->json('post', '/recycle', [
            'id' => $recycle_id,
            'recycle' => [
                'name' => 'unit test data',
                'code' => rand(100000000000, 999999999999),
                'attachment' => $attachment
            ]
        ]);

        $response->assertStatus(200);
    }
}
