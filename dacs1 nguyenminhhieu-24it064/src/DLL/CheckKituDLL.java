/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package DLL;

/**
 *
 * @author Aki
 */
public class CheckKituDLL {
    public  static  char[] syb={'~','!','@','#','$','%','^','&','*',':',';','"','<','>','?','='};
    
    public  static boolean checksyb(String q){
        boolean check= false;
        char a[]= q.toCharArray();
        
        for(int i=0;i<a.length;i++){
            for(int j=0;j<syb.length;j++)
            {
                if(a[i]==syb[j]){
                    check=true;
                }
            }
        }
        return  check;
    }
}
