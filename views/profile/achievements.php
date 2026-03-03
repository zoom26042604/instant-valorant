<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes succès — Instant-Valorant</title>
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
        <a href="/games"
           class="flex items-center gap-2 border border-white px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-white/50 hover:text-white transition-all duration-200 group">
            <i data-lucide="layout-grid" class="w-4 h-4 text-white group-hover:text-white transition-colors"></i>
            Missions
        </a>
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

<main class="flex-1 px-16 py-14">

    <div class="mb-10">
        <p class="text-valo-red text-[11px] font-valo font-semibold tracking-[0.25em] uppercase mb-3">
            // DOSSIER AGENT — PALMARÈS
        </p>
        <h1 class="font-valo font-bold text-[3rem] tracking-[0.08em] leading-none">
            MES <span class="text-valo-red">SUCCÈS</span>
        </h1>
    </div>

    <div class="flex items-center justify-between mb-1">
        <h2 class="text-[11px] font-valo font-semibold tracking-[0.25em] text-white uppercase">
            <?= count($achievementsData) ?> succès débloqué<?= count($achievementsData) > 1 ? 's' : '' ?>
        </h2>
        <a href="/games"
           class="text-[11px] font-valo tracking-[0.15em] text-white/40 hover:text-valo-red transition-colors duration-200 uppercase">
            Parcourir les jeux →
        </a>
    </div>
    <div class="border-t border-white/10 mb-6"></div>

    <?php if (empty($achievementsData)): ?>
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <i data-lucide="trophy" class="w-12 h-12 text-white/10 mb-4"></i>
            <p class="text-white/30 text-sm font-valo tracking-[0.15em] uppercase">Aucun succès débloqué</p>
            <a href="/games" class="mt-4 text-valo-red/60 hover:text-valo-red text-[11px] font-valo tracking-[0.15em] uppercase transition-colors">
                → Parcourir les jeux
            </a>
        </div>
    <?php else: ?>
        <div class="border border-white/5 rounded-2xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                <tr class="border-b border-white/5 bg-white/2">
                    <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Succès</th>
                    <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Jeu</th>
                    <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Description</th>
                    <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="calendar" class="w-3 h-3"></i>
                            Débloqué le
                        </span>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                $moisFr = ['','janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];
                function formatDateFrAch(string $date, array $mois): string {
                    $ts = strtotime($date);
                    if (!$ts) return $date;
                    return date('j', $ts) . ' ' . $mois[(int)date('n', $ts)] . ' ' . date('Y', $ts);
                }
                ?>
                <?php foreach ($achievementsData as $entry): ?>
                    <?php $ua = $entry['ua']; $a = $entry['achievement']; $game = $entry['game'] ?? null; ?>
                    <tr class="border-b border-white/5 hover:bg-white/2 transition-colors duration-150">
                        <td class="px-5 py-4">
                            <span class="flex items-center gap-2 font-valo text-sm tracking-wide">
                                <i data-lucide="trophy" class="w-4 h-4 text-yellow-500/60 shrink-0"></i>
                                <?= htmlspecialchars($a->name ?? '—') ?>
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <?php if ($game): ?>
                                <a href="/games/<?= $game->id ?>" class="flex items-center gap-1.5 text-[11px] font-valo tracking-widest uppercase text-white/50 hover:text-valo-red transition-colors duration-150">
                                    <i data-lucide="gamepad-2" class="w-3 h-3 shrink-0"></i>
                                    <?= htmlspecialchars($game->name) ?>
                                </a>
                            <?php else: ?>
                                <span class="text-white/20 text-xs">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-4 text-xs text-white/40">
                            <?= htmlspecialchars($a->description ?? '—') ?>
                        </td>
                        <td class="px-5 py-4 text-xs text-white/40 font-mono">
                            <?= !empty($ua->unlocked_at) ? formatDateFrAch($ua->unlocked_at, $moisFr) : '—' ?>
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
