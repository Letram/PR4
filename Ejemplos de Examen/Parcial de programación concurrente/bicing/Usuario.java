package bicing;
import java.util.Random;
public class Usuario extends Thread{
    private final int userId;
    private Estacion from;
    private Estacion to;
    
    public Usuario(int id, Estacion from, Estacion to){
        userId = id;
        this.from = from;
        this.to = to;
    }
    @Override
    public void run(){
        System.out.println("Nace el ciclista " + userId);
        Bicicleta bikeTaken = from.alquila(userId);
        if(bikeTaken != null){
            System.out.println("Coge la bici");
            try{
                sleep(getRandomValue(4000, 7000));
            }catch(InterruptedException e){}
            System.out.println("Devuelve la bici");
            to.devuelve(bikeTaken, userId);
        }
        System.out.println("Muere el ciclista " + userId);
    }
    
    private int getRandomValue(int min, int max){
        Random rand = new Random();
        int random = rand.nextInt((max-min)+1)+min; 
        return random;
    }
}
