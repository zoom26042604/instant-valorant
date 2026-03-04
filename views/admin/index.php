<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin — Tableau de bord · Instant-Valorant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/assets/css/app.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest" defer></script>
</head>
<body class="bg-valo-dark text-white min-h-screen flex flex-col select-none">

<nav class="border-b border-white px-4 sm:px-10 py-4 flex items-center justify-between sticky top-0 z-50 bg-valo-dark/95 backdrop-blur-sm">
    <a href="/" class="font-valo font-bold text-2xl tracking-[0.2em] cursor-pointer">
        INSTANT<span class="text-valo-red font-valo">-VALORANT</span>
    </a>
    <div class="hidden md:flex items-center gap-2 text-[11px] tracking-[0.15em] font-valo font-semibold text-white">
        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 dot-pulse"></span>
        KINGDOM CORP. · ACCÈS ADMINISTRATEUR
    </div>
    <div class="flex items-center gap-2 sm:gap-3">
        <a href="/admin/users"
           class="flex items-center gap-2 border border-white/30 px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-white hover:text-white transition-all duration-200 group">
            <i data-lucide="users" class="w-4 h-4 group-hover:text-white transition-colors"></i>
            Agents
        </a>
        <a href="/admin/games"
           class="flex items-center gap-2 border border-white/30 px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-white hover:text-white transition-all duration-200 group">
            <i data-lucide="gamepad-2" class="w-4 h-4 group-hover:text-white transition-colors"></i>
            Jeux
        </a>
        <a href="/games"
           class="flex items-center gap-2 border border-white px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-white/50 hover:text-white transition-all duration-200 group">
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
        <a href="javascript:history.back()" class="flex items-center gap-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:text-valo-red transition-colors duration-150">
            <i data-lucide="arrow-big-left" class="w-6 h-6 text-white mb-2 hover:text-valo-red cursor-pointer"></i>
            RETOUR
        </a>
        <p class="text-[11px] text-valo-red font-valo font-semibold tracking-[0.25em] uppercase mb-3">
            // PANNEAU DE CONTRÔLE — ACCÈS RESTREINT
        </p>
        <h1 class="font-valo font-bold text-[3.2rem] tracking-[0.08em] leading-none mb-5">
            TABLEAU DE <span class="text-yellow-400">BORD</span>
        </h1>
        <div class="flex items-center gap-6 text-[13px]">
            <span class="flex items-center gap-2 text-white">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                <?= count(R::findAll('user')) ?> agents
            </span>
            <span class="flex items-center gap-2 text-white">
                <span class="w-2 h-2 rounded-full bg-yellow-400"></span>
                <?= count(R::findAll('game')) ?> jeux
            </span>
            <span class="flex items-center gap-2 text-white">
                <span class="w-2 h-2 rounded-full bg-white/30"></span>
                <?= count(R::findAll('achievement')) ?> succès
            </span>
        </div>
    </div>

    <div class="flex items-center justify-between mb-1">
        <h2 class="text-[11px] font-valo font-semibold tracking-[0.25em] text-white uppercase">
            Sections de contrôle
        </h2>
        <span class="text-[11px] font-valo tracking-[0.15em] text-white uppercase">
            Protocole Sécurisé · Niveau 5
        </span>
    </div>
    <div class="border-t border-white/20 mb-8"></div>

    <?php
    $totalUsers  = count(R::findAll('user'));
    $totalAdmins = count(R::find('user', 'role = ?', ['admin']));
    $totalGames  = count(R::findAll('game'));
    $totalAch    = count(R::findAll('achievement'));
    ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 max-w-3xl">

        <a href="/admin/users"
           class="group relative border border-white/10 hover:border-yellow-500/50 rounded-2xl p-8 flex flex-col gap-5 transition-all duration-300 hover:bg-yellow-500/5 hover:-translate-y-1.5 overflow-hidden">
            <div class="absolute top-0 right-0 w-36 h-36 bg-yellow-500/5 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:bg-yellow-500/10 transition-colors duration-300 pointer-events-none"></div>
            <div class="flex items-start justify-between relative z-10">
                <div class="border border-yellow-500/30 rounded-xl p-3 bg-yellow-500/10 group-hover:bg-yellow-500/20 transition-colors">
                    <i data-lucide="shield" class="w-6 h-6 text-yellow-400"></i>
                </div>
                <span class="text-[10px] font-valo tracking-[0.2em] uppercase text-yellow-500/40 group-hover:text-yellow-500/70 transition-colors mt-1">ADMIN //</span>
            </div>
            <div class="relative z-10">
                <p class="font-valo font-bold text-2xl tracking-[0.1em] mb-2">AGENTS</p>
                <p class="text-xs text-white/50 leading-relaxed">Gérer les utilisateurs, changer les rôles, supprimer des comptes.</p>
            </div>
            <div class="flex items-center justify-between relative z-10 pt-3 border-t border-white/5">
                <span class="text-[11px] font-valo tracking-widest text-white/30"><?= $totalUsers ?> agents · <?= $totalAdmins ?> admins</span>
                <div class="flex items-center gap-1.5 leading-none text-[11px] font-valo tracking-widest text-yellow-500/50 group-hover:text-yellow-400 uppercase transition-colors">
                    Accéder <i data-lucide="arrow-big-right" class="w-3.5 h-3.5 shrink-0 group-hover:translate-x-1 transition-transform duration-200"></i>
                </div>
            </div>
        </a>

        <a href="/admin/games"
           class="group relative border border-white/10 hover:border-valo-red/50 rounded-2xl p-8 flex flex-col gap-5 transition-all duration-300 hover:bg-valo-red/5 hover:-translate-y-1.5 overflow-hidden">
            <div class="absolute top-0 right-0 w-36 h-36 bg-valo-red/5 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:bg-valo-red/10 transition-colors duration-300 pointer-events-none"></div>
            <div class="flex items-start justify-between relative z-10">
                <div class="border border-valo-red/30 rounded-xl p-3 bg-valo-red/10 group-hover:bg-valo-red/20 transition-colors">
                    <i data-lucide="gamepad-2" class="w-6 h-6 text-valo-red"></i>
                </div>
                <span class="text-[10px] font-valo tracking-[0.2em] uppercase text-valo-red/40 group-hover:text-valo-red/70 transition-colors mt-1">MISSIONS //</span>
            </div>
            <div class="relative z-10">
                <p class="font-valo font-bold text-2xl tracking-[0.1em] mb-2">JEUX & SUCCÈS</p>
                <p class="text-xs text-white/50 leading-relaxed">Ajouter, modifier ou supprimer des jeux et leurs succès.</p>
            </div>
            <div class="flex items-center justify-between relative z-10 pt-3 border-t border-white/5">
                <span class="text-[11px] font-valo tracking-widest text-white/30"><?= $totalGames ?> jeux · <?= $totalAch ?> succès</span>
                <div class="flex items-center gap-1.5 leading-none text-[11px] font-valo tracking-widest text-valo-red/50 group-hover:text-valo-red uppercase transition-colors">
                    Accéder <i data-lucide="arrow-big-right" class="w-3.5 h-3.5 shrink-0 group-hover:translate-x-1 transition-transform duration-200"></i>
                </div>
            </div>
        </a>

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
