<section class="p-4 rounded shadow-sm bg-light text-muted">
    <h1 class="display-4 fw-bold mb-3 d-flex justify-content-between align-items-center">
        <span>Game Types List</span><a href="/gameTypes/create" class="btn btn-success">+</a>
    </h1>
    <div class="container grid-stripped">
        <div class="row h4 fw-bold p-2">
            <div class="col">
                ID
            </div>
            <div class="col">
                Name
            </div>
            <div class="col">
                Version
            </div>
        </div>
        <?php
        if (count($gameTypes) > 0) {
            foreach($gameTypes as $gameType) {
        ?>
            <div class="row p-2">
                <div class="col">
                    <a class="d/block text-muted text-decoration-none" href="/gameTypes/<?php echo $gameType['ID'] ?>">
                        <?php echo $gameType['ID'] ?>
                    </a>
                </div>
                <div class="col">
                    <a class="d/block text-muted text-decoration-none" href="/gameTypes/<?php echo $gameType['ID'] ?>">
                        <?php echo $gameType['name'] ?>
                    </a>
                </div>
                <div class="col">
                    <a class="d/block text-muted text-decoration-none" href="/gameType/<?php echo $gameType['ID'] ?>">
                        <?php echo $gameType['version'] ?>
                    </a>
                </div>
            </div>
        <?php
            }
        } else {
        ?>
        <div class="row text-center">No Game Types found</div>
        <?php } ?>
    </div>
</section>