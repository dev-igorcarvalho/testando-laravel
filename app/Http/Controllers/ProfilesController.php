<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $userId
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($userId)
    {
        //buscou o usuario no banco a partir de bruxaria laravel do modelo User
        $user = User::findOrFail($userId);

        //verifica se o usuario logado segue o usuario da tela
        $follows = (auth()->user()) != null ? auth()->user()->following->contains($user->id) : false;

        //enviou o $user pra tela a partir da rota
        //obs -> o map abaixo manda valores para a tela
        return view('profiles/index', ["user" => $user, "follows" => $follows]);
    }

    //laravel bruxaria faz o find automatico se colocar desse jeito WTF O.O
    public function edit(User $user)
    {
        // chama o metodo da policy para verificaçao de autorizaçao
        $this->authorize('update', $user->profile);

        return view('profiles/edit', ["user" => $user]);
    }

    protected function update(User $user)
    {
        $this->authorize('update', $user->profile);

        $data = request()->validate(
            [
                'title' => 'required',
                'description' => 'required',
                'url' => 'required',
                'imgPath' => ''
            ]
        );


        if (request('imgPath')) {
            $imgPath = request('imgPath')->store('profile/img', 'public');
            $image = Image::make(public_path("storage/{$imgPath}"))->fit(1000, 1000)->save();
        }

        $data = array_merge(
            $data,
            ['imgPath' => $imgPath ?? $user->profile->imgPath]
        );

        //utiliza o usuario logado e impede que um usuario faça alteraçao em outro
        auth()->user()->profile->update($data);
        return redirect("/profile/{$user->id}");
    }
}
