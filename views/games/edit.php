<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier <?= htmlspecialchars($game->name) ?> — Instant-Valorant</title>
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
        <a href="/games/<?= $game->id ?>"
           class="flex items-center gap-2 border border-white px-4 sm:px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-white/50 hover:text-white transition-all duration-200 group">
            <i data-lucide="layout-grid" class="w-4 h-4 text-white group-hover:text-white transition-colors"></i>
            <span class="hidden sm:inline">Fiche jeu</span>
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

<main class="flex-1 flex flex-col md:flex-row">

    <!-- ═══ PANNEAU GAUCHE DÉCORATIF ═══ -->
    <div class="relative md:w-[42%] overflow-hidden flex flex-col justify-between p-8 md:p-12 bg-black border-b md:border-b-0 md:border-r border-white/8 min-h-55 md:min-h-0">

        <!-- Barre jaune gauche -->
        <div class="absolute left-0 top-0 bottom-0 w-1 bg-yellow-500"></div>

        <!-- Grille décorative -->
        <div class="absolute inset-0 opacity-[0.025]"
             style="background-image: linear-gradient(rgba(255,255,255,.15) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.15) 1px, transparent 1px); background-size: 48px 48px;"></div>

        <!-- Accent diagonal -->
        <div class="absolute top-0 right-0 w-64 h-full"
             style="background: linear-gradient(to left, rgba(234,179,8,.05), transparent); clip-path: polygon(40% 0, 100% 0, 100% 100%, 0 100%);"></div>

        <!-- Coins décoratifs -->
        <div class="absolute top-6 right-6 w-8 h-8 border-t border-r border-yellow-500/20"></div>
        <div class="absolute bottom-6 right-6 w-8 h-8 border-b border-r border-white/8"></div>

        <!-- Retour -->
        <div class="relative z-10">
            <a href="/games/<?= $game->id ?>"
               class="inline-flex items-center gap-2 leading-none text-[11px] font-valo tracking-[0.15em] uppercase text-white/30 hover:text-white transition-colors duration-150">
                <i data-lucide="arrow-big-left" class="w-3.5 h-3.5 shrink-0"></i>
                Retour à la fiche
            </a>
        </div>

        <!-- Titre -->
        <div class="relative z-10 py-6 md:py-0">
            <p class="text-yellow-500 text-[10px] font-valo font-semibold tracking-[0.3em] uppercase mb-4">
                // PANNEAU ADMIN
            </p>
            <h1 class="font-valo font-bold text-3xl md:text-4xl tracking-[0.06em] leading-none mb-2">
                MODIFIER
            </h1>
            <h2 class="font-valo font-bold text-3xl md:text-4xl tracking-[0.06em] leading-none mb-6 text-yellow-500">
                <?= htmlspecialchars(strtoupper($game->name)) ?>
            </h2>
            <div class="w-8 h-px bg-yellow-500/40 mb-5"></div>
            <p class="text-white/35 text-xs leading-relaxed max-w-xs">
                Modifiez les informations de ce protocole. Les niveaux et succès associés ne seront pas affectés.
            </p>
        </div>

        <!-- Status -->
        <div class="relative z-10 flex items-center gap-2">
            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
            <span class="text-yellow-500/50 text-[10px] font-valo tracking-[0.15em] uppercase">Accès Administrateur</span>
        </div>
    </div>

    <!-- ═══ PANNEAU DROIT — FORMULAIRE ═══ -->
    <div class="flex-1 flex items-center justify-center p-8 md:p-12 lg:p-16">
        <div class="w-full max-w-lg">

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="flex items-center gap-2 border border-valo-red/50 bg-valo-red/10 px-4 py-3 mb-6 text-xs text-valo-red font-valo tracking-wide">
                    <i data-lucide="alert-triangle" class="w-4 h-4 shrink-0"></i>
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form method="POST" action="/games/<?= $game->id ?>/update" class="space-y-5">

                <div class="space-y-1.5">
                    <label for="name" class="block text-[11px] font-valo font-semibold uppercase tracking-[0.2em] text-white/70">
                        Nom du jeu <span class="text-valo-red">*</span>
                    </label>
                    <input type="text" id="name" name="name" required
                           value="<?= htmlspecialchars($game->name) ?>"
                           class="w-full bg-black border border-white/10 hover:border-white/25 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/20 outline-none px-4 py-3 text-sm transition-colors duration-150">
                </div>

                <div class="space-y-1.5">
                    <label for="type" class="block text-[11px] font-valo font-semibold uppercase tracking-[0.2em] text-white/70">
                        Type
                    </label>
                    <input type="text" id="type" name="type"
                           value="<?= htmlspecialchars($game->type ?? '') ?>"
                           class="w-full bg-black border border-white/10 hover:border-white/25 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/20 outline-none px-4 py-3 text-sm transition-colors duration-150">
                </div>

                <div class="space-y-1.5">
                    <label for="description" class="block text-[11px] font-valo font-semibold uppercase tracking-[0.2em] text-white/70">
                        Description
                    </label>
                    <textarea id="description" name="description" rows="3"
                              class="w-full bg-black border border-white/10 hover:border-white/25 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/20 outline-none px-4 py-3 text-sm transition-colors duration-150 resize-none"><?= htmlspecialchars($game->description ?? '') ?></textarea>
                </div>

                <div class="space-y-1.5">
                    <label for="image_url" class="block text-[11px] font-valo font-semibold uppercase tracking-[0.2em] text-white/70">
                        URL de l'image
                    </label>
                    <input type="url" id="image_url" name="image_url"
                           value="<?= htmlspecialchars($game->image_url ?? '') ?>"
                           class="w-full bg-black border border-white/10 hover:border-white/25 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/20 outline-none px-4 py-3 text-sm transition-colors duration-150">
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full bg-yellow-500 hover:bg-yellow-400 active:scale-[.99] transition-all duration-150 py-3 text-sm font-valo font-bold tracking-[0.2em] uppercase text-black shadow-lg shadow-yellow-500/15">
                        Enregistrer les modifications
                    </button>
                </div>

            </form>
        </div>
    </div>

</main>

<footer class="border-t border-white/10 px-4 sm:px-16 py-5 flex items-center justify-between">
    <div class="font-valo font-bold text-lg tracking-[0.2em]">
        INSTANT<span class="text-valo-red">-VALORANT</span>
    </div>
    <p class="text-white/30 text-xs tracking-wide">Ynov Campus · Made with ♥ by Nathan & Laurine.</p>
</footer>

<script src="/assets/js/index.js"></script>
</body>
</html>
