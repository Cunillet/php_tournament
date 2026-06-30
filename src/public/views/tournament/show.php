<section class="p-4 rounded shadow-sm bg-light text-muted">
    <h1 class="display-4 fw-bold mb-3">
        Tournament:
    </h1>
    <div class="container grid-stripped h4">
        <div class="row p-2 d-none">
            <div class="col fw-bold">ID</div>
            <div class="col" id="tournamentID"><?php echo $tournament['ID'] ?></div>
        </div>
        <div class="row p-2">
            <div class="col fw-bold">Name</div>
            <div class="col"><?php echo $tournament['name'] ?></div>
        </div>
        <div class="row p-2">
            <div class="col fw-bold">Game Type</div>
            <div class="col"><?php echo $tournament['gameType'] ?></div>
        </div>
        <div class="row p-2">
            <div class="col fw-bold">Players Count</div>
            <div class="col"><?php echo print_R($tournament['players_count'], true) ?></div>
        </div>
        <div class="row p-2">
            <div class="col fw-bold">Played Rounds</div>
            <div class="col"><?php echo $tournament['rounds'] ?></div>
        </div>
    </div>
</section>
<section class="p-4 mt-2 rounded shadow-sm bg-light text-muted">
    <div class="container">
        <div class="row p-2">
            <div class="col p-4">
                <?php if (!isset($userJoined) || !$userJoined) { ?>
                <a href="/tournaments/join/<?php echo $tournament['ID'] ?>" id="joinTournament" class="d-block btn btn-success btn-lg">
                    Join this Tournament
                </a>
                <?php } else { ?>
                <a href="#" class="d-block btn btn-success btn-lg disabled" id="joinTournament">
                    Already joined this tournament
                </a>
                <?php } ?>
            </div>
            <div class="col p-4">
                <a href="/rounds/create/<?php echo $tournament['ID'] ?>" id="createRoundButton" class="d-block btn btn-success btn-lg">
                    Create Tournament Round
                </a>
            </div>
        </div>
    </div>
</section>
<script type="module" src="../../js/tournament/show.js"></script>