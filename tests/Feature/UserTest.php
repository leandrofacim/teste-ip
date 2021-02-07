<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile as FileUploadedFile;
use Tests\TestCase;

use function Composer\Autoload\includeFile;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test get.
     *
     * @return void
     */
    // public function testGet()
    // {
    //     $response = $this->get('api/users');

    //     $response->assertStatus(200);
    // }

    public function testMethodPost()
    {
        $pathFile = new File(base_path('tests/resources/teste.pdf'));
        // $file1 = UploadedFile::fake()->create('documents.pdf', 500, 'application/pdf');
        $fileName = Storage::putFileAs('curriculos', $pathFile, 'curriculo.pdf');
        
        $dados = [
            'name' => 'Leandro',
            'email' => 'gdsadassd.facsim@hodddddssdddtmail.com',
            'telefone' => '1111111111',
            'endereco' => 'Rua Lorem Ipisum',
            'curriculo' => $fileName,
        ];
        $response = $this->json('POST', '/api/users', $dados);
        // dd($response->getContent());
        $response
        ->assertStatus(200)
        ->assertJson([
            'data' => $dados,
            'message' => 'Dados enviado com sucesso!',
            ]);
            
        Storage::disk('curriculos')->assertExists($pathFile->hashName());
        }
    }
