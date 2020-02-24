<?php $v->layout("_theme"); ?>


<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="font-weight: bold;">
                    Black List
                </div>
                <div class="card-body">
                    <table class="table table-hover table-sm">
                        <thead>
                        <tr>
                            <th scope="col">Segmento</th>
                            <th scope="col" style="text-align: center"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($blacklist): ?>
                            <?php foreach ($blacklist as $segment): ?>

                                <tr>
                                    <td>
                                        <?= $segment->phrase; ?>
                                    </td>
                                    <td style="text-align: center">
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-action="<?= $router->route("delete.blacklist"); ?>"
                                                data-segment="<?= $segment->id; ?>">
                                            Remover da BlackList
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php $v->start("scripts"); ?>
<script>
    $(function () {

        $("body").on("click", "[data-action]", function (e) {
            e.preventDefault();
            let data = $(this).data();
            let div = $(this).parents("tr");

            $.post(data.action, data, function () {
                div.fadeOut();
            }, "json").fail(function () {
                alert("Erro ao processar requisição");
            });
        });





    })
</script>
<?php $v->end(); ?>


