<section class="p-4 rounded shadow-sm bg-light text-muted">
    <h1 class="display-4 fw-bold mb-3">
        New Game Type
    </h1>
    <form
        action="/gameTypes"
        method="POST"
        id="createForm"
        enctype="multipart/form-data"
        class="container h4">
        <div class="row form-group mb-2">
            <label class="col-4 col-form-label fw-bold" for="inputName">Name</label>
            <input class="col up form-control rounded" name="name" id="inputName" type="text" value="" placeholder="Name"/>
        </div>
        <div class="row form-group mb-2">
            <label class="col-4 col-form-label fw-bold" for="inputVersion">Version</label>
            <input class="col up form-control rounded" name="version" id="inputVersion" type="number" min="0" step="0.1" placeholder="Version"/>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-success mt-5 mr-2">Create</button>
        </div>
    </form>
</section>
<script type="module" src="../../js/gametype/create.js"></script>
