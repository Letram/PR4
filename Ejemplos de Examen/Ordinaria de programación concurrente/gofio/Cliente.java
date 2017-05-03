package gofio;
public class Cliente extends Thread{
    int id;
    int gofioBought;
    Tienda shop;
    public Cliente(int id, Tienda t){
        this.id=id;
        shop=t;
        gofioBought = 0;
    }
    public int comprado(){
        return gofioBought;
    }
    @Override
    public void run(){
        System.out.println("Nace un comprador");
        while(true){
            int buyAmount = ValoresSimulacion.cantidadAComprar();
            long sleepTime = ValoresSimulacion.tiempoConsumoKilo();
            
            Log.intentandoComprar(id, shop.stock(), buyAmount, sleepTime);
            if(!shop.comprar(id, buyAmount)){
                Log.noPudoComprar(id, shop.stock(), buyAmount);
                break;
            }
            Log.comprado(id, shop.stock(), buyAmount);
            gofioBought+=buyAmount;
            try{
                sleep(sleepTime*buyAmount);
            }catch(InterruptedException e){}
        }
        System.out.println("Muere un comprador");
    }
}
