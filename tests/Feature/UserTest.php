<?php

namespace Tests\Feature;

use App\Mail\UserPostSendEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
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
    public function testGet()
    {
        $response = $this->get('api/users');

        $response->assertStatus(200);
    }

    public function test_method_store()
    {
        Mail::fake();

        $sizeInKilobytes = 500;
        $file = UploadedFile::fake()->create(
            'document.pdf',
            $sizeInKilobytes,
            'application/pdf'
        );

        $dados = [
            'name' => 'Leandro',
            'email' => 'leandro.facim@hotmail.com',
            'telefone' => '1111111111',
            'endereco' => 'Rua Lorem Ipisum',
            'curriculo' =>  $file,
        ];
        $response = $this->postJson('/api/users', $dados);
        // dd($response->getContent());
        $response
            ->assertStatus(201)
            ->assertJson([
                'created' => true,
                'message' =>  'Dados enviado com sucesso!'
            ]);

        Storage::assertExists('curriculos/' . $file->hashName());
        Storage::delete('curriculos/' . $file->hashName());
        Mail::assertSent(UserPostSendEmail::class);
    }
}
