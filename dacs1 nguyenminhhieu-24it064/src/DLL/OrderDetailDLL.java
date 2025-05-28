/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package DLL;

import DAL.OrderDetailDAL;
import Entity.OrderDetail;
import java.util.ArrayList;

/**
 *
 * @author Aki
 */
public class OrderDetailDLL {
    OrderDetailDAL orde= new OrderDetailDAL();
    
    public ArrayList<OrderDetail> getAll(){
        return orde.getAll();
    }
    public boolean  AddData(OrderDetail orde1){
        return orde.AddData(orde1);
    }
    public boolean UpDateData(OrderDetail orde2){
        return orde.UpdateData(orde2);
    }
    public boolean DelData(int id){
        return orde.DeleteData(id);
    }
    public ArrayList<OrderDetail> GetPayment(int id){
        return orde.getPayment(id);
    }
}
