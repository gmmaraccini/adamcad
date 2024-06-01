<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'cpf.unique' => 'O CPF cadastrado já existe.',
        ];

        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'cpf' => 'required|unique:usuarios',
            'foto' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('usuarios.create')
                ->withErrors($validator)
                ->withInput();
        }

        $imageData = $request->input('foto');
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $fileName = uniqid() . '.png';
        \File::put(storage_path('app/public/fotos/') . $fileName, base64_decode($imageData));

        Usuario::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'foto' => 'fotos/' . $fileName
        ]);

        return redirect()->route('usuarios.index');
    }
}
