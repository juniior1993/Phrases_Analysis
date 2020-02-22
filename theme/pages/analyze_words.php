<?php $v->layout("_theme"); ?>

<div class="card">
    <div class="card-header">
        <b>Analisar segmentos</b>
    </div>
    <div class="card-body">
        <form>
            <div class="form-group row">
                <label for="exampleFormControlTextarea1" class="col-sm-2 col-form-label">Texto</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="15"></textarea>
                </div>
            </div>

            <div class="form-group row ">
                <label for="wordsToAnalyze" class="col-sm-2 col-form-label">Palavras para analisar</label>
                <div class="col-sm-1">
                    <input type="text" class="form-control mb-2" id="wordsToAnalyze" placeholder="5" style="text-align: center">
                </div>
            </div>
            <div class="form-group row ">
                <label for="wordsToShow" class="col-sm-2 col-form-label">Mostrar</label>
                <div class="col-sm-1">
                    <input type="text" class="form-control mb-2" id="wordsToShow" placeholder="5" style="text-align: center">
                </div>
                <label for="wordsToShow" class="col-sm-2 col-form-label">Palavras repetidas</label>
            </div>


            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Analisar</button>
                </div>
            </div>
        </form>
    </div>
</div>