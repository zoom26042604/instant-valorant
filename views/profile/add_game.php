<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une mission — Instant-Valorant</title>
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
        <span class="w-1.5 h-1.5 rounded-full bg-valo-red dot-pulse"></span>
        KINGDOM CORP. · PROTOCOLE ACTIF
    </div>
    <div class="flex items-center gap-2 sm:gap-3">
        <a href="/games"
           class="flex items-center gap-2 border border-white px-4 sm:px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-white/50 hover:text-white transition-all duration-200 group">
            <i data-lucide="layout-grid" class="w-4 h-4 text-white group-hover:text-white transition-colors"></i>
            <span class="hidden sm:inline">Missions</span>
        </a>
        <a href="/profile"
           class="flex items-center gap-2 border border-white px-4 sm:px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-white/50 hover:text-white transition-all duration-200 group">
            <i data-lucide="user-round-search" class="w-4 h-4 text-white group-hover:text-white transition-colors"></i>
            <span class="hidden sm:inline">Dossier Agent</span>
        </a>
        <?php if (!empty($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <a href="/admin"
               class="flex items-center gap-2 border border-yellow-500 px-4 sm:px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-yellow-500/60 hover:text-yellow-400 transition-all duration-200 group">
                <i data-lucide="shield" class="w-4 h-4 text-yellow-500 group-hover:text-yellow-400 transition-colors"></i>
                Admin
            </a>
        <?php endif; ?>
        <a href="/logout"
           class="flex items-center gap-2 border border-white px-4 sm:px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-valo-red/60 hover:text-valo-red transition-all duration-200 group">
            <i data-lucide="log-out" class="w-4 h-4 text-valo-red group-hover:text-valo-red transition-colors"></i>
            <span class="hidden sm:inline">Quitter</span>
        </a>
    </div>
</nav>

<main class="flex-1 px-4 sm:px-8 md:px-16 py-10">
<div class="max-w-6xl mx-auto">

    <!-- En-tête -->
    <div class="mb-10">
        <a href="/profile"
           class="inline-flex items-center gap-2 text-[11px] font-valo tracking-[0.15em] uppercase text-white/30 hover:text-white transition-colors duration-150 mb-6">
            <i data-lucide="arrow-big-left" class="w-3.5 h-3.5"></i>
            Retour au dossier agent
        </a>
        <p class="text-valo-red text-[11px] font-valo font-semibold tracking-[0.25em] uppercase mb-3">
            // BIBLIOTHÈQUE AGENT
        </p>
        <h1 class="font-valo font-bold text-4xl sm:text-5xl tracking-[0.08em] leading-none">
            AJOUTER UNE <span class="text-valo-red">MISSION</span>
        </h1>
    </div>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="flex items-center gap-2 border border-valo-red/50 bg-valo-red/10 px-4 py-3 mb-8 text-xs text-valo-red font-valo tracking-wide max-w-2xl">
            <i data-lucide="alert-triangle" class="w-4 h-4 shrink-0"></i>
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 max-w-6xl">

        <!-- ═══ DEPUIS LA PLATEFORME ═══ -->
        <div>
            <div class="flex items-center gap-3 mb-6">
                <div class="w-px h-6 bg-valo-red"></div>
                <h2 class="font-valo font-bold text-sm tracking-[0.2em] uppercase">Depuis la plateforme</h2>
                <span class="text-white/20 text-[10px] font-valo tracking-[0.15em] uppercase"><?= count($games) ?> jeux disponibles</span>
            </div>
            <div class="border-t border-white/8 mb-6"></div>

            <?php if (empty($games)): ?>
                <div class="flex flex-col items-center justify-center py-12 text-center border border-white/5">
                    <i data-lucide="gamepad-2" class="w-10 h-10 text-white/10 mb-3"></i>
                    <p class="text-white/20 text-sm font-valo tracking-[0.15em] uppercase">Aucun jeu disponible</p>
                </div>
            <?php else: ?>
                <form method="POST" action="/profile/games" id="form-platform">
                    <!-- Grille de cartes radio -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-6 max-h-80 overflow-y-auto pr-1">
                        <?php foreach ($games as $game): ?>
                            <label class="cursor-pointer group" for="game_<?= $game->id ?>">
                                <input type="radio" id="game_<?= $game->id ?>" name="game_id" value="<?= $game->id ?>"
                                       class="hidden peer"
                                       <?= $preselected == $game->id ? 'checked' : '' ?>>
                                <div class="relative overflow-hidden border border-white/8 peer-checked:border-valo-red peer-checked:bg-valo-red/5 hover:border-white/25 transition-all duration-150 h-28 flex flex-col">
                                    <!-- Indicateur de sélection -->
                                    <div class="absolute top-2 right-2 w-3.5 h-3.5 rounded-full border border-white/20 z-10 group-has-checked:border-valo-red group-has-checked:bg-valo-red/90 flex items-center justify-center">
                                        <div class="w-1.5 h-1.5 rounded-full bg-white opacity-0 group-has-checked:opacity-100"></div>
                                    </div>
                                    <?php if (!empty($game->image_url)): ?>
                                        <img src="<?= htmlspecialchars($game->image_url) ?>"
                                             alt="<?= htmlspecialchars($game->name) ?>"
                                             class="absolute inset-0 w-full h-full object-cover opacity-30 group-has-checked:opacity-50 transition-opacity">
                                        <div class="absolute inset-0 bg-linear-to-t from-black/80 to-transparent"></div>
                                    <?php else: ?>
                                        <div class="absolute inset-0 bg-black"></div>
                                    <?php endif; ?>
                                    <div class="relative z-10 flex flex-col justify-end h-full p-2.5">
                                        <?php if (!empty($game->type)): ?>
                                            <span class="text-[9px] font-valo tracking-[0.15em] text-valo-red/70 uppercase mb-0.5"><?= htmlspecialchars($game->type) ?></span>
                                        <?php endif; ?>
                                        <p class="font-valo text-xs leading-tight"><?= htmlspecialchars($game->name) ?></p>
                                    </div>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <button type="submit"
                            class="w-full bg-valo-red hover:bg-valo-red/80 active:scale-[.99] transition-all duration-150 py-3 text-sm font-valo font-bold tracking-[0.2em] uppercase shadow-lg shadow-valo-red/15">
                        Ajouter à ma bibliothèque
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <!-- ═══ JEU PERSONNALISÉ ═══ -->
        <div>
            <div class="flex items-center gap-3 mb-6">
                <div class="w-px h-6 bg-white/20"></div>
                <h2 class="font-valo font-bold text-sm tracking-[0.2em] uppercase">Jeu personnalisé</h2>
            </div>
            <div class="border-t border-white/8 mb-6"></div>

            <form method="POST" action="/profile/games" class="space-y-4">

                <div class="space-y-1.5">
                    <label for="custom_name" class="block text-[11px] font-valo font-semibold uppercase tracking-[0.2em] text-white/70">
                        Nom <span class="text-valo-red">*</span>
                    </label>
                    <input type="text" id="custom_name" name="custom_name" required
                           placeholder="ex: Mon jeu indie"
                           class="w-full bg-black border border-white/10 hover:border-white/25 focus:border-valo-red focus:ring-1 focus:ring-valo-red/20 outline-none px-4 py-3 text-sm transition-colors duration-150">
                </div>

                <div class="space-y-1.5">
                    <label for="custom_type" class="block text-[11px] font-valo font-semibold uppercase tracking-[0.2em] text-white/70">
                        Type
                    </label>
                    <input type="text" id="custom_type" name="custom_type"
                           placeholder="ex: Stratégie"
                           class="w-full bg-black border border-white/10 hover:border-white/25 focus:border-valo-red focus:ring-1 focus:ring-valo-red/20 outline-none px-4 py-3 text-sm transition-colors duration-150">
                </div>

                <div class="space-y-1.5">
                    <label for="custom_description" class="block text-[11px] font-valo font-semibold uppercase tracking-[0.2em] text-white/70">
                        Description
                    </label>
                    <textarea id="custom_description" name="custom_description" rows="3"
                              class="w-full bg-black border border-white/10 hover:border-white/25 focus:border-valo-red focus:ring-1 focus:ring-valo-red/20 outline-none px-4 py-3 text-sm transition-colors duration-150 resize-none"></textarea>
                </div>

                <div class="space-y-1.5">
                    <label for="custom_image_url" class="block text-[11px] font-valo font-semibold uppercase tracking-[0.2em] text-white/70">
                        URL de l'image
                    </label>
                    <input type="url" id="custom_image_url" name="custom_image_url"
                           placeholder="https://…"
                           class="w-full bg-black border border-white/10 hover:border-white/25 focus:border-valo-red focus:ring-1 focus:ring-valo-red/20 outline-none px-4 py-3 text-sm transition-colors duration-150">
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full border border-white/15 hover:border-white/35 hover:bg-white/5 active:scale-[.99] transition-all duration-150 py-3 text-sm font-valo font-bold tracking-[0.2em] uppercase">
                        Ajouter le jeu personnalisé
                    </button>
                </div>

            </form>
        </div>

    </div>

</div><!-- /max-w-6xl -->
</main>

<footer class="border-t border-white/10 px-4 sm:px-16 py-5 flex items-center justify-between mt-10">
    <div class="font-valo font-bold text-lg tracking-[0.2em]">
        INSTANT<span class="text-valo-red">-VALORANT</span>
    </div>
    <p class="text-white/30 text-xs tracking-wide">Ynov Campus · Made with ♥ by Nathan & Laurine.</p>
</footer>

<script src="/assets/js/index.js"></script>
</body>
</html>
