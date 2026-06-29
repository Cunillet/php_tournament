<section class="p-4 rounded shadow-sm bg-light text-muted">
    <h1 class="display-4 fw-bold mb-3 d-flex justify-content-between align-items-center">
        <span>Tournaments List</span><a href="/tournaments/create" class="btn btn-success">+</a>
    </h1>
    <div class="container grid-stripped">
        <div class="row h4 fw-bold p-2">
            <div class="col">
                Date
            </div>
            <div class="col">
                Name
            </div>
            <div class="col">
                Game
            </div>
            <div class="col">
                Players
            </div>
            <div class="col">
                Rounds
            </div>
            <div class="col">
                Actions
            </div>
        </div>
        <?php
        if (count($tournaments) > 0) {
            foreach($tournaments as $tournament) {
        ?>
            <div class="row p-2">
                <div class="col">
                    <a class="d/block text-muted text-decoration-none" href="/tournaments/<?php echo $tournament['ID'] ?>">
                        <?php echo $tournament['created_at'] ?>
                    </a>
                </div>
                <div class="col">
                    <a class="d/block text-muted text-decoration-none" href="/tournaments/<?php echo $tournament['ID'] ?>">
                        <?php echo $tournament['name'] ?>
                    </a>
                </div>
                <div class="col">
                    <a class="d/block text-muted text-decoration-none" href="/tournaments/<?php echo $tournament['ID'] ?>">
                        <?php echo $tournament['gameType'] ?>
                    </a>
                </div>
                <div class="col">
                    <a class="d/block text-muted text-decoration-none" href="/tournaments/<?php echo $tournament['ID'] ?>">
                        <?php echo $tournament['players_count'] ?>
                    </a>
                </div>
                <div class="col">
                    <a class="d/block text-muted text-decoration-none" href="/tournaments/<?php echo $tournament['ID'] ?>">
                        <?php echo $tournament['rounds'] ?>
                    </a>
                </div>
                <div class="col">
                    <a class="d/block text-muted text-decoration-none" href="/tournaments/<?php echo $tournament['ID'] ?>/delete">
                        <i class="bi bi-trash3-fill"></i>
                    </a>
                    <a class="text-primary text-decoration-none ms-3" href="/tournaments/<?php echo $tournament ['ID'] ?>/edit">
                        <i class="bi bi-pen-fill"></i>
                    </a>
                </div>
            </div>
        <?php
            }
        } else {
        ?>
        <div class="row text-center">No Tournaments found</div>
        <?php } ?>
    </div>
</section>