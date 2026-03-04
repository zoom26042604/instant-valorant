<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Protocoles — Instant-Valorant</title>
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
        <span class="font-valo w-1.5 h-1.5 rounded-full bg-valo-red dot-pulse"></span>
        KINGDOM CORP. · PROTOCOLE ACTIF
    </div>

    <div class="flex items-center gap-2 sm:gap-3">
        <?php if (!empty($_SESSION['user_id'])): ?>

            <a href="/profile"
               class="flex items-center gap-2 border border-white px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-white/50 hover:text-white transition-all duration-200 group">
                <i data-lucide="user-round-search" class="w-4 h-4 text-white group-hover:text-white transition-colors"></i>
                Dossier Agent
            </a>

            <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <a href="/admin/users"
                   class="flex items-center gap-2 border border-yellow-500 px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-yellow-500/60 hover:text-yellow-400 transition-all duration-200 group">
                    <i data-lucide="shield" class="w-4 h-4 text-yellow-500 group-hover:text-yellow-400 transition-colors"></i>
                    Admin
                </a>
            <?php endif; ?>

            <a href="/logout"
               class="flex items-center gap-2 border border-white px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-valo-red/60 hover:text-valo-red transition-all duration-200 group">
                <i data-lucide="log-out" class="w-4 h-4 text-valo-red group-hover:text-valo-red transition-colors"></i>
                Quitter Protocole
            </a>

        <?php else: ?>

            <a href="/login"
               class="flex items-center gap-2 border border-white px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-white/50 hover:text-white transition-all duration-200 group">
                <i data-lucide="log-in" class="w-4 h-4 text-white/60 group-hover:text-white transition-colors"></i>
                Connexion
            </a>

            <a href="/register"
               class="flex items-center gap-2 border border-valo-red/40 px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-valo-red/80 hover:text-valo-red transition-all duration-200 group">
                <i data-lucide="user-plus" class="w-4 h-4 text-valo-red/60 group-hover:text-valo-red transition-colors"></i>
                Inscription
            </a>

        <?php endif; ?>
    </div>
</nav>

