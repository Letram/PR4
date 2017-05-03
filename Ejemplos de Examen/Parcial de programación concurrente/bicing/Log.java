package bicing;
// NO TIENE EFECTO MODIFICAR ESTE FICHERO
public class Log extends BaseLog{
    public static void creandoEstación(int estación, int numeroBicicletas){
        System.out.println("Creando estación "+estación+" con "+numeroBicicletas+" bicicletas");
    }
    public static void intentandoAlquilar(int idUsuario, int estación){
        imprime(1,idUsuario,estación,"intentando alquilar");
    }
    public static void esperandoAlquilar(int idUsuario, int estación, long t){
        imprime(2,idUsuario,estación,"esperando alquilar hasta "+(t/1000)+","+(t%1000)+" seg");
    }
    public static void alquila(int idUsuario, int estación, int idBicicleta){
        imprime(3,idUsuario,estación,"alquila bicicleta "+idBicicleta);
    }
    public static void abandona(int idUsuario, int estación){
        imprime(8,idUsuario,estación,"cansado de esperar abandona");
    }
    public static void paseando(int idUsuario, int estación, long t){
        imprime(4,idUsuario,estación,"comenzando paseo de "+(t/1000)+","+(t%1000)+" seg");
    }
    public static void intentandoDevolver(int idUsuario, int estación, int idBicicleta){
        imprime(5,idUsuario,estación,"intentando devolver la bicicleta "+idBicicleta);
    }
    public static void devuelve(int idUsuario, int estación, int idBicicleta){
        imprime(6,idUsuario,estación,"devuelve la bicicleta "+idBicicleta);
    }
}
