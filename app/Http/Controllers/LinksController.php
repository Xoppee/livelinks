<?php

namespace App\Http\Controllers;

use App\Models\LinkLogs;
use App\Models\Links;
use App\Models\Moderators;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LinksController extends Controller
{

    public function store(Request $request)
    {
        // return response()->json(['cheguei' => 'o controller está ouvindo!']);
        // 1. Validação
        $request->validate([
            'streamer_id' => 'required|integer',
            'link_url' => 'required|url',
            'username' => 'string|nullable', // Use nullable para não dar erro se não vier
            'message' => 'string|nullable'
        ]);

        try {
            // 2. Identificar Plataforma
            $url = $request->link_url;
            $host = parse_url($url, PHP_URL_HOST);

            $platform = match (true) {
                Str::contains($host, 'tiktok') => 'TikTok',
                Str::contains($host, 'twitch') => 'Twitch',
                Str::contains($host, 'instagram') => 'Instagram',
                Str::contains($host, 'youtube'), Str::contains($host, 'youtu.be') => 'Youtube',
                default => 'Outro' // Essencial para não crashar!
            };

            // 3. Buscar o Streamer (Se não achar, ele já joga pro catch)
            $streamer = User::where('id_user', $request->streamer_id)->firstOrFail();

            // 4. Criar o Link
            $link = Links::create([
                'streamer_id' => $request->streamer_id,
                'link_url' => $url,
                'username' => $request->username ?? 'Anônimo',
                'message' => $request->message
            ]);

            // 5. Criar o Log
            $log = LinkLogs::create([
                'link_id' => $link->id_link, // Certifique-se que o Model Links tem $primaryKey = 'id_link'
                'streamer_name' => $streamer->username,
                'link_url' => $link->link_url,
                'platform' => $platform,
                'username' => $link->username
            ]);

            return response()->json([
                'message' => 'Link salvo e log gerado!',
                'platform_detected' => $platform
            ], 201);
        } catch (\Exception $e) {
            // Se der qualquer erro (banco, código, etc), ele cai aqui
            return response()->json([
                'message' => 'Erro ao processar o link.',
                'error' => $e->getMessage() // Útil para você debugar agora (remova no portfólio final)
            ], 500); // 500 é erro de servidor
        }
    }

    public function index(Request $request)
    {
        $user = $request->validate([
            'id_user' => 'integer|required'
        ]);

        $isMod = Moderators::where('mod_id', $user)->firstOrFail();
        $links = Links::where('streamer_id', $isMod->streamer_id)->get();

        if ($isMod) {
            return response()->json(['message' => 'Aqui estão os links:' . $links, 201]);
        } else {
            return response()->json(['message' => 'Não há nenhum link novo, volte mais tarde'], 401);
        }
    }

    public function markWatched($id)
    {
        $link = Links::where('id_link', $id)
            ->where('streamer_id', auth()->user()->id_user)
            ->first();

        if ($link) {
            // Se você tiver uma coluna 'status', mude para: 
            $link->update(['is_watched' => true]);


            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Link não encontrado'], 404);
    }
}
