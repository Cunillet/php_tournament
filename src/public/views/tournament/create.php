<section class="p-4 rounded shadow-sm bg-light text-muted">
    <h1 class="display-4 fw-bold mb-3">
        New Tournament
    </h1>
    <form
        action="/tournaments"
        method="POST"
        id="createForm"
        enctype="multipart/form-data"
        class="container h4">
        <div class="row form-group mb-2">
            <label class="col-4 col-form-label fw-bold" for="inputName">Name</label>
            <input class="col up form-control rounded" name="name" id="inputName" type="text" value="" placeholder="Name"/>
        </div>
        <div class="row form-group mb-2">
            <label class="col-4 col-form-label fw-bold" for="inputVersion">Game Type</label>
            <?php if (count($gameTypes) > 0) { ?>
            <select id="selectGameType" name="selectGameType" class="form-select col up rounded" aria-label="Default select example">
                <option selected>Select Game Type</option>
                <?php foreach($gameTypes as $gameType) { ?>
                <option value="<?php echo $gameType['ID'] ?>"><?php echo $gameType['name'].' v.'. $gameType['version'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-success mt-5 mr-2">Create</button>
            <?php } else { ?>
            <span>NO GAME TYPES FOUND. Create game types before create tournaments</span>
            <?php } ?>
        </div>
    </form>
</section>
<script type="module" src="../../js/tournament/create.js"></script>