<main class="flex-1 px-4 sm:px-8 md:px-16 py-8 md:py-14">

    <div class="mb-14">
        <p class="text-valo-red text-[11px] font-valo font-semibold tracking-[0.25em] uppercase mb-3">
            // ROYAUME VALORANT — PROTOCOLES DISPONIBLES
        </p>
        <h1 class="font-valo font-bold text-[3.2rem] tracking-[0.08em] leading-none mb-5">
            MISSIONS <span class="text-valo-red">ACTIVES</span>
        </h1>
        <div class="flex items-center gap-6 text-[13px]">
            <span class="flex items-center gap-2 text-white">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                <?= count($games) ?> protocole<?= count($games) > 1 ? 's' : '' ?> disponible<?= count($games) > 1 ? 's' : '' ?>
            </span>
            <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <a href="/games/create"
                   class="flex items-center gap-2 border border-yellow-500/40 px-4 py-1.5 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-yellow-500/80 hover:text-yellow-400 transition-all duration-200 group">
                    <i data-lucide="plus" class="w-3.5 h-3.5 text-yellow-500 group-hover:text-yellow-400 transition-colors"></i>
                    Ajouter un jeu
                </a>
                <button onclick="fetch('/api/games/seed',{method:'POST'}).then(r=>r.json()).then(d=>alert(d.message))"
                        class="flex items-center gap-2 border border-white/20 px-4 py-1.5 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-white/40 hover:text-white/60 transition-all duration-200">
                    <i data-lucide="database" class="w-3.5 h-3.5 text-white/40"></i>
                    Seeder
                </button>
            <?php endif; ?>
        </div>
    </div>

    <div class="flex items-center justify-between mb-1">
        <h2 class="text-[11px] font-valo font-semibold tracking-[0.25em] text-white uppercase">
            Tous les protocoles
        </h2>
    </div>
    <div class="border-t border-white/10 mb-6"></div>

    <?php if (empty($games)): ?>
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <i data-lucide="gamepad-2" class="w-12 h-12 text-white/10 mb-4"></i>
            <p class="text-white/30 text-sm font-valo tracking-[0.15em] uppercase">Aucun protocole disponible</p>
            <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <a href="/games/create" class="mt-4 text-valo-red/60 hover:text-valo-red text-[11px] font-valo tracking-[0.15em] uppercase transition-colors">
                    + Ajouter le premier
                </a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <?php
        $themes = [
            'League of Legends' => ['border' => 'border-yellow-500/20', 'hover' => 'hover:border-yellow-500/60', 'shadow' => 'hover:shadow-yellow-500/20', 'icon' => 'swords',     'iconColor' => 'text-yellow-500/60', 'tag' => 'text-yellow-500/40', 'label' => 'text-yellow-500/70', 'tagText' => 'NEXUS //'],
            'Valorant'          => ['border' => 'border-valo-red/20',   'hover' => 'hover:border-valo-red/60',   'shadow' => 'hover:shadow-valo-red/20',   'icon' => 'crosshair', 'iconColor' => 'text-valo-red/60',   'tag' => 'text-valo-red/40',   'label' => 'text-valo-red/70',   'tagText' => 'SPIKE //'],
            'Mario Kart'        => ['border' => 'border-red-400/20',    'hover' => 'hover:border-red-400/60',    'shadow' => 'hover:shadow-red-400/20',    'icon' => 'car',       'iconColor' => 'text-red-400/60',    'tag' => 'text-red-400/40',    'label' => 'text-red-400/70',    'tagText' => 'RACE //'],
            'Avatar: Frontiers of Pandora' => ['border' => 'border-cyan-400/20',   'hover' => 'hover:border-cyan-400/60',   'shadow' => 'hover:shadow-cyan-400/20',   'icon' => 'waves',     'iconColor' => 'text-cyan-400/60',   'tag' => 'text-cyan-400/40',   'label' => 'text-cyan-400/70',   'tagText' => 'PANDORA //'],
            'Skyrim'            => ['border' => 'border-purple-400/20', 'hover' => 'hover:border-purple-400/60', 'shadow' => 'hover:shadow-purple-400/20', 'icon' => 'flame',     'iconColor' => 'text-purple-400/60', 'tag' => 'text-purple-400/40', 'label' => 'text-purple-400/70', 'tagText' => 'DOVAH //'],
        ];
        $themeFallback = array_values($themes);
        ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
            <?php foreach ($games as $i => $game): ?>
                <?php $t = $themes[$game->name] ?? $themeFallback[$i % count($themeFallback)]; ?>

                <!-- Carte avec lien absolu pour éviter les éléments interactifs imbriqués -->
                <div class="group relative flex flex-col bg-black border <?= $t['border'] ?> <?= $t['hover'] ?> rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1.5 hover:shadow-lg <?= $t['shadow'] ?>">

                    <!-- Lien couvrant toute la carte (z-0) -->
                    <a href="/games/<?= $game->id ?>" class="absolute inset-0 z-0" tabindex="-1" aria-hidden="true"></a>

                    <?php if (!empty($game->image_url)): ?>
                        <div class="h-28 overflow-hidden shrink-0">
                            <img src="<?= htmlspecialchars($game->image_url) ?>"
                                 alt="<?= htmlspecialchars($game->name) ?>"
                                 class="w-full h-full object-cover opacity-60 group-hover:opacity-80 transition-opacity duration-300 pointer-events-none">
                        </div>
                    <?php else: ?>
                        <div class="h-28 bg-black flex items-center justify-center relative overflow-hidden shrink-0 pointer-events-none">
                            <i data-lucide="<?= $t['icon'] ?>"
                               class="w-10 h-10 <?= $t['iconColor'] ?> relative z-10 group-hover:scale-110 transition-transform duration-300"></i>
                            <span class="absolute top-2 right-2.5 text-xs <?= $t['tag'] ?> font-valo tracking-wider">
                                <?= $t['tagText'] ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <div class="p-4 flex flex-col flex-1 pointer-events-none">
                        <?php if (!empty($game->type)): ?>
                            <span class="text-xs font-valo tracking-[0.2em] <?= $t['label'] ?> mb-1.5 uppercase">
                                <?= htmlspecialchars($game->type) ?>
                            </span>
                        <?php endif; ?>
                        <h3 class="text-sm font-valo mb-1.5 leading-tight"><?= htmlspecialchars($game->name) ?></h3>
                        <p class="text-white text-xs leading-relaxed mb-4 flex-1">
                            <?php if (!empty($game->description)): ?>
                                <?= htmlspecialchars(mb_strimwidth($game->description, 0, 70, '…')) ?>
                            <?php endif; ?>
                        </p>
                        <div class="flex items-center gap-1.5 text-xs pt-3 border-t border-white/5">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-400 shrink-0 animate-pulse"></span>
                            <span class="text-green-400/70">Disponible</span>
                        </div>
                    </div>


                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</main>

<footer class="border-t border-white px-4 sm:px-16 py-5 flex items-center justify-between">
    <div class="font-valo font-bold text-lg tracking-[0.2em]">
        INSTANT<span class="text-valo-red">-VALORANT</span>
    </div>
    <p class="text-white text-xs tracking-wide">Ynov Campus · Made with ♥ by Nathan & Laurine.</p>
</footer>

<script src="/assets/js/index.js"></script>

</body>
</html>
