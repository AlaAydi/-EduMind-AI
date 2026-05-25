<x-app-layout :title="$course->title . ' - Info'">
    
    <!-- Breadcrumbs -->
    <div class="mb-6 relative z-10">
        <a href="{{ route('courses.index') }}" class="text-xs text-purple-400 hover:underline flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Catalog
        </a>
    </div>

    <!-- Main Scaffolding -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 relative z-10">
        
        <!-- Left: Course Overview & Syllabus (Col Span 8) -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Hero banner card -->
            <x-glass-card class="overflow-hidden">
                <div class="h-64 relative">
                    <img src="{{ $course->thumbnail ?? 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=800&q=80' }}" class="w-full h-full object-cover brightness-50" alt="Course Banner">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <div class="flex items-center gap-3 mb-3">
                            <x-gradient-badge type="purple">{{ $course->category }}</x-gradient-badge>
                            <x-gradient-badge type="{{ $course->level == 'Beginner' ? 'emerald' : ($course->level == 'Intermediate' ? 'blue' : 'purple') }}">
                                {{ $course->level }}
                            </x-gradient-badge>
                        </div>
                        <h2 class="text-2xl lg:text-3xl font-extrabold text-white leading-tight shadow-sm">{{ $course->title }}</h2>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <div>
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">About this module</h3>
                        <p class="text-sm text-slate-350 leading-relaxed">{{ $course->description }}</p>
                    </div>

                    <!-- Syllabus preview -->
                    <div>
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Syllabus Outline (5 Chapters)</h3>
                        <div class="space-y-3.5">
                            <div class="p-3 bg-slate-950/40 border border-slate-900 rounded-2xl flex justify-between items-center text-xs">
                                <span class="text-slate-300 font-bold">1. Introduction and Core Framework Structure</span>
                                <span class="text-slate-500 font-semibold">12m</span>
                            </div>
                            <div class="p-3 bg-slate-950/40 border border-slate-900 rounded-2xl flex justify-between items-center text-xs">
                                <span class="text-slate-300 font-bold">2. Context Management & Dynamic State Binding</span>
                                <span class="text-slate-500 font-semibold">25m</span>
                            </div>
                            <div class="p-3 bg-slate-950/40 border border-slate-900 rounded-2xl flex justify-between items-center text-xs">
                                <span class="text-slate-300 font-bold">3. Advanced Visual Designing with Layout Grids</span>
                                <span class="text-slate-500 font-semibold">18m</span>
                            </div>
                            <div class="p-3 bg-slate-950/40 border border-slate-900 rounded-2xl flex justify-between items-center text-xs">
                                <span class="text-slate-300 font-bold">4. Optimizing Production Assets & Bundle Sizes</span>
                                <span class="text-slate-500 font-semibold">30m</span>
                            </div>
                            <div class="p-3 bg-slate-950/40 border border-slate-900 rounded-2xl flex justify-between items-center text-xs">
                                <span class="text-slate-300 font-bold">5. Final Cohort Evaluation and Sandbox Test</span>
                                <span class="text-slate-500 font-semibold">15m</span>
                            </div>
                        </div>
                    </div>
                </div>
            </x-glass-card>

        </div>

        <!-- Right: Instructor & Enrollment Actions (Col Span 4) -->
        <div class="lg:col-span-4 space-y-8">
            
            <!-- Enroll Action Box -->
            <x-glass-card class="p-6 border-purple-500/10" glow="true">
                <span class="text-[10px] text-purple-400 font-bold uppercase tracking-wider block mb-2">ACCESS NODE</span>
                <span class="text-3xl font-black text-white block mb-6">Free Enrollment</span>

                <ul class="space-y-3.5 mb-8 text-xs text-slate-350 border-b border-slate-900 pb-6">
                    <li class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Syllabus duration: {{ $course->duration }}
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Included Quizzes: {{ $quizzes->count() }}
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Verified Digital Certificate
                    </li>
                </ul>

                @if (auth()->user()->isTeacher())
                    <button class="w-full py-3 bg-slate-900 border border-slate-850 text-slate-500 font-bold text-sm rounded-xl cursor-not-allowed" disabled>
                        Instructors Cannot Enroll
                    </button>
                @else
                    <form action="{{ route('courses.enroll', $course->id) }}" method="POST" class="m-0 p-0">
                        @csrf
                        <x-primary-button class="w-full py-3">
                            Enroll in Syllabus
                        </x-primary-button>
                    </form>
                @endif
            </x-glass-card>

            <!-- Instructor details card -->
            <x-glass-card class="p-6">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Syllabus Instructor</h3>
                
                <div class="flex items-center gap-4">
                    <img class="w-12 h-12 rounded-2xl object-cover border border-purple-500/20" src="{{ $course->teacher->avatar ?? 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&q=80' }}" alt="Teacher Avatar">
                    <div>
                        <span class="block text-sm font-bold text-slate-200">{{ $course->teacher->name }}</span>
                        <span class="text-[10px] text-purple-400 font-bold uppercase tracking-wider block mt-1">Lead Academic Node</span>
                    </div>
                </div>
            </x-glass-card>

        </div>

    </div>

</x-app-layout>
