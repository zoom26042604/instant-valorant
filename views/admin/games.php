<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin — Jeux & Succès · Instant-Valorant</title>
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
        <span class="w-1.5 h-1.5 rounded-full bg-valo-red dot-pulse"></span>
        KINGDOM CORP. · ACCÈS ADMINISTRATEUR
    </div>
    <div class="flex items-center gap-2 sm:gap-3">
        <a href="/admin/users"
           class="flex items-center gap-2 border border-white/30 px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-white hover:text-white transition-all duration-200 group">
            <i data-lucide="users" class="w-4 h-4 group-hover:text-white transition-colors"></i>
            Agents
        </a>
        <a href="/admin/games"
           class="flex items-center gap-2 border border-white px-5 py-2 text-[11px] tracking-[0.15em] font-valo font-semibold uppercase hover:border-white/50 hover:text-white transition-all duration-200 group">
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
            GESTION DES <span class="text-valo-red">JEUX ET SUCCÈS</span>
        </h1>
        <div class="flex items-center gap-6 text-[13px]">
            <span class="flex items-center gap-2 text-white">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                <?= count($games) ?> jeux enregistrés
            </span>
            <span class="flex items-center gap-2 text-white">
                <span class="w-2 h-2 rounded-full bg-valo-red/70"></span>
                <?= count(R::findAll('achievement')) ?> succès au total
            </span>
        </div>
    </div>

    <div class="flex items-center justify-between mb-1">
        <h2 class="text-[11px] font-valo font-semibold tracking-[0.25em] text-white uppercase">
            Registre des jeux
        </h2>
        <a href="/games/create"
           class="flex items-center gap-1.5 text-[11px] font-valo tracking-widest uppercase text-valo-red/60 hover:text-valo-red border border-valo-red/20 hover:border-valo-red/50 px-3 py-1.5 transition-all duration-150">
            <i data-lucide="plus" class="w-3 h-3"></i>
            Ajouter un jeu
        </a>
    </div>
    <div class="border-t border-white/20 mb-6"></div>

    <div class="border border-white/10 rounded-2xl overflow-hidden mb-16">
        <table class="w-full text-sm">
            <thead>
            <tr class="border-b border-white/10 bg-white/4">
                <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Nom</th>
                <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Type</th>
                <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Succès</th>
                <th class="text-left px-5 py-3 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($games as $g):
                $achievementCount = count(R::find('achievement', 'game_id = ?', [$g->id]));
            ?>
                <tr class="border-b border-white/10 hover:bg-white/4 transition-colors duration-150">
                    <td class="px-5 py-4">
                        <a href="/games/<?= $g->id ?>" class="font-valo text-sm tracking-wide hover:text-valo-red transition-colors">
                            <?= htmlspecialchars($g->name) ?>
                        </a>
                    </td>
                    <td class="px-5 py-4 text-xs text-white/60 font-valo tracking-wider uppercase">
                        <?= htmlspecialchars($g->type ?? '—') ?>
                    </td>
                    <td class="px-5 py-4 text-xs text-white/60 font-valo">
                        <?= $achievementCount ?> succès
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">
                            <a href="/games/<?= $g->id ?>/edit"
                               class="flex items-center gap-1.5 text-[11px] font-valo tracking-widest uppercase text-yellow-500/50 hover:text-yellow-400 border border-yellow-500/20 hover:border-yellow-500/50 px-3 py-1.5 transition-all duration-150">
                                <i data-lucide="pencil" class="w-3 h-3"></i>
                                Modifier
                            </a>
                            <form method="POST" action="/games/<?= $g->id ?>/delete"
                                  onsubmit="return confirm('Supprimer le jeu <?= htmlspecialchars($g->name) ?> et tous ses succès ?')">
                                <button type="submit"
                                        class="flex items-center gap-1.5 text-[11px] font-valo tracking-widest uppercase text-valo-red/50 hover:text-valo-red border border-valo-red/20 hover:border-valo-red/50 px-3 py-1 transition-all duration-150">
                                    <i data-lucide="trash-2" class="w-3 h-3"></i>
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($games)): ?>
                <tr>
                    <td colspan="4" class="px-5 py-8 text-center text-xs text-white/30 font-valo tracking-widest uppercase">
                        Aucun jeu enregistré
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="flex items-center justify-between mb-1">
        <h2 class="text-[11px] font-valo font-semibold tracking-[0.25em] text-white uppercase">
            Succès par jeu
        </h2>
    </div>
    <div class="border-t border-white/20 mb-6"></div>

    <?php if (empty($games)): ?>
        <p class="text-xs text-white/30 font-valo tracking-widest uppercase">Aucun jeu disponible.</p>
    <?php else: ?>
        <div class="flex flex-col gap-8">
        <?php foreach ($games as $g):
            $achievements = R::find('achievement', 'game_id = ?', [$g->id]);
        ?>
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <span class="w-1 h-5 bg-valo-red rounded-full"></span>
                        <span class="font-valo font-semibold tracking-widest text-sm"><?= htmlspecialchars($g->name) ?></span>
                        <span class="text-[10px] text-white/30 font-valo tracking-widest uppercase"><?= count($achievements) ?> succès</span>
                    </div>
                    <a href="/games/<?= $g->id ?>/achievements/create"
                       class="flex items-center gap-1.5 text-[11px] font-valo tracking-widest uppercase text-valo-red/60 hover:text-valo-red border border-valo-red/20 hover:border-valo-red/50 px-3 py-1.5 transition-all duration-150">
                        <i data-lucide="plus" class="w-3 h-3"></i>
                        Ajouter
                    </a>
                </div>

                <div class="border border-white/10 rounded-xl overflow-hidden">
                    <table class="w-full text-sm table-fixed">
                        <colgroup>
                            <col style="width:30%">
                            <col style="width:54%">
                            <col style="width:16%">
                        </colgroup>
                        <thead>
                        <tr class="border-b border-white/10 bg-white/4">
                            <th class="text-left px-5 py-2.5 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Nom</th>
                            <th class="text-left px-5 py-2.5 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Description</th>
                            <th class="text-left px-5 py-2.5 text-[10px] font-valo tracking-[0.2em] text-white uppercase font-semibold">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($achievements as $a): ?>
                            <tr class="border-b border-white/5 hover:bg-white/4 transition-colors duration-150">
                                <td class="px-5 py-3 text-xs font-valo tracking-wide truncate"><?= htmlspecialchars($a->name) ?></td>
                                <td class="px-5 py-3 text-xs text-white/50 truncate"><?= htmlspecialchars($a->description ?? '—') ?></td>
                                <td class="px-5 py-3 whitespace-nowrap">
                                    <form method="POST" action="/achievements/<?= $a->id ?>/delete"
                                          onsubmit="return confirm('Supprimer le succès <?= htmlspecialchars($a->name) ?> ?')">
                                        <button type="submit"
                                                class="flex items-center gap-1.5 text-[11px] font-valo tracking-widest uppercase text-valo-red/50 hover:text-valo-red border border-valo-red/20 hover:border-valo-red/50 px-3 py-1 transition-all duration-150">
                                            <i data-lucide="trash-2" class="w-3 h-3"></i>
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($achievements)): ?>
                            <tr>
                                <td colspan="3" class="px-5 py-5 text-center text-[11px] text-white/20 font-valo tracking-widest uppercase">
                                    Aucun succès pour ce jeu
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>

</main>

<footer class="border-t border-white/10 px-4 sm:px-16 py-5 flex items-center justify-between mt-14">
    <div class="font-valo font-bold text-lg tracking-[0.2em]">
        INSTANT<span class="text-valo-red">-VALORANT</span>
    </div>
    <p class="text-white text-xs tracking-wide">Ynov Campus · Made with ♥ by Nathan & Laurine.</p>
</footer>

<script src="/assets/js/index.js"></script>
</body>
</html>
