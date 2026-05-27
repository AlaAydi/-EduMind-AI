<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AIChatbotController extends Controller
{
  
    public function index(Request $request)
    {
        $user = Auth::user();

        $messages = ChatMessage::where('user_id', $user->id)
            ->oldest()
            ->get();

        $prefilledMsg = $request->query('msg');

        return view('ai-chatbot', compact('messages', 'prefilledMsg'));
    }


    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $user = Auth::user();
        $messageText = trim($request->message);

        $apiKey = env('GEMINI_API_KEY');
        
        if (empty($apiKey)) {
            $reply = "Veuillez configurer votre clé d'API Gemini (GEMINI_API_KEY) dans le fichier .env pour activer l'assistant IA gratuit.";
        } else {
            $models = [
                "gemini-2.5-flash",
                "gemini-3-pro",
                "gemini-1.5-flash",
                "gemini-pro",
                "gemini-1.5-flash-latest"
            ];
            
            $success = false;
            $lastError = "";

            foreach ($models as $model) {
                try {
                    $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . $apiKey, [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => "You are EduMind AI, a helpful e-learning assistant. Answer the user's prompt clearly and concisely. User Prompt: " . $messageText]
                                ]
                            ]
                        ]
                    ]);

                    if ($response->successful()) {
                        $reply = $response->json('candidates.0.content.parts.0.text') ?? 'Désolé, je n\'ai pas pu générer une réponse.';
                        $success = true;
                        break;
                    } else {
                        $lastError = $response->json('error.message', 'Erreur inconnue avec ' . $model);
                    }
                } catch (\Exception $e) {
                    $lastError = $e->getMessage();
                }
            }

            if (!$success) {
                $reply = "Erreur de l'API Gemini après avoir essayé tous les modèles. Dernière erreur : " . $lastError;
            }
        }

        ChatMessage::create([
            'user_id' => $user->id,
            'message' => $messageText,
            'response' => $reply
        ]);

        ActivityLog::create([
            'user_id' => $user->id,
            'activity_type' => 'ai_chat',
            'description' => "Consulted EduMind AI on: \"" . substr($messageText, 0, 30) . "...\""
        ]);

        return redirect()->route('ai-chatbot')->with('success', 'AI response received.');
    }
}
