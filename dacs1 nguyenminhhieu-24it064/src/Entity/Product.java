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
public class Product {
    private int ProductID;
    private String Name;
    private String Brand;
    private int Price;
    private int Quantity;
    private String Description;
    private int CatID;
    public int getproid(){
        return ProductID;
    }
    public void setproId(int Pid)
    {
        this.ProductID=Pid;
    }
    public String getname()
    {
        return Name;
    }
    public void setname(String name)
    {
        this.Name=name;
    }
    public String getbrand()
    {
        return Brand;
    }
    public void setbrand(String b){
        this.Brand=b;
    }
    public int getprice()
    {
        return Price;
    }
    public void setprice(int p)
    {
        this.Price=p;
    }
    public int getquantity()
    {
        return Quantity;
    }
    public void setquantity(int q)
    {
        this.Quantity=q;
    }
    public String getDesc()
    {
        return Description;
    }
    public void setDesc(String d)
    {
        this.Description=d;
    }
    public int getcatid()
    {
        return CatID;
    }
    public void setcatid(int c)
    {
        this.CatID=c;
    }
}
