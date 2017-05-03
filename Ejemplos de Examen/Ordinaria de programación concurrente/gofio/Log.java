package gofio;
public class Log extends BaseLog{
    public static void comprado(int id, int stock, int cantidad){ //El cliente compra en la tienda
        imprimeComprar(id,stock," Ha comprado "+cantidad+" Kg");
    }
    public static void intentandoComprar(int id, int stock, int cantidad, long t){
        imprimeComprar(id,stock," Intentando comprar "+cantidad+" Kg hasta "+(t/1000)+","+(t%1000)+" seg");
    }
    public static void noPudoComprar(int id, int stock, int cantidad){
        imprimeComprar(id,stock," NO PUDO COMPRAR "+cantidad+" Kg");
    }
    public static void vendido(int id, int stock, int cantidad){ //El agricultor vende a la tienda
        imprimeVender(id,stock," Ha vendido "+cantidad+" Kg");
    }
    public static void intentandoVender(int id, int stock, int cantidad, long t){
        imprimeVender(id,stock," Intentando vender "+cantidad+" Kg hasta "+(t/1000)+","+(t%1000)+" seg");
    }
    public static void noPudoVender(int id, int stock, int cantidad){
        imprimeVender(id,stock," NO PUDO VENDER "+cantidad+" Kg");
    }
    public static void resumen(int vendido, int comprado, int stock){
        System.out.println("RESUMEN FINAL");
        if(vendido != comprado+stock){
            System.out.print("\033[1m\033[33mERROR: resultados incoherentes\n");
        }else{
            System.out.print("\033[1m\033[34m");
        }
        System.out.format("Vendido: %d\nComprado: %d\nStock %d\033[39m\033[0m",vendido,comprado,stock);
    }
}
