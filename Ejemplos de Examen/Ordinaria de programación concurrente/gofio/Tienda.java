package gofio;
public class Tienda{
    private int capacity;
    private int storedKilos;
    public Tienda(int capacidad){
        capacity=capacidad;
        storedKilos = 0;
    }
    public synchronized boolean vender(int idAgricultor, int sacos){ //El agricultor intenta vender N sacos de 20kg
        while(storedKilos + (sacos*20) > capacity){
            try{
                wait(ValoresSimulacion.esperaVenta());
                notifyAll();
                return false;
            }catch(InterruptedException e){}
        }
        storedKilos += sacos*20;
        notifyAll();
        return true;
    }
    public synchronized boolean comprar(int idCliente, int kilos){//El cliente intenta comprar N kilos
        while(storedKilos < kilos){
            try{
                wait(ValoresSimulacion.esperaCompra());
                notifyAll();
                return false;
            }catch(InterruptedException e){}
        }
        storedKilos -= kilos;
        notifyAll();
        return true;
    }
    public synchronized int stock(){ //kilos en stock
        return storedKilos;
    }
}
