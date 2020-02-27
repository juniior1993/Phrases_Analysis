<?php $v->layout("_theme"); ?>


<div class="container-fluid">
    <div class="row">
        <div class="col-2">
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <b>Filtros</b>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Segmento</span>
                                </div>
                                <input type="text" class="form-control" id="filterSegment"
                                       aria-label="digite o segmento">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="valExato"
                                       value="1" checked>
                                <label class="form-check-label" for="valExato">
                                    Valores Exatos
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="maiorQue"
                                       value="2" checked>
                                <label class="form-check-label" for="maiorQue">
                                    Valores Maiores
                                </label>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="selectPalavras">Palavras</label>
                                </div>
                                <select class="custom-select" id="selectPalavras" name="selectPalavras">
                                    <option selected value="0">...</option>
                                    <?php foreach ($filterWords as $number): ?>
                                        <option value="<?= $number; ?>"><?= $number; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="selectRepeticao">Repetição</label>
                                </div>
                                <select class="custom-select" id="selectRepeticao" name="selectRepeticao">
                                    <option selected value="0">...</option>
                                    <?php foreach ($filterRepetitions as $number): ?>
                                        <option value="<?= $number; ?>"><?= $number; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-2">
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <b>Resultado</b>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-sm" id="tableSegments">
                        <thead>
                        <tr>
                            <th scope="col">Segmento</th>
                            <th scope="col" style="text-align: center">Repetição</th>
                            <th scope="col" style="text-align: center">Black List</th>
                            <th scope="col" style="width: 0"></th>
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
                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                data-action="<?= $router->route("add.blacklist"); ?>"
                                                data-segment="<?= $phrase; ?>">
                                            Adicionar
                                        </button>
                                    </td>
                                    <td style="visibility:hidden; width: 0" class="divOne"><?= $character; ?></td>
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
        });

        $("body").on("keyup change", "#selectRepeticao, #selectPalavras, #filterSegment, #valExato, #maiorQue", function (event) {

            let segment = $("#filterSegment").val();
            let words = $("#selectPalavras").val();
            let repetition = $("#selectRepeticao").val();
            let table = $('#tableSegments');
            let typeSearch = $("input:checked").val();

            if (segment || words || repetition) {
                table.find('tr').each(function (i) {
                    let text = $(this).find('td:eq(0)').text();
                    let repetitionsCompare = $(this).find('td:eq(1)').text().trim();
                    let wordsCompare = $(this).find('td:eq(3)').text();
                    let search = text.search(segment);

                    repetitionsCompare = parseInt(repetitionsCompare);
                    wordsCompare = parseInt(wordsCompare);


                    if (!segment) {
                        search = 2;
                    } else {
                        let search = text.search(segment);
                    }
                    if (words == 0) {
                        wordsCompare = true;
                    } else {

                        if (typeSearch == 1) {
                            wordsCompare = wordsCompare == words;
                        } else if (typeSearch == 2) {
                            wordsCompare = wordsCompare >= words;
                        }
                    }

                    if (repetition == 0) {
                        repetitionsCompare = true;
                    } else {

                        if (typeSearch == 1) {
                            repetitionsCompare = repetitionsCompare == repetition;
                        } else if (typeSearch == 2) {
                            repetitionsCompare = repetitionsCompare >= repetition;
                        }
                    }

                    if (search > 1 && wordsCompare && repetitionsCompare) {
                        $(this).fadeIn(400);
                    } else {
                        if ($(this).find("th").length == 0) {
                            $(this).fadeOut(400);
                        }

                    }
                });
            } else {
                table.find('tr').each(function (i) {
                    $(this).stop().fadeIn(400);
                });
            }
        });
    });
</script>
<?php $v->end(); ?>


