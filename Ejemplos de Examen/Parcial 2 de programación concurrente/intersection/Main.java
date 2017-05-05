package intersection;
public class Main {
    private static Street s1;
    private static Street s2;
    private static Street open;
    private static long ini=System.currentTimeMillis();
    public static void main(String[] args) {
        s1 = new Street("B.M.");
        s2 = new Street("L.C.");
        TrafficLight tl = new TrafficLight(s1,s2,100);
        CarGenerator cg1= new CarGenerator(s1);
        CarGenerator cg2= new CarGenerator(s2);
        //Descomente la siguiente línea para encender semáforo
        tl.start();
        //Descomente el bloque siguiente para esperar a que termine el semáforo
        
        try {
            tl.join();
        } catch(Exception e) {
            e.printStackTrace();
        }
        cg1.interrupt();
        cg2.interrupt();
    }
    //Establece la vía abierta
    public static void setOpenStreet(Street s) {
        open = s;
        System.out.print("============================================================\n");
    }
    public static void log(String message) {
            long cur=System.currentTimeMillis();
            String t="";
            t += String.format("%6.2fs      \033[1;31m%s\033[m\n", (cur-ini)/1000.0, message);
            t += showStreet(s1,33);
            t += showStreet(s2,35);
            t +="------------------------------------------------------------\n";
            System.out.print(t);
    }
    public static String showStreet(Street s1, int color) {
        String s=String.format("%4s: ",s1.getName());
        String separator = "|";
        s += String.format("\033[1;%dm",color);
        if ( s1 == open ) {
            s += "\033[40m";
            separator = "<";
        }
        s += separator;
        Car[] cars = s1.getAllCars();
        for(int i=0; i< cars.length; i++) {
            Car c = cars[i];
            s += separator+c.getName() + String.format(" %3.1fs ", c.getCrossingTime()/1000.0);
        }
        s += "\033[m\n";
        return s;
    }
}
