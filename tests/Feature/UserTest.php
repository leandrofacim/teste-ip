<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile as FileUploadedFile;
use Tests\TestCase;

use function Composer\Autoload\includeFile;

class UserTest extends TestCase
{
    /**
     * A basic feature test get.
     *
     * @return void
     */
    public function testGet()
    {
        $response = $this->get('api/users');

        $response->assertStatus(200);
    }

    public function testMethodPost()
    {
        Storage::fake('curriculos');
        $file = UploadedFile::fake()->create('Leandro.pdf', 500);
        $dados = [
            'name' => 'Leandro',
            'email' => 'leandro.facim@hotmail.com',
            'telefone' => '1111111111',
            'endereco' => 'Rua Lorem Ipisum',
            'curriculo' => UploadedFile::fake()->create('Leandro.pdf', 500),
        ];
        dd($dados);
        $response = $this->json('POST', '/api/users', $dados);
        $response->assertStatus(200)
        ->assertJson([
            'data' => $dados,
            'message' => 'Dados enviado com sucesso!',
            ]);
        
        Storage::disk('curriculos')->assertExists($file->hashName());
        }
    }
