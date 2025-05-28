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
public class Category {
    private  int CatID;
    private  String Name;
    private String Img;
    public  int getcatid(){
        return CatID;
    }
    public void setcatid(int id){
        this.CatID=id;
    }
    public String getname(){
        return Name;
    }
    public void setname(String name){
        this.Name=name;
    }
    public String setImg(){
        return Img;
    }
    public void getimg(String img)
    {
        this.Img=img;
    }
}
