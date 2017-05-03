package textprocessing;
import java.util.Map;
import java.util.HashMap;
import java.util.Iterator;
public class WordFrequencies {
    
    private Map<String, Integer> wordFreq;
    public WordFrequencies(){
        wordFreq = new HashMap<>();
    }
    public synchronized void addFrequencies(Map<String,Integer> f){
        //Converting hashmap to an iterable set
        for(Map.Entry<String, Integer> entry : f.entrySet()){
            if(wordFreq.containsKey(entry.getKey()))wordFreq.put(entry.getKey(), wordFreq.get(entry.getKey()) + entry.getValue());
            else wordFreq.put(entry.getKey(), entry.getValue());
        }
    }
    public synchronized Map<String,Integer> getFrequencies(){
        return wordFreq;
    }
}
