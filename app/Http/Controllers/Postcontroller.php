<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Storage;

class Postcontroller extends Controller
{
   
    public function index()
    {
        return Post::all();
    }

  
    public function store(Request $request)
    {
        $p = new Post();
        $path = $request->file('arquivo')->store('imagens', 'public');
        $p->nome = $request->nome;
        $p->email = $request->email;
        $p->titulo = $request->titulo;
        $p->subtitulo = $request->subtitulo;
        $p->mensagem = $request->mensagem;
        $p->arquivo = $path;
        $p->likes = 0;
        $p->save();

        return response($p, 200);
    }

    public function destroy($id)
    {
        $p = Post::find($id);

        if(isset($p)) {
            Storage::disk('public')->delete($p->arquivo);
            $p->delete();
            return 204;
        }
        return response('Arquivo não encontrado', 404);
    }
    public function like($id)
    {
        $p = Post::find($id);
        if(isset($p)) {
            $p->likes++;
            $p->save();
            return $p;
        }
        return response('Não foi encontrado a imagem', 404);
    }
}
