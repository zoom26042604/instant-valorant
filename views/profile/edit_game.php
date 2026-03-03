<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le jeu — Instant-Valorant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/assets/css/app.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest" defer></script>
</head>

<body class="bg-valo-dark text-white min-h-screen flex flex-col select-none">

<nav class="border-b border-white px-10 py-4 flex items-center justify-between sticky top-0 z-50 bg-valo-dark/95 backdrop-blur-sm">
    <a href="/" class="font-valo font-bold text-2xl tracking-[0.2em] cursor-pointer">
        INSTANT<span class="text-valo-red font-valo">-VALORANT</span>
    </a>
    <div class="flex items-center gap-2 text-[11px] tracking-[0.15em] font-valo font-semibold text-white">
        <span class="w-1.5 h-1.5 rounded-full bg-valo-red dot-pulse"></span>
        KINGDOM CORP. · PROTOCOLE ACTIF
    </div>
    <div class="flex items-center gap-3">
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
    </div>
</nav>

<main class="flex-1 flex items-center justify-center px-6 py-14">
    <div class="w-full max-w-md">

        <a href="/profile"
           class="inline-flex items-center gap-2 text-[11px] font-valo tracking-[0.15em] uppercase text-white/40 hover:text-white transition-colors duration-150 mb-8">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Retour au dossier agent
        </a>

        <div class="flex items-center gap-3 mb-8">
            <div class="w-1 h-8 bg-valo-red rounded-full"></div>
            <div>
                <p class="text-valo-red text-[10px] font-valo font-semibold tracking-[0.25em] uppercase">
                    // BIBLIOTHÈQUE AGENT
                </p>
                <h1 class="font-valo font-bold text-2xl tracking-[0.1em] leading-none">
                    MODIFIER LE JEU
                </h1>
            </div>
        </div>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="flex items-center gap-2 border border-valo-red/50 bg-valo-red/10 px-4 py-3 rounded mb-6 text-xs text-valo-red font-valo tracking-wide">
                <i data-lucide="alert-triangle" class="w-4 h-4 shrink-0"></i>
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="bg-valo-card border border-valo-red/20 rounded-xl p-8 shadow-2xl shadow-black/60">
            <form method="POST" action="/profile/games/<?= $userGame->id ?>/update" class="space-y-5">

                <div class="space-y-1.5">
                    <label for="custom_name" class="block text-xs font-semibold uppercase tracking-widest text-white/80">
                        Nom <span class="text-valo-red">*</span>
                    </label>
                    <input type="text" id="custom_name" name="custom_name" required
                           value="<?= htmlspecialchars($userGame->custom_name ?? '') ?>"
                           class="w-full bg-black/50 border border-gray-700 hover:border-gray-500 focus:border-valo-red focus:ring-1 focus:ring-valo-red/30 outline-none rounded px-4 py-2.5 text-sm transition-colors duration-150">
                </div>

                <div class="space-y-1.5">
                    <label for="custom_type" class="block text-xs font-semibold uppercase tracking-widest text-white/80">
                        Type
                    </label>
                    <input type="text" id="custom_type" name="custom_type"
                           value="<?= htmlspecialchars($userGame->custom_type ?? '') ?>"
                           class="w-full bg-black/50 border border-gray-700 hover:border-gray-500 focus:border-valo-red focus:ring-1 focus:ring-valo-red/30 outline-none rounded px-4 py-2.5 text-sm transition-colors duration-150">
                </div>

                <div class="space-y-1.5">
                    <label for="custom_description" class="block text-xs font-semibold uppercase tracking-widest text-white/80">
                        Description
                    </label>
                    <textarea id="custom_description" name="custom_description" rows="3"
                              class="w-full bg-black/50 border border-gray-700 hover:border-gray-500 focus:border-valo-red focus:ring-1 focus:ring-valo-red/30 outline-none rounded px-4 py-2.5 text-sm transition-colors duration-150 resize-none"><?= htmlspecialchars($userGame->custom_description ?? '') ?></textarea>
                </div>

                <div class="space-y-1.5">
                    <label for="custom_image_url" class="block text-xs font-semibold uppercase tracking-widest text-white/80">
                        URL de l'image
                    </label>
                    <input type="url" id="custom_image_url" name="custom_image_url"
                           value="<?= htmlspecialchars($userGame->custom_image_url ?? '') ?>"
                           class="w-full bg-black/50 border border-gray-700 hover:border-gray-500 focus:border-valo-red focus:ring-1 focus:ring-valo-red/30 outline-none rounded px-4 py-2.5 text-sm transition-colors duration-150">
                </div>

                <button type="submit"
                        class="w-full bg-valo-red hover:bg-[#e63f4b] active:scale-95 transition-all duration-150 rounded py-2.5 text-sm font-bold tracking-[0.15em] uppercase mt-2 shadow-lg shadow-valo-red/30">
                    Enregistrer les modifications
                </button>

            </form>
        </div>

    </div>
</main>

<footer class="border-t border-white px-16 py-5 flex items-center justify-between">
    <div class="font-valo font-bold text-lg tracking-[0.2em]">
        INSTANT<span class="text-valo-red">-VALORANT</span>
    </div>
    <p class="text-white text-xs tracking-wide">Ynov Campus · Made with ♥ by Nathan & Laurine.</p>
</footer>

<script src="/assets/js/index.js"></script>
</body>
</html>
