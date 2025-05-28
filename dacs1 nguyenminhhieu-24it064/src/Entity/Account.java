/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Entity;

/**
 *
 * @author Aki
 */
public class Account {
    private int AccID;
    private String Username;
    private  String Password;
    private String maxacnhan;
    public int getaccid(){
        return AccID;
    }

    public String getMaxacnhan() {
        return maxacnhan;
    }
    public void setaccid(int id){
        this.AccID=id;
    }
    public String getuser(){
        return Username;
        
    }
    public void setuser(String s)
    {
        this.Username=s;
    }
    public String getpass(){
        return Password;
    }
    public void setpass(String p){
        this.Password=p;
    }

    public void setMaxacnhan(String maxacnhan) {
        this.maxacnhan = maxacnhan;
    }
    
}
