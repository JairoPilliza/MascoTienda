<?php
session_start();
class Pedidos{
    protected $cart_contents = array();

    //obtener de session la matriz del carrito de compras 
    public function __construct()
    {
        $this->cart_contents= !empty($_SESSION['cart_contents'])?$_SESSION['cart_contents']:NULL;
        if ($this->cart_contents === NULL ) {
            //Inicializamos el array en el caso de que el array sea Null.
            $this->cart_contents = array('cart_total'=>0,'total_items'=>0);

        }
        
    }

    //Retornar la matriz del carrito reorganizada de la compra mas reciente a la mas antigua 
    public function contents()
    {
        $cart = array_reverse($this->cart_contents);
        //Eliminar para no crar problemas
        unset($cart['total_items']);
        unset($cart['cart_total']);

        return $cart;
    }

    //Retornar el detalle especifico de un item

    public function get_item($row_id)
    {
        return (in_array($row_id,array('total_items','cart_total'),TRUE)OR !isset($this->cart_contents[$row_id]))?FALSE:$this->cart_contents[$row_id];

    }

    //Retornar el conteo total del items 
    public function total_items()
    {
        return $this->cart_contents['total_items'];
    }
    //Rteornar el precio total 
    public function total()
    {
        return $this->cart_contents['cart_total'];
    }
    //Guardar el contenido del array cart_contents en un session
    protected function save_cart()
    {
        $this->cart_contents['total_items'] = $this->cart_contents['cart_total']=0;

        foreach($this->cart_contents as $key=>$val){
            if (!is_array($val) or !isset($val['price'],$val['cantidad'])){
                continue;
            }
            $this->cart_contents['cart_total'] += ($val['price']*$val['cantidad']);
            $this->cart_contents['total_items'] += $val['cantidad'];
            $this->cart_contents[$key]['subtotal'] = 
                ($this->cart_contents[$key]['price']*$this->cart_contents[$key]['cantidad']);
        }
            if (count($this->cart_contents)<=2) {
                unset($_SESSION['cart_contents']);
                return false;
            }else{
                $_SESSION['cart_contents'] = $this->cart_contents;
                return true;
            }
        
    }

    //Insertar un elemento en el carrito

    public function insert($item = array())
    {
        if (!is_array($item) or count($item) === 0) {
            return false;
        }else{
            if (!isset($item['id'],$item['especie'],$item['price'],$item['cantidad'])) {
                return false;
            }else{
                //insertar un elemento
                $item['cantidad'] = (float) $item['cantidad'];
                if ($item['cantidad']==0) {
                    return false;
                }
                $item['price'] = (float) $item['price'];
                //Generar un codigo unico para el identificador de la fila.
                $rowid = md5($item['id']);
                $_cantidad = isset($item['cantidad']) ? $item['cantidad'] : 0 ;
                $item['rowid'] = $rowid;
                $item['cantidad']= $_cantidad;
                $this->cart_contents[$rowid] = $item;

                if ($this->save_cart()) {
                    return isset($rowid) ? $rowid : true;
                }else{
                    false;
                }
            }
        }
    }

    //Actualizar carrito

    public function updateItem($item = array()){
        if(!is_array($item) or count($item) ===0){
            return false;
        }else{
            if(!isset($item['rowid'], $this->cart_contents[md5($item['rowid'])])){
                return false;
            }else{
                if(isset($item['cantidad'])){
                    $item['cantidad'] = (float)$item['cantidad'];
                    if($item['cantidad']==0){
                        $this->remove($item['rowid']);
                        
                    }
                }
                $this->cart_contents[md5($item['rowid'])]['cantidad'] = $item['cantidad'];
                $this->save_cart();
                return true;
               // $keys = array_intersect(array_keys($this->cart_contents[md5($item['rowid'])]),array_keys($item));
                //if(isset($item['price'])){
                   // $item['price'] = (float) $item['price'];
               // }
               // foreach(array_diff($keys,array('id','especie')) as $key){
                 //   $this->cart_contents[$item['rowid']][$key] =$item[$key];
              //  }
               // $this->save_cart();
               // return true;
            }
        }
    }

    //Retornar un item del el carro 
    public function remove($row_id)
    {
        unset($this->cart_contents[md5($row_id)]);
        $this->save_cart();
        return true;
    }
    //Limpiar el carro y a destruir la session
    public function destroy()
    {
        $this->cart_contents=array('cart_total'=>0,'total_items'=>0);
        unset($_SESSION['cart_contents']);
    }

}
?>