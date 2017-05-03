package textprocessing;
import java.util.LinkedList;
import java.util.Queue;
public class FileNames {
    private Queue<String> queue;
    private boolean stop = false;
    public FileNames(){
        queue = new LinkedList<>();
    }
    public synchronized void addName(String fileName) {
        if(!stop){
            queue.add(fileName);
            notifyAll();
        }
    }
    public synchronized String getName(){
        while(queue.isEmpty()){
            if(stop == true){
                return null;
            }
            else{
                try {
                    wait();
                } catch(InterruptedException e) {}
            }
        }
        return queue.poll();
    }
    public synchronized void noMoreNames() {
        stop = true;
    }
}