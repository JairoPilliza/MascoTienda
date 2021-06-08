<?php
    include 'pedidos.php';
    include '../config/conexion.php';
    $pedidos = new Pedidos;

    if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
        if ($_REQUEST['action'] == 'addItem' && !empty($_REQUEST['id'])) {
            $id = $_REQUEST['id'];

            $query = $mysqli->query('Select * from mascotas where id='.$id);
            $row = $query->fetch_assoc();
            $itemData = array(
                'id' => $row['id'],
                'especie' => $row['especie'],
                'price' => $row['precio'],
                'cantidad' =>1
            );
            $insertItem = $pedidos->insert($itemData);
            $redirectLoc = $insertItem?"Carrito.php":"../index.php";
            header("Location:".$redirectLoc);
        }else if($_REQUEST['action'] == 'removeItem' && !empty($_REQUEST['id'])){
            $deleteItem = $pedidos->remove($_REQUEST['id']);
            header("Location: Carrito.php");
            die;

        }else if($_REQUEST['action'] == 'updateItem' && !empty($_REQUEST['id'])){
                $itemData = array(
                    'rowid'=>$_REQUEST['id'],
                    'cantidad' =>$_REQUEST['cantidad']
                );
                $updateItem = $pedidos->updateItem($itemData);
                echo $updateItem?'ok':'err';
                die;
        }
    }
?>