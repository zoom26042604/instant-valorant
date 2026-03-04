<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil — Instant-Valorant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/assets/css/app.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest" defer></script>
</head>

<body class="bg-valo-dark text-white min-h-screen flex flex-col select-none">

<nav class="border-b border-white px-10 py-4 flex items-center justify-between sticky top-0 z-50 bg-valo-dark/95 backdrop-blur-sm">
    <a href="/" class="font-valo font-bold text-2xl tracking-[0.2em] cursor-pointer">
        INSTANT<span class="text-valo-red">-VALORANT</span>
    </a>

    <div class="flex items-center gap-2 text-[11px] tracking-[0.15em] font-valo font-semibold text-white">
        <span class="w-1.5 h-1.5 rounded-full bg-valo-red"></span>
        KINGDOM CORP. · PROTOCOLE ACTIF
    </div>

    <div class="flex items-center gap-3">
        <a href="/games"
           class="flex items-center gap-2 border border-white px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-white hover:text-white transition-all duration-200 group">
            <i data-lucide="layout-grid" class="w-4 h-4 text-white group-hover:text-white transition-colors"></i>
            Missions
        </a>
        <a href="/profile/achievements"
           class="flex items-center gap-2 border border-white px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-white/50 hover:text-white transition-all duration-200 group">
            <i data-lucide="trophy" class="w-4 h-4 text-white group-hover:text-white transition-colors"></i>
            Succès
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
    </div>
</nav>

<main class="flex-1 px-16 py-14">

    <div class="mb-14">
        <p class="text-valo-red text-[11px] font-valo font-semibold tracking-[0.25em] uppercase mb-3">
            // DOSSIER AGENT — ACCÈS RESTREINT
        </p>
        <div class="flex items-end gap-8">
            <div class="w-20 h-20 rounded-2xl border border-white bg-white flex items-center justify-center shrink-0">
                <i data-lucide="user-round" class="w-10 h-10 text-white"></i>
            </div>
            <div>
                <h1 class="font-valo font-bold text-[3rem] tracking-[0.08em] leading-none mb-2">
                    <?= htmlspecialchars($user->name) ?>
                </h1>
                <div class="flex items-center gap-6 text-[13px]">
                    <span class="flex items-center gap-2 text-white/">
                        <i data-lucide="mail" class="w-3.5 h-3.5 text-white"></i>
                        <?= htmlspecialchars($user->email) ?>
                    </span>
                    <span class="flex items-center gap-1.5 text-valo-red text-[11px] font-valo tracking-[0.15em] uppercase border border-valo-red/30 px-2 py-0.5">
                        <i data-lucide="crosshair" class="w-3 h-3"></i>
                        <?= htmlspecialchars($user->role ?? 'user') ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between mb-1">
        <h2 class="text-[11px] font-valo font-semibold tracking-[0.25em] text-white uppercase">
            Bibliothèque de l'Agent
        </h2>
        <a href="/profile/games/add"
           class="flex items-center gap-2 border border-valo-red px-4 py-1.5 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-valo-red/80 hover:text-valo-red transition-all duration-200 group">
            <i data-lucide="plus" class="w-3.5 h-3.5 text-valo-red group-hover:text-valo-red transition-colors"></i>
            Ajouter un jeu
        </a>
    </div>
    <div class="border-t border-white/10 mb-6"></div>

    <?php if (empty($gamesData)): ?>
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <i data-lucide="gamepad-2" class="w-12 h-12 text-white/10 mb-4"></i>
            <p class="text-white text-sm font-valo tracking-[0.15em] uppercase">Aucune mission enregistrée</p>
            <a href="/profile/games/add" class="mt-4 text-valo-red/60 hover:text-valo-red text-[11px] font-valo tracking-[0.15em] uppercase transition-colors">
                + Ajouter votre premier jeu
            </a>
        </div>
    <?php else: ?>
        <div class="border border-white/5 rounded-2xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                <tr class="border-b border-white/5 bg-white/2">
                    <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Jeu</th>
                    <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Type</th>
                    <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Ajouté le</th>
                    <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">
                            <span class="flex items-center gap-1.5">
                                <i data-lucide="clock" class="w-3 h-3"></i>
                                Temps de jeu
                            </span>
                    </th>
                    <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $moisFr = ['','janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];
                function formatDateFrProfile(string $date, array $mois): string {
                    $ts = strtotime($date);
                    if (!$ts) return $date;
                    return date('j', $ts) . ' ' . $mois[(int)date('n', $ts)] . ' ' . date('Y', $ts);
                }
                function formatPlaytime(int $minutes): string {
                    if ($minutes < 60) return "{$minutes}min";
                    $h = floor($minutes / 60);
                    $m = $minutes % 60;
                    return $m > 0 ? "{$h}h{$m}" : "{$h}h";
                }
                ?>
                <?php foreach ($gamesData as $entry): ?>
                    <?php $ug = $entry['ug']; $game = $entry['game']; ?>
                    <tr class="border-b border-white/5 hover:bg-white/2 transition-colors duration-150 group">
                        <td class="px-5 py-4">
                            <?php if ($game): ?>
                                <a href="/games/<?= $game->id ?>"
                                   class="font-valo text-sm tracking-wide hover:text-valo-red transition-colors duration-150 flex items-center gap-2">
                                    <i data-lucide="gamepad-2" class="w-4 h-4 text-white group-hover:text-valo-red/40 transition-colors shrink-0"></i>
                                    <?= htmlspecialchars($game->name) ?>
                                </a>
                            <?php else: ?>
                                <span class="font-valo text-sm tracking-wide text-white flex items-center gap-2">
                                        <i data-lucide="gamepad-2" class="w-4 h-4 text-white/20 shrink-0"></i>
                                        <?= htmlspecialchars($ug->custom_name ?? '-') ?>
                                    </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-4">
                                <span class="text-[11px] font-valo tracking-[0.15em] uppercase text-white/40 border border-white/10 px-2 py-0.5">
                                    <?= htmlspecialchars($game ? ($game->type ?? '-') : ($ug->custom_type ?? '-')) ?>
                                </span>
                        </td>
                        <td class="px-5 py-4 text-xs text-white/40 font-mono">
                            <?= !empty($ug->date_added) ? formatDateFrProfile($ug->date_added, $moisFr) : '-' ?>
                        </td>
                        <td class="px-5 py-4">
                                <span class="flex items-center gap-1.5 text-xs text-white/50">
                                    <i data-lucide="timer" class="w-3.5 h-3.5 text-valo-red/40 shrink-0"></i>
                                    <?= isset($ug->playtime) ? formatPlaytime((int)$ug->playtime) : '-' ?>
                                </span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <?php if (!$game): ?>
                                    <a href="/profile/games/<?= $ug->id ?>/edit"
                                       class="flex items-center gap-1.5 text-[11px] font-valo tracking-[0.1em] uppercase text-white/40 hover:text-white border border-white/10 hover:border-white/30 px-3 py-1 transition-all duration-150">
                                        <i data-lucide="pencil" class="w-3 h-3"></i>
                                        Modifier
                                    </a>
                                <?php endif; ?>
                                <form method="POST" action="/profile/games/<?= $ug->id ?>/delete"
                                      onsubmit="return confirm('Retirer ce jeu ?')">
                                    <button type="submit"
                                            class="flex items-center gap-1.5 text-[11px] font-valo tracking-[0.1em] uppercase text-valo-red/50 hover:text-valo-red border border-valo-red/20 hover:border-valo-red/50 px-3 py-1 transition-all duration-150">
                                        <i data-lucide="trash-2" class="w-3 h-3"></i>
                                        Retirer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

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
