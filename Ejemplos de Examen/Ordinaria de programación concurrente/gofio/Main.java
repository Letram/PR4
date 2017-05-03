package gofio;
public class Main{
    public static void main(String[] args){
        Cliente[] clientes= new Cliente[4];
        Agricultor[] agricultores= new Agricultor[2];
        Tienda tienda= new Tienda(120);
        for(int i=0; i<agricultores.length; i++){
            agricultores[i] = new Agricultor(i+1,tienda);
            //Descomente la siguiente línea cuando quiera probar
            agricultores[i].start();
        }
        for(int i=0; i<clientes.length; i++){
            clientes[i] = new Cliente(i+1,tienda);
            //Descomente la siguiente línea cuando quiera probar
            clientes[i].start();
        }
        for(int i=0; i<agricultores.length; i++){
            //Descomente la siguiente línea cuando quiera probar
            try{agricultores[i].join();}catch(Exception e){}
        }
        for(int i=0; i<clientes.length; i++){
            //Descomente la siguiente línea cuando quiera probar
            try{clientes[i].join();}catch(Exception e){}
        }
        int vendido=0;
        int comprado=0;
        for(int i=0; i<agricultores.length; i++){
            vendido+=agricultores[i].vendido();
        }
        for(int i=0; i<clientes.length; i++){
            comprado+=clientes[i].comprado();
        }
        Log.resumen(vendido,comprado,tienda.stock());
    }
}
