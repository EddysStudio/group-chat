<?php

namespace EddysStudio\GroupChat\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use EddysStudio\GroupChat\Models\GchatMessage;
use EddysStudio\GroupChat\Models\GchatUser;

class GChatController extends Controller
{
    
    protected string $cookieName = 'gchat_token';
    protected string $hash_salt;

    public function __construct()
    {
        $this->hash_salt = config('app.key');
    }
    
    public function index()
    {
        return view('group-chat::chat');
    }

    protected function resolveUser(Request $request): GchatUser
    {
        $user = $this->storeLasttime($request);
        if($user!=null) return $user;
        // Созаддим юзера, если нет
        $user = GchatUser::create([
            'name' => 'Anonim',
            'last_time' => now(),
        ]);
        $hash = hash('sha256', $user->id . $this->hash_salt);
        $user->update(['hash' => $hash]);

        Cookie::queue($this->cookieName, $hash, 60 * 24 * 365);

        return $user;
    }

    // Сохранение времени последнего входа
    protected function storeLasttime(Request $request) { 
        if ($request->hasCookie($this->cookieName)) {
            $hash = $request->cookie($this->cookieName);
            $user = GchatUser::where('hash', $hash)->first();

            if ($user) {
                $user->update(['last_time' => now()]);
                return $user;
            }
        }
        return null; 
    }

    // Получим статусы нахождения в сети
    public function getStatuses(Request $request) {
        $user =  $this->storeLasttime($request);
        $users = GchatUser::where('last_time', '>', now()->subMinutes(1))->get(['id']);
        $ar_ids = [];
        foreach($users as $u) {
            $ar_ids[] = $u->id;
        }
        return response()->json(['users' => $ar_ids]);
    }

    public function storeMessage(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $user = $this->resolveUser($request);

        $message = GchatMessage::create([
            'user_id' => $user->id,
            'message' => $validated['message'],
        ]);

        $uname = $user->name;
        if($uname=="Anonim") $uname.= "_".$user->id;
        
        return response()->json([
            'ok' => true,
            'message' => [
                'id' => $message->id,
                'user_id' => $message->user_id,
                'user_name' => $uname,
                'user_online' => true,
                'message' => $message->message,
                'created_at' => $message->created_at->format('H:i'),
            ],
        ]);
    }

    public function getMessages(Request $request) // Получаем сообщения
    {
        $query = GchatMessage::with('user')->orderBy('created_at', 'desc');

        if ($request->has('after')) {
            $messages = $query->where('id', '>', $request->input('after'))
                ->orderBy('created_at', 'asc') 
                ->limit(50) 
                ->get();
        } else {
            // Первая загрузка — 10 последних
            $messages = $query->limit(10)->get()->reverse()->values();
        }

        $formatted = $messages->map(function ($msg) {
            $created_at = $msg->created_at->isToday()?$msg->created_at->format('H:i'):$msg->created_at->format('d.m.Y H:i');
            return [
                'id' => $msg->id,
                'user_id' => $msg->user_id,
                'user_name' => $msg->user->name.($msg->user->name=="Anonim"?"_".$msg->user_id:""),
                'user_online' => ($msg->user->last_time->timestamp > (time()-185))?true:false,
                'message' => $msg->message,
                'created_at' => $created_at,
            ];
        });

        return response()->json(['messages' => $formatted]);
    }
}