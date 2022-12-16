<?php

namespace App\Http\Request;

use App\Rules\Cpf;
use App\Rules\PlacaCarro;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClienteRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route('id');

        $uniqueCPF = Rule::unique('clientes','cpf');
        $uniqueTelefone = Rule::unique('clientes','telefone');
        $uniquePlaca = Rule::unique('clientes','placa_carro');

        if(!is_null($id)){
            $uniqueCPF->ignore($id);
            $uniqueTelefone->ignore($id);
            $uniquePlaca->ignore($id);
        }

        return [
            'nome' => 'required',
            'telefone' => ['required',$uniqueTelefone],
            'cpf' =>  ['required',$uniqueCPF,new Cpf()],
            'placa_carro' => ['required',$uniquePlaca,new PlacaCarro()],
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'Campo nome não preenchido',

            'telefone.required' => 'Campo telefone não preenchido',
            'telefone.unique' => 'Já existe um registro com esse telefone',

            'cpf.required' => 'Campo cpf não preenchido',
            'cpf.unique' => 'Já existe um registro com esse CPF',

            'placa_carro.required' => 'Campo Placa do carro não preenchido',
            'placa_carro.unique' => 'Já existe um registro com essa Placa'

        ];
    }
}
