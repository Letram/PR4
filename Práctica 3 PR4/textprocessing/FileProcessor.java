package textprocessing;
import java.util.Map;
import java.util.HashMap;

public class FileProcessor extends Thread {
    
    private FileContents fc;
    private WordFrequencies wf;
    
    public FileProcessor(FileContents fc, WordFrequencies wf){
        this.fc = fc;
        this.wf = wf;
    }
    
    @Override
    public void run(){
        String content = fc.getContents();
        String spacers = "[^\\wáéíóúÁÉÍÓÚÑñüÜ]+";
        //String spacers = "[ .,;?!¡¿\"\\[\\]\\n()]+";
        while(content!= null){
            String[] words = content.split(spacers);
            Map<String, Integer> map = new HashMap<>();
            for(String individualWords : words){
                if(map.containsKey(individualWords))map.put(individualWords, map.get(individualWords) + 1   );
                else map.put(individualWords, 1);
            }
            wf.addFrequencies(map);
            content = fc.getContents();
        }
    }
}
