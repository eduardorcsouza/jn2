<?php

namespace Tests\Feature;

use App\Models\Cliente;
use Facade\FlareClient\Http\Client;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ClienteTeste extends \Tests\TestCase
{
    use DatabaseMigrations, WithoutMiddleware;


    public function testCriarUsuarioInvalidData()
    {
        $payload = [
            'nome' => '',
            'cpf' => '111111111',
            'telefone' => '',
            'placa_carro' => 'NEY3C84S'
        ];
        $response = $this->post('/api/cliente', $payload);
        $json = $response->json();

        $keys = array_keys($json['errors']);

        $response->assertStatus(200);
        $this->assertEquals($json['error'], true);
        $this->assertTrue(in_array('cpf', $keys));
        $this->assertTrue(in_array('nome', $keys));
        $this->assertTrue(in_array('telefone', $keys));
        $this->assertTrue(in_array('placa_carro', $keys));
    }

    public function testCriarUsuarioSuccess()
    {
        $payload = [
            'nome' => 'Usuario Teste',
            'cpf' => '90248575031',
            'telefone' => '11999999999',
            'placa_carro' => 'NEY3C84'
        ];
        $response = $this->post('/api/cliente', $payload);
        $json = $response->json();

        $cliente = Cliente::query()->where('cpf', '=', $payload['cpf'])->first()->toArray();

        $response->assertStatus(200);
        $this->assertEquals($json['error'], false);
        $this->assertEquals($payload['nome'], $cliente['nome']);
        $this->assertEquals($payload['cpf'], $cliente['cpf']);
        $this->assertEquals($payload['telefone'], $cliente['telefone']);
        $this->assertEquals($payload['placa_carro'], $cliente['placa_carro']);
    }

    public function testEditCliente()
    {
        $cliente = $this->createCliente();
        $payload = $cliente->toArray();

        $payload['nome'] = 'Usuário Alterado';

        $response = $this->put('/api/cliente/' . $cliente->id, $payload);
        $json = $response->json();

        $clienteAlterado = Cliente::find($cliente->id);

        $response->assertStatus(200);
        $this->assertEquals(false, $json['error']);
        $this->assertEquals($payload['nome'], $clienteAlterado->nome);

    }

    public function testGetCliente()
    {
        $cliente = $this->createCliente();


        $response = $this->get('/api/cliente/' . $cliente->id);
        $json = $response->json();


        $response->assertStatus(200);
        $this->assertEquals($cliente->toArray(), $json);
    }


    public function testGetClienteFinalPlaca()
    {
        $cliente = $this->createCliente();

        $final = substr($cliente->placa_carro, -1);
        $response = $this->get('/api/consulta/final-placa/' . $final);
        $json = $response->json();

        $response->assertStatus(200);
        $this->assertEquals(1, count($json));
        $this->assertEquals($cliente->toArray(), $json[0]);
    }


    public function testGetClienteDelete()
    {
        $cliente = $this->createCliente();

        $response = $this->delete('/api/cliente/' . $cliente->id);
        $json = $response->json();

        $clienteDeleted = Cliente::find($cliente->id);

        $response->assertStatus(200);
        $this->assertEquals(false, $json['error']);
        $this->assertEquals(null, $clienteDeleted);
    }


    /**
     * @return Cliente
     */
    private function createCliente()
    {
        $cliente = [
            'nome' => 'Usuario Teste',
            'cpf' => '90248575031',
            'telefone' => '11999999999',
            'placa_carro' => 'NEY3C84'
        ];
        return Cliente::create($cliente);
    }
}
