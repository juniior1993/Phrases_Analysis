<?php $v->layout("_theme"); ?>
<div class="container-sm">
    <div class="card">
        <div class="card-header">
            <b>Analisar segmentos</b>
        </div>
        <div class="card-body">
            <form action="<?= url("/text_analyze"); ?>" method="post">
                <div class="form-group row">
                    <label for="textToAnalyze"
                           class="col-sm-3 col-form-label">
                        Texto
                    </label>
                    <div class="col-sm-9">
                            <textarea class="form-control"
                                      id="textToAnalyze"
                                      name="textToAnalyze"
                                      rows="15" required></textarea>
                        <span>Palavras: <b id="counterWords">0</b></span>
                    </div>
                </div>

                <div class="form-group row ">
                    <label for="wordsToAnalyze" class="col-sm-3 col-form-label">Palavras minimas por
                        segmento</label>
                    <div class="col-sm-1">
                        <input type="text"
                               class="form-control mb-2"
                               id="wordsToAnalyze"
                               placeholder="5"
                               name="wordsToAnalyze"
                               style="text-align: center" required
                               autocomplete="off">
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="wordsToShow"
                           class="col-sm-3 col-form-label">Mostrar quando tiver</label>
                    <div class="col-sm-1">
                        <input type="text"
                               class="form-control mb-2"
                               id="wordsToShow"
                               placeholder="2"
                               name="wordsToShow"
                               style="text-align: center" required
                               autocomplete="off">
                    </div>
                    <label for="wordsToShow"
                           class="col-sm-3
                               col-form-label">ou mais segmentos repetidas</label>
                </div>

                <div class="form-group row">
                    <div class="col-sm-3">
                        <label for="caseSensitive">Case sensitive</label>
                    </div>
                    <div class=" col-sm-3">
                        <input class="" type="checkbox" id="caseSensitive" name="caseSensitive"
                               style="margin: 0 0 0 10px">
                    </div>

                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit"
                                class="btn btn-primary">
                            Analisar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $v->start("scripts"); ?>
<script>
    $(function () {

        $("#textToAnalyze").on("keyup", function () {
            let text = $(this).val();
            let textArray;
            let arrayClear;
            textArray = text.trim().split(/\s/g);

            arrayClear = textArray.filter(function (element) {
                return element !== "";
            });
            $("#counterWords").text((arrayClear.length).toLocaleString())

        });

    })
</script>
<?php $v->end(); ?>

<?php $v->start("style"); ?>
<style>


    input[type=checkbox] {
        /* Double-sized Checkboxes */
        -ms-transform: scale(2); /* IE */
        -moz-transform: scale(2); /* FF */
        -webkit-transform: scale(2); /* Safari and Chrome */
        -o-transform: scale(2); /* Opera */
        padding: 10px;
    }


</style>
<?php $v->end(); ?>

