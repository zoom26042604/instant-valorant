<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription Valorant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/assets/css/app.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest" defer></script>

</head>
<body class="min-h-screen bg-valo-dark text-white flex items-center justify-center relative overflow-hidden">

<div class="absolute inset-0 bg-gradient-to-br from-valo-dark via-black to-valo-red/20 pointer-events-none"></div>
<div class="absolute top-0 left-0 w-full h-1 bg-valo-red"></div>

<div class="relative z-10 w-full max-w-5xl mx-6 py-12">

    <div class="flex flex-col items-center mb-12">
        <h1 class="text-4xl font-black tracking-[0.3em] uppercase">
            INSTANT-<span class="text-valo-red">VALORANT</span>
        </h1>
        <p class="text-white text-xs tracking-widest mt-1 uppercase">Plateforme de jeux</p>
    </div>

    <div class="grid md:grid-cols-1 gap-6">
        <a href="/" class="flex items-center gap-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:text-valo-red transition-colors duration-150">
            <i data-lucide="arrow-big-left" class="w-6 h-6 text-white mb-2 hover:text-valo-red cursor-pointer"></i>
            Retour au site
        </a>
        <div class="bg-valo-card border border-gray-700/60 rounded-xl p-8 shadow-2xl shadow-black/60 backdrop-blur-sm">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-1 h-6 bg-gray-500 rounded-full"></div>
                <h2 class="text-xl font-bold tracking-widest uppercase">Inscription</h2>



            </div>
        <?php if (!empty($_SESSION['error'])): ?>
            <p><?= htmlspecialchars($_SESSION['error']) ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <form method="POST" action="/register" class="space-y-4">
            <div class="space-y-1">
                <label for="register_username"
                       class="block text-xs font-semibold uppercase tracking-widest text-white">
                    Pseudo
                </label>
                <input type="text" id="register_username" name="name" required placeholder="agent007"
                       class="w-full bg-black/50 border border-gray-700 hover:border-gray-500 focus:border-valo-red focus:ring-1 focus:ring-valo-red outline-none rounded px-4 py-2.5 text-sm transition-colors duration-150">
            </div>

            <div class="space-y-1">
                <label for="register_email"
                       class="block text-xs font-semibold uppercase tracking-widest text-white">
                    Adresse e-mail
                </label>
                <input type="email" id="register_email" name="email" required placeholder="agent@valorant.com"
                       class="w-full bg-black/50 border border-gray-700 hover:border-gray-500 focus:border-valo-red focus:ring-1 focus:ring-valo-red outline-none rounded px-4 py-2.5 text-sm transition-colors duration-150">
            </div>

            <div class="space-y-1">
                <label for="register_password"
                       class="block text-xs font-semibold uppercase tracking-widest text-white">
                    Mot de passe
                </label>
                <input type="password" id="register_password" name="password" required placeholder="••••••••"
                       class="w-full bg-black/50 border border-gray-700 hover:border-gray-500 focus:border-valo-red focus:ring-1 focus:ring-valo-red outline-none rounded px-4 py-2.5 text-sm transition-colors duration-150">
            </div>

            <div class="space-y-1">
                <label for="register_confirm"
                       class="block text-xs font-semibold uppercase tracking-widest text-white">
                    Confirmation
                </label>
                <input type="password" id="register_confirm" name="password_confirm" required placeholder="••••••••"
                       class="w-full bg-black/50 border border-gray-700 hover:border-gray-500 focus:border-valo-red focus:ring-1 focus:ring-valo-red outline-none rounded px-4 py-2.5 text-sm transition-colors duration-150">
            </div>

            <button type="submit" name="action" value="register"
                    class="w-full bg-transparent border border-valo-red text-valo-red hover:bg-valo-red hover:text-white active:scale-95 transition-all duration-150 rounded py-2.5 text-sm font-bold tracking-[0.15em] uppercase">
                Créer un compte
            </button>
        </form>
    </div>
        <p><a href="/login">Déjà un compte ?</a></p>
    </div>
</div>
<script src="/assets/js/index.js"></script>

</body>
</html>