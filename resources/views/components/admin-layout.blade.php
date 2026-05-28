@props(['title' => 'Admin Panel'])

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} — EduMind Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }
        body { background: #0a0a0f; margin: 0; }

        .sidebar {
            background: linear-gradient(180deg, #0f0f1a 0%, #12121f 100%);
            border-right: 1px solid rgba(139, 92, 246, 0.15);
            width: 256px;
            min-height: 100vh;
            position: fixed;
            left: 0; top: 0;
            display: flex;
            flex-direction: column;
            z-index: 50;
        }

        .nav-link {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 16px; border-radius: 10px;
            color: #9ca3af; font-size: 14px; font-weight: 500;
            text-decoration: none; transition: all 0.2s;
            border: 1px solid transparent;
        }
        .nav-link:hover { background: rgba(139, 92, 246, 0.1); color: #c4b5fd; }
        .nav-link.active {
            background: linear-gradient(135deg, rgba(139,92,246,0.2), rgba(59,130,246,0.1));
            color: #a78bfa;
            border-color: rgba(139, 92, 246, 0.25);
        }

        .admin-card {
            background: rgba(255,255,255,0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #7c3aed, #4f46e5);
            color: white; padding: 9px 20px; border-radius: 10px;
            font-size: 14px; font-weight: 600; border: none;
            cursor: pointer; transition: all 0.2s;
            text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 25px rgba(124,58,237,0.4); color: white; }

        .btn-danger {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white; padding: 6px 14px; border-radius: 8px;
            font-size: 13px; font-weight: 600; border: none;
            cursor: pointer; transition: all 0.2s;
            text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-danger:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(220,38,38,0.35); color: white; }

        .btn-success {
            background: linear-gradient(135deg, #059669, #047857);
            color: white; padding: 6px 14px; border-radius: 8px;
            font-size: 13px; font-weight: 600; border: none;
            cursor: pointer; transition: all 0.2s;
            text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-success:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(5,150,105,0.35); color: white; }

        .btn-edit {
            background: rgba(59,130,246,0.12); border: 1px solid rgba(59,130,246,0.25);
            color: #93c5fd; padding: 6px 14px; border-radius: 8px;
            font-size: 13px; font-weight: 500; cursor: pointer;
            transition: all 0.2s; text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-edit:hover { background: rgba(59,130,246,0.22); color: #bfdbfe; }

        .badge-teacher { background: rgba(139,92,246,0.2); color: #c4b5fd; border: 1px solid rgba(139,92,246,0.3); padding: 2px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .badge-student { background: rgba(16,185,129,0.2); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.3); padding: 2px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .badge-approved { background: rgba(16,185,129,0.15); color: #6ee7b7; border: 1px solid rgba(16,185,129,0.3); padding: 2px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; }
        .badge-pending { background: rgba(245,158,11,0.15); color: #fcd34d; border: 1px solid rgba(245,158,11,0.3); padding: 2px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; }

        .form-input {
            width: 100%; background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px; padding: 10px 14px; color: #e5e7eb; font-size: 14px;
            outline: none; transition: border-color 0.2s;
        }
        .form-input:focus { border-color: rgba(139,92,246,0.5); }
        .form-input::placeholder { color: #6b7280; }
        select.form-input option { background: #1f1f2e; color: #e5e7eb; }

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

        .main-content { margin-left: 256px; padding: 32px; min-height: 100vh; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <!-- Logo -->
        <div style="padding: 24px; border-bottom: 1px solid rgba(255,255,255,0.05);">
            <a href="{{ route('admin.dashboard') }}" style="display:flex; align-items:center; gap:12px; text-decoration:none;">
                <div style="width:36px; height:36px; border-radius:10px; background: linear-gradient(135deg,#7c3aed,#4f46e5); display:flex; align-items:center; justify-content:center; color:white; font-weight:800; font-size:18px;">A</div>
                <div>
                    <p style="color:white; font-weight:700; font-size:14px; margin:0;">EduMind AI</p>
                    <p style="color:#a78bfa; font-size:11px; margin:0; font-weight:600;">Admin Panel</p>
                </div>
            </a>
        </div>

        <!-- Nav -->
        <nav style="flex:1; padding:16px; display:flex; flex-direction:column; gap:4px;">
            <p style="color:#4b5563; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; padding: 0 12px; margin-bottom:8px; margin-top:4px;">Navigation</p>

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

            <div style="border-top: 1px solid rgba(255,255,255,0.05); margin: 12px 0;"></div>
            <p style="color:#4b5563; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; padding: 0 12px; margin-bottom:8px;">Application</p>

            <a href="{{ route('dashboard') }}" class="nav-link">
                <span>🏠</span> App principale
            </a>
        </nav>

        <!-- User / Logout -->
        <div style="padding:16px; border-top: 1px solid rgba(255,255,255,0.05);">
            <div style="display:flex; align-items:center; gap:12px; padding: 0 8px; margin-bottom:12px;">
                <div style="width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,#7c3aed,#4f46e5); display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:14px; flex-shrink:0;">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div style="flex:1; min-width:0;">
                    <p style="color:white; font-size:13px; font-weight:600; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ Auth::user()->name }}</p>
                    <p style="color:#a78bfa; font-size:11px; margin:0;">Administrateur</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link" style="width:100%; background:none; border:1px solid transparent; cursor:pointer; color:#f87171; justify-content:flex-start;" onmouseover="this.style.background='rgba(239,68,68,0.1)'; this.style.color='#fca5a5';" onmouseout="this.style.background='none'; this.style.color='#f87171';">
                    <span>🚪</span> Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="alert-success" style="margin-bottom:24px;">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error" style="margin-bottom:24px;">❌ {{ session('error') }}</div>
        @endif

        {{ $slot }}
    </main>

</body>
</html>
