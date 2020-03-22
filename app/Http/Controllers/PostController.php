<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{

    public function __construct()
    {
    }

    public function create()
    {
        return view('posts/create');
    }


    public function index()
    {

        $authUser = auth()->user();
        if ($authUser == null) {
            return view('auth/login');
        }

        $users = $authUser->following()->pluck('profiles.user_id');
//      $posts = Post::whereIn('user_id', $users)->orderBy('created_at', 'DESC')->get();
//      latest a mesma coisa q orderBy('created_at', 'DESC')
//      paginate(numero) cria um limite + paginator, podendo ser chamado na tela pelo <nomeModel> -> links()
        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(3);

        return view('posts/index', ['posts' => $posts]);

    }

//    public function show($postId)
//    {
//        $post = Post::findOrFail($postId);
//        return view('posts/show' , ['post' => $post]);
//    }

//laravel bruxaria faz o find automatico se colocar desse jeito WTF O.O
    public function show(\App\Post $post)
    {
        //tradicional
        return view('posts/show', ['post' => $post]);
        //bruxaria
//        return view('posts/show', compact('post'));

    }

    public function store()
    {

//        $this->authorize('create', auth()->user());

        //incluir todos os campos, se algum campo nao tiver validaçao usar 'campo'=>''
        $data = \request()->validate([
            'caption' => 'required',
            'imgUrl' => ['required', 'image']
        ]);

        // armazena a imagem no <path>, e seleciona o o <driver> (podia ser num s3 amazon, one drive, etc
        // precisa rodar o php artisan storage:link para funcionar, o comando cria um link de acesso ao storage
        //q é privado para exibiçao publica
        $imgPath = \request('imgUrl')->store('uploads/img', 'public');


        //usa o pacote intervention/image para editar a imagem
        $image = Image::make(public_path("storage/{$imgPath}"))->fit(1200, 1200)->save();

        //salva os dados a partir do usuario logado para manter o relacionamento correto
        //e apenas permitir a criacao de posts pelo usuario logado, e apenas na propria conta
        auth()->user()->posts()->create(
            [
                'caption' => $data['caption'],
                'imgUrl' => $imgPath
            ]
        );
        return redirect('/profile/' . auth()->user()->id);
    }
}
