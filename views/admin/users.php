<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin — Utilisateurs · Instant-Valorant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/assets/css/app.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest" defer></script>
</head>
<body class="bg-valo-dark text-white min-h-screen flex flex-col select-none">

<nav class="border-b border-white px-4 sm:px-10 py-4 flex items-center justify-between sticky top-0 z-50 bg-valo-dark/95 backdrop-blur-sm">
    <a href="/admin" class="font-valo font-bold text-2xl tracking-[0.2em] cursor-pointer">
        INSTANT<span class="text-valo-red font-valo">-VALORANT</span>
    </a>

    <div class="hidden md:flex items-center gap-2 text-[11px] tracking-[0.15em] font-valo font-semibold text-white">
        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 dot-pulse"></span>
        KINGDOM CORP. · ACCÈS ADMINISTRATEUR
    </div>
    <div class="flex items-center gap-2 sm:gap-3">
        <a href="/admin/users"
           class="flex items-center gap-2 border border-white px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-white/50 hover:text-white transition-all duration-200 group">
            <i data-lucide="users" class="w-4 h-4 text-white group-hover:text-white transition-colors"></i>
            Agents
        </a>
        <a href="/admin/games"
           class="flex items-center gap-2 border border-white/30 px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-white hover:text-white transition-all duration-200 group">
            <i data-lucide="gamepad-2" class="w-4 h-4 group-hover:text-white transition-colors"></i>
            Jeux
        </a>
        <a href="/games"
           class="flex items-center gap-2 border border-white/30 px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-white/50 hover:text-white transition-all duration-200 group">
            <i data-lucide="layout-grid" class="w-4 h-4 text-white group-hover:text-white transition-colors"></i>
            Missions
        </a>
        <a href="/logout"
           class="flex items-center gap-2 border border-white px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-valo-red/60 hover:text-valo-red transition-all duration-200 group">
            <i data-lucide="log-out" class="w-4 h-4 text-valo-red/60 group-hover:text-valo-red transition-colors"></i>
            Quitter Protocole
        </a>
    </div>
</nav>

