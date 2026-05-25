<x-app-layout>
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-emerald-400 to-blue-500">My Progression</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Level & XP Card -->
            <div class="lg:col-span-2">
                <x-glass-card class="p-8 h-full flex flex-col justify-center relative overflow-hidden">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>
                    
                    <div class="flex items-center gap-8 z-10">
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 flex items-center justify-center p-2 shadow-[0_0_30px_rgba(16,185,129,0.2)]">
                            <div class="w-full h-full rounded-full border-4 border-emerald-500/50 flex flex-col items-center justify-center bg-gray-800">
                                <span class="text-xs text-gray-400 uppercase tracking-wider">Level</span>
                                <span class="text-4xl font-bold text-white">{{ $currentLevel }}</span>
                            </div>
                        </div>
                        
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-white mb-2">Keep up the great work!</h2>
                            <p class="text-gray-400 mb-6">You're making excellent progress in your learning journey.</p>
                            
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400">Current XP: <span class="text-white font-medium">{{ number_format($xpPoints) }}</span></span>
                                    <span class="text-gray-400">Next Level: <span class="text-emerald-400 font-medium">{{ number_format($xpToNextLevel) }} XP</span></span>
                                </div>
                                <div class="h-3 w-full bg-gray-800 rounded-full overflow-hidden border border-gray-700">
                                    <div class="h-full bg-gradient-to-r from-emerald-500 to-blue-500 shadow-[0_0_10px_rgba(16,185,129,0.5)] rounded-full" style="width: {{ ($xpPoints / $xpToNextLevel) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-glass-card>
            </div>

            <!-- Stats Mini Cards -->
            <div class="space-y-6">
                <x-glass-card class="p-6 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-orange-500/20 flex items-center justify-center text-orange-400 text-xl border border-orange-500/30 shadow-[0_0_15px_rgba(249,115,22,0.3)]">
                        🔥
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Current Streak</p>
                        <p class="text-2xl font-bold text-white">14 Days</p>
                    </div>
                </x-glass-card>
                
                <x-glass-card class="p-6 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center text-purple-400 text-xl border border-purple-500/30 shadow-[0_0_15px_rgba(168,85,247,0.3)]">
                        ⭐
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Total Badges</p>
                        <p class="text-2xl font-bold text-white">{{ count($achievements) }} Earned</p>
                    </div>
                </x-glass-card>
            </div>
        </div>

        <!-- Achievements Grid -->
        <div>
            <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                <span>Recent Achievements</span>
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($achievements as $achievement)
                <x-glass-card class="p-6 hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 flex items-center justify-center text-2xl shadow-inner shadow-black/50">
                            {{ $achievement['icon'] }}
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white">{{ $achievement['title'] }}</h4>
                            <p class="text-sm text-gray-400 mt-1">{{ $achievement['description'] }}</p>
                            <p class="text-xs text-gray-500 mt-3 font-medium uppercase tracking-wide">Earned {{ $achievement['earned_at'] }}</p>
                        </div>
                    </div>
                </x-glass-card>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
