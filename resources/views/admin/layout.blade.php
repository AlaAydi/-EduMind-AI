<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel — EduMind AI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; }
        body { background: #0a0a0f; }

        .sidebar {
            background: linear-gradient(180deg, #0f0f1a 0%, #12121f 100%);
            border-right: 1px solid rgba(139, 92, 246, 0.15);
        }

        .nav-link {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 16px; border-radius: 10px;
            color: #9ca3af; font-size: 14px; font-weight: 500;
            text-decoration: none; transition: all 0.2s;
        }
        .nav-link:hover {
            background: rgba(139, 92, 246, 0.1);
            color: #c4b5fd;
        }
        .nav-link.active {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(59, 130, 246, 0.1));
            color: #a78bfa;
            border: 1px solid rgba(139, 92, 246, 0.25);
        }

        .admin-card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #7c3aed, #4f46e5);
            color: white; padding: 8px 20px; border-radius: 10px;
            font-size: 14px; font-weight: 600; border: none;
            cursor: pointer; transition: all 0.2s; text-decoration: none;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 25px rgba(124,58,237,0.4); }

        .btn-danger {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white; padding: 6px 14px; border-radius: 8px;
            font-size: 13px; font-weight: 600; border: none;
            cursor: pointer; transition: all 0.2s; text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(220,38,38,0.4); }

        .btn-success {
            background: linear-gradient(135deg, #059669, #047857);
            color: white; padding: 6px 14px; border-radius: 8px;
            font-size: 13px; font-weight: 600; border: none;
            cursor: pointer; transition: all 0.2s; text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-success:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(5,150,105,0.4); }

        .btn-edit {
            background: rgba(59,130,246,0.15); border: 1px solid rgba(59,130,246,0.3);
            color: #93c5fd; padding: 6px 14px; border-radius: 8px;
            font-size: 13px; font-weight: 500; cursor: pointer;
            transition: all 0.2s; text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-edit:hover { background: rgba(59,130,246,0.25); }

        .badge-teacher { background: rgba(139,92,246,0.2); color: #c4b5fd; border: 1px solid rgba(139,92,246,0.3); }
        .badge-student { background: rgba(16,185,129,0.2); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.3); }
        .badge-approved { background: rgba(16,185,129,0.2); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.3); }
        .badge-pending { background: rgba(245,158,11,0.2); color: #fcd34d; border: 1px solid rgba(245,158,11,0.3); }

        .form-input {
            width: 100%; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px; padding: 10px 14px; color: #e5e7eb; font-size: 14px;
            outline: none; transition: border-color 0.2s;
        }
        .form-input:focus { border-color: rgba(139,92,246,0.5); }
        .form-input::placeholder { color: #6b7280; }

        .form-label { color: #9ca3af; font-size: 13px; font-weight: 500; margin-bottom: 6px; display: block; }

        .table-row:hover { background: rgba(255,255,255,0.02); }

        .alert-success {
            background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3);
            color: #6ee7b7; padding: 12px 16px; border-radius: 10px; font-size: 14px;
        }
        .alert-error {
            background: rgba(220,38,38,0.1); border: 1px solid rgba(220,38,38,0.3);
            color: #fca5a5; padding: 12px 16px; border-radius: 10px; font-size: 14px;
        }
    </style>
</head>
<body class="min-h-screen flex">

    <!-- Sidebar -->
    <aside class="sidebar w-64 min-h-screen flex flex-col fixed left-0 top-0 z-50">
        <!-- Logo -->
        <div class="p-6 border-b border-white/5">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-600 to-blue-600 flex items-center justify-center text-white font-bold text-lg">A</div>
                <div>
                    <p class="text-white font-bold text-sm">EduMind AI</p>
                    <p class="text-violet-400 text-xs font-medium">Admin Panel</p>
                </div>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-4 space-y-1">
            <p class="text-gray-600 text-xs font-semibold uppercase tracking-wider px-3 mb-3">Navigation</p>

            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span>📊</span> Dashboard
            </a>
            <a href="{{ route('admin.users.index') }}"
               class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <span>👥</span> Utilisateurs
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <span>🏷️</span> Catégories
            </a>

            <div class="border-t border-white/5 my-3"></div>
            <p class="text-gray-600 text-xs font-semibold uppercase tracking-wider px-3 mb-3">Application</p>
            <a href="{{ route('dashboard') }}" class="nav-link">
                <span>🏠</span> App principale
            </a>
        </nav>

        <!-- User info -->
        <div class="p-4 border-t border-white/5">
            <div class="flex items-center gap-3 px-2">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-violet-500 to-blue-500 flex items-center justify-center text-white text-sm font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-violet-400 text-xs">Administrateur</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="w-full text-left nav-link text-red-400 hover:text-red-300 hover:bg-red-500/10">
                    <span>🚪</span> Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-64 min-h-screen p-8">

        <!-- Flash messages -->
        @if(session('success'))
            <div class="alert-success mb-6">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error mb-6">❌ {{ session('error') }}</div>
        @endif

        {{ $slot }}
    </main>

</body>
</html>