<main class="flex-1 px-4 sm:px-8 md:px-16 py-8 md:py-14">

    <div class="mb-14">
        <p class="text-[11px] text-valo-red font-valo font-semibold tracking-[0.25em] uppercase mb-3">
            // PANNEAU DE CONTRÔLE — ACCÈS RESTREINT
        </p>
        <h1 class="font-valo font-bold text-[3.2rem] tracking-[0.08em] leading-none mb-5">
            GESTION DES <span class="text-yellow-400">AGENTS</span>
        </h1>

        <div class="flex items-center gap-6 text-[13px]">
            <span class="flex items-center gap-2 text-white">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                <?= count($users) ?> agents enregistrés
            </span>
            <span class="flex items-center gap-2 text-white">
                <span class="w-2 h-2 rounded-full bg-yellow-400"></span>
                <?= count(array_filter($users, fn($u) => ($u->role ?? 'user') === 'admin')) ?> administrateurs
            </span>
            <span class="flex items-center gap-2 text-white">
                <span class="w-2 h-2 rounded-full bg-white/30"></span>
                <?= count(array_filter($users, fn($u) => ($u->role ?? 'user') === 'user')) ?> agents standard
            </span>
        </div>
    </div>

    <div class="flex items-center justify-between mb-1">
        <h2 class="text-[11px] font-valo font-semibold tracking-[0.25em] text-white uppercase">
            Registre des agents
        </h2>
        <span class="text-[11px] font-valo tracking-[0.15em] text-white uppercase">
            Protocole Sécurisé · Niveau 5
        </span>
    </div>
    <div class="border-t border-white/20 mb-6"></div>

    <div class="border border-white/10 rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
            <thead>
            <tr class="border-b border-white/10 bg-white/4">
                <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Agent</th>
                <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Email</th>
                <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Rang</th>
                <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $u): ?>
                <?php $isAdmin = ($u->role ?? 'user') === 'admin'; ?>
                <tr class="border-b border-white/10 hover:bg-white/4 transition-colors duration-150 group">

                    <td class="px-5 py-4">
                            <span class="flex items-center gap-2 font-valo text-sm tracking-wide">
                                <i data-lucide="user-round" class="w-4 h-4 text-white shrink-0"></i>
                                <?= htmlspecialchars($u->name) ?>
                            </span>
                    </td>

                    <td class="px-5 py-4 text-xs text-white font-valo">
                        <?= htmlspecialchars($u->email) ?>
                    </td>

                    <td class="px-5 py-4">
                        <?php if ($isAdmin): ?>
                            <span class="flex items-center gap-1.5 w-fit text-[11px] font-valo tracking-[0.15em] uppercase text-yellow-400/80 border border-yellow-500/30 px-2 py-0.5">
                                    <i data-lucide="shield" class="w-3 h-3"></i>
                                    Admin
                                </span>
                        <?php else: ?>
                            <span class="flex items-center gap-1.5 w-fit text-[11px] font-valo tracking-widest uppercase text-white border border-white/10 px-2 py-0.5">
                                    <i data-lucide="crosshair" class="w-3 h-3"></i>
                                    Agent
                                </span>
                        <?php endif; ?>
                    </td>

                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">

                            <form method="POST" action="/admin/users/<?= $u->id ?>/role" class="flex items-center gap-1.5">
                                <select name="role"
                                        class="bg-black border <?= $isAdmin ? 'border-yellow-500/40 text-yellow-400' : 'border-white/15 text-white/80' ?> text-[11px] font-valo tracking-widest uppercase px-2 py-1.5 outline-none hover:border-white/30 focus:border-yellow-500/60 transition-colors cursor-pointer appearance-none pr-6"
                                        style="background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='rgba(255,255,255,0.3)' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E\");background-repeat:no-repeat;background-position:right 8px center;">
                                    <option value="user"  <?= !$isAdmin ? 'selected' : '' ?> style="background:#000;color:#fff;">Agent</option>
                                    <option value="admin" <?= $isAdmin  ? 'selected' : '' ?> style="background:#000;color:#eab308;">Admin</option>
                                </select>
                                <button type="submit"
                                        class="flex items-center gap-1.5 text-[11px] font-valo tracking-widest uppercase text-yellow-500/50 hover:text-yellow-400 border border-yellow-500/20 hover:border-yellow-500/50 px-3 py-1.5 transition-all duration-150">
                                    <i data-lucide="refresh-cw" class="w-3 h-3"></i>
                                    Changer
                                </button>
                            </form>

                            <?php if ($u->id != $_SESSION['user_id']): ?>
                                <form method="POST" action="/admin/users/<?= $u->id ?>/delete"
                                      onsubmit="return confirm('Supprimer l\'agent <?= htmlspecialchars($u->name) ?> ?')">
                                    <button type="submit"
                                            class="flex items-center gap-1.5 text-[11px] font-valo tracking-widest uppercase text-valo-red/50 hover:text-valo-red border border-valo-red/20 hover:border-valo-red/50 px-3 py-1 transition-all duration-150">
                                        <i data-lucide="trash-2" class="w-3 h-3"></i>
                                        Supprimer
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="text-[11px] font-valo tracking-widest uppercase text-white px-3 py-1 border border-white/5">
                                        Vous
                                    </span>
                            <?php endif; ?>

                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</main>

<footer class="border-t border-white/10 px-4 sm:px-16 py-5 flex items-center justify-between">
    <div class="font-valo font-bold text-lg tracking-[0.2em]">
        INSTANT<span class="text-valo-red">-VALORANT</span>
    </div>
    <p class="text-white text-xs tracking-wide">Ynov Campus · Made with ♥ by Nathan & Laurine.</p>
</footer>

<script src="/assets/js/index.js"></script>
</body>
</html>


