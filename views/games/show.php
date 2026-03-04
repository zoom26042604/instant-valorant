<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($game->name) ?> — Instant-Valorant</title>
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
        <a href="/games"
           class="flex items-center gap-2 border border-white px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-white hover:text-white transition-all duration-200 group">
            <i data-lucide="layout-grid" class="w-4 h-4 text-white group-hover:text-white transition-colors"></i>
            Missions
        </a>

        <?php if (!empty($_SESSION['user_id'])): ?>

            <a href="/profile"
               class="flex items-center gap-2 border border-white px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-white/50 hover:text-white transition-all duration-200 group">
                <i data-lucide="user-round-search" class="w-4 h-4 text-white group-hover:text-white transition-colors"></i>
                Dossier Agent
            </a>

            <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <a href="/admin"
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

<main class="flex-1 flex flex-col">

    <!-- ═══ HERO BANNER ═══ -->
    <div class="relative w-full overflow-hidden" style="min-height: 420px;">

        <!-- Fond : image ou dégradé -->
        <?php if (!empty($game->image_url)): ?>
            <div class="absolute inset-0">
                <img src="<?= htmlspecialchars($game->image_url) ?>"
                     alt=""
                     class="w-full h-full object-cover opacity-25 scale-105"
                     style="filter: blur(2px);">
                <div class="absolute inset-0 bg-gradient-to-r from-black via-black/85 to-black/50"></div>
            </div>
        <?php else: ?>
            <div class="absolute inset-0 bg-gradient-to-br from-valo-red/8 via-black to-black"></div>
        <?php endif; ?>

        <!-- Grille décorative Valorant -->
        <div class="absolute inset-0 opacity-[0.025]"
             style="background-image: linear-gradient(rgba(255,255,255,.15) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.15) 1px, transparent 1px); background-size: 48px 48px;"></div>

        <!-- Barre rouge gauche -->
        <div class="absolute left-0 top-0 bottom-0 w-1 bg-valo-red"></div>

        <!-- Accent diagonal droit -->
        <div class="absolute top-0 right-0 w-80 h-full"
             style="background: linear-gradient(to left, rgba(189,57,68,.06), transparent); clip-path: polygon(30% 0, 100% 0, 100% 100%, 0 100%);"></div>

        <!-- Coins Valorant -->
        <div class="absolute top-6 right-6 w-8 h-8 border-t border-r border-valo-red/25"></div>
        <div class="absolute bottom-6 right-6 w-8 h-8 border-b border-r border-white/10"></div>

        <!-- Ligne du bas -->
        <div class="absolute bottom-0 left-0 right-0 h-px bg-white/8"></div>

        <!-- Contenu hero -->
        <div class="relative z-10 flex flex-col justify-end h-full px-6 sm:px-12 md:px-16 py-10 md:py-14"
             style="min-height: 420px;">

            <p class="text-valo-red text-[10px] sm:text-[11px] font-valo font-semibold tracking-[0.3em] uppercase mb-4">
                // FICHE PROTOCOLE<?php if (!empty($game->type)): ?> — <?= htmlspecialchars(strtoupper($game->type)) ?><?php endif; ?>
            </p>

            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
                <div class="flex-1">
                    <h1 class="font-valo font-bold text-4xl sm:text-5xl md:text-6xl lg:text-7xl tracking-[0.06em] leading-none mb-5">
                        <?= htmlspecialchars($game->name) ?>
                    </h1>

                    <!-- Badges -->
                    <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-5">
                        <?php if (!empty($game->type)): ?>
                            <span class="flex items-center gap-1.5 text-valo-red text-[10px] sm:text-[11px] font-valo tracking-[0.15em] uppercase border border-valo-red/40 px-3 py-1 bg-valo-red/5">
                                <i data-lucide="crosshair" class="w-3 h-3"></i>
                                <?= htmlspecialchars($game->type) ?>
                            </span>
                        <?php endif; ?>
                        <span class="flex items-center gap-1.5 text-white/50 text-[10px] sm:text-[11px] font-valo tracking-[0.15em] uppercase border border-white/15 px-3 py-1">
                            <i data-lucide="layers" class="w-3 h-3"></i>
                            <?= count($levels) ?> niveau<?= count($levels) > 1 ? 'x' : '' ?>
                        </span>
                        <span class="flex items-center gap-1.5 text-white/50 text-[10px] sm:text-[11px] font-valo tracking-[0.15em] uppercase border border-white/15 px-3 py-1">
                            <i data-lucide="trophy" class="w-3 h-3"></i>
                            <?= count($achievements) ?> succès
                        </span>
                    </div>

                    <!-- Description bien visible -->
                    <?php if (!empty($game->description)): ?>
                        <p class="text-white/65 text-sm sm:text-base leading-relaxed max-w-2xl">
                            <?= htmlspecialchars($game->description) ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Actions -->
                <div class="flex flex-row md:flex-col items-start md:items-end gap-2 shrink-0">
                    <?php if (!empty($_SESSION['user_id'])): ?>
                        <?php if (!empty($_SESSION['error'])): ?>
                            <div class="flex items-center gap-2 border border-valo-red/50 bg-valo-red/10 px-3 py-2 text-[10px] text-valo-red font-valo tracking-wide max-w-xs">
                                <i data-lucide="alert-triangle" class="w-3.5 h-3.5 shrink-0"></i>
                                <?= htmlspecialchars($_SESSION['error']) ?>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>
                        <?php if (!empty($userHasGame)): ?>
                            <div class="flex items-center gap-2 border border-green-500/30 bg-green-500/5 px-4 sm:px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase text-green-400/80">
                                <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                <span class="hidden sm:inline">Dans ma bibliothèque</span>
                                <span class="sm:hidden">Ajouté</span>
                            </div>
                        <?php else: ?>
                            <form method="POST" action="/profile/games">
                                <input type="hidden" name="game_id" value="<?= $game->id ?>">
                                <input type="hidden" name="_from" value="/games/<?= $game->id ?>">
                                <button type="submit"
                                        class="flex items-center gap-2 bg-valo-red border border-valo-red px-4 sm:px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:bg-valo-red/80 hover:border-valo-red/80 transition-all duration-200 group">
                                    <i data-lucide="plus" class="w-3.5 h-3.5 transition-colors"></i>
                                    <span class="hidden sm:inline">Ajouter à ma bibliothèque</span>
                                    <span class="sm:hidden">Ajouter</span>
                                </button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <a href="/games/<?= $game->id ?>/edit"
                           class="flex items-center gap-1.5 text-[11px] font-valo tracking-[0.1em] uppercase text-white/40 hover:text-white border border-white/10 hover:border-white/30 px-3 py-2 transition-all duration-150">
                            <i data-lucide="pencil" class="w-3 h-3"></i>
                            Modifier
                        </a>
                        <form method="POST" action="/games/<?= $game->id ?>/delete"
                              onsubmit="return confirm('Supprimer <?= htmlspecialchars(addslashes($game->name)) ?> ?')">
                            <button type="submit"
                                    class="flex items-center gap-1.5 text-[11px] font-valo tracking-[0.1em] uppercase text-valo-red/50 hover:text-valo-red border border-valo-red/20 hover:border-valo-red/50 px-3 py-2 transition-all duration-150">
                                <i data-lucide="trash-2" class="w-3 h-3"></i>
                                Supprimer
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══ CONTENU ═══ -->
    <div class="flex-1 px-6 sm:px-12 md:px-16 py-10 md:py-14">

    <!-- Niveaux & Succès en 2 colonnes -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10">

        <!-- Niveaux -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <h2 class="text-[11px] font-valo font-semibold tracking-[0.25em] text-white uppercase">Niveaux</h2>
                <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                    <a href="/games/<?= $game->id ?>/levels/create"
                       class="flex items-center gap-2 border border-yellow-500/40 px-3 py-1 text-[10px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-yellow-500/80 hover:text-yellow-400 transition-all duration-200 group">
                        <i data-lucide="plus" class="w-3 h-3 text-yellow-500 group-hover:text-yellow-400 transition-colors"></i>
                        Ajouter
                    </a>
                <?php endif; ?>
            </div>
            <div class="border-t border-white/10 mb-6"></div>

            <?php if (empty($levels)): ?>
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <i data-lucide="layers" class="w-10 h-10 text-white/10 mb-3"></i>
                    <p class="text-white/20 text-sm font-valo tracking-[0.15em] uppercase">Aucun niveau</p>
                </div>
            <?php else: ?>
                <div class="border border-white/5 rounded-2xl overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                        <tr class="border-b border-white/5 bg-white/2">
                            <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Nom</th>
                            <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Description</th>
                            <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Actions</th>
                            <?php endif; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($levels as $level): ?>
                            <tr class="border-b border-white/5 hover:bg-white/2 transition-colors duration-150 group">
                                <td class="px-5 py-4">
                                    <span class="flex items-center gap-2 font-valo text-sm tracking-wide">
                                        <i data-lucide="layers" class="w-4 h-4 text-valo-red/30 shrink-0"></i>
                                        <?= htmlspecialchars($level->name) ?>
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-xs text-white/40">
                                    <?= htmlspecialchars($level->description ?? '—') ?>
                                </td>
                                <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="/levels/<?= $level->id ?>/edit"
                                               class="flex items-center gap-1.5 text-[11px] font-valo tracking-[0.1em] uppercase text-white/40 hover:text-white border border-white/10 hover:border-white/30 px-3 py-1 transition-all duration-150">
                                                <i data-lucide="pencil" class="w-3 h-3"></i>
                                                Modifier
                                            </a>
                                            <form method="POST" action="/levels/<?= $level->id ?>/delete"
                                                  onsubmit="return confirm('Supprimer ?')">
                                                <button type="submit"
                                                        class="flex items-center gap-1.5 text-[11px] font-valo tracking-[0.1em] uppercase text-valo-red/50 hover:text-valo-red border border-valo-red/20 hover:border-valo-red/50 px-3 py-1 transition-all duration-150">
                                                    <i data-lucide="trash-2" class="w-3 h-3"></i>
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Succès -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <h2 class="text-[11px] font-valo font-semibold tracking-[0.25em] text-white uppercase">Succès</h2>
                <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                    <a href="/games/<?= $game->id ?>/achievements/create"
                       class="flex items-center gap-2 border border-yellow-500/40 px-3 py-1 text-[10px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-yellow-500/80 hover:text-yellow-400 transition-all duration-200 group">
                        <i data-lucide="plus" class="w-3 h-3 text-yellow-500 group-hover:text-yellow-400 transition-colors"></i>
                        Ajouter
                    </a>
                <?php endif; ?>
            </div>
            <div class="border-t border-white/10 mb-6"></div>

            <?php if (empty($achievements)): ?>
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <i data-lucide="trophy" class="w-10 h-10 text-white/10 mb-3"></i>
                    <p class="text-white/20 text-sm font-valo tracking-[0.15em] uppercase">Aucun succès</p>
                </div>
            <?php else: ?>
                <div class="border border-white/5 rounded-2xl overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                        <tr class="border-b border-white/5 bg-white/2">
                            <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Succès</th>
                            <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Description</th>
                            <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($achievements as $achievement): ?>
                            <tr class="border-b border-white/5 hover:bg-white/2 transition-colors duration-150 group">
                                <td class="px-5 py-4">
                                    <span class="flex items-center gap-2 font-valo text-sm tracking-wide">
                                        <i data-lucide="trophy" class="w-4 h-4 text-yellow-500/50 shrink-0"></i>
                                        <?= htmlspecialchars($achievement->name) ?>
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-xs text-white/40">
                                    <?= htmlspecialchars($achievement->description ?? '—') ?>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <?php if (!empty($_SESSION['user_id'])): ?>
                                            <form method="POST" action="/profile/achievements/<?= $achievement->id ?>/unlock">
                                                <button type="submit"
                                                        class="flex items-center gap-1.5 text-[11px] font-valo tracking-[0.1em] uppercase text-yellow-500/50 hover:text-yellow-400 border border-yellow-500/20 hover:border-yellow-500/50 px-3 py-1 transition-all duration-150">
                                                    <i data-lucide="unlock" class="w-3 h-3"></i>
                                                    Débloquer
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                                            <form method="POST" action="/achievements/<?= $achievement->id ?>/delete"
                                                  onsubmit="return confirm('Supprimer ?')">
                                                <button type="submit"
                                                        class="flex items-center gap-1.5 text-[11px] font-valo tracking-[0.1em] uppercase text-valo-red/50 hover:text-valo-red border border-valo-red/20 hover:border-valo-red/50 px-3 py-1 transition-all duration-150">
                                                    <i data-lucide="trash-2" class="w-3 h-3"></i>
                                                    Supprimer
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

    </div>

    </div><!-- /contenu -->

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
