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
public class User {
    private int UserID;
    private String Fullname;
    private String Phone;
    private String Address;
    private int Age;
    public int getUserid()
    {
        return UserID;
    }
    public void setUserid(int id)
    {
        this.UserID=id;
    }
    public String getFullname()
    {
        return Fullname;
    }
    public void setFulname(String name)
    {
        this.Fullname=name;
    }
    public String getphone()
    {
        return Phone;
    }
    public void setphone(String phone)
    {
        this.Phone=phone;
    }
    public String getAddress()
    {
        return Address;
    }
    public void setaddress(String dc){
        this.Address=dc;
    }
    public int getage()
    {
        return Age;
    }
    public void setage(int tuoi)
    {
        this.Age=tuoi;
    }
            
}
