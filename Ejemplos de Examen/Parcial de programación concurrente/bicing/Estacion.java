package bicing;
public class Estacion{
    private final int stationId;
    private Bicicleta[] bikes;
    private int bikesTaken;
    public Estacion(int id, int size){
        stationId = id;
        bikes = new Bicicleta[size];
        for(int i = 0; i < size; i++){
            bikes[i] = new Bicicleta(stationId*1000 + i);
        }
        bikesTaken = 0;
    }
    public synchronized int getId(){
        return stationId;
    }
    
    /**
     * se le pasa un identificador de usuario (para mostrarlo) y nos devuelve una bicicleta de las disponibles, 
     * en caso de que no exista ninguna disponible espera hasta 10 segundos a que haya una disponible. Si sigue 
     * sin haber ninguna disponible devolverá null.
     * */
    public synchronized Bicicleta alquila(int userId){
        while(bikesTaken == bikes.length){
            try{
                wait(10000);
                return null;
            }catch(InterruptedException e){}
        }
        System.out.println("Se saca una bici de la estacion, huecos libres= " + (bikes.length-bikesTaken));
        Bicicleta bikeTaken = bikes[bikesTaken];
        bikesTaken++;
        notifyAll();
        return bikeTaken;
    }
    /**
     * se le pasa una bici y un identificador de usuario. Almacena la bicicleta cuando haya hueco disponible.
     * Si no hay hueco, espera lo que sea necesario.
     * */
    public synchronized void devuelve(Bicicleta bike, int userId){
        while(bikesTaken == 0){
            try{
                wait();
            }catch(InterruptedException e){}
        }
        System.out.println("Se mete una bici en la estacion, huecos libres= " + (bikes.length-bikesTaken));
        bikesTaken--;
        notifyAll();
    }
}