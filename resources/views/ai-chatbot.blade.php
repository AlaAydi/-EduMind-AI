<x-app-layout :title="'EduMind AI Tutor'">

    <div class="flex flex-col h-[calc(100vh-80px)] relative z-10">

        <!-- Header -->
        <div class="mb-4">
            <span class="text-xs font-bold text-purple-400 uppercase tracking-widest">Neural Copilot</span>
            <h2 class="text-3xl font-extrabold text-white mt-1">AI Chatbot Console</h2>
            <p class="text-xs text-slate-450 mt-1">Ask questions, request code summaries, or seek syllabus progression advice.</p>
        </div>

        <!-- Chat Container (full width + flex-1 pour prendre tout l'espace restant) -->
        <div class="flex-1 flex flex-col bg-slate-900/40 border border-slate-900 rounded-3xl overflow-hidden"
            x-data="{
                queryText: '{{ $prefilledMsg ?? '' }}',
                sendPrompt(text) {
                    this.queryText = text;
                    this.$refs.chatForm.submit();
                }
            }">

            <!-- Messages Container (flex-1 = prend tout l'espace dispo) -->
            <div class="flex-1 p-6 overflow-y-auto space-y-6" id="chat-messages-container">
                @forelse ($messages as $msg)
                    <!-- User Message bubble -->
                    <div class="flex justify-end">
                        <div class="max-w-2xl bg-purple-500/10 border border-purple-500/20 text-purple-300 rounded-2xl rounded-tr-none px-4 py-3 text-xs leading-relaxed font-medium shadow-sm">
                            <span class="text-[9px] font-extrabold text-purple-400 block mb-1 text-right">YOU</span>
                            {{ $msg->message }}
                        </div>
                    </div>

                    <!-- AI Reply bubble -->
                    <div class="flex justify-start">
                        <div class="max-w-2xl bg-slate-950/70 border border-slate-900 text-slate-300 rounded-2xl rounded-tl-none px-4 py-3 text-xs leading-relaxed font-medium shadow-glow border-purple-500/5">
                            <div class="flex items-center gap-2 mb-1.5">
                                <div class="w-4 h-4 rounded bg-purple-500 flex items-center justify-center text-[9px] font-bold text-white uppercase">AI</div>
                                <span class="text-[9px] font-extrabold text-purple-450 uppercase tracking-wider">EduMind AI</span>
                            </div>
                            {{ $msg->response }}
                        </div>
                    </div>
                @empty
                    <!-- Welcome Display if Empty -->
                    <div class="h-full flex flex-col items-center justify-center text-center py-12 space-y-5">
                        <div class="w-16 h-16 rounded-3xl bg-gradient-to-tr from-purple-500 to-indigo-500 flex items-center justify-center text-white shadow-glow shadow-purple-500/20 animate-pulse">
                            <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-extrabold text-white">Ask EduMind AI Tutor Anything</h4>
                            <p class="text-xs text-slate-550 max-w-xs mx-auto mt-1 leading-relaxed">Type coding problems, ask for template explanations, or ask for progression tips.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Input Bar (collé en bas) -->
            <div class="p-4 bg-slate-950/40 border-t border-slate-900">
                <form action="{{ route('ai-chatbot.message') }}" method="POST" class="m-0 p-0 flex gap-3" x-ref="chatForm">
                    @csrf
                    <input type="text" name="message" x-model="queryText"
                        placeholder="Ask details about laravel, python charts, prompt engineering..."
                        class="flex-1 text-xs bg-slate-950 border border-slate-850 rounded-2xl px-4 py-3 text-slate-250 focus:outline-none focus:border-purple-500 placeholder-slate-700"
                        required>
                    <button type="submit" class="px-5 bg-gradient-to-r from-purple-500 to-indigo-500 text-white text-xs font-bold rounded-2xl hover:shadow-glow shadow-md hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center justify-center gap-1.5">
                        Send
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var chatBox = document.getElementById("chat-messages-container");
            if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;
        });
    </script>

</x-app-layout>
