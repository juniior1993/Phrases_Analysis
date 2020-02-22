<?php

include_once './vendor/autoload.php';

$file = __DIR__ . '/Teste.docx';


$text = "MARCILIA RIBEIRO DOS SANTOS	
Em Viña del Mar, República do Chile, em 10 de julho de 2018, perante mim, PATRICIA BAHAMONDE VEGA, Advogada, Notária Pública de Viña del Mar, estabelecida em Doce Norte número setecentos e oitenta e cinco, terceiro andar, Suplente do titular LUIS ENRIQUE FISCHER YAVAR, em virtude do Decreto Judicial Protocolizado, comparece: Sra. SORAYA ELLEN VALLEJOS MUÑOZ, chilena, casada, professora, carteira de identidade nacional número dez milhões trezentos e noventa e três mil cento e quarenta e um travessão K, domiciliada em Villanelo cinqüenta e seis, apartamento vinte e seis, Edifício Vagnara, município de Viña del Mar, em representação do Sr. CESAR DAGOBERTO VALLEJOS MUNOZ, chileno, divorciado, empresário, carteira de Identidade Nacional e Número de Contribuinte Único dez milhões trezentos e noventa e três mil e noventa e três travessão seis, domiciliado na rua Escriba de Balaguer número setecentos e setenta, Foresta de Montemar, número dois mil seiscentos e um, Concon, maior de idade e em pessoa nessa localidade, comprovando sua identidade com o documento já anotado e declara que autoriza pelo presente instrumento a Sra. MARCILIA RIBEIRO DOS SANTOS, carteira de identidade brasileira número um milhão e quinhentos e noventa e cinco mil e setenta e cinco, para que possa viajar para o exterior com seu filho legítimo, menor de idade, Sr. FILIPE VALLEJOS DOS SANTOS, Cédula de Identidade Brasileira número quatro milhões setecentos e oitenta e oito mil oitocentos e trinta e seis, para qualquer parte do mundo, sempre que julgar conveniente, em companhia de qualquer de seus pais, sem limitação de qualquer tipo, espécie ou natureza, podendo ingressar e tornar a fazer uso desta autorização de viagem tantas vezes quantas forem necessárias, sujeito às leis e regulamentos de cada país ou cidade visitada. - A presente autorização de viagem é outorgada até que o referido menor alcance sua maioridade. – Sob a maior extensão e sem que a enumeração signifique limitação, declaram que esta autorização poderá ser ampliada para todos e quaisquer dos países, seja América do Sul, América do Norte, Europa, Ásia, África ou Oceanis, com as amplas faculdades. - Também faculta realizar todos os tipos de procedimentos para obter o passaporte correspondente do menor de idade perante o Órgão competente. Consta protocolizado sob o mesmo número de repertório CERTIDÃO DE NASCIMENTO do menor, juntamente com um certificado apostilado do mesmo e cópia da carteira de identidade da mãe. A presente autorização não autoriza o portador a realizar procedimentos de adoção do menor acima mencionado. Dados pessoais: os dados pessoais da Sra Soraya Ellen Vallejos Muñoz para representar o Sr. Cesar Dagoberto Vallejos Muñoz constam de escritura pública de mandato geral datada de vinte e um de julho de dois mil e dez, lavrada no cartório de Viña del Mar do Sr. Raul Farren Paredes, com efeito a partir de vinte e oito de fevereiro de dois mil e dezoito, outorgada pela arquivista judicial de Viña del Mar, Sra. Ana María Letelier Peres, a qual não é inserida por ser conhecida das partes e da Notária autorizante. Em um instrumento e depois de lê-lo, assina o comparecimento junto com a Notária autorizante. Foi dado cópia. DOU FÉ.	
";

//$token = tokenize($text);
//
//$trigrams = ngrams($token, 3);
//
//$rake = rake($token, 3);
//var_dump($rake->getKeywordScores());

$analysis = new \Source\Core\Phrases_Analysis();

$analysis->getWordsAndSplit($text);
$analysis->analyze(20);
$analysis->clearUniqWords(3);
$analysis->unionArrays();

var_dump($analysis->unionArrays);