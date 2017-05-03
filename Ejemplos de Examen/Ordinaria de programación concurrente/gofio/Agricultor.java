package gofio;
public class Agricultor extends Thread{
    int id;
    private int gofioSold;
    private Tienda shop;
    public Agricultor(int id, Tienda t){
        this.id=id;
        shop = t;
        gofioSold = 0;
    }
    public int vendido(){ 
        // RETORNAR nº de Kg
        return gofioSold; 
    }
    
    @Override
    public void run(){
        int nIter=5;
        System.out.println("Nace un agricultor");
        while(nIter > 0){
            nIter--;
            long sleepTime = ValoresSimulacion.tiempoCosecha();
            int harvest = ValoresSimulacion.cantidadCosechada();
            
            Log.intentandoVender(id, shop.stock(), harvest, sleepTime);
            if(!shop.vender(id, harvest)){
                Log.noPudoVender(id, shop.stock(), harvest); 
                continue;
            }
            Log.vendido(id, shop.stock(), harvest);
            gofioSold+=harvest*20;
            try{
                sleep(sleepTime);
            }catch(InterruptedException e){}
        }
        System.out.println("Muere un agricultor");
    }
}
