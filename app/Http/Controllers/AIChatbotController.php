<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AIChatbotController extends Controller
{
    /**
     * Show the chatbot console.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Fetch conversation logs
        $messages = ChatMessage::where('user_id', $user->id)
            ->oldest()
            ->get();

        // Check if a quick message was sent from dashboard
        $prefilledMsg = $request->query('msg');

        return view('ai-chatbot', compact('messages', 'prefilledMsg'));
    }

    /**
     * Send message to simulated AI.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $user = Auth::user();
        $messageText = trim($request->message);

        // Core Rule-Based AI Response Engine
        $lcMsg = strtolower($messageText);
        $reply = "";

        if (str_contains($lcMsg, 'laravel') || str_contains($lcMsg, 'blade') || str_contains($lcMsg, 'component')) {
            $reply = "Laravel Blade components provide a modular approach to template design. You can pass inputs using the `:` syntax (e.g. `:items=\"$data\"`) and manage internal states seamlessly. Learn more in our course **\"Mastering Laravel & Blade Component Design\"** in your dashboard catalog!";
        } elseif (str_contains($lcMsg, 'prompt') || str_contains($lcMsg, 'llm') || str_contains($lcMsg, 'ai')) {
            $reply = "Prompt engineering is the core art of guiding Large Language Models. To optimize outcomes, set precise System Persona instructions, structure few-shot demonstrations, and use low temperatures for logical/deterministic replies. See our premium course **\"Advanced Prompt Engineering & LLMs\"**.";
        } elseif (str_contains($lcMsg, 'chart') || str_contains($lcMsg, 'apex') || str_contains($lcMsg, 'python')) {
            $reply = "Data visualization bridges raw databases and actionable analytics. Using Python, you can format clean arrays to render ApexCharts area, line, or bar series. We recommend taking the **\"Data Visualization with Python & ApexCharts\"** course to learn this in depth.";
        } elseif (str_contains($lcMsg, 'xp') || str_contains($lcMsg, 'level') || str_contains($lcMsg, 'progress')) {
            $reply = "Your progression is tracked dynamically! In EduMind AI, completing a course rewards you with **500 XP** and passing quizzes rewards you with **200 XP**. Track your Level Rank, achievements, and milestone timelines directly in your **Progression & XP** tab.";
        } elseif (str_contains($lcMsg, 'help') || str_contains($lcMsg, 'how')) {
            $reply = "I am EduMind AI, your personal e-learning assistant. You can query me on software design patterns, prompts parameters, charts integrations, or progression guidelines. Just ask your question below!";
        } else {
            $reply = "That is an interesting topic! As your EduMind tutor, I recommend aligning your query with our specialized syllabus modules. You can browse through our Artificial Intelligence, Web Development, or Data Visualization guides to build your skills.";
        }

        // Store Chat Message
        ChatMessage::create([
            'user_id' => $user->id,
            'message' => $messageText,
            'response' => $reply
        ]);

        // Log Activity
        ActivityLog::create([
            'user_id' => $user->id,
            'activity_type' => 'ai_chat',
            'description' => "Consulted EduMind AI on: \"" . substr($messageText, 0, 30) . "...\""
        ]);

        return redirect()->route('ai-chatbot')->with('success', 'AI response received.');
    }
}
