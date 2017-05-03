package textprocessing;
public class FileReader extends Thread{
    
    FileNames fn;
    FileContents fc;
    
    public FileReader(FileNames fn, FileContents fc){
        this.fn = fn;
        this.fc = fc;
    }
    
    @Override
    public void run(){
        fc.registerWriter();
        String fname = fn.getName();
        while(fname != null){
            fc.addContents(Tools.getContents(fname));
            fname = fn.getName();
        }
        fc.unregisterWriter();
    }
}
