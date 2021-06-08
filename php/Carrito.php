<?php
    include "pedidos.php";
  
    $pedidos = new Pedidos;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script>
    function updateItem(e , id){
       let cantidad = e.value;
       let xhttp = new XMLHttpRequest();
       xhttp.onload = function(){
           document.getElementById("mensaje").innerHTML = this.responseText;
          if(this.response =='ok'){
              window.location="Carrito.php";
          }else{
            document.getElementById("mensaje").innerHTML = 'Error';
          }
       }
       xhttp.open("GET","solicitarPedido.php?action=updateItem&id="+id+"&cantidad="+cantidad);
       xhttp.send();

    }
</script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
      
    <a class="navbar-brand"><img src="../img/logo.png" height="70px" width="80px;" /></a>
       <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
       </button>
       <div id="my-nav" class="collapse navbar-collapse">
           <ul class="navbar-nav mr-auto">
               <li class="nav-item ">
                   <a class="nav-link" href="../index.php">Inicio <span class="sr-only">(current)</span></a>
               </li>
               <li class="nav-item active">
                   <a class="nav-link" href="Carrito.php">Carrito<span class="sr-only">(current)</span></a>
               </li>
               <li class="nav-item">
                   <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Contactenos</a>
               </li>
           </ul>
       </div>
</nav>
<br><br><br><br><br>
<div class="alert alert-info">
           <h1 id="mensaje">Hola Amigo.</h1>           
       </div>
<div class="container">   
    <h1>Carrito de Compras</h1>  
    <table class="table">
        <thead>
        <tr>
        <th>ID</th>
        <th>Especie:</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Importe</th>
        <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php
               if (($_SESSION['cart_contents']) && $_SESSION['cart_contents']>0 && $_SESSION['cart_contents']['total_items'] !=0) {
                    foreach($_SESSION['cart_contents'] as $items){
                        if (isset($items['id']) && !empty($items['id'])) {                           
                        
                        echo "
                        <tr>
                        <td>".$items['id']."</td>
                        <td>".$items['especie']."</td>
                        <td>".$items['price']."</td>
                        <td> <input type='number' onchange='updateItem(this,". $items['id'] .")' value='".$items['cantidad']."'></td>
                        <td> $".$items['subtotal']."</td>
                        <td><a href='solicitarPedido.php?action=removeItem&id=".$items['id']."' class='btn btn-danger'"."onclick=''><i class='fas fa-trash'>Eliminar</i></a></t>
                        </tr>
                        
                        ";
                    }
                }
                }else{
                    echo "<tr><td colspan='6'><h1>No hay Datos</h1></td></tr>";
                }
                
        ?>
        </tbody>
        <tfoot>
        <tr>
        <th>ID</th>
        <th>Especie:</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Importe</th>
        <th>&nbsp;</th>
        </tr>
        </tfoot>
    </table>
       </div>
</div>
</body>
</html>