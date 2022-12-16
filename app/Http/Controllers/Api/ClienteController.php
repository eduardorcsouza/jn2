<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ClientException;
use App\Http\Controllers\Controller;
use App\Http\Request\ClienteRequest;
use App\Service\ClienteService;
use Illuminate\Http\JsonResponse;

class ClienteController extends Controller
{
    public function listaClientesPeloFinalDaPlaca($finalPlaca): JsonResponse
    {
        $dados = (new ClienteService())->retornaClientesPeloFinalDaPlaca($finalPlaca);
        return response()->json($dados);
    }

    public function salvarCliente(ClienteRequest $request, $id = null): JsonResponse
    {
        $data = $request->all();
        try {
            $cliente = (new ClienteService())->salvarCliente($data, $id);
            if (!$cliente) {
                return $this->responseErrorJson("Erro ao salvar Cliente");
            }
            return $this->responseSuccessJson("Cliente salvo com sucesso");
        } catch (ClientException $clientException) {
            return $clientException->responseJson();
        }
    }

    public function getCliente(int $id): JsonResponse
    {
        try {
            $cliente = (new ClienteService())->getDadosCliente($id);
            return response()->json($cliente);
        } catch (ClientException $exception) {
            return $exception->responseJson();
        }
    }

    public function delete(int $id)
    {
        if ((new ClienteService())->deletarCliente($id)) {
            return $this->responseSuccessJson('Cliente Removido com sucesso');
        }
        return $this->responseErrorJson('Erro ao remover cliente');
    }
}
