<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Mock data for progression
        $currentLevel = 12;
        $xpPoints = 3450;
        $xpToNextLevel = 5000;
        
        $achievements = [
            ['title' => 'First Blood', 'description' => 'Completed first quiz.', 'icon' => '🏆', 'earned_at' => '2 days ago'],
            ['title' => 'Fast Learner', 'description' => 'Completed 5 courses in a month.', 'icon' => '⚡', 'earned_at' => '1 week ago'],
            ['title' => 'AI Explorer', 'description' => 'Asked 50 questions to the AI tutor.', 'icon' => '🤖', 'earned_at' => '2 weeks ago'],
        ];

        return view('progression.index', compact(
            'currentLevel', 'xpPoints', 'xpToNextLevel', 'achievements'
        ));
    }
}
