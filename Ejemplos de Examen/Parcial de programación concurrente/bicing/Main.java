package bicing;
public class Main{
    public static void main(String[] args){
        java.util.Random rnd=new java.util.Random();
        Estacion e1= new Estacion(1,2); // quería poder probar con capacidades menores - JFG
        Estacion e2= new Estacion(2,3);
        for(int i=0; i<50; i++){
            Usuario u;
            if(rnd.nextBoolean()){
                u=new Usuario(i,e1,e2);
            }else{
                u=new Usuario(i,e2,e1);
            }
            u.start();
            try{
                long espera=rnd.nextInt(2000);
                Thread.sleep(espera);
            }catch(Exception e){};
        }
        try{
            Thread.sleep(18000);
        }catch(Exception e){};
        System.exit(0);
    }
}