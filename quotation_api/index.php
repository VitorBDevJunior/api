<?php
require_once 'config/config.php';
require_once 'modules/qt-api.php';

$qt = new QtApi(QT_API_KEY);
$dolar = $qt->CotDolar();
if($qt->is_error() == false){
    $variation = ($dolar['variation'] < 0) ? 'danger' : 'primary';
}


$euro = $qt->CotEuro();
if($qt->is_error() == false){
    $variation = ($euro['variation'] < 0) ? 'danger' : 'primary';
}

//print_r($dolar);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotação de Moedas</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p>Cotação do dólar</p>
                <?php if($qt->is_error() == false):  ?>
                <p>USD:  <span class="badge badge-pill badge-<?=$variation;?>"><?php echo $dolar['buy'];?> </span></p>

                    <?php else:  ?> 
                        <p>USD <span class="badge badge-pill badge-danger">Serviço indisponível no momento</span></p>
                    <?php endif;  ?>     
            </div>
        </div>
    </div>
<hr>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p>Cotação do Euro</p>
                <?php if($qt->is_error() == false):  ?>
                <p>EUR: <span class="badge badge-pill badge-<?=$variation;?>"><?php echo $euro['buy'];?> </span></p>
                    <?php else:  ?> 
                        <p>EUR <span class="badge badge-pill badge-danger">Serviço indisponível no momento</span></p>
                    <?php endif;  ?>     
            </div>
        </div>
    </div>

    <div class="container">
        <span class="badge bg-light text-dark" id="timer"></span>
    </div>



    


<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
</body>
</html>

<script>
    /**
     * Função para setar o time
     */
    function setTimer(duration, display){
        var timer = duration, minutes, seconds;
        setInterval(function(){
            minutes = parseInt(timer/60,10);//seta os minutos
            seconds = parseInt(timer % 60,10);//seta os segundos

            //se os valores forem menor que 10 concatena com o valor 0
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            //seta informações no input timer
            display.textContent = "Atualiza em: " + minutes + ":" + seconds;
            if(--timer < 0){
                location.reload();
                timer = duration;
            }
        }, 1000);
    }

    /**
     * Função que inicia ao carregar a pagina
     */
    window.onload = function(){
        const duration = 59;
        var display = document.getElementById("timer");
        setTimer(duration, display);
    };
</script>