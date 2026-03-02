<?php

namespace App\Http\Controllers;

use App\Models\Links;
use App\Models\Moderators;
use Illuminate\Http\Request;
use App\Models\User;

class StreamerController extends Controller
{

    public function index($username)
    {
        $userLogado = auth()->user();

        // 1. Busca o dono do canal
        $streamer = User::where('username', $username)->firstOrFail();

        // 2. Verifica as permissões
        $isOwner = $userLogado->id_user === $streamer->id_user;
        $isModerator = Moderators::where('streamer_id', $streamer->id_user)
            ->where('mod_id', $userLogado->id_user)
            ->exists();

        if (!$isOwner && !$isModerator) {
            abort(403, 'Você não tem permissão para acessar este painel.');
        }

        // 3. Lógica de Filtro de Links
        $query = Links::where('streamer_id', $streamer->id_user)
            ->where('is_watched', false);

        if ($isOwner) {
            // O Streamer só vê o que já foi aceito pela moderação
            $links = $query->where('is_accept', true)->orderBy('created_at', 'asc')->get();
        } else {
            // O Moderador vê apenas o que ainda NÃO foi aceito (fila de triagem)
            $links = $query->where('is_accept', false)->orderBy('created_at', 'asc')->get();
        }

        // 4. Lista de moderadores
        $moderators = Moderators::where('streamer_id', $streamer->id_user)
            ->with('user')
            ->get();

        return view('dash', compact('links', 'moderators', 'streamer'));
    }


    public function addMod(Request $request)
    {
        $request->validate([
            'user_id' => 'integer|required'
        ]);

        $mod = Moderators::create([
            'mod_id' => $request->user_id,
            'streamer_id' => auth()->user()->id_user
        ]);

        if ($mod) {
            return response()->json(['message' => 'Moderador adicionado com sucesso!'], 201);
        } else {
            return response()->json(['message' => 'Houve um erro ao adicionar este moderador, talvez o usuário não exista. Tente novamente mais tarde'], 401);
        }
    }
}
