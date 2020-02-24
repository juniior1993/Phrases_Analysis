<?php $v->layout("_theme"); ?>


<div class="container-fluid">
    <div class="row">
        <div class="col-2">
        </div>
        <div class="col-10">
            <div class="card">
                <div class="card-header">
                    <b>Resultado</b>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-responsive-sm">
                        <thead>
                        <tr>
                            <th scope="col">Segmento</th>
                            <th scope="col" style="text-align: center">Repetição</th>
                            <th scope="col" style="text-align: center">Black List</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($phrases as $numberOfRepetitions => $arrayPhrases): ?>
                            <?php foreach ($arrayPhrases as $phrase => $character): ?>
                                <tr>
                                    <td>
                                        <?= $phrase; ?>
                                    </td>
                                    <td style="text-align: center">
                                        <?= $numberOfRepetitions; ?>
                                    </td>
                                    <td style="text-align: center">
                                        <button type="button" class="btn btn-outline-danger"
                                                data-action="<?= $router->route("add.blacklist"); ?>"
                                                data-segment="<?= $phrase; ?>">
                                            Adicionar
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
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
            })
        })


    })
</script>
<?php $v->end(); ?>


