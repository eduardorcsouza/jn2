<?php

namespace App\Service;

use App\Exceptions\ClientException;
use App\Models\Cliente;
use App\Repositories\ClienteRepository;
use Carbon\Carbon;
use http\Client;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ClienteService
{

    public function retornaClientesPeloFinalDaPlaca($finalPlaca)
    {
        $clienteQuery = Cliente::where(
            DB::raw('SUBSTRING(placa_carro, -1, 1)'), '=', $finalPlaca
        );
        return $clienteQuery->get();
    }


    public function salvarCliente(array $dadosCliente, $id = null)
    {
        try {
            $cliente = new Cliente();
            if (!is_null($id)) {
                $cliente = Cliente::find($id);
            }
            $cliente->nome = $dadosCliente['nome'];
            $cliente->cpf = $dadosCliente['cpf'];
            $cliente->telefone = $dadosCliente['telefone'];
            $cliente->placa_carro = $dadosCliente['placa_carro'];
            $cliente->timestamps = true;
            $cliente->save();
            return $cliente;

        } catch (\Exception $error) {
            Log::error("Erro ao Salvar cliente" . $error->getMessage());
        }
        return false;
    }

    public function getDadosCliente(int $id)
    {
        $cliente = new Cliente();
        $cliente = Cliente::find($id);
        if(is_null($cliente)){
            throw new ClientException('Usuário inexistente');
        }
        return $cliente->toArray();
    }

    public function deletarCliente(int $id)
    {
        try {
            $cliente = Cliente::find($id);
            $cliente->deleteOrFail();
            return true;
        } catch (\Exception $error) {
            Log::error("Erro ao remover cliente cliente" . $error->getMessage());
        }
        return false;
    }
}
