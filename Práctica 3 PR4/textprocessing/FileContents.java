package textprocessing;
import java.util.LinkedList;
import java.util.Queue;
public class FileContents {
    private Queue<String> queue;
    private int registerCount = 0;
    private int maxCharSize = 0;
    private int maxSize = 0;
    private boolean closed = false;
    private int spaceOccupied = 0;
    
    public FileContents(int maxFiles, int maxChars) {
        maxSize = maxFiles;
        maxCharSize = maxChars;
        queue = new LinkedList<>();
    }
    public synchronized void registerWriter() {
        registerCount++;
    }
    public synchronized void unregisterWriter() {
        registerCount--;
        if(registerCount == 0)closed=true;
    }
    public synchronized void addContents(String contents){
        if(queue.isEmpty() && contents.length() > maxCharSize){
            queue.add(contents);
            spaceOccupied += contents.length();
            notifyAll();
        }else{
            while((queue.size() == maxSize) || ((spaceOccupied + contents.length() > maxCharSize))){
                try {
                    wait();
                } catch(InterruptedException e) {}
            }
            queue.add(contents);
            spaceOccupied += contents.length();
            notifyAll();   
        }
    }
    public synchronized String getContents(){
        while (queue.isEmpty()){
            if(closed)return null;
            else{
                try {
                    wait();
                } catch(InterruptedException e) {}
            }
        }
        String contents = queue.poll();
        spaceOccupied -= contents.length();
        notifyAll();
        return contents;
    }
}
