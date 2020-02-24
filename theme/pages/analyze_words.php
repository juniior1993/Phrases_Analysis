<?php $v->layout("_theme"); ?>
<div class="container-sm">
    <div class="card">
        <div class="card-header">
            <b>Analisar segmentos</b>
        </div>
        <div class="card-body">
            <form action="<?= url("/text_analyze"); ?>" method="post">
                <div class="form-group row">
                    <label for="textToAnalyze" class="col-sm-2 col-form-label">Texto</label>
                    <div class="col-sm-10">
                    <textarea class="form-control"
                              id="textToAnalyze"
                              name="textToAnalyze"
                              rows="15" required></textarea>
                    </div>
                </div>

                <div class="form-group row ">
                    <label for="wordsToAnalyze" class="col-sm-2 col-form-label">Palavras para analisar</label>
                    <div class="col-sm-1">
                        <input type="text"
                               class="form-control mb-2"
                               id="wordsToAnalyze"
                               placeholder="5"
                               name="wordsToAnalyze"
                               style="text-align: center" required>
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="wordsToShow" class="col-sm-2 col-form-label">Mostrar quando tiver</label>
                    <div class="col-sm-1">
                        <input type="text"
                               class="form-control mb-2"
                               id="wordsToShow"
                               placeholder="2"
                               name="wordsToShow"
                               style="text-align: center" required>
                    </div>
                    <label for="wordsToShow" class="col-sm-3 col-form-label">ou mais palavras repetidas</label>
                </div>


                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Analisar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>