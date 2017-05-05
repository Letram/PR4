package intersection;

class TrafficLight extends Thread{
    private Street s1;
    private Street s2;
    private int crossingCars;
    /* se le pasan las dos calles de la intercesión
     y el número de coches a simular que la cruzan */
    public TrafficLight(Street s1, Street s2, int m){
        this.s1 = s1;
        this.s2 = s2;
        crossingCars = m;
    }
    
    @Override
    public void run(){
        boolean stop = false;
        int cont = 0;
        System.out.println("Nace el semáforo");
        while(stop == false){
            int carsAllowed = 3;
            while(carsAllowed > 0 && stop == false){
                Main.setOpenStreet(s1);
                Car c = s1.getCar();
                if(c == null){
                    Main.log("Me he cansado de esperar en la calle s1");
                    break;
                }
                Main.log("Saco un coche de la calle 1");
                try{
                    sleep(c.getCrossingTime());
                }catch(InterruptedException e){}
                carsAllowed--;
                if(carsAllowed == 0)Main.log("Se ha atendido a 3 coches en s1");
                cont++;
                if(cont == crossingCars){
                    stop = true;
                    Main.log("Se han atendido los coches que se pidieron");
                    break;
                }
            }
            carsAllowed = 3;
            while(carsAllowed > 0 && stop == false){
                Main.setOpenStreet(s2);
                Car c = s2.getCar();
                if(c == null){
                    Main.log("Me he cansado de esperar en la calle s2");
                    break;
                }
                Main.log("Saco un coche de la calle 2");
                try{
                    sleep(c.getCrossingTime());
                }catch(InterruptedException e){}
                carsAllowed--;
                if(carsAllowed == 0)Main.log("Se ha atendido a 3 coches en s2");
                cont++;
                if(cont == crossingCars){
                    stop = true;
                    Main.log("Se han atendido los coches que se pidieron");
                    break;
                }
            }
        }
        System.out.println("Muere el semáforo");
    }
}
