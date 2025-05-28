/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package DLL;

import DAL.ProductDAL;
import Entity.Product;
import java.util.ArrayList;

/**
 *
 * @author Aki
 */
public class ProductDLL {
    ProductDAL pro= new ProductDAL();
    public ArrayList<Product> getAll(){
        return pro.getAll();
    }
    public ArrayList<Product> getbyID(int id){
        return pro.getByID(id);
    }
    public boolean Adddata(Product pr){
        return pro.Adddata(pr);
    }
    public boolean UpdateData(Product u){
        return pro.UpdateData(u);
    }
    public boolean DelData(int u){
        return pro.DelData(u);
    }
    public ArrayList<Product> getbyName(String name){
        return pro.getByName(name);
    }
public ArrayList<Product> getbyIDfromOrder(int id){
    return pro.getbyIDfromOrder(id);
}
public ArrayList<Product> getbyIDFind(int id){
    return pro.getbyIDFind(id);
}
public boolean UpdateSL(Product prod){
    return  pro.UpdateSL(prod);
}
}
