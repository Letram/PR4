package intersection;

import java.util.*;

class Street {
    private String name;
    private Queue<Car> queue;
    
    /* Se le pasa nombre de calle y
    establece la cola vacía */
    public Street(String name){
        this.name = name;
        queue = new LinkedList<>();
    }

    /* Devuelve nombre de calle */
    public String getName(){
        return name;
    }

    /* Añade un coche a la cola. Lo usa la clase CarGenerator */
    public synchronized void addCar(Car c){
        queue.add(c);
        notifyAll();
    }
    
    /* Devuelve y saca un coche de la cola */
    public synchronized Car getCar(){
        while(queue.peek() == null){
            try{
                wait(2000);
                if(queue.peek() == null)return null;
            }catch(InterruptedException e){}
        }
        return queue.poll();
    }

    /* Devuelve un array con los coche de la cola y en su orden*/
    public Car[] getAllCars(){
        return queue.toArray(new Car[0]);
    }
}
