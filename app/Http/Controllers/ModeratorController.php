<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Links;
use App\Models\Moderators;

class ModeratorController extends Controller
{
    // O moderador aprova o link para aparecer na live
    public function acceptLink($id)
    {
        $user = auth()->user();
        $link = Links::findOrFail($id);

        // Validação de segurança: Este usuário é moderador deste streamer?
        $isMod = Moderators::where('streamer_id', $link->streamer_id)
                           ->where('mod_id', $user->id_user)
                           ->exists();

        if (!$isMod && $user->id_user !== $link->streamer_id) {
            return response()->json(['error' => 'Acesso negado. Você não modera este canal.'], 403);
        }

        // Marcar como aceito (Supondo que você use essa lógica)
        $link->update(['is_accept' => true]);

        return response()->json(['message' => 'Link aprovado com sucesso!']);
    }

    // O moderador descarta o link (não vai para o streamer)
    public function declineLink($id)
    {
        $user = auth()->user();
        $link = Links::findOrFail($id);

        $isMod = Moderators::where('streamer_id', $link->streamer_id)
                           ->where('mod_id', $user->id_user)
                           ->exists();

        if (!$isMod && $user->id_user !== $link->streamer_id) {
            return response()->json(['error' => 'Acesso negado.'], 403);
        }

        // Se recusou, a gente deleta para limpar a fila
        $link->delete();

        return response()->json(['message' => 'Link descartado.']);
    }
}