/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package DLL;

import DAL.OrderDAL;
import Entity.Order;
import java.util.ArrayList;

/**
 *
 * @author Aki
 */
public class OrderDLL {
    OrderDAL ord= new OrderDAL();
    public ArrayList<Order> getAll(){
        return ord.getAll();
    }
    public boolean AddData(Order order){
        return ord.AddData(order);
    }
    public boolean UpdateData(Order order){
        return ord.UpdateData(order);
    }
    public boolean DelData(int o){
        return ord.DeleteData(o);
    }
}
